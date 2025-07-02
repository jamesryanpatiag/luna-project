<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeLeaveRequestResource\Pages;
use App\Filament\Resources\EmployeeLeaveRequestResource\RelationManagers;
use App\Models\EmployeeLeaveRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Employee;
use App\Models\LeaveType;

class EmployeeLeaveRequestResource extends Resource
{
    protected static ?string $model = EmployeeLeaveRequest::class;

    protected static ?string $navigationGroup = 'Transactions';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Employee Leave Form')
                ->icon('heroicon-o-user')
                ->schema([
                Forms\Components\Select::make('employee_id')
                    ->label('Employee')
                    ->options(Employee::all()->pluck('name', 'id'))
                    ->searchable(),
                Forms\Components\Select::make('leave_type_id')
                    ->label('Leave Type')
                    ->options(LeaveType::all()->pluck('name', 'id'))
                    ->searchable(),
                Forms\Components\DatePicker::make('start_date')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->required(),
                Forms\Components\Textarea::make('remarks')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_approve')
                    ->required(),
            ])->columns(2)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('leave_type_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_approve')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListEmployeeLeaveRequests::route('/'),
            'create' => Pages\CreateEmployeeLeaveRequest::route('/create'),
            'edit' => Pages\EditEmployeeLeaveRequest::route('/{record}/edit'),
        ];
    }
}
