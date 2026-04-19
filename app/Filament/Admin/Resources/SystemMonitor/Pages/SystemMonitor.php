<?php

namespace App\Filament\Admin\Resources\SystemMonitor\Pages;

use BackedEnum;
use Filament\Actions;
use Filament\Resources\Pages\Page; // <-- Use the Resource Page class
use App\Filament\Admin\Resources\SystemMonitor\SystemMonitorResource;
use Filament\Support\Icons\Heroicon;

class SystemMonitor extends Page
{
    // 1. Link it back to your Resource
    protected static string $resource = SystemMonitorResource::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedCodeBracket;

    // 2. Define a view for this custom page
    protected string $view = 'filament.admin.resources.system-monitor.pages.system-monitor';

    protected static bool $shouldRegisterNavigation = true;

    public function getTitle(): string
    {
        return 'System Monitor';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('refresh')
                ->label('Refresh')
                ->icon('heroicon-m-arrow-path')
                ->action(fn () => $this->refresh()),
        ];
    }
}
