<x-filament::section>
    <x-slot name="heading">
        File Browser
    </x-slot>
    <x-slot name="description">
        Browse storage directory
    </x-slot>

    <div class="fi-form-component gap-6">
        {{-- Search --}}
        <div class="fi-input-wrp">
            <div class="fi-input-wrp-input relative flex-1">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <x-filament::icon
                        icon="heroicon-o-magnifying-glass"
                        class="h-5 w-5 text-gray-400"
                    />
                </div>
                <input
                    type="text"
                    placeholder="Search files..."
                    x-data
                    x-ref="search"
                    x-init="$watch('search', value => @this.set('search', value))"
                    class="fi-input block w-full rounded-lg border-gray-300 bg-white py-2 pl-10 text-sm text-gray-900 shadow-sm transition-colors placeholder:text-gray-400 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500"
                />
            </div>
        </div>

        {{-- Breadcrumb --}}
        <nav class="fi-breadcrumbs">
            <ol class="flex flex-wrap items-center gap-x-1 text-sm">
                @foreach($this->breadcrumb as $crumb)
                    <li class="flex items-center">
                        <button
                            wire:click="navigateTo('{{ $crumb['path'] }}')"
                            type="button"
                            class="fi-breadcrumbs-item text-primary-600 hover:text-primary-700 hover:underline dark:text-primary-400 dark:hover:text-primary-300"
                        >
                            {{ $crumb['name'] }}
                        </button>
                    </li>
                    @if (!$loop->last)
                        <li class="fi-breadcrumbs-separator flex items-center px-1 text-gray-400">
                            <x-filament::icon
                                icon="heroicon-o-chevron-right"
                                class="h-4 w-4"
                            />
                        </li>
                    @endif
                @endforeach
            </ol>
        </nav>

        {{-- File Table --}}
        <div class="fi-ta-content">
            <table class="fi-ta-table w-full text-left text-sm">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="fi-ta-header-cell px-3 py-3 text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Name
                        </th>
                        <th class="fi-ta-header-cell px-3 py-3 text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Type
                        </th>
                        <th class="fi-ta-header-cell px-3 py-3 text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Size
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($this->directoryList as $item)
                        <tr class="fi-ta-row transition-colors hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="fi-ta-cell px-3 py-3">
                                <button
                                    wire:click="navigateTo('{{ $item['path'] }}')"
                                    type="button"
                                    @class([
                                        'flex items-center gap-2 font-medium',
                                        'text-primary-600 hover:text-primary-700 hover:underline dark:text-primary-400 dark:hover:text-primary-300' => $item['type'] === 'directory',
                                        'text-gray-900 dark:text-white' => $item['type'] !== 'directory',
                                    ])
                                >
                                    @if($item['type'] === 'directory')
                                        <x-filament::icon
                                            icon="heroicon-o-folder"
                                            class="h-5 w-5 text-gray-400"
                                        />
                                    @else
                                        <x-filament::icon
                                            icon="heroicon-o-document"
                                            class="h-5 w-5 text-gray-400"
                                        />
                                    @endif
                                    {{ $item['name'] }}
                                </button>
                            </td>
                            <td class="fi-ta-cell px-3 py-3">
                                <x-filament::badge
                                    :color="$item['type'] === 'directory' ? 'primary' : 'gray'"
                                    size="sm"
                                >
                                    {{ $item['type'] }}
                                </x-filament::badge>
                            </td>
                            <td class="fi-ta-cell px-3 py-3 text-gray-600 dark:text-gray-400">
                                {{ $item['size'] ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="fi-ta-cell px-3 py-8 text-center text-gray-500 dark:text-gray-400">
                                No files found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament::section>
