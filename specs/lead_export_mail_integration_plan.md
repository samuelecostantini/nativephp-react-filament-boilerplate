# Implementation Plan: Lead Export Mail Integration

This plan outlines the changes needed to automatically send a generated CSV export via the remote Mail API.

## 1. Research & Analysis
- **Filament Export Hook**: The `LeadExporter::getCompletedNotificationBody(Export $export)` static method is called by Filament's `ExportCompletion` job when the export is finished. This is our target hook.
- **Mail API Requirements**: The server expects a `POST` request to `/totem/send-mail` with:
    - `token`: JWT token.
    - `file`: Multipart CSV file.
    - `content`: Text content for the email body.
- **Authentication**: `HandshakeAction` retrieves and saves the token to `SecureStorage`.

## 2. Strategy
- Update `LeadExporter.php` to dispatch `SendEmailAction` within `getCompletedNotificationBody`.
- Update `SendEmailAction.php` to handle multipart file attachment and API communication.

## 3. Implementation Steps

### Task 1: Update `LeadExporter.php`
- Modify `getCompletedNotificationBody` to dispatch `SendEmailAction`.
- Use `$export->user` as the recipient.
- Construct the file path: `$export->getFileDirectory() . '/' . $export->file_name . '.csv'`.

### Task 2: Update `SendEmailAction.php`
- Add necessary imports: `Illuminate\Support\Facades\Storage`, `Illuminate\Support\Facades\Http`.
- Update `handle()` method:
    - Retrieve the file content from the appropriate disk (usually stored in `Export::file_disk`).
    - Get the `authToken` (using existing logic).
    - Use `Http::attach('file', $content, $filename)` to prepare the file.
    - Post to the mail server endpoint with `token` and `content`.
    - Log success or failure.

### Task 3: Configuration & Environment
- Ensure `SERVER_MAIL_ENDPOINT` is correctly set in `.env` (already present in `config/mail.php`).

## 4. Verification Plan
- **Mock Test**: Create a test case to mock the `Http::post` call and verify `SendEmailAction` is dispatched with correct data.
- **Manual Test**: Trigger a lead export from the Filament UI and check application logs for "Token arrived", "Handshake success/failure", and API response logs.
