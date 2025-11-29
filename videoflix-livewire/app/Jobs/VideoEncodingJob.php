<?php

namespace App\Jobs;

use App\Models\Video;
use FFMpeg\Format\Video\X264;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

use function Laravel\Prompts\info;

class VideoEncodingJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private Video $video,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $newVideoName = str_replace(strrchr($this->video->video, '.'), '', $this->video->video).'.m3u8';

        $low = new X264()->setKiloBitrate(500);
        $mid = new X264()->setKiloBitrate(1500);
        $high = new X264()->setKiloBitrate(3000);

        FFMpeg::fromDisk('videos')
            ->open($this->video->video)
            ->exportForHLS()
            ->addFormat($low)
            ->addFormat($mid)
            ->addFormat($high)
            ->onProgress(function ($progress) use ($newVideoName) {
                // Dispatch event with video encoding progress
                info("Encoding video {$newVideoName}: {$progress}% completed.");
            })
            ->toDisk('encoded_videos')
            ->save($this->video->code.DIRECTORY_SEPARATOR.$newVideoName);

        Storage::disk('videos')->delete($this->video->video);

        $this->video->update([
            'video' => $newVideoName,
            'is_processed' => true,
        ]);
    }
}
