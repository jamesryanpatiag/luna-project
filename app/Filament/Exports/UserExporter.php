<?php

namespace App\Filament\Exports;

use App\Models\User;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class UserExporter extends Exporter
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('contractor_id_number'),
            ExportColumn::make('first_name'),
            ExportColumn::make('last_name'),
            ExportColumn::make('is_active'),
            ExportColumn::make('email'),
            ExportColumn::make('department.name'),
            ExportColumn::make('contractorType.name'),
            ExportColumn::make('contractor_position'),
            ExportColumn::make('date_hired'),
            ExportColumn::make('regularization_date'),
            ExportColumn::make('hmo_active'),
            ExportColumn::make('slack_username'),
            ExportColumn::make('gender'),
            ExportColumn::make('birth_date'),
            ExportColumn::make('contact_number'),
            ExportColumn::make('current_home_address'),
            ExportColumn::make('citizenship'),
            ExportColumn::make('personal_email'),
            ExportColumn::make('marital_status'),
            ExportColumn::make('tin_number'),
            ExportColumn::make('emergency_contact_person'),
            ExportColumn::make('emergency_contact_number'),
            ExportColumn::make('emergency_contact_person_address'),
            ExportColumn::make('relationship_to_emergency_contact'),
            ExportColumn::make('bank_name'),
            ExportColumn::make('bank_account_name'),
            ExportColumn::make('bank_account_number'),
            ExportColumn::make('email_verified_at'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your user export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
