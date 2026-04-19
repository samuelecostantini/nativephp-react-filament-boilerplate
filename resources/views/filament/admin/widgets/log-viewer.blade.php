<x-filament::section>
    <x-slot name="heading">
        Log Viewer
    </x-slot>
    <x-slot name="description">
        View application logs
    </x-slot>

    <div class="fi-form-component gap-6">
        {{-- Controls --}}
        <div class="flex flex-wrap items-center gap-3">
            {{-- Log Type Toggle --}}
            <div class="fi-btn-group">
                <button
                    wire:click="setSelectedLog('laravel')"
                    type="button"
                    @class([
                        'fi-btn-group-btn fi-btn relative flex items-center justify-center px-3 py-2 text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900',
                        'bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700' => $this->selectedLog !== 'laravel',
                        'bg-primary-600 text-white hover:bg-primary-500' => $this->selectedLog === 'laravel',
                        'rounded-l-lg border border-gray-300 dark:border-gray-600' => $this->selectedLog !== 'laravel',
                        'rounded-l-lg' => $this->selectedLog === 'laravel',
                    ])
                >
                    Laravel Log
                </button>
                <button
                    wire:click="setSelectedLog('browser')"
                    type="button"
                    @class([
                        'fi-btn-group-btn fi-btn relative flex items-center justify-center px-3 py-2 text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900',
                        'bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700' => $this->selectedLog !== 'browser',
                        'bg-primary-600 text-white hover:bg-primary-500' => $this->selectedLog === 'browser',
                        'rounded-r-lg border border-l-0 border-gray-300 dark:border-gray-600' => $this->selectedLog !== 'browser',
                        'rounded-r-lg' => $this->selectedLog === 'browser',
                    ])
                >
                    Browser Log
                </button>
            </div>

            {{-- Filter Input --}}
            <div class="fi-input-wrp min-w-[200px] max-w-xs flex-1">
                <div class="fi-input-wrp-input relative flex-1">
                    <input
                        type="text"
                        placeholder="Filter logs..."
                        x-data
                        x-ref="filter"
                        x-init="$watch('filter', value => @this.set('filter', value))"
                        class="fi-input block w-full rounded-lg border-gray-300 bg-white py-2 text-sm text-gray-900 shadow-sm transition-colors placeholder:text-gray-400 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500"
                    />
                </div>
            </div>

            {{-- Line Count Select --}}
            <div class="fi-input-wrp w-40">
                <div class="fi-input-wrp-input relative flex-1">
                    <select
                        wire:model.live="lineCount"
                        class="fi-select block w-full rounded-lg border-gray-300 bg-white py-2 text-sm text-gray-900 shadow-sm transition-colors focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >
                        <option value="50">Last 50 lines</option>
                        <option value="100">Last 100 lines</option>
                        <option value="500">Last 500 lines</option>
                        <option value="1000">Last 1000 lines</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- File Info --}}
        <div class="text-xs text-gray-500 dark:text-gray-400">
            @if($this->logs['exists'] ?? false)
                <span class="mr-4 inline-block">Path: {{ $this->logs['path'] }}</span>
                <span class="mr-4 inline-block">Size: {{ $this->logs['size'] }}</span>
                <span class="inline-block">Total lines: {{ $this->logs['lines'] }}</span>
            @else
                <span class="text-danger-600 dark:text-danger-400">Log file not found</span>
            @endif
        </div>

        {{-- Log Content --}}
        <div class="fi-section-content">
            <div class="h-96 overflow-auto rounded-lg border border-gray-200 bg-gray-50 p-4 font-mono text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                <pre class="whitespace-pre-wrap break-all">{{ $this->logs['content'] ?? '' }}</pre>
            </div>
        </div>
    </div>
</x-filament::section>
