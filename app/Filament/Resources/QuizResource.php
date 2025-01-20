<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizResource\Pages;
use App\Filament\Resources\QuizResource\RelationManagers;
use App\Models\Quiz;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Auth;
class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('Admin');
    }
    public static function form(Form $form): Form
    {
          return $form
            ->schema([
                // Quiz Title Section
                Forms\Components\Section::make('Quiz Details')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->label('Quiz Title'),
                        Forms\Components\Textarea::make('description')
                            ->nullable()
                            ->label('Description'),
                    ])
                    ->columns(1), // Single column for the title and description section

                // Questions Section
                Forms\Components\Section::make('Questions')
                    ->schema([
                        Forms\Components\HasManyRepeater::make('questions')
                            ->relationship('questions')
                            ->schema([
                                Forms\Components\Textarea::make('question_text')
                                    ->required()
                                    ->label('Question Text'),
                                Forms\Components\HasManyRepeater::make('options')
                                    ->relationship('options')
                                    ->schema([
                                        Forms\Components\TextInput::make('option_text')
                                            ->required()
                                            ->label('Option Text'),
                                        Forms\Components\Radio::make('is_correct')
                                            ->label('Correct Answer')
                                            ->boolean()
                                            ->default(false),
                                    ])
                                    ->minItems(2)
                                    // ->maxItems(10)
                                    ->required(),
                            ])->columnSpan(2)
                            ->minItems(1)
                            ->label('Questions'),
                    ])
                    ->columns(2), // Two columns for the questions section
            ])
            ->columns(2); // Set the overall number of columns for the form
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                    Tables\Columns\TextColumn::make('title')->searchable(),
                    Tables\Columns\TextColumn::make('description')->limit(50),
                    Tables\Columns\TextColumn::make('creator.name')->label('Created By'),
                    Tables\Columns\TextColumn::make('created_at')->dateTime(),
                ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
                
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
            'index' => Pages\ListQuizzes::route('/'),
            'create' => Pages\CreateQuiz::route('/create'),
            'view' => Pages\ViewQuiz::route('/{record}'),
            'edit' => Pages\EditQuiz::route('/{record}/edit'),

        ];
    }


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        
        foreach ($data['questions'] as &$question) {
            $correctOptions = collect($question['options'])->where('is_correct', true);

            if ($correctOptions->count() !== 1) {
                throw new \Exception('Each question must have exactly one correct answer.');
            }
        }
        return $data;
    }


}
