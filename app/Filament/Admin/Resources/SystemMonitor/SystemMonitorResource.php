<?php

namespace App\Filament\Admin\Resources\SystemMonitor;

use App\Filament\Admin\Resources\SystemMonitor\Pages\SystemMonitor;
use Filament\Resources\Resource;

class SystemMonitorResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;

    public static function getPages(): array
    {
        return [
            'index' => SystemMonitor::route('/'),
        ];
    }
}
