<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ModulesResource\Pages;
use Illuminate\Support\Facades\Storage;
use App\Filament\Admin\Resources\ModulesResource\RelationManagers;
use App\Models\Modules;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ModulesResource extends Resource
{
    protected static ?string $model = Modules::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Learning System';
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
                Forms\Components\Select::make('course_id')
                    ->relationship('course', 'title')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Pertemuan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('file')
                    ->label('Modul PPT/PDF')
                    ->default(null),
                Forms\Components\FileUpload::make('video')
                    ->label('Modul Video')
                    ->disk('public') // Optional: use your desired disk
                    ->directory('videos') // Optional: target folder
                    ->acceptedFileTypes(['video/mp4']) // optional restriction
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('course.title')
                    ->label('Course Name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Pertemuan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file')
                    ->label('Materi PPT/PDF')
                    ->searchable(),
                Tables\Columns\TextColumn::make('video')
                    ->label('Materi Video')
                    ->searchable(),
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
            'index' => Pages\ListModules::route('/'),
            'create' => Pages\CreateModules::route('/create'),
            'edit' => Pages\EditModules::route('/{record}/edit'),
        ];
    }
}
