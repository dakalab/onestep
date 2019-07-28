<?php

namespace App\Console\Commands;

use App\Models\Photo;
use Illuminate\Console\Command;
use Log;

class RemovePhotos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photo:remove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove unused photos';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $photos = Photo::get();
        foreach ($photos as $photo) {
            if ($photo->remove()) {
                Log::channel('photo')->info($photo->id);
            }
        }
    }
}
