<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;


class EditPage extends \Z3d0X\FilamentFabricator\Resources\PageResource\Pages\EditPage
{
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
