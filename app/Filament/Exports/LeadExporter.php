<?php

namespace App\Filament\Exports;

use App\Actions\SendEmailAction;
use App\Models\Lead;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Number;
use PhpOffice\PhpSpreadsheet\Exception;

class LeadExporter extends Exporter
{
    protected static ?string $model = Lead::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('brand.name')
                ->label('Brand'),
            ExportColumn::make('first_name')
                ->label('Nome'),
            ExportColumn::make('last_name')
                ->label('Cognome'),
            ExportColumn::make('email')
                ->label('Email'),
            ExportColumn::make('privacy_consent')
                ->label('Privacy')
                ->formatStateUsing(fn (bool $state) => $state ? 'Si' : 'No'),
            ExportColumn::make('created_at')
                ->label('Data creazione'),
        ];
    }

    public function getFormats(): array
    {
        return [ExportFormat::Csv];
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function __invoke(Model $record): array
    {
        $this->record = $record;

        $columns = $this->getCachedColumns();

        $data = [];

        foreach (array_keys($this->columnMap) as $column) {
            $data[] = $columns[$column]->getFormattedState();
        }

        Log::info(json_encode($data, JSON_PRETTY_PRINT));

        return $data;
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Sono state esportate '.Number::format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' righe.';
        $directoryPath = $export->getFileDirectory();

        if ($export->user) {
            SendEmailAction::dispatch($export->user, $directoryPath, disk: $export->file_disk);
        }

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' fallite.';
        }

        $body .= 'Controlla nel pannello notifiche se la mail è stata inviata correttamente.';

        return $body;
    }
}
