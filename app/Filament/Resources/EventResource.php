<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
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


class EventResource extends Resource
{
    protected static ?string $model = Event::class;

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
                                    ->required()
                                    ->columnSpanFull()
                                    ->afterStateUpdated(function ( $set, $state, $context) {
                                            $set('slug', Str::slug($state));
                                    })
                                    ->debounce('500ms')
                                    ->maxLength(255),
                                Forms\Components\Hidden::make('is_slug_changed_manually')
                                    ->default(false)
                                    ->dehydrated(false),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)->columnSpanFull(),
                                Forms\Components\TextInput::make('subtitle')
                                    ->columnSpanFull()
                                    ->maxLength(255),
                                CuratorPicker::make('image')
                                    ->label('Select an Image')
                                    ->buttonLabel('Upload')
                                    ->imageResizeMode('contain')
                                    ->imageResizeTargetWidth('800')
                                    ->preserveFilenames()
                                    ->columnSpanFull(),
                                Forms\Components\DatePicker::make('start_date')->native(false)
                                    ->required(),
                                Forms\Components\DatePicker::make('end_date')->native(false)
                                    ->required(),
                                Forms\Components\TextInput::make('times')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('location')
                                    ->maxLength(255),
                                TiptapEditor::make('content')
                                    ->profile('simple')
                                    ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
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
                    ->url(fn (?Event $record) => '/events/'.$record->slug  )
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }    
}