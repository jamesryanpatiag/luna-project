<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimeInTimeOutDataResource\Pages;
use App\Filament\Resources\TimeInTimeOutDataResource\RelationManagers;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use App\Models\TimeInTimeOutData;
use App\Filament\Exports\TimeInTimeOutDataExporter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TimeInTimeOutDataResource extends Resource
{
    protected static ?string $model = TimeInTimeOutData::class;

    protected static ?string $navigationGroup = 'Transactions';

    protected static ?string $navigationLabel = "Time-in/Time-out";

    protected static ?string $breadcrumb = "Time-in/Time-out";

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public ?string $tableSortColumn = 'id';

    public ?string $tableSortDirection = 'desc';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('start_time')
                    ->required(),
                Forms\Components\DateTimePicker::make('end_time'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.name')
                    ->label('Employee Name')
                    ->searchable(['first_name','last_name'])
                    ->formatStateUsing(fn (TimeInTimeOutData $record): string => $record->employee->first_name . ' ' . $record->employee->last_name),
                Tables\Columns\TextColumn::make('employee.department.name')
                    ->label('Department')
                    ->searchable()
                    ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('notes')
                    ->label('Time-In Notes')
                    ->searchable()
                    ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('checkout_notes')
                    ->label('Time-Out Notes')
                    ->searchable()
                    ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->dateTime()
                    ->timezone('Asia/Manila')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_time')
                    ->timezone('Asia/Manila')
                    ->dateTime()
                    ->sortable(),
            ])->defaultSort('id', 'desc')
            ->filters([
                DateRangeFilter::make('start_time'),
                DateRangeFilter::make('end_time'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ExportBulkAction::make()->exporter(TimeInTimeOutDataExporter::class)
                ]),
                
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTimeInTimeOutData::route('/'),
            'create' => Pages\CreateTimeInTimeOutData::route('/create'),
            'edit' => Pages\EditTimeInTimeOutData::route('/{record}/edit'),
        ];
    }
}
