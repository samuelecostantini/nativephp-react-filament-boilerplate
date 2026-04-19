<?php

namespace App\Actions;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Native\Mobile\Facades\SecureStorage;

class SendEmailAction implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public User $user,
        private string $filePath,
        public ?string $disk = null,
        public ?string $content = null,
        public bool $deleteAfterSend = false,
        public ?string $endpoint = null
    ) {
        if (! $this->endpoint) {
            $this->endpoint = config('mail.server_mail.mail_endpoint');
        }

        if (! $this->content) {
            $this->content = "Ecco l'esportazione dei lead richiesta.";
        }
    }

    /**
     * @throws ConnectionException
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        /** @var User $user */
        $user = $this->user;
        $filePath = $this->filePath;

        $authToken = null;

        if($encryptedValue = Cache::get(config()->string('auth.auth_token_ss_key'))){
            $authToken = Crypt::decryptString($encryptedValue);
        }

        if (! $authToken) {
            Notification::make()
                ->title('Errore')
                ->danger()
                ->body('L\'email non è stata inviata.
                            Token di autenticazione scaduto. Effettua di nuovo il login e riprova l\'export.')
                ->actions([
                    Action::make('Login')
                        ->button()
                        ->url(fn ():string => route('logout')),
                ])
                ->sendToDatabase($user);
            return;
        }

        $filename = basename($filePath);
        $fileContent = null;

        if ($this->disk) {
            $storage = Storage::disk($this->disk);
            if (str_contains($filePath, 'filament_exports')) {
                // It's a directory for filament exports, we need to merge headers.csv + all numbered csvs
                $directory = rtrim($filePath, '/');
                $files = $storage->files($directory);

                $mergedContent = $storage->get($directory.'/headers.csv');

                $dataFiles = collect($files)
                    ->filter(fn ($f) => preg_match('/[0-9]{16}\.csv$/', $f))
                    ->sort()
                    ->all();

                foreach ($dataFiles as $dataFile) {
                    $mergedContent .= $storage->get($dataFile);
                }
                $fileContent = $mergedContent;
                $filename = ($this->user->name ?? 'export').'_partecipanti_totem_'.Date::now()->format('Y-m-d_H-i-s').'.csv';
            } else {
                $fileContent = $storage->get($filePath);
            }
        } else {
            $fileContent = (file_exists($filePath) ? file_get_contents($filePath) : null);
        }

        if (! $fileContent) {
            Log::error("SendEmailAction: File not found at {$filePath} on disk ".($this->disk ?? 'absolute path'));
            Notification::make()
                ->title('Errore')
                ->danger()
                ->body('Errore server: controlla i log per maggiori informazioni.')
                ->sendToDatabase($user);
            return;
        }

        Log::info("Sending email to {$user->email} with file {$filename} (".strlen($fileContent)." bytes)");

        $response = Http::attach('file', $fileContent, $filename)
            ->post($this->endpoint, [
                'auth_token' => $authToken,
            ]);

        if ($response->successful()) {
            Log::info("Email sent successfully to {$user->email} for file {$filename}");

            Notification::make()
                ->title('Email inviata!')
                ->success()
                ->body('Email con l\'export inviata con successo. Controlla la tua casella di posta.')
                ->sendToDatabase($user);

            if ($this->deleteAfterSend) {
                if ($this->disk) {
                    Storage::disk($this->disk)->delete($this->filePath);
                } else {
                    @unlink($this->filePath);
                }
            }
        } else {
            Log::error("Failed to send email to {$user->email}", [
                'status' => $response->status(),
                'body' => $response->body(),
                'endpoint' => $this->endpoint,
            ]);
            Notification::make()
                ->title('Errore')
                ->danger()
                ->body('Errore server: controlla i log per maggiori informazioni.')
                ->sendToDatabase($user);
        }
    }
}
