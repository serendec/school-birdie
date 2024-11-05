<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\School;

class CalculateStorageUsage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate the storage usage for each school';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $schoolIds = School::pluck('id')->toArray();
        foreach ($schoolIds as $schoolId) {
            $totalSize = 0;
            $directories = [
                "public/media/course/$schoolId",
                "public/media/forum/$schoolId",
                "public/media/lesson_record/$schoolId",
                "public/media/video_advice/$schoolId"
            ];

            foreach ($directories as $directory) {
                $totalSize += $this->getDirectorySize($directory);
            }

            // 合計サイズをGBに変換
            $totalSizeGB = $totalSize / (1024 * 1024 * 1024);
            $totalSizeGBFormatted = number_format($totalSizeGB, 2);

            // データベースに保存
            School::where('id', $schoolId)->update(['storage_usage' => $totalSizeGBFormatted]);

            $this->info("School ID: $schoolId, Total Size: $totalSizeGBFormatted GB");
        }
    }

    private function getDirectorySize($directory)
    {
        $size = 0;
        foreach (Storage::allFiles($directory) as $file) {
            $size += Storage::size($file);
        }
        return $size;
    }
}
