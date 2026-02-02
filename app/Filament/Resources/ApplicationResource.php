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
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Dropdown;

use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
//use Filament\Infolists\Components\Section;
use Filament\Tables\Actions\ViewAction;

use Filament\Tables\Filters\SelectFilter;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

     
    

   
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

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

                        Select::make('domain')
                            ->label('Internship Domain')
                            ->required()
                            ->searchable()
                            ->disabled(fn ($record) => $record?->status !== 'applied'),
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
                        ])
                        ->downloadable()
                        ->openable()
                        ->preserveFilenames(),
                ]),

                Select::make('status')
                    ->options(Application::statuses())
                    ->default(Application::STATUS_APPLIED)
                    ->required()
                    ->visible(fn () => auth()->user()?->role === 'admin'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->poll('10s') // ⬅ auto refresh
            ->defaultSort('created_at', 'desc') // 🔥 newest on top
            ->columns([
                // To display in table
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('phone') ->toggleable(),
                TextColumn::make('college') ->toggleable(),
                TextColumn::make('degree') ->toggleable(),
                TextColumn::make('domain') ->toggleable(),
                TextColumn::make('skills')  ->toggleable(isToggledHiddenByDefault: true),
                // TextColumn::make('resume_path')
                //     ->label('Resume')
                //     ->formatStateUsing(fn () => 'View Resume')
                //     ->url(fn ($record) => asset('storage/' . $record->resume_path))
                //     ->openUrlInNewTab()
                //     ->sortable(false),

                TextColumn::make('created_at')->dateTime(),
                
                BadgeColumn::make('status')
                ->colors([
                    'secondary' => 'applied',
                    'warning'   => 'interviewed',
                    'success'   => 'selected',
                ])->alignCenter()
   

            ->formatStateUsing(fn (string $state) => ucfirst($state)),
                    ])

        // filter
            ->filters([

             //to filter from status

                SelectFilter::make('status')
                ->options(Application::statuses()),
                ])
                    
                ->actions([

                    // // TO view
                    // ViewAction::make(),
                    Action::make('download')
                        ->label('Download Resume')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->url(fn ($record) => asset('storage/' . $record->resume_path))
                        ->openUrlInNewTab(false),
                      // for edit 
                    Tables\Actions\EditAction::make(),

                     // for change status from intern
                        Action::make('Schedule Interview')
                            ->visible(fn ($record) => $record->status === 'applied')
                            ->action(fn ($record) => $record->update(['status' => 'interviewed']))
                            ->color('warning'),

                        Action::make('Select Intern')
                            ->visible(fn ($record) => $record->status === 'interviewed')
                            ->action(fn ($record) => $record->update(['status' => 'selected']))
                            ->color('success'),

                ])
                
                ->bulkActions([
                    Tables\Actions\BulkActionGroup::make([
                    // to delete all records
                      Tables\Actions\DeleteBulkAction::make(),

                ])
            ]);

            // for interview schedulling 
                //       Tables\Actions\BulkAction::make('scheduleInterview')
                //         ->label('Schedule Interview')
                //             ->form([
                //                     Forms\Components\Select::make('interview_batch_id')
                //                         ->relationship('interviewBatch', 'title')
                //                         ->required(),
                //                 ])

                //              ->action(function (Collection $records, array $data) 
                //                     {
                //                         foreach ($records as $application)
                //                         {
                //                             $application->interviewBatches()
                //                                 ->attach($data['interview_batch_id']);

                //                             $application->update([
                //                                 'status' => 'interview_scheduled',  ]);
                //                         }
                //                     }
                //                 )
                                            


                
                // ]);
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
            // 'view' => Pages\ViewApplication::route('/{record}'),
        ];
    }
}