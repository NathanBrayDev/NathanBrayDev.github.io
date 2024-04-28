<?php

namespace App\Filament\Resources\KeywordsResource\Pages;

use App\Filament\Resources\KeywordsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKeywords extends EditRecord
{
    protected static string $resource = KeywordsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
