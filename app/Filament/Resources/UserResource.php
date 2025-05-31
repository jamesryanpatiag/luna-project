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
                        Forms\Components\TextInput::make('contractor_id_number')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Company Email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('personal_email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\Select::make('gender')
                            ->options([
                                'MALE' => 'Male',
                                'FEMALE' => 'Female'
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('birth_date'),
                        Forms\Components\TextInput::make('contact_number')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('citizenship')
                            ->maxLength(255),
                        Forms\Components\Select::make('marital_status')
                            ->options([
                                'MARRIED' => 'Married',
                                'SINGLE' => 'Single',
                                'WIDOWED' => 'Widowed',
                                'SEPARATED' => 'Separated'
                            ]),
                        Forms\Components\TextInput::make('tin_number')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('current_home_address')
                            ->columnSpanFull(),
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
                Section::make('Company Designation')
                    ->icon('heroicon-o-building-office')
                    ->schema([
                        Forms\Components\Select::make('department_id')
                            ->label('Department')
                            ->options(Department::all()->pluck('name', 'id'))
                            ->searchable(),
                        Forms\Components\Select::make('contractor_type_id')
                            ->label('Contractor Type')
                            ->options(ContractorType::all()->pluck('name', 'id'))
                            ->searchable(),
                        Forms\Components\TextInput::make('contractor_position')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('date_hired')
                            ->required(),
                        Forms\Components\DatePicker::make('regularization_date')
                            ->required(),
                        Forms\Components\TextInput::make('slack_username')
                            ->maxLength(255),
                        Forms\Components\Toggle::make('hmo_active')
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->required(),
                        Forms\Components\DateTimePicker::make('email_verified_at'),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->maxLength(255),
                    ])
                    ->columns(3)->columnSpan(4),
                Section::make('Bank Details')
                    ->icon('heroicon-o-banknotes')
                    ->schema([
                        Forms\Components\TextInput::make('bank_name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('bank_account_name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('bank_account_number')
                            ->maxLength(255),   
                    ])
                    ->columns(3)->columnSpan(4),
                Section::make('Emergency Contact')
                    ->icon('heroicon-o-users')
                    ->schema([
                        Forms\Components\TextInput::make('emergency_contact_person')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emergency_contact_number')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('relationship_to_emergency_contact')
                            ->maxLength(255),  
                        Forms\Components\Textarea::make('emergency_contact_person_address')
                            ->columnSpanFull(),      
                    ])
                    ->columns(3)->columnSpan(4),
            ])->columns(5);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('contractor_id_number')
                    ->label('ID Number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->label('Department')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contractorType.name')
                    ->label('Contractor Type')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contractor_position')
                    ->label('Position')
                    ->searchable(),
                    Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
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
