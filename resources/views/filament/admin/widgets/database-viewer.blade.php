<div class="rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800 mt-4">
    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Database Viewer</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400">Browse and query SQLite database</p>
    </div>

    <div class="mb-4 flex gap-2">
        <select
            wire:model.live="selectedTable"
            class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
        >
            <option value="">Select a table...</option>
            @foreach($this->getTables() as $table)
                <option value="{{ $table }}">{{ $table }}</option>
            @endforeach
        </select>
    </div>

    @if($this->selectedTable)
        <div class="mb-4 rounded-lg bg-blue-50 p-3 text-sm text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
            <span class="font-semibold">Table:</span> {{ $this->selectedTable }}
            @if($this->selectedTableColumns)
                <div class="mt-1">
                    <span class="font-semibold">Columns:</span>
                    <span class="ml-2">{{ implode(', ', $this->selectedTableColumns) }}</span>
                </div>
            @endif
        </div>

        <div class="mb-4 rounded-lg bg-gray-50 p-3 dark:bg-gray-900">
            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                Custom SQL Query
            </label>
            <div class="flex gap-2">
                <input
                    type="text"
                    wire:model.blur="query"
                    placeholder="SELECT * FROM {{ $this->selectedTable }} LIMIT 100"
                    class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                />
                <button
                    wire:click="runCustomQuery"
                    class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                >
                    Run
                </button>
            </div>
            @if($this->queryError)
                <div class="mt-2 rounded-lg bg-red-50 p-2 text-sm text-red-800 dark:bg-red-900/30 dark:text-red-300">
                    <span class="font-semibold">Error:</span> {{ $this->queryError }}
                </div>
            @endif
        </div>

        <h4 class="mb-2 text-sm font-semibold text-gray-900 dark:text-white">Sample Data (First 100 rows)</h4>

        @if($this->tableData && count($this->tableData) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            @foreach(array_keys((array) $this->tableData[0]) as $column)
                                <th class="px-4 py-2">{{ $column }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($this->tableData as $row)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                @foreach((array) $row as $value)
                                    <td class="px-4 py-2 break-all">{{ $value }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @elseif($this->queryError === null)
            <div class="rounded-lg bg-gray-50 p-4 text-center text-sm text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                No data found
            </div>
        @endif
    @else
        <div class="rounded-lg bg-gray-50 p-8 text-center text-sm text-gray-500 dark:bg-gray-900 dark:text-gray-400">
            Select a table to view its structure and data
        </div>
    @endif
</div>
