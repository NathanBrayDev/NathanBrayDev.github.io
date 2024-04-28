<?php

namespace App\Filament\Resources\ArtifactsResource\Pages;

use App\Filament\Resources\ArtifactsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtifacts extends ListRecords
{
    protected static string $resource = ArtifactsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
