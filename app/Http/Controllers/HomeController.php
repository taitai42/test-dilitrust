<?php

namespace App\Http\Controllers;

use App\File;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home', [
            'files' => auth()->user()->files()->get(),
            'access' => File::getAccessibleFiles()
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|max:2000',
            'public' => 'required|integer|in:0,1'
        ]);

        $file = $request->file('file')->store('usersfiles');
        auth()->user()->files()->create([
            'file' => $file,
            'original_name' => $request->file('file')->getClientOriginalName(),
            'public' => intval($request->input('public')) === 1,
        ]);

        $request->session()->flash('success', 'file uploaded');
        return redirect('/');
    }

    public function view($id)
    {
        $file = File::with(['viewers', 'owner'])->findorfail($id);
        $this->authorize('view', $file);

        // if the file is public we mark it as viewed
        if ($file->public && $file->user_id != auth()->user()->id && $file->viewers->where('id', auth()->user()->id)->count() == 0) {
            $file->viewers()->attach(auth()->user()->id, ['read_at' => new Carbon()]);
        }

        return view('file', [
            'file' => $file,
            'url' => Storage::temporaryUrl($file->file, now()->addMinutes(10)),
            'files' => auth()->user()->files()->get(),
            'access' => File::getAccessibleFiles(),
            'users' => User::with('access')->get(),
        ]);
    }

    public function delete(Request $request, $id)
    {
        $file = File::with('viewers')->findorfail($id);
        $this->authorize('delete', $file);

        Storage::delete($file->file);
        $file->delete();

        $request->session()->flash('success', "file deleted");
        return redirect('/');
    }

    public function toggleAccess(Request $request, $id, $user_id, $can_see)
    {
        $file = File::with('viewers')->findorfail($id);
        $user = User::findorfail($user_id);
        $this->authorize('delete', $file);
        if ($file->viewers->where('id', $user->id)->count() > 0) {
            $file->viewers()->updateExistingPivot($user->id, ['can_see' => $can_see == true]);
        } else {
            $file->viewers()->attach($user->id, ['can_see' => $can_see == true]);
        }

        $request->session()->flash('success', $can_see ? 'access granted' : 'access_removed');
        return redirect("/{$file->id}");
    }

}
