@php
    $data = $this->data;
@endphp

<div class="grid grid-cols-2 gap-4">
    <div class="col-span-2 rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800">
        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Application Info</h3>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">App Name</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $data['app_name'] }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">App Version</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $data['app_version'] }}</dd>
            </div>
            <div class="col-span-2">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">App ID</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $data['app_id'] }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Environment</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $data['environment'] }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">PHP Version</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $data['php_version'] }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Laravel Version</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $data['laravel_version'] }}</dd>
            </div>
        </dl>
    </div>

    <div class="col-span-2 rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800 sm:col-span-1">
        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Database</h3>
        <dl class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400">Driver</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $data['database']['driver'] }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400">DB File</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $data['database']['path'] }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400">Exists</span>
                <span class="font-medium {{ $data['database']['exists'] ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                    {{ $data['database']['exists'] ? 'Yes' : 'No' }}
                </span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400">Size</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $data['database']['size'] }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400">Tables</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $data['database']['tables'] }}</span>
            </div>
        </dl>
    </div>

    <div class="col-span-2 rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800 sm:col-span-1">
        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Storage</h3>
        <dl class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400">Path</span>
                <span class="font-medium text-gray-900 dark:text-white truncate" title="{{ $data['storage']['path'] }}">{{ $data['storage']['path'] }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400">Total Size</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $data['storage']['size'] }}</span>
            </div>
            <div class="pt-2 border-t border-gray-200 dark:border-gray-700">
                <dt class="text-sm font-medium text-gray-900 dark:text-white">Laravel Log</dt>
                <dd class="mt-1 flex justify-between text-xs">
                    <span class="text-gray-500 dark:text-gray-400">Size: {{ $data['storage']['logs']['laravel']['size'] }}</span>
                    <span class="text-gray-500 dark:text-gray-400">Lines: {{ $data['storage']['logs']['laravel']['lines'] }}</span>
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-900 dark:text-white">Browser Log</dt>
                <dd class="mt-1 flex justify-between text-xs">
                    <span class="text-gray-500 dark:text-gray-400">Size: {{ $data['storage']['logs']['browser']['size'] }}</span>
                    <span class="text-gray-500 dark:text-gray-400">Lines: {{ $data['storage']['logs']['browser']['lines'] }}</span>
                </dd>
            </div>
        </dl>
    </div>

    <div class="col-span-2 rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800 sm:col-span-1">
        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Memory</h3>
        <dl class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400">Current Usage</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $data['memory']['usage'] }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400">Peak Usage</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $data['memory']['peak'] }}</span>
            </div>
        </dl>
    </div>

    <div class="col-span-2 rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800 sm:col-span-1">
        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">NativePHP</h3>
        <dl class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400">Running Natively</span>
                <span class="font-medium {{ $data['nativephp']['is_native'] ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}">
                    {{ $data['nativephp']['is_native'] ? 'Yes' : 'No' }}
                </span>
            </div>
            <div class="col-span-2">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">App Directory</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white truncate" title="{{ $data['nativephp']['app_dir'] }}">
                    {{ $data['nativephp']['app_dir'] }}
                </dd>
            </div>
        </dl>
    </div>
</div>
