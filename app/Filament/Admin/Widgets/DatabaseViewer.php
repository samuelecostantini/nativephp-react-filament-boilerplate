<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;

class DatabaseViewer extends Widget
{
    protected string $view = 'filament.admin.widgets.database-viewer';

    public ?string $selectedTable = null;

    public ?string $query = '';

    public ?array $results = null;

    public ?array $columns = null;

    public ?string $queryError = null;

    public function mount(): void
    {
        // Initialization if needed
    }

    public function getTables(): array
    {
        return $this->getAllTables();
    }

    public function selectTable(string $table): void
    {
        $this->selectedTable = $table;
        $this->query = '';
        $this->results = null;
        $this->queryError = null;

        // Get columns for selected table
        try {
            $this->columns = Schema::getColumnListing($table);
        } catch (\Exception $e) {
            $this->columns = [];
        }
    }

    public function runCustomQuery(): void
    {
        if (empty(trim($this->query))) {
            $this->results = null;
            $this->queryError = null;
            return;
        }

        try {
            $this->results = DB::select($this->query);
            $this->queryError = null;
        } catch (QueryException $e) {
            $this->results = null;
            $this->queryError = $e->getMessage();
        }
    }

    public function getTableDataProperty(): ?array
    {
        if (! $this->selectedTable) {
            return null;
        }

        try {
            $results = DB::table($this->selectedTable)->limit(100)->get();
            return $results->toArray();
        } catch (\Exception $e) {
            $this->queryError = $e->getMessage();
            return null;
        }
    }

    public function getSelectedTableColumnsProperty(): array
    {
        if (! $this->selectedTable) {
            return [];
        }

        try {
            return Schema::getColumnListing($this->selectedTable);
        } catch (\Exception $e) {
            return [];
        }
    }

    protected function getAllTables(): array
    {
        try {
            return Schema::hasTable('brands') ? Schema::hasTable('quizzes') ? Schema::hasTable('leads') ? ['brands', 'quizzes', 'leads', 'users', 'migrations'] : [] : [] : [];
        } catch (\Exception $e) {
            return [];
        }
    }
}
