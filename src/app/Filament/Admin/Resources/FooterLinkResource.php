<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\FooterLinkResource\Pages;
use App\Filament\Admin\Resources\FooterLinkResource\RelationManagers;
use App\Models\Front\FooterLink;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class FooterLinkResource extends Resource
{
    protected static ?string $model = FooterLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Footer Manager';
    protected static ?string $breadcrumb = 'Footer Manager';
    protected static ?string $pluralLabel = 'Footer Setting';
    public static function getNavigationSort(): ?int
    {
        // Auto-generate sort from navigation label
        return crc32(static::getNavigationLabel()) % 100;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('section')
                ->options([
                    'service' => 'Service',
                    'quick_links' => 'Quick Links',
                    'other_links' => 'Other Links',
                ])
                ->required()
                ->label('Section'),

            Forms\Components\TextInput::make('label')
                ->required()
                ->label('Link Text'),

            Forms\Components\TextInput::make('url')
                ->required()
                ->label('Link URL'),

            Forms\Components\TextInput::make('order')
                ->numeric()
                ->default(0)
                ->label('Order'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('section')->sortable(),
                Tables\Columns\TextColumn::make('label')->label('Text'),
                Tables\Columns\TextColumn::make('url')->label('URL'),
                Tables\Columns\TextColumn::make('order')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListFooterLinks::route('/'),
            'create' => Pages\CreateFooterLink::route('/create'),
            'edit' => Pages\EditFooterLink::route('/{record}/edit'),
        ];
    }
}
