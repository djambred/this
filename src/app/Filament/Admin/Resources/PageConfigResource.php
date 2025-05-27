<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PageConfigResource\Pages;
use App\Filament\Admin\Resources\PageConfigResource\RelationManagers;
use App\Models\Front\PageConfig;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PageConfigResource extends Resource
{
    protected static ?string $model = PageConfig::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Pages Manager';
    protected static ?string $breadcrumb = 'Pages Manager';
    protected static ?string $pluralLabel = 'Pages Setting';
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
                Forms\Components\TextInput::make('url')
                    ->required()
                    ->label('URL'),
                Forms\Components\FileUpload::make('image')
                    ->label('Image')
                    ->directory('seo')
                    ->image()
                    ->imagePreviewHeight('150')
                    ->maxSize(1024),
                Forms\Components\TextInput::make('name_services')
                    ->required(),
                Forms\Components\TextInput::make('detail_services')
                    ->required(),
                Forms\Components\TextInput::make('description_services')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('title')->limit(30),
                Tables\Columns\TextColumn::make('description')->limit(50),
                Tables\Columns\TextColumn::make('url')->limit(50),
                Tables\Columns\TextColumn::make('name_services')->limit(30),
                Tables\Columns\TextColumn::make('detail_services')->limit(30),
                Tables\Columns\TextColumn::make('description_services')->limit(30),
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
            'index' => Pages\ListPageConfigs::route('/'),
            'create' => Pages\CreatePageConfig::route('/create'),
            'edit' => Pages\EditPageConfig::route('/{record}/edit'),
        ];
    }
}
