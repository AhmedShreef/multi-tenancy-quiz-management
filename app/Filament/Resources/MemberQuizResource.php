<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberQuizResource\Pages;
use App\Filament\Resources\MemberQuizResource\RelationManagers;
use App\Models\Quiz;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\Action;
class MemberQuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('Member');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getUnAnsweredQuizzes()
    {
        return  Quiz::whereDoesntHave('submissions', function ($query) {
                        $query->where('user_id', auth()->id());
                });
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(self::getUnAnsweredQuizzes()) 
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('answer')
                    ->label('Answer Quiz')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->url(fn ($record) => route('filament.admin.resources.member-quizzes.answer', ['record' => $record->id]))
                    ->color('success')
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
            'index' => Pages\ListMemberQuizzes::route('/'),
            'answer' => Pages\AnswerQuiz::route('/{record}/answer'),
        ];
    }
}
