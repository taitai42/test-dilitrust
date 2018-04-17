<?php

namespace Tests\Unit;

use App\File;
use App\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileAssociationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testOwnerHasFile()
    {
        $user = factory(User::class)->create();
        $file = factory(File::class)->make();

        $user->files()->save($file);

        self::assertEquals(1, $user->files()->count());
    }

    public function testPublicFile()
    {
        $users = factory(User::class, 2)->create();
        $file = factory(File::class)->make(['public' => true]);

        $users->first()->files()->save($file);
        self::assertTrue($users->last()->can('view', $file));
    }

    public function testPrivateFile()
    {
        $users = factory(User::class, 2)->create();
        $file = factory(File::class)->make(['public' => false]);

        $users->first()->files()->save($file);
        self::assertFalse($users->last()->can('view', $file));
    }

    public function testPrivateFileWithPermission()
    {
        $users = factory(User::class, 2)->create();
        $file = factory(File::class)->make(['public' => false]);

        $users->first()->files()->save($file);
        $users->last()->access()->attach($file->id, ['can_see' => true]);
        self::assertTrue($users->last()->can('view', $file));
    }

    public function testRemoveAccess()
    {
        $users = factory(User::class, 2)->create();
        $file = factory(File::class)->make(['public' => false]);

        $users->first()->files()->save($file);
        $users->last()->access()->attach($file->id, ['can_see' => false]);
        self::assertFalse($users->last()->can('view', $file));
    }

    public function testAccessibleFiles()
    {
        $users = factory(User::class, 2)->create();
        $file = factory(File::class)->make(['public' => false]);
        $file2 = factory(File::class)->create(['user_id' => $users->first()->id, 'public' => true]);

        $users->first()->files()->save($file);
        $users->last()->access()->attach($file->id, ['can_see' => true]);
        Auth::setUser($users->last());
        $files = File::getAccessibleFiles();
        self::assertEquals(2, $files->count());
    }

    public function testAccessibleFilesNoAccess()
    {
        $users = factory(User::class, 2)->create();
        $file = factory(File::class)->make(['public' => false]);
        $file2 = factory(File::class)->create(['user_id' => $users->first()->id, 'public' => true]);

        $users->first()->files()->save($file);
        Auth::setUser($users->last());
        $files = File::getAccessibleFiles();
        self::assertEquals(1, $files->count());
    }


}
