<?php

namespace App\Jobs;

use FFMpeg;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class ProcessVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $videoFilePath;
    protected $videoDirectoryPath;

    /**
     * Create a new job instance.
     */
    public function __construct(string $videoFilePath, string $videoDirectoryPath)
    {
        $this->videoFilePath = $videoFilePath;
        $this->videoDirectoryPath = $videoDirectoryPath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $lowBitrateFormat = new X264('aac');
        $lowBitrateFormat->setKiloBitrate(2500);

        $midBitrateFormat = new X264('aac');
        $midBitrateFormat->setKiloBitrate(4000);

        $highBitrateFormat = new X264('aac');
        $highBitrateFormat->setKiloBitrate(6000);

        $media = FFMpeg::fromDisk('local')
                        ->open($this->videoFilePath)
                        ->exportForHLS()
                        ->addFormat($lowBitrateFormat)
                        ->addFormat($midBitrateFormat)
                        ->addFormat($highBitrateFormat)
                        ->toDisk('public')
                        ->save("{$this->videoFilePath}.m3u8");
        
        // オリジナル動画を削除
        Storage::disk('local')->deleteDirectory($this->videoDirectoryPath);
    }
}
