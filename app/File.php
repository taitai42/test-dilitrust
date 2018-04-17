<?php
/**
 * Created by PhpStorm.
 * User: USER1
 * Date: 4/16/2018
 * Time: 8:24 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class File extends Model
{

    public $fillable = [
        'file',
        'original_name',
        'public',
    ];

    public static function getAccessibleFiles()
    {
        $public = File::where('user_id', '!=', auth()->user()->id)
            ->where('public', true)
            ->get()
            ->keyby('id');

        $access = auth()->user()->access()
            ->whereNotIn('file_id', $public->pluck('id'))
            ->where('file_user.user_id', '!=', auth()->user()->id)
            ->get()
            ->keyby('id');

        return $access->merge($public)->values();
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function viewers()
    {
        return $this->belongsToMany(User::class)->withPivot('can_see', 'read_at');
    }
}