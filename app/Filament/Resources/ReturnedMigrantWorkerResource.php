<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReturnedMigrantWorkerResource\Pages;
use App\Filament\Resources\ReturnedMigrantWorkerResource\RelationManagers;
use App\Models\ReturnedMigrantWorker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReturnedMigrantWorkerResource extends Resource
{
    protected static ?string $model = ReturnedMigrantWorker::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Migrant Workers';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('household_id')
                //     ->numeric()
                //     ->default(null),
                // Forms\Components\TextInput::make('information_provider_id')
                //     ->numeric()
                //     ->default(null),
                Forms\Components\TextInput::make('name')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('number_of_person')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('age')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('gender')
                    ->required(),
                Forms\Components\TextInput::make('contact_no')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('relation_to_hr')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('education_detail')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('maritial_status')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('foreign_country')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('years_since_returned')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('reason_for_returning_from_foreign_employment')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('disability_or_incapacity_due_to_foreign_employment')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('type_of_work_done_abroad')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('work_experience_during_foreign_employment')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('skill_training_after_return_to_nepal')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('current_occupation')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('type_of_own_business')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('challenges_in_starting_new_business')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Toggle::make('intention_to_return_to_foreign_employment'),
                Forms\Components\TextInput::make('desired_or_current_work_area_in_nepal')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('requirements_for_employment_in_nepal')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Toggle::make('post_foreign_employment_family_issues'),
                Forms\Components\TextInput::make('post_foreign_employment_family_issues_type')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('post_foreign_employment_family_issues_type_other')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Toggle::make('post_foreign_employment_health_issues'),
                Forms\Components\TextInput::make('post_foreign_employment_health_issues_type')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('post_foreign_employment_health_issues_type_other')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Toggle::make('post_foreign_employment_social_or_family_accusations'),
                Forms\Components\TextInput::make('post_foreign_employment_social_or_family_accusations_type')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('latitude')
                    ->disabled(),
                Forms\Components\TextInput::make('longitude')
                    ->disabled(),
                // Forms\Components\TextInput::make('municipality_id')
                //     ->numeric()
                //     ->default(null),
                // Forms\Components\TextInput::make('created_by')
                //     ->numeric()
                //     ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('household_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('information_provider_id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('household.ward_no')
                    ->label('Ward No')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('number_of_person')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('age')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('contact_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('relation_to_hr')
                    ->searchable(),
                Tables\Columns\TextColumn::make('education_detail')
                    ->searchable(),
                Tables\Columns\TextColumn::make('maritial_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('foreign_country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('years_since_returned')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reason_for_returning_from_foreign_employment')
                    ->searchable(),
                Tables\Columns\TextColumn::make('disability_or_incapacity_due_to_foreign_employment')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('type_of_work_done_abroad')
                    ->searchable(),
                Tables\Columns\TextColumn::make('work_experience_during_foreign_employment')
                    ->searchable(),
                Tables\Columns\TextColumn::make('skill_training_after_return_to_nepal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('current_occupation')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type_of_own_business')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('challenges_in_starting_new_business')
                    ->searchable(),
                Tables\Columns\IconColumn::make('intention_to_return_to_foreign_employment')
                    ->boolean(),
                Tables\Columns\TextColumn::make('desired_or_current_work_area_in_nepal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('requirements_for_employment_in_nepal')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\IconColumn::make('post_foreign_employment_family_issues')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\TextColumn::make('post_foreign_employment_family_issues_type')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('post_foreign_employment_family_issues_type_other')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\IconColumn::make('post_foreign_employment_health_issues')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\TextColumn::make('post_foreign_employment_health_issues_type')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('post_foreign_employment_health_issues_type_other')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\IconColumn::make('post_foreign_employment_social_or_family_accusations')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\TextColumn::make('post_foreign_employment_social_or_family_accusations_type')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('municipality.name')
                    ->label('Municipality'),
                Tables\Columns\TextColumn::make('creator.first_name')
                    ->label('Created By'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReturnedMigrantWorkers::route('/'),
            'create' => Pages\CreateReturnedMigrantWorker::route('/create'),
            'edit' => Pages\EditReturnedMigrantWorker::route('/{record}/edit'),
        ];
    }
}
