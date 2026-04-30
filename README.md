# NativePHP + Filament + React Boilerplate

[![Laravel 12](https://img.shields.io/badge/Laravel-12-red)](...)
[![NativePHP](https://img.shields.io/badge/NativePHP-v3-blue)](...)
[![Filament](https://img.shields.io/badge/Filament-v5-pink)](...)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](...)

A modern, batteries-included starter template for building native mobile applications with PHP, Laravel, and React.

## Features

- **Laravel 12** - Latest streamlined structure with PHP 8.4
- **Filament v5** - Admin panel with user management & system monitoring
- **React 19 + Inertia v2** - Modern SPA experience without API complexity
- **Tailwind CSS v4** - Utility-first styling with Vite integration
- **NativePHP Mobile v3** - Build native iOS/Android apps with PHP
- **Pest v4** - Modern PHP testing framework
- **SQLite** - Zero-config database, perfect for mobile

## Requirements

- PHP 8.4+
- Composer
- Node.js 20+
- Android Studio (for Android development)
- Xcode (for iOS development, macOS only)

## Quick Start

```bash
# Clone the repository
git clone <repository-url>
cd nativephp-filament-react-boilerplate

# Install dependencies and setup
composer run setup

# Configure your app
cp .env.example .env
php artisan key:generate

# Start development server
composer run dev
```

## Development Commands

```bash
# Full development stack (server + queue + logs + Vite)
composer run dev

# Frontend only
npm run dev

# Build for production
npm run build

# Run tests
composer run test
php artisan test --compact

# Code formatting (run after modifying PHP files)
vendor/bin/pint --dirty --format agent
```

## NativePHP Mobile Development

### Android

```bash
# Build and run on Android
composer run native:clean-run --android

# Or manually
npm run build -- --mode=android
php artisan native:run --android

# View device logs
php artisan native:tail

# Open in Android Studio
php artisan native:open
```

### iOS (macOS only)

```bash
# Build and run on iOS
npm run build -- --mode=ios
php artisan native:run --ios

# With hot reload
php artisan native:run ios --watch
```

**Important:** NativePHP build/run commands should be run manually in your terminal, not via automated scripts.

## Project Structure

```
├── app/
│   ├── Filament/Admin/Resources/    # Filament admin resources
│   ├── Http/Controllers/            # Web controllers
│   ├── Models/                      # Eloquent models
│   └── Providers/                   # Service providers
├── config/
│   └── nativephp.php               # Mobile app configuration
├── nativephp/
│   └── android/                    # Android Studio project
├── resources/
│   ├── js/
│   │   ├── Pages/                  # Inertia React pages
│   │   ├── Components/             # React components
│   │   └── app.jsx                 # App entry point
│   ├── views/
│   │   └── app.blade.php           # Root Inertia template
│   └── css/app.css                 # Tailwind imports
├── routes/
│   └── web.php                     # Web routes
└── tests/
    ├── Feature/                    # Feature tests (Pest)
    └── Unit/                       # Unit tests
```

## Configuration

### Mobile App Settings

Edit `config/nativephp.php`:

```php
'app' => [
    'name' => 'Your App Name',
    'version' => '1.0.0',
],
'android' => [
    'min_sdk' => 33,        // Android 13+
    'target_sdk' => 36,
    'application_id' => 'com.yourcompany.yourapp',
],
'permissions' => [
    'camera',
    'storage_read',
    'storage_write',
    'network_state',
],
```

### Default Credentials

After running `composer run setup`, a default admin user is created:
- **Email:** admin@example.com
- **Password:** password

## Admin Panel

Access the Filament admin panel at `/admin`:

- **Users** - Manage application users
- **System Monitor** - View logs, file browser, database, and system stats

## Key Technologies

| Package | Version | Purpose |
|---------|---------|---------|
| laravel/framework | 12.x | Backend framework |
| filament/filament | 5.x | Admin panel |
| nativephp/mobile | ~3.1 | Mobile app framework |
| inertiajs/inertia-laravel | 2.x | SPA without API |
| @inertiajs/react | 2.x | React integration |
| react | 19.x | UI library |
| tailwindcss | 4.x | Styling |
| pestphp/pest | 4.x | Testing |

## Mobile-First Design

This boilerplate is optimized for mobile app development:

- Portrait orientation by default
- Safe area handling for notches/dynamic islands
- Touch-friendly UI components
- Native device API access via `#nativephp` imports
- SQLite database runs embedded on device

## Testing

```bash
# Run all tests
php artisan test --compact

# Run specific test
php artisan test --compact --filter=testName

# Run with coverage
php artisan test --coverage
```

## Customization

### Adding Models

```bash
php artisan make:model Post --factory --migration
```

### Creating Filament Resources

```bash
php artisan make:filament-resource Post
```

### Creating React Pages

Create a new file in `resources/js/Pages/`:

```jsx
import { Head } from '@inertiajs/react';

export default function MyPage() {
    return (
        <>
            <Head title="My Page" />
            <div className="p-4">
                <h1 className="text-xl font-bold">My Page</h1>
            </div>
        </>
    );
}
```

## Automated Updates

This repository includes a GitHub Action that runs daily to:

- Update Composer dependencies
- Update NPM packages
- Verify builds still work

## License

MIT License - feel free to use this boilerplate for any project.

## Resources

- [NativePHP Documentation](https://nativephp.com/docs/mobile/3/)
- [Laravel Documentation](https://laravel.com/docs/12.x)
- [Filament Documentation](https://filamentphp.com/docs)
- [Inertia.js Documentation](https://inertiajs.com/)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
