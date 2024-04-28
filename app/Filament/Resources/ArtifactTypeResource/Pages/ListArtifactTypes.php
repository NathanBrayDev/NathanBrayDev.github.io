<?php

namespace App\Filament\Resources\ArtifactTypeResource\Pages;

use App\Filament\Resources\ArtifactTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtifactTypes extends ListRecords
{
    protected static string $resource = ArtifactTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
