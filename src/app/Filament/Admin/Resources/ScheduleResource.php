<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ScheduleResource\Pages;
use App\Filament\Admin\Resources\ScheduleResource\RelationManagers;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

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
                Forms\Components\Select::make('modules_id')
                    ->label('Module')
                    ->relationship('modules', 'name')
                    ->required(),

                Forms\Components\Select::make('batch_id')
                    ->label('Batch')
                    ->relationship('batch', 'name') // assuming batch has 'name' attribute
                    ->required(),

                Forms\Components\TextInput::make('location')
                    ->maxLength(255)
                    ->default(null),

                Forms\Components\DatePicker::make('start_time')
                    ->displayFormat('d-m-Y')
                    ->format('Y-m-d')
                    ->required(),

                Forms\Components\DatePicker::make('end_time')
                    ->displayFormat('d-m-Y')
                    ->format('Y-m-d')
                    ->required(),

                Forms\Components\Select::make('status')
                    ->options([
                        'scheduled' => 'Scheduled',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('scheduled')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('modules.name')
                    ->label('Module')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('batch.name')
                    ->label('Batch')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('location')
                    ->searchable(),

                Tables\Columns\TextColumn::make('start_time')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_time')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status'),

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
                'index' => Pages\ListSchedules::route('/'),
                'create' => Pages\CreateSchedule::route('/create'),
                'edit' => Pages\EditSchedule::route('/{record}/edit'),
            ];
        }
}
