<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Models\Task;
use App\Models\User;
use App\Services\ProductQaService;
use BackedEnum;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArchiveBox;

    protected static ?string $navigationLabel = 'محصولات (Products)';

    protected static ?string $modelLabel = 'محصول (Product)';

    protected static ?string $pluralModelLabel = 'محصولات (Products)';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('اطلاعات پایه (Basic Info)')->schema([
                Forms\Components\TextInput::make('name')
                    ->label('نام محصول (Name)')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('sku')
                    ->label('کد SKU')
                    ->maxLength(100)
                    ->unique(ignoreRecord: true),

                Forms\Components\TextInput::make('category')
                    ->label('دسته‌بندی (Category)')
                    ->maxLength(100),

                Forms\Components\Select::make('status')
                    ->label('وضعیت (Status)')
                    ->options(Product::statusLabels())
                    ->default('raw')
                    ->required(),

                Forms\Components\Select::make('assigned_to')
                    ->label('مسئول محصول (Assigned To)')
                    ->options(User::pluck('name', 'id'))
                    ->searchable()
                    ->nullable(),
            ])->columns(2),

            Section::make('قیمت و موجودی (Pricing & Stock)')->schema([
                Forms\Components\TextInput::make('purchase_price')
                    ->label('قیمت خرید (Purchase Price)')
                    ->numeric()
                    ->prefix('﷼')
                    ->nullable(),

                Forms\Components\TextInput::make('sale_price')
                    ->label('قیمت فروش (Sale Price)')
                    ->numeric()
                    ->prefix('﷼')
                    ->nullable(),

                Forms\Components\TextInput::make('stock_quantity')
                    ->label('موجودی (Stock Quantity)')
                    ->numeric()
                    ->nullable(),
            ])->columns(3),

            Section::make('محتوا (Content)')->schema([
                Forms\Components\Textarea::make('raw_description')
                    ->label('توضیح خام (Raw Description)')
                    ->rows(5)
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('specs')
                    ->label('ویژگی‌ها (Specs)')
                    ->rows(5)
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('notes')
                    ->label('یادداشت‌ها (Notes)')
                    ->rows(3)
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('نام محصول (Name)')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('sku')
                    ->label('کد SKU')
                    ->searchable()
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('category')
                    ->label('دسته‌بندی (Category)')
                    ->placeholder('—')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت (Status)')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'ready_to_publish' => 'success',
                        'ready_for_review' => 'warning',
                        'rejected' => 'danger',
                        'needs_content', 'needs_price', 'needs_image' => 'warning',
                        'incomplete' => 'danger',
                        'raw' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => Product::statusLabels()[$state] ?? $state),

                Tables\Columns\TextColumn::make('sale_price')
                    ->label('قیمت فروش (Price)')
                    ->money('IRR')
                    ->placeholder('—')
                    ->sortable(),

                Tables\Columns\TextColumn::make('stock_quantity')
                    ->label('موجودی (Stock)')
                    ->placeholder('—')
                    ->sortable(),

                Tables\Columns\TextColumn::make('assignee.name')
                    ->label('مسئول محصول (Assigned To)')
                    ->placeholder('—')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('latestQaCheck.readiness_score')
                    ->label('امتیاز بررسی (QA Score)')
                    ->suffix('%')
                    ->placeholder('—')
                    ->badge()
                    ->color(fn ($state): string => match (true) {
                        $state === null => 'gray',
                        $state >= 80 => 'success',
                        $state >= 50 => 'warning',
                        default => 'danger',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت (Status)')
                    ->options(Product::statusLabels()),

                Tables\Filters\SelectFilter::make('assigned_to')
                    ->label('مسئول محصول (Assigned To)')
                    ->options(User::pluck('name', 'id')),
            ])
            ->actions([
                Actions\Action::make('run_qa')
                    ->label('اجرای بررسی محصول (Run QA Check)')
                    ->icon('heroicon-o-beaker')
                    ->color('info')
                    ->action(function (Product $record): void {
                        $result = app(ProductQaService::class)->run($record);

                        $missing = json_decode($result->missing_items ?? '[]', true);
                        $missingText = empty($missing)
                            ? 'همه فیلدها موجودند.'
                            : 'موارد ناقص: ' . implode('، ', $missing);

                        Notification::make()
                            ->title("امتیاز بررسی: {$result->readiness_score}%")
                            ->body($missingText)
                            ->success()
                            ->send();
                    }),

                Actions\Action::make('create_task')
                    ->label('ساخت تسک برای محصول (Create Task)')
                    ->icon('heroicon-o-plus-circle')
                    ->color('warning')
                    ->form([
                        Forms\Components\TextInput::make('title')
                            ->label('عنوان تسک (Task Title)')
                            ->required()
                            ->default(fn (Product $record): string => "بررسی محصول: {$record->name}"),

                        Forms\Components\Select::make('priority')
                            ->label('اولویت (Priority)')
                            ->options(Task::priorityLabels())
                            ->default('normal')
                            ->required(),

                        Forms\Components\Select::make('assigned_to')
                            ->label('مسئول انجام (Assigned To)')
                            ->options(User::pluck('name', 'id'))
                            ->searchable()
                            ->nullable(),
                    ])
                    ->action(function (Product $record, array $data): void {
                        Task::create([
                            'title' => $data['title'],
                            'priority' => $data['priority'],
                            'assigned_to' => $data['assigned_to'] ?? null,
                            'created_by' => Auth::id(),
                            'status' => 'backlog',
                            'related_type' => Product::class,
                            'related_id' => $record->id,
                        ]);

                        Notification::make()
                            ->title('تسک ایجاد شد')
                            ->success()
                            ->send();
                    }),

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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
