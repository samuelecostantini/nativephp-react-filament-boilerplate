<?php

namespace Tests\Feature\Actions;

use App\Actions\SendEmailAction;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Native\Mobile\Facades\SecureStorage;

it('sends an email with attachment', function () {
    config(['mail.server_mail.mail_endpoint' => 'https://api.example.com/send-mail']);
    Http::fake([
        '*' => Http::response(['status' => 'success'], 200),
    ]);

    Storage::fake('local');
    Storage::disk('local')->put('filament_exports/1/headers.csv', "ID,Name\n");
    Storage::disk('local')->put('filament_exports/1/0000000000000001.csv', "1,Test\n");

    SecureStorage::shouldReceive('get')
        ->once()
        ->with(config()->string('auth.auth_token_ss_key'))
        ->andReturn('fake-token');

    $user = User::factory()->create(['email' => 'test@example.com', 'name' => 'Doe']);

    $action = new SendEmailAction(
        user: $user,
        filePath: 'filament_exports/1',
        disk: 'local'
    );

    $action->handle();

    Http::assertSent(function ($request) {
        $data = $request->data();

        $token = collect($data)->firstWhere('name', 'token')['contents'] ?? null;
        $file = collect($data)->firstWhere('name', 'file');

        return $request->url() === 'https://api.example.com/send-mail' &&
            $token === 'fake-token' &&
            $file['contents'] === "ID,Name\n1,Test\n" &&
            $file['filename'] === 'Doe_leads.csv';
    });
});

it('sends an email from absolute path', function () {
    config(['mail.server_mail.mail_endpoint' => 'https://api.example.com/send-mail']);
    Http::fake([
        '*' => Http::response(['status' => 'success'], 200),
    ]);

    $tempPath = storage_path('app/temp/test_export.csv');
    if (! is_dir(dirname($tempPath))) {
        mkdir(dirname($tempPath), 0755, true);
    }
    file_put_contents($tempPath, 'test content absolute');

    SecureStorage::shouldReceive('get')
        ->once()
        ->andReturn('fake-token');

    $user = User::factory()->create();

    $action = new SendEmailAction(
        user: $user,
        filePath: $tempPath
    );

    $action->handle();

    Http::assertSent(function ($request) {
        return $request->url() === config('mail.server_mail.mail_endpoint');
    });

    unlink($tempPath);
});

it('logs error if file is missing', function () {
    Http::fake();

    SecureStorage::shouldReceive('get')
        ->once()
        ->andReturn('fake-token');

    Log::shouldReceive('error')
        ->once()
        ->withArgs(function ($message) {
            return str_contains($message, 'SendEmailAction: File not found');
        });

    $user = User::factory()->create();

    $action = new SendEmailAction(
        user: $user,
        filePath: 'non_existent_file.csv',
        disk: 'local'
    );

    $action->handle();

    Http::assertNothingSent();
});

it('deletes file after send if requested', function () {
    config(['mail.server_mail.mail_endpoint' => 'https://api.example.com/send-mail']);
    Http::fake([
        '*' => Http::response(['status' => 'success'], 200),
    ]);

    $tempPath = storage_path('app/temp/test_deletion.csv');
    if (! is_dir(dirname($tempPath))) {
        mkdir(dirname($tempPath), 0755, true);
    }
    file_put_contents($tempPath, 'test content deletion');

    SecureStorage::shouldReceive('get')
        ->once()
        ->andReturn('fake-token');

    $user = User::factory()->create();

    $action = new SendEmailAction(
        user: $user,
        filePath: $tempPath,
        deleteAfterSend: true
    );

    $action->handle();

    expect(file_exists($tempPath))->toBeFalse();
});
