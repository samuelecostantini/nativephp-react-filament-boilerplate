@php
    $data = $this->data;
@endphp

<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
    {{-- Application Info --}}
    <div class="col-span-full">
        <x-filament::section>
            <x-slot name="heading">
                Application Info
            </x-slot>
            <x-slot name="description">
                General application information
            </x-slot>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div class="fi-in-entry">
                    <span class="fi-in-entry-label text-sm text-gray-500 dark:text-gray-400">App Name</span>
                    <div class="fi-in-entry-value mt-1 text-sm font-medium text-gray-900 dark:text-white">{{ $data['app_name'] }}</div>
                </div>
                <div class="fi-in-entry">
                    <span class="fi-in-entry-label text-sm text-gray-500 dark:text-gray-400">App Version</span>
                    <div class="fi-in-entry-value mt-1 text-sm font-medium text-gray-900 dark:text-white">{{ $data['app_version'] }}</div>
                </div>
                <div class="fi-in-entry">
                    <span class="fi-in-entry-label text-sm text-gray-500 dark:text-gray-400">Environment</span>
                    <div class="fi-in-entry-value mt-1 text-sm font-medium text-gray-900 dark:text-white">{{ $data['environment'] }}</div>
                </div>
                <div class="fi-in-entry">
                    <span class="fi-in-entry-label text-sm text-gray-500 dark:text-gray-400">App ID</span>
                    <div class="fi-in-entry-value mt-1 text-sm font-medium text-gray-900 dark:text-white truncate" title="{{ $data['app_id'] }}">{{ $data['app_id'] }}</div>
                </div>
                <div class="fi-in-entry">
                    <span class="fi-in-entry-label text-sm text-gray-500 dark:text-gray-400">PHP Version</span>
                    <div class="fi-in-entry-value mt-1 text-sm font-medium text-gray-900 dark:text-white">{{ $data['php_version'] }}</div>
                </div>
                <div class="fi-in-entry">
                    <span class="fi-in-entry-label text-sm text-gray-500 dark:text-gray-400">Laravel Version</span>
                    <div class="fi-in-entry-value mt-1 text-sm font-medium text-gray-900 dark:text-white">{{ $data['laravel_version'] }}</div>
                </div>
            </div>
        </x-filament::section>
    </div>

    {{-- Database --}}
    <x-filament::section>
        <x-slot name="heading">
            Database
        </x-slot>
        <x-slot name="description">
            SQLite database information
        </x-slot>

        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500 dark:text-gray-400">Driver</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $data['database']['driver'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500 dark:text-gray-400">DB File</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $data['database']['path'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500 dark:text-gray-400">Exists</span>
                @if($data['database']['exists'])
                    <x-filament::badge color="success" size="sm">Yes</x-filament::badge>
                @else
                    <x-filament::badge color="danger" size="sm">No</x-filament::badge>
                @endif
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500 dark:text-gray-400">Size</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $data['database']['size'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500 dark:text-gray-400">Tables</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $data['database']['tables'] }}</span>
            </div>
        </div>
    </x-filament::section>

    {{-- Storage --}}
    <x-filament::section>
        <x-slot name="heading">
            Storage
        </x-slot>
        <x-slot name="description">
            Storage usage and logs
        </x-slot>

        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500 dark:text-gray-400">Path</span>
                <span class="max-w-[60%] truncate text-sm font-medium text-gray-900 dark:text-white" title="{{ $data['storage']['path'] }}">{{ $data['storage']['path'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500 dark:text-gray-400">Total Size</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $data['storage']['size'] }}</span>
            </div>
            <div class="fi-section-separator border-t border-gray-200 pt-3 dark:border-gray-700">
                <div class="mb-2 text-sm font-medium text-gray-900 dark:text-white">Laravel Log</div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">Size: {{ $data['storage']['logs']['laravel']['size'] }}</span>
                    <span class="text-gray-500 dark:text-gray-400">Lines: {{ $data['storage']['logs']['laravel']['lines'] }}</span>
                </div>
            </div>
            <div>
                <div class="mb-2 text-sm font-medium text-gray-900 dark:text-white">Browser Log</div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">Size: {{ $data['storage']['logs']['browser']['size'] }}</span>
                    <span class="text-gray-500 dark:text-gray-400">Lines: {{ $data['storage']['logs']['browser']['lines'] }}</span>
                </div>
            </div>
        </div>
    </x-filament::section>

    {{-- Memory --}}
    <x-filament::section>
        <x-slot name="heading">
            Memory
        </x-slot>
        <x-slot name="description">
            Current memory usage
        </x-slot>

        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500 dark:text-gray-400">Current Usage</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $data['memory']['usage'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500 dark:text-gray-400">Peak Usage</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $data['memory']['peak'] }}</span>
            </div>
        </div>
    </x-filament::section>

    {{-- NativePHP --}}
    <x-filament::section>
        <x-slot name="heading">
            NativePHP
        </x-slot>
        <x-slot name="description">
            NativePHP runtime information
        </x-slot>

        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500 dark:text-gray-400">Running Natively</span>
                @if($data['nativephp']['is_native'])
                    <x-filament::badge color="success" size="sm">Yes</x-filament::badge>
                @else
                    <x-filament::badge color="gray" size="sm">No</x-filament::badge>
                @endif
            </div>
            <div>
                <span class="text-sm text-gray-500 dark:text-gray-400">App Directory</span>
                <div class="mt-1 truncate text-sm font-medium text-gray-900 dark:text-white" title="{{ $data['nativephp']['app_dir'] }}">{{ $data['nativephp']['app_dir'] }}</div>
            </div>
        </div>
    </x-filament::section>
</div>
