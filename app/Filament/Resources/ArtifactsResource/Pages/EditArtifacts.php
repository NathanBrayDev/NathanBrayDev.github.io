<?php

namespace App\Filament\Resources\ArtifactsResource\Pages;

use App\Filament\Resources\ArtifactsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArtifacts extends EditRecord
{
    protected static string $resource = ArtifactsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
