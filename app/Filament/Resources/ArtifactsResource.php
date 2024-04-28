<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtifactsResource\Pages;
use App\Filament\Resources\ArtifactsResource\RelationManagers;
use App\Models\Artifacts;
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
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;

use Str;

class ArtifactsResource extends Resource
{
    protected static ?string $model = Artifacts::class;

    protected static ?string $navigationIcon = 'heroicon-m-star';
    protected static ?string $navigationLabel = 'Artifacts';
    protected static ?string $navigationGroup = 'Artifacts';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Label')->columnSpanFull()
                    ->tabs([

                        Tabs\Tab::make('Title & File')->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('originalTitle')
                                    ->label('Title in original language')
                                    ->columnSpanFull()
                                    ->required(),   
                                Forms\Components\TextInput::make('translatedTitle')
                                    ->label('Translated title into English')
                                    ->required()
                                    ->columnSpanFull()
                                    ->afterStateUpdated(function ($set, $state, $context) {
                                        $set('slug', Str::slug($state));
                                    })
                                    ->debounce('500ms')
                                    ->maxLength(255),
                                Forms\Components\Hidden::make('is_slug_changed_manually')
                                    ->default(false)
                                    ->dehydrated(false),
                                Forms\Components\TextInput::make('slug')
                                    ->helperText('Created automatically by the translated title')
                                    ->required()
                                    ->maxLength(255)->columnSpanFull(),
                                    FileUpload::make('artifactImage')
                                    ->label('Artifact File'),
                                Forms\Components\TextInput::make('fileName')
                                    ->label('Filename of artifact in Google Drive')
                                    ->columnSpanFull(),
                            ]),


                        Tabs\Tab::make('Creator & Media Type')->columns(2)
                            ->schema([
                                Section::make('Creator Details')
                                    ->description('The name and role of the creator of the artifact')
                                    ->schema([
                                        Forms\Components\TextInput::make('creatorName')
                                            ->label('Creator Name')
                                            ->columnSpanFull()
                                            ->required(),
                                        Forms\Components\TextInput::make('creatorRole')
                                            ->label('Role / Organisation Type')
                                            ->columnSpanFull(),
                                    ]),
                                Section::make('Media Type')
                                    ->description('The type of media this artifact is')
                                    ->schema([
                                        Select::make('type')
                                        ->relationship( titleAttribute: 'type')
                                        ->searchable()
                                        ->preload()
                                        ->createOptionForm([
                                            Forms\Components\TextInput::make('type')
                                                ->required(),
                                        ]),
                                    ]),
                            ]),

                        Tabs\Tab::make('Date & Description')->columns(2)
                            ->schema([
                                Section::make('Date of release')
                                    ->description('The day, month and year the artifact was released, if known')
                                    ->schema([
                                        Forms\Components\TextInput::make('dayOfRelease')
                                            ->label('Date of the day of release')
                                            ->helperText('The date of the day, if known, that the artifact was released or published')
                                            ->columnSpanFull(),
                                            Select::make('monthOfRelease')
                                            ->options([
                                                '1' => 'January',
                                                '2' => 'February',
                                                '3' => 'March',
                                                '4' => 'April',
                                                '5' => 'May',
                                                '6' => 'June',
                                                '7' => 'July',
                                                '8' => 'August',
                                                '9' => 'September',
                                                '10' => 'October',
                                                '11' => 'November',
                                                '12' => 'December',

                                            ])
                                            ->label('Month of release')
                                            ->helperText('The month, if known, that the artifact was released or published')
                                            ->placeholder(('N/A'))
                                            ->columnSpanFull(),
                                            
                                        Forms\Components\TextInput::make('yearOfRelease')
                                            ->label('The year of release')
                                            ->helperText('The year that the artifact was released or published')
                                            ->columnSpanFull()
                                    ]),
                                Section::make('Description')
                                    ->description('The short and long description of the artifact')
                                    ->schema([
                                        TiptapEditor::make('shortDesc')
                                            ->label('Short description')
                                            ->profile('simple')
                                            ->columnSpanFull(),
                                        TiptapEditor::make('longDesc')
                                            ->label('Long description')
                                            ->profile('simple')
                                            ->columnSpanFull(),
                                    ])
                            ]),

                        Tabs\Tab::make('Location & Language')->columns(2)
                            ->schema([
                                Section::make('Location')
                                    ->description('The location or place associated with the resource')
                                    ->schema([
                                        Select::make('locations')
                                        ->relationship( titleAttribute: 'wholeAddress')
                                        ->searchable()
                                        ->preload()
                                        ->createOptionForm([
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
                                        ]),
                                    ]),
                                Section::make('Language')
                                    ->description('The Lanuage of the resource')
                                    ->schema([
                                        Select::make('language')
                                        ->relationship( titleAttribute: 'name')
                                        
                                        ->createOptionForm([
                                            Forms\Components\TextInput::make('name')
                                                ->required(),
                                        ]),
                                    ]),
                            ]),

                        Tabs\Tab::make('Publishing & Copyrights')->columns(2)
                            ->schema([
                                Section::make('Publishing')
                                    ->description('The publisher or entity responsible for making the resource available')
                                    ->schema([
                                        Forms\Components\TextInput::make('publisher')
                                            ->label('Publisher')
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('producer')
                                            ->label('Producer')
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('printer')
                                            ->label('Printer')
                                            ->columnSpanFull(),
                                    ]),
                                Section::make('Copyrights')
                                    ->description('Copyright information about the resource')
                                    ->schema([
                                        TiptapEditor::make('copyright')
                                            ->label('Copyright Information')
                                            ->profile('simple')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tabs\Tab::make('Instituion, Bibliography & Documenter')->columns(2)
                            ->schema([
                                Section::make('Institute')
                                    ->description('The Institution / Archive / Depository that the resouce is held in')
                                    ->schema([
                                        Forms\Components\TextInput::make('institute')
                                            ->label('Institution')
                                            ->helperText('Format: Not abbreviated')
                                            ->columnSpanFull(),
                                    ]),
                                    Section::make('Bibliography')
                                    ->description('A list of sources used in the process of research')
                                    ->schema([
                                        Forms\Components\TextInput::make('bibliography')
                                            ->label('Bibliography')
                                            ->helperText('Format: APA Style')
                                            ->columnSpanFull(),
                                    ]),
                                    Section::make('Documenter')
                                    ->description('The person documenting the artifact')
                                    ->schema([
                                        Forms\Components\TextInput::make('documenter')
                                            ->label('Documenter')
                                            ->columnSpanFull(),
                                    ]),
                            ]),


                        Tabs\Tab::make('Keywords, Tags and Themeing')->columns(2)
                            ->schema([
                                Select::make('keywords')
                                ->multiple()
                                ->relationship( titleAttribute: 'word')
                                ->searchable()
                                ->preload()
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('word')
                                        ->required(),
                                ]),
                                Select::make('tags')
                                ->multiple()
                                ->relationship( titleAttribute: 'tag')
                                ->searchable()
                                ->preload()
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('tag')
                                        ->required(),
                                ]),
                                    Forms\Components\TextInput::make('themeing')
                                    ->label('Themeing')
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
            Tables\Columns\TextColumn::make('translatedTitle')
            ->searchable(),
        ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('keywords')->relationship('keywords', 'word'),
                Tables\Filters\SelectFilter::make('tags')->relationship('tags', 'tag')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListArtifacts::route('/'),
            'create' => Pages\CreateArtifacts::route('/create'),
            'edit' => Pages\EditArtifacts::route('/{record}/edit'),
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
