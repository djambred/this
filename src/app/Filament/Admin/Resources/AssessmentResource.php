<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AssessmentResource\Pages;
use App\Filament\Admin\Resources\AssessmentResource\RelationManagers;
use App\Models\Assessment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssessmentResource extends Resource
{
    protected static ?string $model = Assessment::class;

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
                Forms\Components\TextInput::make('github_repository')
                    ->maxLength(255)
                    ->default(null),

                Forms\Components\TextInput::make('score')
                    ->maxLength(255)
                    ->default(null),

                Forms\Components\Select::make('status')
                    ->options([
                        'ongoing' => 'Ongoing',
                        'passed' => 'Passed',
                        'failed' => 'Failed',
                    ])
                    ->default('ongoing')
                    ->required(),

                Forms\Components\Select::make('user_id')
                    ->label('Student')
                    ->options(function () {
                        return \App\Models\User::role('student')->pluck('name', 'id');
                    })
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('module_id')
                    ->label('Module')
                    ->relationship('modules', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('github_repository')
                    ->searchable(),
                Tables\Columns\TextColumn::make('score')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status'),

                // Show student's user name via relationship
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student Name')
                    ->sortable()
                    ->searchable(),

                // Show module name via relationship
                Tables\Columns\TextColumn::make('modules.name')
                    ->label('Module Name')
                    ->sortable()
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
            'index' => Pages\ListAssessments::route('/'),
            'create' => Pages\CreateAssessment::route('/create'),
            'edit' => Pages\EditAssessment::route('/{record}/edit'),
        ];
    }
}
