<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Models\Menu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;
    protected static ?string $navigationIcon = 'heroicon-o-bars-3';
    protected static ?string $navigationGroup = 'Navigation';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\Select::make('location')
                    ->options([
                        'header_main'    => 'Header – Main Nav',
                        'footer_plan'    => 'Footer – Plan Your Trip',
                        'footer_company' => 'Footer – Company Links',
                    ])
                    ->required()
                    ->unique(Menu::class, 'location', ignoreRecord: true),
            ])->columns(2),

            Forms\Components\Section::make('Menu Items')
                ->description('Items without any dropdown items link directly. Add dropdown items to turn a top-level item into a dropdown trigger (its own URL still works as the main link).')
                ->schema([
                    Forms\Components\Repeater::make('items')
                        ->relationship()
                        ->schema([
                            Forms\Components\TextInput::make('label')->required()->columnSpan(2),
                            Forms\Components\TextInput::make('url')->required()->columnSpan(2),
                            Forms\Components\Select::make('target')
                                ->options(['_self' => 'Same tab', '_blank' => 'New tab'])
                                ->default('_self'),
                            Forms\Components\Toggle::make('is_active')->default(true)->label('Active'),
                            Forms\Components\TextInput::make('sort_order')
                                ->numeric()
                                ->default(0)
                                ->label('Order'),
                            Forms\Components\Repeater::make('children')
                                ->relationship()
                                ->label('Dropdown items')
                                ->schema([
                                    Forms\Components\TextInput::make('label')->required()->columnSpan(2),
                                    Forms\Components\TextInput::make('url')->required()->columnSpan(2),
                                    Forms\Components\Select::make('target')
                                        ->options(['_self' => 'Same tab', '_blank' => 'New tab'])
                                        ->default('_self'),
                                    Forms\Components\Toggle::make('is_active')->default(true)->label('Active'),
                                    Forms\Components\TextInput::make('sort_order')
                                        ->numeric()
                                        ->default(0)
                                        ->label('Order'),
                                ])
                                ->columns(3)
                                ->reorderable('sort_order')
                                ->orderColumn('sort_order')
                                ->cloneable()
                                ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                                ->columnSpanFull()
                                ->collapsed(),
                        ])
                        ->columns(3)
                        ->reorderable('sort_order')
                        ->orderColumn('sort_order')
                        ->cloneable()
                        ->itemLabel(fn (array $state): ?string => $state['label'] ?? null),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable(),
                Tables\Columns\TextColumn::make('location')->badge(),
                Tables\Columns\TextColumn::make('allItems_count')
                    ->counts('allItems')
                    ->label('Items'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit'   => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
