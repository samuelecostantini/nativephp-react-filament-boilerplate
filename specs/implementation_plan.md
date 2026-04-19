# Totem Ariston - Implementation Plan

This document outlines the step-by-step plan to bootstrap and implement the Totem Ariston project using Laravel, NativePHP, Filament, and Inertia+React.

## Phase 1: Project Initialization & Dependencies

The current project is a fresh NativePHP Mobile starter. We need to install the required stack components.

### 1.1 Backend Dependencies (Composer)
- **Filament**: For the Admin Panel.
- **Inertia.js (Server-side)**: For the frontend adapter.

```bash
composer require filament/filament
composer require inertiajs/inertia-laravel
```

### 1.2 Frontend Dependencies (NPM)
- **React & ReactDOM**: Frontend framework.
- **Inertia.js (Client-side)**: React adapter.
- **Vite Plugin React**: For building React.

```bash
npm install @inertiajs/react react react-dom @vitejs/plugin-react
```

### 1.3 Configuration
- **Vite Config**: Update `vite.config.js` to support React.
- **Inertia Setup**:
    - Run `php artisan inertia:middleware`.
    - Register middleware in `bootstrap/app.php`.
    - Create `resources/views/app.blade.php` (Root template).
    - Initialize React app in `resources/js/app.jsx`.

## Phase 2: Database Modeling

We will use SQLite (already configured in NativePHP starter).

### 2.1 Brands Table
Stores the brand configuration.
- `id`
- `name` (Ariston, Chaffoteaux, Wolf)
- `slug` (unique)
- `primary_color` (for theming)
- `secondary_color`
- `logo_path`
- `is_active` (boolean, for event selection)
- `timestamps`

### 2.2 Quizzes & Questions
Structure for the game.
- **Table: `quizzes`**
    - `id`
    - `brand_id` (FK)
    - `title`
    - `description`
    - `is_active`
- **Table: `questions`**
    - `id`
    - `quiz_id` (FK)
    - `text`
    - `order`
    - `type` (single_choice, multiple_choice)
- **Table: `answers`**
    - `id`
    - `question_id` (FK)
    - `text`
    - `is_correct` (boolean)

### 2.3 Leads
Stores user data collected at the end of the game.
- **Table: `leads`**
    - `id`
    - `brand_id` (FK)
    - `first_name`
    - `last_name`
    - `email`
    - `quiz_result_score` (optional)
    - `created_at` (timestamp)

## Phase 3: Admin Panel (Filament)

### 3.1 Setup
- Run `php artisan filament:install --panels`.
- Create a new Admin User.

### 3.2 Resources
- **BrandResource**: Manage brands and their themes.
- **QuizResource**: Manage quizzes. Use `Repeater` or `RelationManager` to manage Questions and Answers within the Quiz form for better UX.
- **LeadResource**:
    - `index`: List all leads with filtering by Brand.
    - `export`: Add a Header Action to export leads to CSV/Excel.

## Phase 4: Frontend Development (Inertia + React)

### 4.1 Layouts
- **MainLayout**: For the Brand Selection screen.
- **BrandLayout**: Dynamic layout that reads the selected Brand's colors/logo and applies them to the UI.

### 4.2 Pages
1.  **Home (`/`)**:
    -   Display 3 large cards/buttons for Brand Selection (Ariston, Chaffoteaux, Wolf).
    -   Redirects to `/brand/{slug}`.

2.  **Brand Dashboard (`/brand/{slug}`)**:
    -   The "Homepage" requested by the user.
    -   3 Buttons:
        1.  **"Scopri di più" (Show PDF)** -> Navigates to PDF Viewer.
        2.  **"Vai nel simulatore" (Show Tool)** -> Navigates to Simulator.
        3.  **"Fai il quiz" (Show Game)** -> Navigates to Quiz Start.

3.  **PDF Viewer (`/brand/{slug}/info`)**:
    -   Embeds a PDF or interactive infographic using a React PDF viewer or standard `<iframe>`/`<object>`.

4.  **Simulator (`/brand/{slug}/simulator`)**:
    -   Loads the local simulator tool (likely an iframe to a static HTML build or a specific React component if the tool is rebuilt). *Assumption: It's a separate offline-capable web module.*

5.  **Quiz Flow (`/brand/{slug}/quiz`)**:
    -   **Start Screen**: Instructions.
    -   **Question Screen**: Display question & answers. Handle state locally or via Inertia visits (Local state preferred for speed in a game).
    -   **Result/Lead Form**:
        -   Display Score.
        -   Form: Name, Surname, Email.
        -   Submit -> Save Lead.
        -   Show QR Code (xBonus).

## Phase 5: NativePHP & Offline Integration

### 5.1 Asset Management
- Ensure PDF files and Simulator assets are placed in `public/` or `storage/app/public` so they are accessible offline.
- NativePHP serves the `public` directory.

### 5.2 Build & Run
- Run `npm run build` to compile React assets.
- Run `php artisan native:serve` to test locally.
- Run `php artisan native:build` for Android APK generation.

## Next Steps
1.  Approve this plan.
2.  Execute Phase 1 (Install Dependencies).
3.  Execute Phase 2 (Database & Models).
4.  Execute Phase 3 (Filament).
5.  Execute Phase 4 (Frontend).
