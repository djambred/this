<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductResource\Pages;
use App\Filament\Admin\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Sales Management';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?int $navigationSort = -2;


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
                Forms\Components\Select::make('batch_id')
                    ->label('Batch')
                    ->relationship('batch', 'name')
                    ->required(),
                Forms\Components\Select::make('course_id')
                    ->required()
                    ->relationship('course', 'name')
                    ->label('Course'),
                Forms\Components\Select::make('user_id')
                    ->label('Instructor')
                    ->options(function () {
                        return \App\Models\User::role('instructor')->pluck('name', 'id');
                    })
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->prefix('Rp.'),
                Forms\Components\FileUpload::make('image')
                    ->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('batch.name')
                    ->label('Batch Name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('course.name')
                    ->label('Course Name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Instructor Name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('Rp.')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
