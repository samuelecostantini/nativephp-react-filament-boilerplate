<x-filament::section>
    <x-slot name="heading">
        Database Viewer
    </x-slot>
    <x-slot name="description">
        Browse and query SQLite database
    </x-slot>

    <div class="fi-form-component gap-6">
        {{-- Table Selector --}}
        <div class="fi-input-wrp">
            <div class="fi-input-wrp-input relative flex-1">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <x-filament::icon
                        icon="heroicon-o-table-cells"
                        class="h-5 w-5 text-gray-400"
                    />
                </div>
                <select
                    wire:model.live="selectedTable"
                    class="fi-select block w-full rounded-lg border-gray-300 bg-white py-2 pl-10 pr-10 text-sm text-gray-900 shadow-sm transition-colors focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                >
                    <option value="">Select a table...</option>
                    @foreach($this->getTables() as $table)
                        <option value="{{ $table }}">{{ $table }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                    <x-filament::icon
                        icon="heroicon-o-chevron-down"
                        class="h-4 w-4 text-gray-400"
                    />
                </div>
            </div>
        </div>

        @if($this->selectedTable)
            {{-- Table Info --}}
            <div class="fi-alert fi-alert-info rounded-lg bg-primary-50 p-4 text-sm dark:bg-primary-900/20">
                <div class="flex items-start gap-3">
                    <x-filament::icon
                        icon="heroicon-o-information-circle"
                        class="h-5 w-5 text-primary-600 dark:text-primary-400"
                    />
                    <div class="flex-1">
                        <p class="font-medium text-primary-700 dark:text-primary-300">
                            Table: {{ $this->selectedTable }}
                        </p>
                        @if($this->selectedTableColumns)
                            <p class="mt-1 text-primary-600 dark:text-primary-400">
                                Columns: <span class="font-medium">{{ implode(', ', $this->selectedTableColumns) }}</span>
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Query Input --}}
            <div class="fi-section-content rounded-lg bg-gray-50 p-4 dark:bg-gray-900">
                <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                    Custom SQL Query
                </label>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <div class="fi-input-wrp flex-1">
                        <div class="fi-input-wrp-input relative flex-1">
                            <input
                                type="text"
                                wire:model.blur="query"
                                placeholder="SELECT * FROM {{ $this->selectedTable }} LIMIT 100"
                                class="fi-input block w-full rounded-lg border-gray-300 bg-white py-2 px-3 text-sm font-mono text-gray-900 shadow-sm transition-colors placeholder:text-gray-400 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500"
                            />
                        </div>
                    </div>
                    <button
                        wire:click="runCustomQuery"
                        type="button"
                        class="fi-btn fi-btn-primary fi-btn-size-md inline-flex items-center justify-center gap-1 rounded-lg bg-primary-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                    >
                        <x-filament::icon
                            icon="heroicon-o-play"
                            class="h-4 w-4"
                        />
                        Run
                    </button>
                </div>
                @if($this->queryError)
                    <div class="fi-alert fi-alert-danger mt-3 rounded-lg bg-danger-50 p-3 text-sm dark:bg-danger-900/20">
                        <div class="flex items-start gap-2">
                            <x-filament::icon
                                icon="heroicon-o-exclamation-triangle"
                                class="h-5 w-5 text-danger-600 dark:text-danger-400"
                            />
                            <div class="flex-1">
                                <span class="font-medium text-danger-700 dark:text-danger-300">Error:</span>
                                <span class="text-danger-600 dark:text-danger-400">{{ $this->queryError }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Data Table --}}
            @if($this->tableData && count($this->tableData) > 0)
                <div>
                    <h4 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Sample Data (First 100 rows)</h4>
                    <div class="fi-ta-content overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <table class="fi-ta-table w-full text-left text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    @foreach(array_keys((array) $this->tableData[0]) as $column)
                                        <th class="fi-ta-header-cell whitespace-nowrap px-4 py-3 text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                            {{ $column }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($this->tableData as $row)
                                    <tr class="fi-ta-row transition-colors hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        @foreach((array) $row as $value)
                                            <td class="fi-ta-cell max-w-xs truncate px-4 py-3 text-gray-700 dark:text-gray-300" title="{{ $value }}">
                                                {{ $value }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @elseif($this->queryError === null)
                <div class="fi-empty-state rounded-lg bg-gray-50 p-8 text-center dark:bg-gray-900">
                    <x-filament::icon
                        icon="heroicon-o-table-cells"
                        class="mx-auto h-12 w-12 text-gray-400"
                    />
                    <h3 class="mt-4 text-sm font-medium text-gray-900 dark:text-white">No data found</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">This table appears to be empty.</p>
                </div>
            @endif
        @else
            {{-- Empty State --}}
            <div class="fi-empty-state rounded-lg bg-gray-50 p-8 text-center dark:bg-gray-900">
                <x-filament::icon
                    icon="heroicon-o-circle-stack"
                    class="mx-auto h-12 w-12 text-gray-400"
                />
                <h3 class="mt-4 text-sm font-medium text-gray-900 dark:text-white">Select a table</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Select a table from the dropdown to view its structure and data</p>
            </div>
        @endif
    </div>
</x-filament::section>
