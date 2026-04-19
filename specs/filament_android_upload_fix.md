# Plan: Resolve Filament File Upload Issue in Android Native Environment

## Problem Analysis
The `FileUpload` component in `BrandForm` is currently configured to use the `public` disk and the `brands` directory. 
In a NativePHP Mobile environment, file handling behaves differently than in a web-only Laravel application. Specifically, the Android WebView may have limitations in accessing the local file system or handling multipart form data file uploads when using the standard Laravel `public` disk driver, which often maps to `storage/app/public` in a web context.

## Investigation Strategy
1.  **Verify WebView Permissions/Environment:** Ensure the Android manifest and NativePHP configuration allow for file system access and that the WebView's file upload intent is correctly handled.
2.  **Inspect Storage Configuration:** Verify if `storage/app/public` is accessible or if we need to use a specific `NativePHP` file storage driver/approach for mobile.
3.  **Test File Upload Flow:** Use a simple test to see if the file picker triggers and if the file metadata is correctly received by the server side.

## Proposed Steps
1.  **Check NativePHP Documentation:** Consult the NativePHP Mobile documentation regarding file uploads and `FileUpload` component compatibility.
2.  **Identify Android-Specific Limitations:** Look for known issues with `Filament`'s `FileUpload` in a WebView context (e.g., mime type handling, file access permissions).
3.  **Implement Necessary Changes:** 
    *   If permissions are missing, adjust `AndroidManifest.xml` (or NativePHP equivalents).
    *   If disk configuration is the issue, provide a `NativePHP`-compatible storage path or driver.
4.  **Verification:** Create a test case or perform a smoke test on the Android device to confirm the file upload functions correctly after the changes.

## Timeline
- Research (1 hour)
- Implementation (1-2 hours)
- Verification (1 hour)
