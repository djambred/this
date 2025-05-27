<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BootcampResource\Pages;
use App\Filament\Admin\Resources\BootcampResource\RelationManagers;
use App\Models\Bootcamp;
use Filament\Forms\Components\{Select, Grid};
use Filament\Tables\Columns\{TextColumn, BadgeColumn};
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BootcampResource extends Resource
{
    protected static ?string $model = Bootcamp::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Bootcamp Management';
    protected static ?string $recordTitleAttribute = 'name';

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
        return $form->schema([
            Grid::make(2)->schema([
                Select::make('batch_id')
                    ->label('Batch')
                    ->relationship('batch', 'name')
                    ->searchable()
                    ->required(),

                Select::make('course_id')
                    ->label('Course')
                    ->relationship('course', 'name')
                    ->searchable()
                    ->required(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('batch.name')->label('Batch')->searchable(),
                TextColumn::make('course.name')->label('Course')->searchable(),
                TextColumn::make('created_at')->dateTime()->label('Created'),
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
            'index' => Pages\ListBootcamps::route('/'),
            'create' => Pages\CreateBootcamp::route('/create'),
            'edit' => Pages\EditBootcamp::route('/{record}/edit'),
        ];
    }
}
