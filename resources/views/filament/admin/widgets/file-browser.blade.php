<div class="rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800 mt-4">
    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">File Browser</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400">Browse storage directory</p>
    </div>

    <div class="mb-4 flex gap-2">
        <input
            type="text"
            placeholder="Search files..."
            x-data
            x-ref="search"
            x-init="$watch('search', value => @this.set('search', value))"
            class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm placeholder-gray-400 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
        />
    </div>

    <div class="mb-4 flex items-center gap-2 overflow-x-auto">
        @foreach($this->breadcrumb as $crumb)
            <button
                wire:click="navigateTo('{{ $crumb['path'] }}')"
                class="rounded px-2 py-1 text-sm text-primary-600 hover:bg-gray-100 dark:text-primary-400 dark:hover:bg-gray-700"
            >
                {{ $crumb['name'] }}
            </button>
            @if (!$loop->last)
                <span class="text-gray-400">/</span>
            @endif
        @endforeach
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
            <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Type</th>
                    <th class="px-4 py-2">Size</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($this->directoryList as $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <td class="px-4 py-2 font-medium text-gray-900 dark:text-white">
                            <button
                                wire:click="navigateTo('{{ $item['path'] }}')"
                                class="flex items-center gap-2 {{ $item['type'] === 'directory' ? 'text-primary-600 hover:underline dark:text-primary-400' : '' }}"
                            >
                                {{ $item['name'] }}
                            </button>
                        </td>
                        <td class="px-4 py-2">
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                {{ $item['type'] }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $item['size'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
