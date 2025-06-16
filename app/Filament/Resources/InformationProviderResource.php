<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InformationProviderResource\Pages;
use App\Filament\Resources\InformationProviderResource\RelationManagers;
use App\Models\InformationProvider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InformationProviderResource extends Resource
{
    protected static ?string $model = InformationProvider::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('relation_to_hr')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('ethinic_group')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('mother_tongue')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('religion')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('created_by')
                    ->numeric()
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('relation_to_hr')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ethinic_group')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mother_tongue')
                    ->searchable(),
                Tables\Columns\TextColumn::make('religion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_by')
                    ->numeric()
                    ->sortable(),
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
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageInformationProviders::route('/'),
        ];
    }
}
