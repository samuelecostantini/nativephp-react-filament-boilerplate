
# Boilerplate Guide: NativePHP Mobile with Inertia & Filament

This guide provides a generic, plug-and-play boilerplate for creating a NativePHP mobile application using the TALL stack (Tailwind CSS, Alpine.js, Laravel, Livewire) along with Inertia.js and Filament.

## 1. Project Initialization

### 1.1. Create a New Laravel Project

First, create a new Laravel project.

```bash
composer create-project laravel/laravel my-app
cd my-app
```

### 1.2. Configure the Database

This boilerplate uses SQLite for local development. Create a `database.sqlite` file.

```bash
touch database/database.sqlite
```

Then, update your `.env` file to use the `sqlite` driver:

```
DB_CONNECTION=sqlite
DB_DATABASE=/path/to/your/project/database/database.sqlite
```

## 2. Install Dependencies

### 2.1. Composer Dependencies

Install the required Composer packages for NativePHP, Filament, and Inertia.

```bash
composer require nativephp/mobile:^3.0
composer require filament/filament:^5.0
composer require inertiajs/inertia-laravel:^2.0
```

### 2.2. NPM Dependencies

Install the required NPM packages for the frontend, including React, Inertia, and Tailwind CSS.

```bash
npm install
npm install @inertiajs/react:^2.3.18 @vitejs/plugin-react:^6.0.1 react:^19.2.4 react-dom:^19.2.4
npm install -D @tailwindcss/vite:^4.0.0 tailwindcss:^4.0.0
```

## 3. Configuration

### 3.1. Vite

Update your `vite.config.js` to include the React plugin.

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.jsx',
            refresh: true,
        }),
        react(),
    ],
});
```

### 3.2. Tailwind CSS

Create a `tailwind.config.js` file:

```bash
npx tailwindcss init
```

Then, configure the content paths in `tailwind.config.js`:

```javascript
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.jsx",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
```

### 3.3. Inertia

Run the Inertia middleware command:

```bash
php artisan inertia:middleware
```

Register the middleware in `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->web(append: [
        \App\Http\Middleware\HandleInertiaRequests::class,
    ]);
})
```

Create the root Blade view at `resources/views/app.blade.php`:

```html
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    @viteReactRefresh
    @vite('resources/js/app.jsx')
    @inertiaHead
  </head>
  <body>
    @inertia
  </body>
</html>
```

Finally, initialize the React app in `resources/js/app.jsx`:

```javascript
import './bootstrap';
import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client'

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.jsx', { eager: true })
    return pages[`./Pages/${name}.jsx`]
  },
  setup({ el, App, props }) {
    createRoot(el).render(<App {...props} />)
  },
})
```

## 4. Filament & Database

### 4.1. Install Filament

Run the Filament installation command:

```bash
php artisan filament:install --panels
```

### 4.2. Migrations

This boilerplate includes several migrations to set up the database schema.

**`create_users_table`**
```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
});
```

**`create_brands_table`**
```php
Schema::create('brands', function (Blueprint $blueprint) {
    $blueprint->id();
    $blueprint->string('name');
    $blueprint->string('slug')->unique();
    $blueprint->string('primary_color')->nullable();
    $blueprint->string('secondary_color')->nullable();
    $blueprint->string('logo_path')->nullable();
    $blueprint->boolean('is_active')->default(true);
    $blueprint->timestamps();
});
```

**`create_quizzes_table`**
```php
Schema::create('quizzes', function (Blueprint $blueprint) {
    $blueprint->id();
    $blueprint->foreignId('brand_id')->constrained()->cascadeOnDelete();
    $blueprint->string('title');
    $blueprint->text('description')->nullable();
    $blueprint->boolean('is_active')->default(true);
    $blueprint->timestamps();
});
```

**`create_questions_table`**
```php
Schema::create('questions', function (Blueprint $blueprint) {
    $blueprint->id();
    $blueprint->foreignId('quiz_id')->constrained()->cascadeOnDelete();
    $blueprint->text('text');
    $blueprint->integer('order')->default(0);
    $blueprint->string('type')->default('single_choice');
    $blueprint->timestamps();
});
```

**`create_answers_table`**
```php
Schema::create('answers', function (Blueprint $blueprint) {
    $blueprint->id();
    $blueprint->foreignId('question_id')->constrained()->cascadeOnDelete();
    $blueprint->text('text');
    $blueprint->boolean('is_correct')->default(false);
    $blueprint->timestamps();
});
```

**`create_leads_table`**
```php
Schema::create('leads', function (Blueprint $blueprint) {
    $blueprint->id();
    $blueprint->foreignId('brand_id')->constrained()->cascadeOnDelete();
    $blueprint->string('first_name');
    $blueprint->string('last_name');
    $blueprint->string('email');
    $blueprint->integer('quiz_result_score')->nullable();
    $blueprint->timestamps();
});
```

### 4.3. User Seeder

Create a seeder for the Filament admin user.

```bash
php artisan make:seeder UserSeeder
```

```php
// database/seeders/UserSeeder.php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@admin.it'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );
    }
}
```

Now, add the seeder to `DatabaseSeeder.php`:

```php
// database/seeders/DatabaseSeeder.php
public function run(): void
{
    $this->call([
        UserSeeder::class,
    ]);
}
```

Run the migrations and seed the database:

```bash
php artisan migrate --seed
```

## 5. NativePHP Setup

Install NativePHP:

```bash
php artisan native:install
```

## 6. Build & Run

### 6.1. Build Frontend Assets

Compile your frontend assets.

```bash
npm run build
```

### 6.2. Run the Application

Serve the application to start development.

```bash
php artisan native:serve
```

You can now access your Filament admin panel at `/admin` and start building your Inertia pages.
