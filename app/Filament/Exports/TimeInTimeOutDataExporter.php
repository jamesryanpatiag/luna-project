<?php

namespace App\Filament\Exports;

use App\Models\TimeInTimeOutData;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class TimeInTimeOutDataExporter extends Exporter
{
    protected static ?string $model = TimeInTimeOutData::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('employee.first_name')
                ->label('First Name'),
            ExportColumn::make('employee.last_name')
                ->label('Last Name'),
            ExportColumn::make('employee.department.name'),
            ExportColumn::make('notes')
                ->label('Time-In Notes'),
            ExportColumn::make('checkout_notes')
                ->label('Time-Out Notes'),
            ExportColumn::make('start_time'),
            ExportColumn::make('end_time'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your time in time out data export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
