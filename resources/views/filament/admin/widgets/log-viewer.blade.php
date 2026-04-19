<div class="rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800 mt-4">
    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Log Viewer</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400">View application logs</p>
    </div>

    <div class="mb-4 flex gap-2">
        <div class="flex rounded-md shadow-sm">
            <button
                wire:click="setSelectedLog('laravel')"
                class="{{ $this->selectedLog === 'laravel' ? 'bg-primary-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600' }} rounded-l-md border border-r-0 border-gray-300 px-3 py-1.5 text-sm font-medium focus:z-10 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 dark:border-gray-600"
            >
                Laravel Log
            </button>
            <button
                wire:click="setSelectedLog('browser')"
                class="{{ $this->selectedLog === 'browser' ? 'bg-primary-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600' }} rounded-r-md border border-gray-300 px-3 py-1.5 text-sm font-medium focus:z-10 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 dark:border-gray-600"
            >
                Browser Log
            </button>
        </div>

        <input
            type="text"
            placeholder="Filter logs..."
            x-data
            x-ref="filter"
            x-init="$watch('filter', value => @this.set('filter', value))"
            class="block w-64 rounded-lg border border-gray-300 px-3 py-2 text-sm placeholder-gray-400 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
        />

        <select
            wire:model.live="lineCount"
            class="block rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
        >
            <option value="50">Last 50 lines</option>
            <option value="100" selected>Last 100 lines</option>
            <option value="500">Last 500 lines</option>
            <option value="1000">Last 1000 lines</option>
        </select>
    </div>

    <div class="mb-2 text-xs text-gray-500 dark:text-gray-400">
        @if($this->logs['exists'] ?? false)
            <span class="mr-4">Path: {{ $this->logs['path'] }}</span>
            <span class="mr-4">Size: {{ $this->logs['size'] }}</span>
            <span>Total lines: {{ $this->logs['lines'] }}</span>
        @else
            <span class="text-red-600 dark:text-red-400">Log file not found</span>
        @endif
    </div>

    <div class="h-96 overflow-auto rounded-lg border border-gray-200 bg-gray-50 p-3 font-mono text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
        <pre>{{ $this->logs['content'] ?? '' }}</pre>
    </div>
</div>
