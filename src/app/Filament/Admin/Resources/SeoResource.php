<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SeoResource\Pages;
use App\Filament\Admin\Resources\SeoResource\RelationManagers;
use App\Models\Front\Seo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SeoResource extends Resource
{
    protected static ?string $model = Seo::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'SEO Manager';
    protected static ?string $breadcrumb = 'SEO Manager';
    protected static ?string $pluralLabel = 'SEO Setting';

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
                Forms\Components\TextInput::make('title')
                    ->required(),

                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->required(),

                Forms\Components\TextInput::make('keywords')
                    ->label('Meta Keywords'),

                Forms\Components\TextInput::make('canonical_url')
                    ->label('Canonical URL'),

                Forms\Components\TextInput::make('robots')
                    ->label('Meta Robots')
                    ->default('index, follow'),

                Forms\Components\FileUpload::make('og_image')
                    ->label('Open Graph Image')
                    ->directory('seo')
                    ->image()
                    ->imagePreviewHeight('150')
                    ->maxSize(1024),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->limit(30),
                Tables\Columns\TextColumn::make('description')->limit(50),
                Tables\Columns\TextColumn::make('keywords')->limit(50),
                Tables\Columns\TextColumn::make('canonical_url')->label('Canonical')->limit(40),
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
            'index' => Pages\ListSeos::route('/'),
            'create' => Pages\CreateSeo::route('/create'),
            'edit' => Pages\EditSeo::route('/{record}/edit'),
        ];
    }
}
