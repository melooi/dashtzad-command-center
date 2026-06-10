<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Services\ProductQaService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('run_qa')
                ->label('اجرای بررسی محصول (Run QA Check)')
                ->icon('heroicon-o-beaker')
                ->color('info')
                ->action(function (): void {
                    $result = app(ProductQaService::class)->run($this->record);

                    $missing = json_decode($result->missing_items ?? '[]', true);
                    $missingText = empty($missing) ? 'همه فیلدها موجودند.' : 'موارد ناقص: ' . implode('، ', $missing);

                    Notification::make()
                        ->title("امتیاز بررسی: {$result->readiness_score}%")
                        ->body($missingText)
                        ->success()
                        ->send();
                }),

            Actions\EditAction::make(),
        ];
    }
}
