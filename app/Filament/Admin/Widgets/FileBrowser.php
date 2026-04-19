<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FileBrowser extends Widget
{
    protected string $view = 'filament.admin.widgets.file-browser';

    public string $currentPath = '';

    public ?string $search = '';

    public function mount(): void
    {
        // Start at the project root instead of storage
        $this->currentPath = base_path();
    }

    public function getDirectoryListProperty(): array
    {
        if (! File::exists($this->currentPath) || ! File::isDirectory($this->currentPath)) {
            return [];
        }

        $items = [];
        // Only get files and directories in the CURRENT folder (not recursive)
        $files = File::files($this->currentPath);
        $directories = File::directories($this->currentPath);

        // Add parent directory link if not at project root
        if ($this->currentPath !== base_path()) {
            $parent = dirname($this->currentPath);
            $items[] = [
                'name' => '..',
                'path' => $parent,
                'type' => 'directory',
                'size' => '',
                'is_parent' => true,
            ];
        }

        // Add directories
        foreach ($directories as $dir) {
            $name = basename($dir);
            // Case-insensitive search match
            if ($this->search && ! Str::contains(strtolower($name), strtolower($this->search))) {
                continue;
            }
            $items[] = [
                'name' => $name,
                'path' => $dir,
                'type' => 'directory',
                'size' => $this->formatDirSize($dir),
                'is_parent' => false,
            ];
        }

        // Add files
        foreach ($files as $file) {
            $name = $file->getFilename();
            // Case-insensitive search match
            if ($this->search && ! Str::contains(strtolower($name), strtolower($this->search))) {
                continue;
            }
            $items[] = [
                'name' => $name,
                'path' => $file->getPathname(),
                'type' => 'file',
                'size' => $this->formatFileSize($file->getSize()),
                'is_parent' => false,
                'extension' => $file->getExtension(),
                'last_modified' => $file->getMTime(),
            ];
        }

        return $items;
    }

    public function getBreadcrumbProperty(): array
    {
        // This will explode the FULL absolute path so you can see exactly where
        // Android placed your project files on the device.
        $parts = explode(DIRECTORY_SEPARATOR, trim($this->currentPath, DIRECTORY_SEPARATOR));

        $path = '';
        $crumb = [];

        // If on Linux/Android, the path starts with /
        if (Str::startsWith($this->currentPath, '/')) {
            $crumb[] = ['name' => '/', 'path' => '/'];
        }

        foreach ($parts as $part) {
            if (empty($part)) continue;
            $path .= DIRECTORY_SEPARATOR . $part;
            $crumb[] = ['name' => $part, 'path' => $path];
        }

        return $crumb;
    }

    public function navigateTo(string $path): void
    {
        if (File::isDirectory($path)) {
            $this->currentPath = $path;
        }
    }

    public function goToParent(): void
    {
        // Prevent navigating above base_path
        if ($this->currentPath !== base_path()) {
            $this->currentPath = dirname($this->currentPath);
        }
    }

    public function setSearch(string $search): void
    {
        $this->search = $search;
    }

    protected function formatDirSize(string $dir): string
    {
        // Warning: Recursively calculating size for folders like 'vendor' or 'node_modules'
        // will cause memory exhaustion and timeouts. It is highly recommended to leave this as '--'.
        return '--';
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
