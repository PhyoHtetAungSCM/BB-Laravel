<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class DeleteImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will delete unecessary images from public folder.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /** Retrieve images from public folder */
        $files = File::files(public_path('images'));
        $images = [];
        foreach ($files as $file) {
            $images[] = $file->getRelativePathname();
        }

        /** Retrieve images from database */
        $users = DB::table('users')->get();
        $profiles = [];
        foreach ($users as $user) {
            if ($user->profile) {
                $profiles[] = $user->profile;
            }
        }
        $results = array_diff($images, $profiles);
        
        foreach ($results as $result) {
            if ($result != 'default.jpg') {
                File::delete(public_path('images/' . $result));
            }
        }
    }
}
