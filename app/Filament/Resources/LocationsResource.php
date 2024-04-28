<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocationsResource\Pages;
use App\Filament\Resources\LocationsResource\RelationManagers;
use App\Models\Locations;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Tabs;
use RalphJSmit\Filament\SEO\SEO;


use Str;

class LocationsResource extends Resource
{
    protected static ?string $model = Locations::class;
    protected static ?string $navigationIcon = 'heroicon-s-map';
    protected static ?string $navigationLabel = 'Locations';
    protected static ?string $navigationGroup = 'Data';

    protected static ?string $area = 'Data';

    public static function form(Form $form): Form
    {
     

        return $form
            ->schema([
                Tabs::make('Label')->columnSpanFull()
                    ->tabs([
                        Tabs\Tab::make('Main Content')->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('area')
                                    ->label('Location - Area')
                                    ->helperText("The location's area/region/site")
                                    ->columnSpanFull()
                                    ->afterStateUpdated(function ($set, $state, $context, $get) {
                                        $area = $state;
                                        $city = $get('city');
                                        if(isset($city)){
                                            $city = ', ' . $city;
                                        }
                                        $country = $get('country');
                                        if(isset($country)){
                                            $country = ', ' . $country;
                                        }
                                        $wholeLocation = $area . $city . $country;
                                        $set('wholeAddress',  $wholeLocation);
                                      
                                    })
                                    ->debounce('500ms')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('city')
                                    ->label('Location - City')
                                    ->helperText("The location's city ")
                                    ->columnSpanFull()
                                    ->afterStateUpdated(function ($set, $state, $context, $get) {
                                        $area = $get('area');
                                        $city = $state;
                                        if(isset($area)){
                                            $city = ', ' . $city;
                                        }
                                        $country = $get('country');
                                        if(isset($country)){
                                            $country = ', ' . $country;
                                        }
                                        $wholeLocation = $area . $city . $country;
                                        $set('wholeAddress',  $wholeLocation);
                                      
                                    })
                                    ->debounce('500ms')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('country')
                                    ->label('Location - Country')
                                    ->helperText("The location's country")
                                    ->columnSpanFull()
                                    ->afterStateUpdated(function ($set, $state, $context, $get) {
                                        $area = $get('area');
                                        $city = $get('city');
                                        if(isset($area)){
                                            $city = ', ' . $city;
                                        }
                                        $country = $state;
                                        if(isset($city)){
                                            $country = ', ' . $country;
                                        }
                                        $wholeLocation = $area . $city . $country;
                                        $set('wholeAddress',  $wholeLocation);
                                      
                                    })
                                    ->debounce('500ms')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('wholeAddress')
                                    ->label('The whole location address')
                                    ->helperText('The whole address made up of the other inputted locations')
                                    ->columnSpanFull()
                                    ->required(),
                                Forms\Components\TextInput::make('longitude')
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('latitude')
                                    ->required()
                                    ->columnSpanFull()
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('wholeAddress')
                    ->searchable(),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('visit')
                    ->label(__('filament-fabricator::page-resource.actions.visit'))
                    ->url(fn (?Locations $record) => '/languages/' . $record->location)
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->openUrlInNewTab()
                    ->color('success')
                    ->visible(config('filament-fabricator.routing.enabled')),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocations::route('/create'),
            'edit' => Pages\EditLocations::route('/{record}/edit'),
        ];
    }
}
