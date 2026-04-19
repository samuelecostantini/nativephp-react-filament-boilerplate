<?php

namespace App\Filament\Admin\Resources\SystemMonitor\Pages;

use App\Filament\Admin\Resources\SystemMonitor\SystemMonitorResource;
use Filament\Actions;
use Filament\Resources\Pages\Page;

class SystemMonitor extends Page
{
    // 1. Link it back to your Resource
    protected static string $resource = SystemMonitorResource::class;

    // Define a view for this custom page
    protected string $view = 'filament.admin.resources.system-monitor.pages.system-monitor';

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationLabel = 'Developer Monitor';

    public function getTitle(): string
    {
        return 'Developer Monitor';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('refresh')
                ->label('Refresh')
                ->action(fn () => $this->refresh()),
        ];
    }
}
