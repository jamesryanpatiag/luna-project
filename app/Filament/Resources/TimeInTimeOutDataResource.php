<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimeInTimeOutDataResource\Pages;
use App\Filament\Resources\TimeInTimeOutDataResource\RelationManagers;
use App\Models\TimeInTimeOutData;
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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Tables\Columns\TextColumn::make('employee.first_name')
                    ->label('First Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee.last_name')
                    ->label('Last Name')
                    ->searchable()
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
            'index' => Pages\ListTimeInTimeOutData::route('/'),
            'create' => Pages\CreateTimeInTimeOutData::route('/create'),
            'edit' => Pages\EditTimeInTimeOutData::route('/{record}/edit'),
        ];
    }
}
