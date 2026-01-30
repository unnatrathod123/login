<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApplicationResource\Pages;
use App\Filament\Resources\ApplicationResource\RelationManagers;
use App\Models\Application;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;


//use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
//use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Section::make('Intern Details')
                ->schema([
                    Grid::make(2)->schema([

                        TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->required()
                            ->maxLength(15),

                        TextInput::make('college')
                            ->label('College Name')
                            ->maxLength(255),

                        TextInput::make('degree')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('domain')
                            ->label('Internship Domain')
                            ->required()
                            ->maxLength(100),
                    ]),
                ]),

            Section::make('Skills')
                ->schema([
                    Textarea::make('skills')
                        ->label('Skills (comma separated)')
                        ->rows(3)
                        ->required(),
                ]),

            Section::make('Resume')
                ->schema([
                    FileUpload::make('resume_path')
                        ->label('Resume')
                        ->disk('public')
                        ->directory('resumes')
                        ->acceptedFileTypes([
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        ])
                        ->downloadable()
                        ->openable()
                        ->preserveFilenames(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                 TextColumn::make('name')->searchable(),
        TextColumn::make('email'),
        TextColumn::make('phone'),
        TextColumn::make('college'),
        TextColumn::make('degree'),
        TextColumn::make('domain'),
        TextColumn::make('skills'),
        TextColumn::make('created_at')->dateTime(),
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
            'index' => Pages\ListApplications::route('/'),
            'create' => Pages\CreateApplication::route('/create'),
            'edit' => Pages\EditApplication::route('/{record}/edit'),
        ];
    }
}