<?php

namespace App\Filament\Resources\InterviewResource\Pages;

use App\Filament\Resources\InterviewResource;
use Filament\Resources\Pages\Page;
use Filament\Forms\Form;

use Filament\Forms;


class AutoScheduleInterview extends Page
{
    protected static string $resource = InterviewResource::class;

    protected static string $view = 'filament.resources.interview-resource.pages.auto-schedule-interview';

    // public function form(Form $form): Form
    // {
    //     return $form->schema([
    //         Forms\Components\DatePicker::make('interview_date')
    //             ->required(),

    //         Forms\Components\TimePicker::make('start_time')
    //             ->required(),

    //         Forms\Components\TimePicker::make('end_time')
    //             ->required(),

    //         Forms\Components\TextInput::make('no_of_candidates')
    //             ->label('Number of Applications')
    //             ->numeric()
    //             ->minValue(1)
    //             ->required(),
    //     ]);
    // }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\DatePicker::make('interview_date')
                ->required(),

            Forms\Components\TimePicker::make('start_time')
                ->required(),

            Forms\Components\TimePicker::make('end_time')
                ->required(),

            Forms\Components\TextInput::make('no_of_candidates')
                ->numeric()
                ->required(),
        ]);
    }
}
