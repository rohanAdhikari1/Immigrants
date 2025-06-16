<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HouseholdResource\Pages;
use App\Filament\Resources\HouseholdResource\RelationManagers;
use App\Models\Household;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HouseholdResource extends Resource
{
    protected static ?string $model = Household::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('muncipality_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('ward_no')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('toll_name')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('toll_no')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('house_no')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('visit_date')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('latitude')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('longitude')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('house_representative_name')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('house_represent_gender'),
                Forms\Components\TextInput::make('house_represent_contact_no')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('house_represent_occupation')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('family_member_count')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('family_members_male_count')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('family_members_female_count')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('family_members_other_count')
                    ->numeric()
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
                Tables\Columns\TextColumn::make('muncipality_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ward_no')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('toll_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('toll_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('house_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('visit_date')
                    ->searchable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->searchable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->searchable(),
                Tables\Columns\TextColumn::make('house_representative_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('house_represent_gender'),
                Tables\Columns\TextColumn::make('house_represent_contact_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('house_represent_occupation')
                    ->searchable(),
                Tables\Columns\TextColumn::make('family_member_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('family_members_male_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('family_members_female_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('family_members_other_count')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ManageHouseholds::route('/'),
        ];
    }
}
