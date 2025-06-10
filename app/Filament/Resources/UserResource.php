<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Exports\UserExporter;
use App\Models\User;
use App\Models\Department;
use App\Models\ContractorType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Actions\ExportAction;
use App\Filament\Resources\UserResource\RelationManagers\UserDocumentRelationManager;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Personal Details')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->rules(['required'])
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->live(true),
                        Forms\Components\TextInput::make('first_name')
                        ->rules(['required'])
                            ->maxLength(255),
                        Forms\Components\TextInput::make('last_name')
                            ->rules(['required'])
                            ->maxLength(255),
                        Forms\Components\TextInput::make('password')
                            ->same('passwordConfirmation')
                            ->rules(['required'])
                            ->password(),
                        Forms\Components\TextInput::make('passwordConfirmation')
                            ->password()
                            ->rules(['required'])

                    ])
                    ->columns(3)->columnSpan(4),
                Section::make('Profile Picture')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('')
                            ->disk('public')
                            ->directory('uploads/profile_pictures')
                            ->visibility('public')
                            ->downloadable()
                            ->image()
                    ])->columnSpan(1),
            ])->columns(5);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ExportBulkAction::make()
                    ->exporter(UserExporter::class)
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            UserDocumentRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
