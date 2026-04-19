<?php

namespace App\Filament\Admin\Resources\Leads\Actions;

use App\Actions\SendEmailAction;
use App\Models\Lead;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Native\Mobile\Facades\Share;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class ExportLeadsAction
{
    public static function make(): Action
    {
        return Action::make('export_csv')
            ->label('Export CSV')
            ->icon('heroicon-o-document-text')
            ->action(function (): mixed {
                return static::export();
            });
    }

    public static function sendToEmail(): Action
    {
        return Action::make('send_leads_to_email')
            ->label('Invia export via Email')
            ->icon('heroicon-o-envelope')
            ->requiresConfirmation()
            ->action(function () {
                $user = auth()->user();
                if (! $user || ! $user->email) {
                    Notification::make()
                        ->title('Errore')
                        ->body('Impossibile trovare l\'indirizzo email dell\'utente.')
                        ->danger()
                        ->send();

                    return;
                }

                $filePath = static::createExportFile();

                SendEmailAction::dispatch($user, $filePath, deleteAfterSend: true);

                Notification::make()
                    ->title('Esportazione inviata')
                    ->body("Il file CSV è stato inviato all'indirizzo {$user->email}")
                    ->success()
                    ->send();
            });
    }

    protected static function createExportFile(): string
    {
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['ID', 'Brand', 'First Name', 'Last Name', 'Email', 'Quiz Score', 'Created At'];
        $sheet->fromArray($headers, null, 'A1');

        $leads = Lead::with('brand')->get();
        $rows = [];

        foreach ($leads as $lead) {
            $rows[] = [
                $lead->id,
                $lead->brand?->name ?? '',
                $lead->first_name,
                $lead->last_name,
                $lead->email,
                $lead->quiz_result_score,
                $lead->created_at->format('Y-m-d H:i:s'),
            ];
        }

        if (! empty($rows)) {
            $sheet->fromArray($rows, null, 'A2');
        }

        $filename = 'leads_export_'.date('Y-m-d_His').'.csv';
        $tempPath = storage_path('app/temp/'.$filename);

        if (! is_dir(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }

        $writer = new Csv($spreadsheet);
        $writer->save($tempPath);

        return $tempPath;
    }

    public static function export(): mixed
    {
        $tempPath = static::createExportFile();
        $filename = basename($tempPath);

        if (app()->runningInNativeEnvironment()) {
            Share::file('Leads Export', 'Here are your leads data', $tempPath);
            unlink($tempPath);

            return null;
        }

        $content = file_get_contents($tempPath);
        unlink($tempPath);

        return response()->streamDownload(
            fn () => print ($content),
            $filename,
            ['Content-Type' => 'text/csv']
        );
    }
}
