<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;

class CreatePage extends \Z3d0X\FilamentFabricator\Resources\PageResource\Pages\CreatePage
{
    protected function getRedirectUrl(): string
        {
            return $this->getResource()::getUrl('index');
        }
}
