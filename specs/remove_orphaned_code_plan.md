# Remove Orphaned Code — Implementation Plan

## Context
`orphaned_code.md` identified dead code: missing classes with dangling references, an orphaned test file, unused methods, and unused helper functions. This plan documents the steps to clean them up safely.

---

## Step 1 — Fix the missing `Brand` model reference

**File:** `app/Providers/AppServiceProvider.php`

**Problem:** `boot()` imports `App\Models\Brand` and calls `Brand::query()->exists()`. The model does not exist.

**Action:**
- Inspect `AppServiceProvider::boot()` to understand what it does with the `Brand` query result.
- If the logic is still needed: create `app/Models/Brand.php` and the migration for the `brands` table.
- If the logic is obsolete: remove the `Brand` import and the related query call from `boot()`.

---

## Step 2 — Remove the orphaned `SendEmailAction` test

**File:** `tests/Feature/Actions/SendEmailActionTest.php`

**Problem:** Tests a class `App\Actions\SendEmailAction` that was never implemented. Running this test will fatal-error.

**Action:**
- Delete `tests/Feature/Actions/SendEmailActionTest.php`.
- If `app/Actions/` becomes empty, consider removing the directory or keeping it for future actions.

---

## Step 3 — Clean up unused Pest helpers

**File:** `tests/Pest.php`

**Problem:** Two helpers are defined but never used:
- `toBeOne()` — custom expectation extension (line ~29)
- `something()` — helper function (line ~44)

**Action:**
- Remove both unused function definitions from `tests/Pest.php`.

---

## Step 4 — Clean up unused factory state method

**File:** `database/factories/UserFactory.php`

**Problem:** `unverified()` state method is defined but never called in any test.

**Action:**
- Remove the `unverified()` method from `UserFactory`.

---

## Step 5 — Decide on `DatabaseSeeder`

**File:** `database/seeders/DatabaseSeeder.php`

**Problem:** `run()` has an empty body. The seeder does nothing.

**Action:**
- If seeding is not used in this project: delete the `DatabaseSeeder.php` file.
- If seeding might be needed later: populate `run()` with useful seeders (e.g., `UserSeeder`) or leave a TODO comment.

---

## Verification Checklist

- [ ] `php artisan config:cache` succeeds without errors
- [ ] `php artisan test --compact` passes (no fatal errors from missing classes)
- [ ] `vendor/bin/pint --dirty --format agent` passes after any PHP file edits
- [ ] `orphaned_code.md` is updated or deleted once cleanup is complete

---

## Order of Execution

1. Step 2 (remove broken test) — unblocks the test suite.
2. Step 1 (fix `Brand` reference) — removes the runtime error risk.
3. Steps 3 & 4 (remove helpers and unused method) — tidy up.
4. Step 5 (decide on `DatabaseSeeder`) — final cleanup.
