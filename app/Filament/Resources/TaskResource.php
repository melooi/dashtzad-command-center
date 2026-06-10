<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Task;
use App\Models\User;
use BackedEnum;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentList;

    protected static ?string $navigationLabel = 'تسک‌ها (Tasks)';

    protected static ?string $modelLabel = 'تسک (Task)';

    protected static ?string $pluralModelLabel = 'تسک‌ها (Tasks)';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make()->schema([
                Forms\Components\TextInput::make('title')
                    ->label('عنوان (Title)')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description')
                    ->label('توضیحات (Description)')
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\Select::make('assigned_to')
                    ->label('مسئول انجام (Assigned To)')
                    ->options(User::pluck('name', 'id'))
                    ->searchable()
                    ->nullable(),

                Forms\Components\Select::make('priority')
                    ->label('اولویت (Priority)')
                    ->options(Task::priorityLabels())
                    ->default('normal')
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('وضعیت (Status)')
                    ->options(Task::statusLabels())
                    ->default('backlog')
                    ->required(),

                Forms\Components\TextInput::make('category')
                    ->label('دسته‌بندی (Category)')
                    ->maxLength(100),

                Forms\Components\DateTimePicker::make('due_at')
                    ->label('مهلت (Due At)'),

                Forms\Components\Toggle::make('requires_approval')
                    ->label('نیازمند تأیید (Requires Approval)')
                    ->default(false),

                Forms\Components\Hidden::make('created_by')
                    ->default(fn () => Auth::id()),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان (Title)')
                    ->searchable()
                    ->weight('bold')
                    ->limit(50),

                Tables\Columns\TextColumn::make('assignee.name')
                    ->label('مسئول انجام (Assigned To)')
                    ->searchable()
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('priority')
                    ->label('اولویت (Priority)')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'urgent' => 'danger',
                        'high' => 'warning',
                        'normal' => 'info',
                        'low' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => Task::priorityLabels()[$state] ?? $state),

                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت (Status)')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'done' => 'success',
                        'cancelled' => 'gray',
                        'blocked' => 'danger',
                        'in_progress' => 'info',
                        'needs_review' => 'warning',
                        'today' => 'primary',
                        'backlog' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => Task::statusLabels()[$state] ?? $state),

                Tables\Columns\TextColumn::make('category')
                    ->label('دسته‌بندی (Category)')
                    ->placeholder('—')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('due_at')
                    ->label('مهلت (Due)')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('creator.name')
                    ->label('ایجادکننده (Created By)')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت (Status)')
                    ->options(Task::statusLabels()),

                Tables\Filters\SelectFilter::make('priority')
                    ->label('اولویت (Priority)')
                    ->options(Task::priorityLabels()),

                Tables\Filters\Filter::make('my_tasks')
                    ->label('تسک‌های من (My Tasks)')
                    ->query(fn (Builder $query) => $query->where('assigned_to', Auth::id()))
                    ->toggle(),

                Tables\Filters\Filter::make('assigned_by_me')
                    ->label('تخصیص‌داده‌شده توسط من (Assigned By Me)')
                    ->query(fn (Builder $query) => $query->where('created_by', Auth::id()))
                    ->toggle(),
            ])
            ->actions([
                Actions\Action::make('mark_done')
                    ->label('انجام شد (Mark Done)')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function (Task $record): void {
                        $record->update([
                            'status' => 'done',
                            'completed_at' => now(),
                        ]);
                    })
                    ->hidden(fn (Task $record): bool => in_array($record->status, ['done', 'cancelled'])),

                Actions\Action::make('mark_blocked')
                    ->label('مسدود شد (Mark Blocked)')
                    ->icon('heroicon-o-no-symbol')
                    ->color('danger')
                    ->action(fn (Task $record) => $record->update(['status' => 'blocked']))
                    ->hidden(fn (Task $record): bool => in_array($record->status, ['done', 'cancelled', 'blocked'])),

                Actions\ViewAction::make(),
                Actions\EditAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'view' => Pages\ViewTask::route('/{record}'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
