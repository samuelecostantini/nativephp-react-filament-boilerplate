# Implementation Plan: Server-Side Mail API Refactor

This plan outlines the necessary changes for the server-side project to optimize the `sendMail` endpoint and fix the attachment filename bug.

## 1. Problem Statement
The current implementation has three main issues:
1. **Redundant Data**: The CSV content is being sent twice (once as a multipart file and once as a `content` string field).
2. **Filename Bug**: The server uses `$file->getFilename()`, which returns the temporary PHP system name (e.g., `phpXYZ123`) instead of the user-friendly original name.
3. **Memory Inefficiency**: Reading the entire file into a request parameter (`content`) is less efficient than handling the `UploadedFile` stream.

## 2. Proposed Changes

### Task 1: Refactor `sendMail` Controller Method
- **File**: Likely `App\Http\Controllers\MailController` (or similar).
- **Changes**:
    - Extract the `UploadedFile` object using `$request->file('file')`.
    - Retrieve the original filename using `$file->getClientOriginalName()`.
    - Retrieve the file content directly from the file object using `$file->get()`.
    - Remove reliance on the `content` POST field.

**Before:**
```php
$file = $request->file('file');
Mail::to($payload->email)->send(new CsvReadyMail($request->get('content'), $file->getFilename()));
```

**After:**
```php
$file = $request->file('file');

if (!$file) {
    return response()->json(['message' => 'File not found'], 400);
}

Mail::to($payload->email)->send(new CsvReadyMail(
    $file->get(), 
    $file->getClientOriginalName()
));
```

### Task 2: Update Validation (Optional)
- If there is a FormRequest or inline validation, remove the `required` rule for the `content` field as it is no longer needed.

### Task 3: Update API Documentation
- Notify client-side developers that the `content` field is now deprecated/removed and that only the `file` multipart and `token` are required.

## 3. Verification Plan
- **Manual Test**: Use Postman or `curl` to send a multipart request with a `file` and a `token`.
- **Verify Email**: Ensure the received email:
    - Contains the correct CSV content.
    - Has the correct filename (e.g., `Doe_leads.csv` instead of `php...`).
