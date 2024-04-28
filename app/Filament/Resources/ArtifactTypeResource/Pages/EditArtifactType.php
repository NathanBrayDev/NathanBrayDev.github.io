<?php

namespace App\Filament\Resources\ArtifactTypeResource\Pages;

use App\Filament\Resources\ArtifactTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArtifactType extends EditRecord
{
    protected static string $resource = ArtifactTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
