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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

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
        // iPhone撮影動画のメタデータストリーム除去（FFmpegエラー防止）
        $this->stripMetadataStreams();

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

    /**
     * iPhone等の撮影動画に含まれるメタデータ/タイムコードストリームを除去
     * FFmpeg HLS変換時の "Decoder (codec none) not found" エラーを防止
     */
    private function stripMetadataStreams(): void
    {
        $inputPath = Storage::disk('local')->path($this->videoFilePath);
        $cleanedPath = $inputPath . '_clean.mp4';
        $ffmpegBin = config('laravel-ffmpeg.ffmpeg.binaries', 'ffmpeg');

        $process = new Process([
            $ffmpegBin,
            '-i', $inputPath,
            '-map', '0:v:0',
            '-map', '0:a:0?',
            '-c', 'copy',
            '-y',
            $cleanedPath,
        ]);
        $process->setTimeout(300);
        $process->run();

        if ($process->isSuccessful() && file_exists($cleanedPath)) {
            rename($cleanedPath, $inputPath);
            Log::info('ProcessVideoJob: stripped metadata streams', ['file' => $this->videoFilePath]);
        } else {
            Log::warning('ProcessVideoJob: strip failed, proceeding with original', [
                'file' => $this->videoFilePath,
                'error' => $process->getErrorOutput(),
            ]);
        }
    }
}
