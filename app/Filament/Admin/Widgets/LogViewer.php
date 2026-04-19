<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LogViewer extends Widget
{
    protected string $view = 'filament.admin.widgets.log-viewer';

    public string $selectedLog = 'laravel';

    public int $lineCount = 100;

    public ?string $filter = '';

    public function getLogsProperty(): array
    {
        $logPath = match ($this->selectedLog) {
            'laravel' => storage_path('logs/laravel.log'),
            'browser' => storage_path('logs/browser.log'),
            default => storage_path('logs/laravel.log'),
        };

        if (! File::exists($logPath)) {
            return [];
        }

        $lines = File::lines($logPath);
        $content = '';
        $count = 0;

        // Read from the end of the file
        $allLines = iterator_to_array($lines);
        $totalLines = count($allLines);
        $start = max(0, $totalLines - $this->lineCount);

        for ($i = $start; $i < $totalLines; $i++) {
            $line = $allLines[$i] ?? '';
            if ($this->filter && ! Str::contains($line, $this->filter)) {
                continue;
            }
            $content .= $line.PHP_EOL;
            $count++;
        }

        return [
            'path' => $logPath,
            'exists' => File::exists($logPath),
            'size' => File::exists($logPath) ? $this->formatFileSize(File::size($logPath)) : 'N/A',
            'lines' => $totalLines,
            'content' => $content,
        ];
    }

    public function setLineCount(int $count): void
    {
        $this->lineCount = $count;
    }

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
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
}
