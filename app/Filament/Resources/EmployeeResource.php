<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use App\Models\Department;
use App\Models\ContractorType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;
use Filament\Actions\ExportAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\ActionGroup;
use TomatoPHP\FilamentDocs\Filament\Actions\DocumentAction;
use TomatoPHP\FilamentDocs\Services\Contracts\DocsVar;
use App\Filament\Exports\EmployeeExporter;
use App\Filament\Resources\EmployeeResource\RelationManagers\DocumentsRelationManager;
use App\Filament\Imports\EmployeeImporter;



class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Personal Details')
                ->icon('heroicon-o-user')
                ->schema([
                    Forms\Components\TextInput::make('contractor_id_number')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->label('Company Email')
                        ->email()
                        ->rules(['required'])
                        ->maxLength(255),
                    Forms\Components\TextInput::make('first_name')
                        ->rules(['required'])
                        ->maxLength(255),
                    Forms\Components\TextInput::make('last_name')
                        ->rules(['required'])
                        ->maxLength(255),
                    Forms\Components\TextInput::make('personal_email')
                        ->email()
                        ->maxLength(255),
                    Forms\Components\Select::make('gender')
                        ->options([
                            'MALE' => 'Male',
                            'FEMALE' => 'Female'
                        ])
                        ->rules(['required']),
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
                    Forms\Components\TextInput::make('sss_number')
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
                        ->rules(['required'])
                        ->maxLength(255),
                    Forms\Components\DatePicker::make('date_hired')
                        ->rules(['required']),
                    Forms\Components\DatePicker::make('regularization_date')
                        ->rules(['required']),
                    Forms\Components\TextInput::make('slack_username')
                        ->maxLength(255),
                    Forms\Components\Toggle::make('hmo_active')
                        ->rules(['required']),
                    Forms\Components\Toggle::make('is_active')
                        ->rules(['required']),
                    Forms\Components\DateTimePicker::make('email_verified_at'),
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
                    ->sortable()
                    ->label('ID Number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->sortable()
                    ->label('Department')
                    ->numeric(),
                Tables\Columns\TextColumn::make('contractorType.name')
                    ->label('Contractor Type')
                    ->numeric(),
                Tables\Columns\TextColumn::make('contractor_position')
                    ->label('Position')
                    ->wrap()
                    ->searchable(),
                    Tables\Columns\IconColumn::make('is_active')
                    ->sortable()
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                DocumentAction::make('Generate')
                ->vars(fn($record) => [
                    DocsVar::make('$ACCOUNT_FIRST_NAME')
                        ->value($record->first_name),
                    DocsVar::make('$ACCOUNT_LASTNAME')
                        ->value($record->last_name),
                    DocsVar::make('$ACCOUNT_NAME')
                        ->value($record->first_name . " " . $record->last_name),
                    DocsVar::make('$HIREDDATE')
                        ->value($record->date_hired),
                    DocsVar::make('$END_DATE')
                        ->value("Present"),
                    DocsVar::make('$POSITION')
                        ->value($record->contractor_position),
                    DocsVar::make('$DEPARTMENT')
                        ->value($record->department->name),
                    DocsVar::make('$SPACE')
                        ->value("&nbsp;&nbsp;")
                ]),
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
            ])
            ->headerActions([
                Tables\Actions\ImportAction::make()->importer(EmployeeImporter::class)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ExportBulkAction::make()
                    ->exporter(EmployeeExporter::class)
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            DocumentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
            'generate_coe' => Pages\CertificateOfEmployment::route('/{record}/generate_coe')
        ];
    }
}
