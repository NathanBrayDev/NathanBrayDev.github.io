<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LanguagesResource\Pages;
use App\Filament\Resources\LanguagesResource\RelationManagers;
use App\Models\Languages;
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


class LanguagesResource extends Resource
{
    protected static ?string $model = Languages::class;
    protected static ?string $navigationIcon = 'heroicon-m-chat-bubble-left';
    protected static ?string $navigationLabel = 'Languages';
    protected static ?string $navigationGroup = 'Data';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Label')->columnSpanFull()
                    ->tabs([
                        Tabs\Tab::make('Main Content')->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('visit')
                    ->label(__('filament-fabricator::page-resource.actions.visit'))
                    ->url(fn (?Languages $record) => '/languages/'.$record->name  )
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
            'index' => Pages\ListLanguages::route('/'),
            'create' => Pages\CreateLanguages::route('/create'),
            'edit' => Pages\EditLanguages::route('/{record}/edit'),
        ];
    }    
}