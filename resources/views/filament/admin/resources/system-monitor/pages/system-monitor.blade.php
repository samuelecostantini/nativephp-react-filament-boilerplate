<x-filament-panels::page>
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    <div class="space-y-6">
        <div class="mb-5">
            <x-filament::section class="space-y-6">
                @livewire(\App\Filament\Admin\Widgets\SystemOverview::class)

                @livewire(\App\Filament\Admin\Widgets\FileBrowser::class)

                @livewire(\App\Filament\Admin\Widgets\LogViewer::class)

                @livewire(\App\Filament\Admin\Widgets\DatabaseViewer::class)
            </x-filament::section>
        </div>

    </div>
</x-filament-panels::page>
