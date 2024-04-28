<?php

namespace App\Filament\Fabricator\PageBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components;
use FilamentTiptapEditor\TiptapEditor;
use Z3d0X\FilamentFabricator\PageBlocks\PageBlock;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Models\Media;
use Filament\Forms\Components\Select;
use RalphJSmit\Filament\SEO\SEO;
use Filament\Forms\Components\Tabs;

class homePageBlock extends PageBlock
{
    public static function getBlockSchema(): Block
    {
        return Block::make('home-page')
            ->schema([
                Tabs::make('Label')
                    ->tabs([
                        Tabs\Tab::make('Main Content')
                            ->schema([
                                TiptapEditor::make('content')
                                    ->profile('simple')
                                    ->required(),
                                CuratorPicker::make('image')
                                    ->label('Select an Image')
                                    ->buttonLabel('Upload')
                                    ->imageResizeMode('contain')
                                    ->imageResizeTargetWidth('1500')
                                    ->preserveFilenames()
                                    ->columnSpanFull(),
                                    
                            ]),
                    Tabs\Tab::make('SEO')
                    ->schema([
                        SEO::make(),
                    ])
                ])
            ])->visible(fn ($get) => $get('../layout') == 'home-page');
       
    }

    public static function mutateData(array $data): array
    {
        if(isset($data['image'])) {
            $data['image'] = Media::find($data['image']);
        }
        return $data;
    }
}