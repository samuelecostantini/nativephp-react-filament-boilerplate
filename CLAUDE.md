# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Totem Ariston is an interactive kiosk/totem application for Ariston Group brands (Ariston, Chaffoteaux, Wolf). Built as a NativePHP Mobile app targeting Android, it runs a full PHP runtime on-device with SQLite — no remote server needed.

The app presents brand selection → dashboard with three actions: product info viewer, interactive simulator (iframe), and quiz game with lead capture.

## Commands

```bash
# Development
composer run dev              # Starts server, queue, logs, and Vite concurrently
npm run dev                   # Vite dev server only
npm run build                 # Compile frontend assets

# Testing
composer run test             # Clear config + run Pest tests
php artisan test --compact    # Run tests directly
php artisan test --compact --filter=testName  # Single test

# Code formatting (run after modifying PHP files)
vendor/bin/pint --dirty --format agent

# NativePHP Mobile
composer run native:clean-run --android  # Build assets + clear cache + run on Android
composer run native:android:sync-run     # Fresh migrate+seed, export data, build, clear app, run Android
php artisan native:run --android         # Run on Android emulator/device
php artisan native:run --ios             # Run on iOS simulator (macOS only)
php artisan native:tail                  # View device logs
php artisan native:open                  # Open project in Android Studio

# Setup (first time)
composer run setup

# Data management
php artisan data:export                    # Export brands/quizzes to database/data/sync.json
```

**NativePHP build/run commands must be given to the user to run manually — never execute them yourself.**

## Android Build Configuration

- **minSdk**: 33 (Android 13 is the minimum supported device)
- **targetSdk/compileSdk**: 36
- **ABI**: arm64-v8a only (no 32-bit ARM or x86 support)
- **applicationId**: `com.samuelecostantini.totem_ariston`
- Build config is in `nativephp/android/app/build.gradle.kts`
- Android Studio project lives in `nativephp/android/`

## Data Model

```
Brand (name, slug, colors, logo_path, colored_logo_path, pdf_path, simulator_url)
  └─ HasMany Quiz (title, description, difficulty, time, number_of_questions)
       └─ HasMany Question (text, order, type, difficulty)
            └─ HasMany Answer (text, is_correct)
  └─ HasMany Lead (first_name, last_name, email, quiz_result_score, privacy_consent)
```

- Use `Brand::with(['quizzes.questions.answers'])` to eager load all quiz data
- Quiz data is exported to `database/data/sync.json` for version control
- Use `InitialDataSeeder` to seed from sync.json
- Brand models have appended accessors (`logo_url`, `colored_logo_url`, `pdf_url`) that detect NativePHP mobile vs web context

## Architecture

### Backend (Laravel 12 — streamlined structure)
- **Routes**: `routes/web.php` — SPA with Inertia, two main routes: `/` (home) and `/brand/{slug}/{view?}` (deep link fallback). Lead capture via POST `/brand/{slug}/quiz/lead`. Quiz by difficulty: `/brand/{slug}/quiz/{difficulty}`.
- **Controllers**: `HomeController` loads brands+quizzes; `QuizController` generates quiz questions by difficulty via `QuizGeneratorService`.
- **Models**: Brand → Quiz → Question → Answer (nested with cascade deletes). Lead stores quiz results + contact info.
- **Enum**: `Difficulty` — Beginner/Intermediate/Pro with Italian labels (Principiante/Intermedio/Professionista).
- **Services**: `QuizGeneratorService` — generates question sets based on difficulty (Beginner: 3 random beginner questions, Intermediate: 3 intermediate, Pro: all pro questions from a random pro quiz).
- **Actions**: `HandshakeAction` (queued) — authenticates with external server, stores encrypted token. `SendEmailAction` (queued) — sends CSV exports via HTTP to external mail endpoint.
- **Admin**: Filament v5 at `/admin` — BrandResource, QuizResource, LeadResource, UserResource, SystemMonitorResource. Each resource uses Schema/Table folder pattern (e.g., `app/Filament/Admin/Resources/Brands/{Schema,Table}/*`). Custom login dispatches `HandshakeAction`. System Monitor page with widgets (DatabaseViewer, FileBrowser, LogViewer, SystemOverview) — admin-only.
- **Database**: SQLite. Seed with `InitialDataSeeder` (3 brands with quizzes from `database/data/sync.json`). `AppServiceProvider` auto-migrates and auto-seeds when running in NativePHP.
- **Config**: `config/nativephp.php` for mobile app settings (permissions, orientation, deep links, hot reload).
- **Middleware**: `HandleInertiaRequests` in `bootstrap/app.php` configures Inertia root template and CSRF exceptions for `_native/*`.
- **Exception handling**: `bootstrap/app.php` catches `TypeError` from `transliterator_transliterate` and throws `RuntimeException` instead — compatibility fix for Android devices lacking ICU transliteration.

### Frontend (React 19 + Inertia v2 + Tailwind v4)
- **Entry**: `resources/js/app.jsx` — Inertia React app with prefetch (5m), hoverDelay 150
- **Single-page flow**: `Home.jsx` manages all view state (1080x1920 viewport scaled to fit); sub-views render based on state, not routes. Easter egg: 10 clicks on Ariston logo → /admin.
- **Component structure**: `resources/js/Pages/Home/` with `Views/` (SelectionView, DashboardView, InfoView, SimulatorView, QuizView, ResultView, GameOverView) and `Components/` (BrandCard, ActionButton)
- **Animations**: Framer Motion with AnimatePresence for view transitions
- **Theming**: Brand colors (`primary_color`) applied dynamically via inline styles
- **PDF viewer**: `InfoView` uses react-pdf with swipe navigation (framer-motion drag) and page indicator. PDF.js worker at `public/js/pdf.worker.min.js`.
- **Icons**: Custom SVG components in `resources/js/Components/Icons/`
- **Asset helper**: `resources/js/Utils/Asset.jsx` — `getNativePath()` for native asset paths
- **Tailwind v4**: Uses `@tailwindcss/vite` plugin — no `tailwind.config.js` needed
- **Vite**: Configured with `nativephpMobile()` and `nativephpHotFile()` plugins
- **Fonts**: Inter + Instrument Sans loaded in `resources/views/app.blade.php`

### Mobile (NativePHP v3)
- Runs embedded PHP + SQLite on device
- JS bridge available via `import { ... } from '#nativephp'` (aliased in package.json)
- Body uses `nativephp-safe-area` class for notch handling
- Layout in `resources/views/app.blade.php` (Blade wraps the Inertia React app)
- Portrait mode only on both Android and iOS
- Permissions: camera, storage_read, storage_write, network_state enabled; biometric/microphone/location/push_notifications disabled
- Lead export: on native, shares CSV file via device share sheet; on web, downloads file. Sends to external email API via `SendEmailAction`.
- Storage route: `GET /storage/{path}` serves files from storage/app/public for NativePHP context

## External API Integration

The app integrates with an external mail server for authentication and lead export delivery:
- Auth: `{SERVER_MAIL_ENDPOINT}/api/totem/auth` — `HandshakeAction` POSTs credentials, stores encrypted token in Cache + SecureStorage
- Mail: `{SERVER_MAIL_ENDPOINT}/api/totem/send-email` — `SendEmailAction` sends CSV exports with auth token
- Config in `config/mail.php` under `server_mail` key

## State Flow

```
Selection → BrandSelect → Dashboard → (Info/Simulator/Quiz) → Back
                                              ↓
                                    Quiz: Beginner → Intermediate → Pro
                                              ↓
                                    QuizResult → LeadForm → Finished
                                              ↓
                                    GameOverView (3 attempts exhausted)
```

- State managed in `Home.jsx` with `view` and `selectedBrand` state
- Inertia routes support deep linking: `/brand/{slug}/{view?}`
- Quiz results submitted to `/brand/{slug}/quiz/lead` POST endpoint
- QuizView has 3 difficulty levels with 3 attempts, timer, and level progression

## Skills Activation

Activate the relevant skill when working in that domain:

- `pest-testing` — Pest PHP testing in Laravel projects
- `inertia-react-development` — Inertia.js v2 React client-side applications
- `tailwindcss-development` — Tailwind CSS styling (always activate when 'tailwind' is mentioned)
- `nativephp-mobile` — NativePHP Mobile app development

## Foundational Context

- php - 8.4
- filament/filament - v5
- inertiajs/inertia-laravel - v2
- laravel/framework - v12
- pestphp/pest - v4
- @inertiajs/react - v2
- react - v19
- tailwindcss - v4
- nativephp/mobile - ~3.1.0