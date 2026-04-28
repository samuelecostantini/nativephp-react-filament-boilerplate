# Orphaned Services, Classes and Functions

> Generated on 2026-04-28

---

## Missing Classes with Dangling References (Broken Code)

These classes are imported or instantiated by application code, but the actual files do not exist.

### `App\Models\Brand`
- **Referenced by:** `app/Providers/AppServiceProvider.php`
- **Issue:** `AppServiceProvider::boot()` imports and queries `Brand::query()->exists()`, but no `Brand.php` model exists in `app/Models/`. No migration for a `brands` table exists either.
- **Action:** Create the model and migration, or remove the dead code from `AppServiceProvider::boot()`.

### `App\Actions\SendEmailAction`
- **Referenced by:** `tests/Feature/Actions/SendEmailActionTest.php`
- **Issue:** The test file instantiates `new SendEmailAction(...)` four times, but `app/Actions/` is completely empty and the class was never created.
- **Action:** Create the missing action class, or delete the orphaned test file.

---

## Orphaned Test Files

### `Tests\Feature\Actions\SendEmailActionTest`
- **File:** `tests/Feature/Actions/SendEmailActionTest.php`
- **Issue:** Tests `App\Actions\SendEmailAction`, which does not exist. The tests will fatal-error on execution.
- **Action:** Remove the file or implement the missing action class.

---

## Unused Methods

### `Database\Factories\UserFactory::unverified()`
- **File:** `database/factories/UserFactory.php:38`
- **Issue:** Defined as a factory state method but never called anywhere in the codebase.
- **Action:** Remove if not needed, or start using it in tests.

### `Database\Seeders\DatabaseSeeder::run()`
- **File:** `database/seeders/DatabaseSeeder.php:12`
- **Issue:** Method body is empty and no seeders are invoked within it. While Laravel may resolve this class via `db:seed`, it performs no work.
- **Action:** Populate with seeders or remove the file if seeding is unused.

---

## Unused Functions

### `something()`
- **File:** `tests/Pest.php:44`
- **Issue:** Helper function defined for Pest tests but never called in any test file.
- **Action:** Remove if not needed.

### `toBeOne()`
- **File:** `tests/Pest.php:29`
- **Issue:** Pest expectation extension defined but never used in any test.
- **Action:** Remove if not needed.
