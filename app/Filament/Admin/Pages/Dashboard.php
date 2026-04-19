<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Panel;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Schema;
use Illuminate\Foundation\Application;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard';

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $slug = 'dashboard';

    protected static ?int $navigationSort = -1;

    public static function getRoutePath(Panel $panel): string
    {
        return '/';
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('NativePHP + Filament + React Boilerplate')
                    ->description('A starter template for building mobile-first applications with embedded PHP and modern React frontend.')
                    ->icon('heroicon-o-rocket-launch')
                    ->collapsible()
                    ->schema([
                        Text::make('description')
                            ->content('This boilerplate provides a minimal structure to build upon, combining Laravel backend, Filament admin panel, and React frontend for mobile deployment.'),
                    ]),

                Section::make('Technology Stack')
                    ->icon('heroicon-o-cube')
                    ->collapsible()
                    ->schema([
                        Text::make('stack1')->content('• Laravel 12 with SQLite for backend'),
                        Text::make('stack2')->content('• Filament v5 admin panel for user management'),
                        Text::make('stack3')->content('• React 19 + Inertia v2 + Tailwind v4 for frontend'),
                        Text::make('stack4')->content('• NativePHP Mobile v3 for Android deployment'),
                    ]),

                Section::make('Quick Commands')
                    ->icon('heroicon-o-command-line')
                    ->collapsible()
                    ->schema([
                        Text::make('cmd1')->content('• composer run dev — Start development server'),
                        Text::make('cmd2')->content('• npm run build — Compile frontend assets'),
                        Text::make('cmd3')->content('• composer run test — Run Pest tests'),
                        Text::make('cmd4')->content('• php artisan native:run --android — Run on Android'),
                    ]),

                Section::make('Android Build Configuration')
                    ->icon('heroicon-o-device-phone-mobile')
                    ->collapsible()
                    ->schema([
                        Text::make('android1')->content('• minSdk: 33 (Android 13 minimum)'),
                        Text::make('android2')->content('• targetSdk/compileSdk: 36'),
                        Text::make('android3')->content('• ABI: arm64-v8a only'),
                        Text::make('android4')->content('• Portrait mode only'),
                        Text::make('android5')->content('• Configure app ID in config/nativephp.php'),
                    ]),

                Section::make('Getting Started')
                    ->icon('heroicon-o-book-open')
                    ->collapsible()
                    ->schema([
                        Text::make('step1')->content('1. Clone this boilerplate'),
                        Text::make('step2')->content('2. Run composer run setup'),
                        Text::make('step3')->content('3. Update config/nativephp.php with your app details'),
                        Text::make('step4')->content('4. Create your models, migrations, and Filament resources'),
                        Text::make('step5')->content('5. Build your frontend in resources/js/Pages/'),
                        Text::make('step6')->content('6. Update CLAUDE.md with your project specifics'),
                    ]),

                Section::make('System Information')
                    ->icon('heroicon-o-information-circle')
                    ->collapsible()
                    ->schema([
                        Text::make('php_version')
                            ->content('PHP Version: '.phpversion()),
                        Text::make('laravel_version')
                            ->content('Laravel Version: '.Application::VERSION),
                        Text::make('environment')
                            ->content('Environment: '.config('app.env')),
                    ]),
            ]);
    }
}
