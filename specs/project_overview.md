# Project Overview: NativePHP + Filament + Inertia React Boilerplate

**Date:** 2026-04-28

---

## Purpose

This repository is a **boilerplate / starter template** for building mobile-first applications with:

- **Backend:** Laravel 12 (PHP 8.3+)
- **Admin Panel:** Filament v5
- **Frontend:** React 19 + Inertia.js v2 + Tailwind CSS v4
- **Mobile Runtime:** NativePHP Mobile v3
- **Testing:** Pest PHP v4

> **Note:** This project was forked from a previous quiz application ("Totem Ariston"). The old implementation plans, designs, and specs remain in the `specs/` directory as artifacts, but they are **not part of the boilerplate scope**.

---

## What Is Implemented

### Infrastructure & Configuration (100% complete)
- Composer dependencies and NPM packages installed and locked
- Vite configured with React plugin, Tailwind v4, and NativePHP plugins (`nativephpMobile()`, `nativephpHotFile()`)
- Inertia middleware registered in `bootstrap/app.php`
- Root Blade view (`resources/views/app.blade.php`) with `nativephp-safe-area` support
- React entry point (`resources/js/app.jsx`) with code-splitting, prefetch (5m), and hover delay configured
- NativePHP configured for Android (minSdk 33, targetSdk 36, arm64-v8a) with camera, storage, and network permissions
- Auto-migration logic in `AppServiceProvider` for NativePHP context
- `composer run dev` and `composer run native:clean-run` scripts ready

### Database
- Default Laravel tables: `users`, `cache`, `jobs`
- Filament system tables: `notifications`, `imports`, `exports`, `failed_import_rows`
- Admin user seeder (`admin@admin.it`)
- Only model: `User` (with Factory)

### Backend Code
- Single route `/` pointing to `HomeController::index`
- `HandleInertiaRequests` middleware
- Filament Admin Panel at `/admin`
- Filament Resources:
  - `UserResource` (CRUD for admins)
  - `SystemMonitorResource` (with Livewire widgets: SystemOverview, FileBrowser, LogViewer, DatabaseViewer)

### Frontend
- Single page: `resources/js/Pages/HomeView.jsx` — a styled welcome/landing page showcasing the tech stack
- No other React components, layouts, or pages

### Tests
- Pest setup active
- 2 example tests passing
- 1 orphaned test: `tests/Feature/Actions/SendEmailActionTest.php` references `App\Actions\SendEmailAction` which **does not exist** (leftover from previous project)

---

## Boilerplate Completeness Checklist

A production-ready boilerplate should ideally include the following. Items marked [x] are done; items marked [ ] are still missing or need cleanup.

### Core Setup
- [x] Laravel 12 installed and configured
- [x] SQLite as default database
- [x] Filament v5 admin panel
- [x] Inertia.js v2 with React adapter
- [x] Tailwind CSS v4 with Vite plugin
- [x] NativePHP Mobile v3 installed and configured
- [x] Vite dev/build pipeline

### Project Hygiene
- [ ] Remove orphaned test (`SendEmailActionTest.php` referencing non-existent action)
- [ ] Clean up leftover specs from previous project (quiz logic, front-end designs)
- [ ] Add a proper `.env.example` with NativePHP-related variables documented
- [ ] Ensure `README.md` is boilerplate-focused, not quiz-focused

### Documentation
- [ ] `README.md` should explain:
  - How to clone and run `composer run setup`
  - How to configure `config/nativephp.php` (app_id, deeplinks, orientation)
  - How to add new models, Filament resources, and React pages
  - How to build and run on Android/iOS
- [ ] `CLAUDE.md` is already present and accurate

### Starter Code
- [x] Single `HomeView.jsx` welcome page
- [ ] Optional: Example `Layout.jsx` component
- [ ] Optional: Example Inertia `Link` navigation
- [ ] Optional: Example form with `useForm`
- [ ] Optional: Example API route + controller returning Inertia props
- [ ] Optional: Example of using `#nativephp` JS imports

### Testing
- [x] Pest configured
- [ ] Add at least 1 feature test proving the Inertia home page loads
- [ ] Add at least 1 test proving Filament admin is accessible

---

## Leftover Artifacts from Previous Project

The following files/directories contain content from the old "Totem Ariston" quiz application and should be reviewed for deletion or archival:

- `specs/implementation_plan.md`
- `specs/quiz_logic_plan.md`
- `specs/reshuffle_questions_plan.md`
- `specs/front-end/refactor-front-end.md`
- `specs/chat_summary_quiz_view_refactor.md`
- `specs/filament_405_error_fix.md`
- `specs/filament_android_upload_fix.md`
- `specs/lead_export_mail_integration_plan.md`
- `specs/ralph_plan_filament_upload.md`
- `specs/server_side_mail_fix_plan.md`
- `specs/ui_resolution_fix.md`
- `specs/QUIZ INCENTIVI STATALI vE 2026.pptx`
- `tests/Feature/Actions/SendEmailActionTest.php`

---

## Summary

**The boilerplate foundation is solid and ready to use.** The stack is wired correctly, builds work, and the admin panel is functional. The main remaining tasks are:

1. **Clean up** leftover specs, tests, and any stale references from the old quiz project.
2. **Improve documentation** (`README.md`) so a new user knows exactly how to bootstrap their own app from this template.
3. **Optionally add** a few more starter examples (layout, form, native API usage) to make the boilerplate more immediately useful.
