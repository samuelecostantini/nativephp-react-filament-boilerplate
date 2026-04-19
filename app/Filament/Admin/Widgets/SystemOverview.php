<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SystemOverview extends Widget
{
    protected string $view = 'filament.admin.widgets.system-overview';

    protected int|string|array $columnSpan = 'full';

    public ?array $data = [];

    public function mount(): void
    {
        $this->data = $this->getSystemInfo();
    }

    protected function getSystemInfo(): array
    {
        $dbPath = database_path('database.sqlite');
        $logPath = storage_path('logs/laravel.log');
        $browserLogPath = storage_path('logs/browser.log');

        $nativeAppId = config('nativephp.app_id', 'Not set');
        $appVersion = config('nativephp.version', '1.0.0');

        return [
            'app_name' => config('app.name', 'Laravel'),
            'app_version' => $appVersion,
            'app_id' => $nativeAppId,
            'environment' => app()->environment(),
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'database' => [
                'driver' => config('database.default'),
                'path' => $dbPath,
                'exists' => File::exists($dbPath),
                'size' => File::exists($dbPath) ? $this->formatFileSize(File::size($dbPath)) : 'N/A',
                'tables' => $this->getTableCount(),
            ],
            'storage' => [
                'path' => storage_path(),
                'size' => $this->getStorageSize(),
                'logs' => [
                    'laravel' => [
                        'path' => $logPath,
                        'exists' => File::exists($logPath),
                        'size' => File::exists($logPath) ? $this->formatFileSize(File::size($logPath)) : 'N/A',
                        'lines' => File::exists($logPath) ? $this->countLines($logPath) : 0,
                    ],
                    'browser' => [
                        'path' => $browserLogPath,
                        'exists' => File::exists($browserLogPath),
                        'size' => File::exists($browserLogPath) ? $this->formatFileSize(File::size($browserLogPath)) : 'N/A',
                        'lines' => File::exists($browserLogPath) ? $this->countLines($browserLogPath) : 0,
                    ],
                ],
            ],
            'memory' => [
                'usage' => $this->formatFileSize(memory_get_usage(true)),
                'peak' => $this->formatFileSize(memory_get_peak_usage(true)),
            ],
            'nativephp' => [
                'is_native' => defined('NATIVEPHP_APP_DIR'),
                'app_dir' => defined('NATIVEPHP_APP_DIR') ? NATIVEPHP_APP_DIR : 'N/A',
            ],
        ];
    }

    protected function getTableCount(): int
    {
        try {
            $schema = DB::getSchemaBuilder();
            $tables = $schema->getAllTables();
            return count($tables);
        } catch (\Exception $e) {
            return 0;
        }
    }

    protected function getStorageSize(): string
    {
        $storagePath = storage_path();
        if (! File::exists($storagePath)) {
            return 'N/A';
        }

        $size = 0;
        foreach (File::allFiles($storagePath) as $file) {
            $size += $file->getSize();
        }

        return $this->formatFileSize($size);
    }

    protected function formatFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor($bytes ? log($bytes, 1024) : 0);
        $pow = min($pow, count($units) - 1);
        $bytes /= (1024 ** $pow);

        return round($bytes, 2).' '.$units[$pow];
    }

    /**
     * @throws FileNotFoundException
     */
    protected function countLines(string $filePath): int
    {
        return File::exists($filePath) ? (int) File::lines($filePath)->count() : 0;
    }
}
