<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InterviewBatchResource\Pages;
use App\Filament\Resources\InterviewBatchResource\RelationManagers;
use App\Models\interview_batches;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;

class InterviewBatchResource extends Resource
{
    protected static ?string $model = interview_batches::class;

    protected static ?string $navigationGroup = 'Interview Management';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    //protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //

                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\DatePicker::make('interview_date')->required(),
                Forms\Components\TimePicker::make('start_time')->required(),
                Forms\Components\TimePicker::make('end_time')->required(),
              
         ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //

                TextColumn::make('title')->searchable(),
                TextColumn::make('interview_date')->searchable(),
                TextColumn::make('start_time')->searchable(),
                TextColumn::make('end_time')->searchable(),
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
            'index' => Pages\ListInterviewBatches::route('/'),
            'create' => Pages\CreateInterviewBatch::route('/create'),
            'edit' => Pages\EditInterviewBatch::route('/{record}/edit'),
        ];
    }
}
