<?php

namespace App\Filament\Imports;

use App\Models\Employee;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use App\Models\ContractorType;
use App\Models\Department;
use Filament\Actions\Imports\Exceptions\RowImportFailedException;
use Log;

class EmployeeImporter extends Importer
{
    protected static ?string $model = Employee::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('contractor_id_number')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('first_name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('last_name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('is_active')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean']),
            ImportColumn::make('email')
                ->rules(['required', 'email', 'max:255']),
            ImportColumn::make('image'),
            ImportColumn::make('department')
                ->relationship(resolveUsing: function (string $state) {
                    return Department::query()
                        ->where('name', $state)
                        ->first();
                }),
            ImportColumn::make('contractorType')
                ->relationship(resolveUsing: function (string $state) {
                    return ContractorType::query()
                        ->where('name', $state)
                        ->first();
                }),
            ImportColumn::make('contractor_position')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('date_hired')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('regularization_date')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('hmo_active')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean']),
            ImportColumn::make('slack_username')
                ->rules(['max:255']),
            ImportColumn::make('gender')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('birth_date')
                ->rules(['date']),
            ImportColumn::make('contact_number')
                ->rules(['max:255']),
            ImportColumn::make('current_home_address'),
            ImportColumn::make('citizenship')
                ->rules(['max:255']),
            ImportColumn::make('personal_email')
                ->rules(['email', 'max:255', 'nullable']),
            ImportColumn::make('marital_status'),
            ImportColumn::make('tin_number')
                ->rules(['max:255']),
            ImportColumn::make('sss_number')
                ->rules(['max:255']),
            ImportColumn::make('emergency_contact_person')
                ->rules(['max:255']),
            ImportColumn::make('emergency_contact_number')
                ->rules(['max:255']),
            ImportColumn::make('emergency_contact_person_address'),
            ImportColumn::make('relationship_to_emergency_contact')
                ->rules(['max:255']),
            ImportColumn::make('bank_name')
                ->rules(['max:255']),
            ImportColumn::make('bank_account_name')
                ->rules(['max:255']),
            ImportColumn::make('bank_account_number')
                ->rules(['max:255']),
            ImportColumn::make('email_verified_at')
                ->rules(['email', 'datetime']),
        ];
    }

    public function resolveRecord(): ?Employee
    {
        $contractorType = ContractorType::where('name', $this->data['contractorType'])->first();

        if (!$contractorType) {
            throw new RowImportFailedException("Invalid contractor type : " . $this->data['contractorType']);
        }

        $department = Department::where('name', $this->data['department'])->first();

        if (!$department) {
            throw new RowImportFailedException("Invalid department : " . $this->data['department']);
        }

        return Employee::firstOrNew([
            'email' => $this->data['email'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your employee import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
