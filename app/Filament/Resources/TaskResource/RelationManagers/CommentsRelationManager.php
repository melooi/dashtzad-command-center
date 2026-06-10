<?php

namespace App\Filament\Resources\TaskResource\RelationManagers;

use Filament\Actions;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    protected static ?string $title = 'نظرات (Comments)';

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\Textarea::make('comment')
                ->label('نظر (Comment)')
                ->required()
                ->rows(3)
                ->columnSpanFull(),

            Forms\Components\Hidden::make('user_id')
                ->default(fn () => Auth::id()),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('comment')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('نویسنده (Author)')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('comment')
                    ->label('نظر (Comment)')
                    ->limit(100)
                    ->wrap(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ارسال (Posted)')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
            ])
            ->headerActions([
                Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['user_id'] = Auth::id();

                        return $data;
                    }),
            ])
            ->actions([
                Actions\DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
