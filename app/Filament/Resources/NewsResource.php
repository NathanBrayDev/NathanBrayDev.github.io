<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Filament\Resources\NewsResource\RelationManagers;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Models\Media;
use Filament\Forms\Components\FileUpload;
use RalphJSmit\Filament\SEO\SEO;
use Filament\Forms\Components\Tabs;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Tables\Actions\Action;


use Str;



class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Label')->columnSpanFull()
                    ->tabs([
                        Tabs\Tab::make('Main Content')->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->afterStateUpdated(function ( $set, $state, $context) {
                                            $set('slug', Str::slug($state));
                                    })
                                    ->debounce('500ms')
                                    ->required()
                                    ->maxLength(255)->columnSpanFull(),
                                Forms\Components\Hidden::make('is_slug_changed_manually')
                                    ->default(false)
                                    ->dehydrated(false),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\DatePicker::make('publish_at')->native(false),
                                Forms\Components\TextInput::make('subtitle')
                                    ->maxLength(255)->columnSpanFull(),
                               CuratorPicker::make('image')
                                    ->label('Select an Image')
                                    ->buttonLabel('Upload')
                                    ->imageResizeMode('contain')
                                    ->imageResizeTargetWidth('800')
                                    ->preserveFilenames()
                                    ->columnSpanFull(),
                                TiptapEditor::make('summary')
                                    ->profile('simple')
                                    ->required()->columnSpanFull(),
                                TiptapEditor::make('content')
                                    ->profile('simple')
                                    ->required()->columnSpanFull(),
                            ]),
                        Tabs\Tab::make('SEO')
                        ->schema([
                            SEO::make(),
                        ])
                    ])
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('publish_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('visit')
                    ->label(__('filament-fabricator::page-resource.actions.visit'))
                    ->url(fn (?News $record) => '/news/'.$record->slug  )
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->openUrlInNewTab()
                    ->color('success')
                    ->visible(config('filament-fabricator.routing.enabled')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }    
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
