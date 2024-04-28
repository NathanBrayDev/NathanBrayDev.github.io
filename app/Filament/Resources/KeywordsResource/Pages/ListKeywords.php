<?php

namespace App\Filament\Resources\KeywordsResource\Pages;

use App\Filament\Resources\KeywordsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKeywords extends ListRecords
{
    protected static string $resource = KeywordsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
