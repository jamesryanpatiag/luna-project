<?php

namespace App\Filament\Exports;

use App\Models\EmployeeLeaveRequest;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class EmployeeLeaveRequestExporter extends Exporter
{
    protected static ?string $model = EmployeeLeaveRequest::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('employee.first_name'),
            ExportColumn::make('employee.last_name'),
            ExportColumn::make('leaveType.name'),
            ExportColumn::make('start_date'),
            ExportColumn::make('end_date'),
            ExportColumn::make('remarks'),
            ExportColumn::make('shift'),
            ExportColumn::make('status'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your employee leave request export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
