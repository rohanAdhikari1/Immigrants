<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CurrentMigrantWorkerResource\Pages;
use App\Filament\Resources\CurrentMigrantWorkerResource\RelationManagers;
use App\Models\CurrentMigrantWorker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CurrentMigrantWorkerResource extends Resource
{
    protected static ?string $model = CurrentMigrantWorker::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Migrant Workers';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('household_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('information_provider_id')
                    ->numeric()
                    ->default(null),
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
                Forms\Components\TextInput::make('number_of_times_fe')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('mode_of_travel')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('route_taken')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('visa_type')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('documents_left_on_home')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Toggle::make('skill_training_before_foreign_employment'),
                Forms\Components\Toggle::make('received_information_or_counseling_before_foreign_employment'),
                Forms\Components\TextInput::make('amount_paid_for_foreign_employment')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('major_source_of_amount_paid')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('current_job_abroad')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Toggle::make('problems_faced_during_foreign_employment'),
                Forms\Components\TextInput::make('problems_faced_during_foreign_employment_type')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Toggle::make('family_problems_during_foreign_employment'),
                Forms\Components\TextInput::make('family_problems_during_foreign_employment_type')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('second_marriage_done_by')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Toggle::make('only_elder_at_home_due_to_foreign_employment'),
                Forms\Components\Toggle::make('is_children_sent_to_other_city'),
                Forms\Components\TextInput::make('children_sent_to_other_city')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Toggle::make('is_amount_sent_at_home_last_1_year'),
                Forms\Components\TextInput::make('reason_for_not_sending_money')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('times_money_sent_home_last_1_year')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('amount_sent_home_last_1_year')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('remittance_expenditure_last_1_year')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('place_of_purchase_of_house_or_land_from_remittance')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('place_of_saving_remittance')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('place_of_receiving_money_from_abroad')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('migration_plan_location')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('plan_after_return')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('latitude')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('longitude')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('municipality_id')
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
                // Tables\Columns\TextColumn::make('household_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('information_provider_id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('household.ward_no')
                    ->label('Ward No')
                    ->searchable(isIndividual: true),
                // Tables\Columns\TextColumn::make('number_of_person')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('age')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('relation_to_hr')
                    ->searchable(),
                Tables\Columns\TextColumn::make('education_detail')
                    ->searchable(),
                Tables\Columns\TextColumn::make('maritial_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('foreign_country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('number_of_times_fe')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('mode_of_travel')
                    ->searchable(),
                Tables\Columns\TextColumn::make('route_taken')
                    ->searchable(),
                Tables\Columns\TextColumn::make('visa_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('documents_left_on_home')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\IconColumn::make('skill_training_before_foreign_employment')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\IconColumn::make('received_information_or_counseling_before_foreign_employment')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\TextColumn::make('amount_paid_for_foreign_employment')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('major_source_of_amount_paid')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('current_job_abroad')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\IconColumn::make('problems_faced_during_foreign_employment')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\TextColumn::make('problems_faced_during_foreign_employment_type')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\IconColumn::make('family_problems_during_foreign_employment')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\TextColumn::make('family_problems_during_foreign_employment_type')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('second_marriage_done_by')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\IconColumn::make('only_elder_at_home_due_to_foreign_employment')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_children_sent_to_other_city')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\TextColumn::make('children_sent_to_other_city')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_amount_sent_at_home_last_1_year')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\TextColumn::make('reason_for_not_sending_money')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('times_money_sent_home_last_1_year')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount_sent_home_last_1_year')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('remittance_expenditure_last_1_year')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('place_of_purchase_of_house_or_land_from_remittance')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('place_of_saving_remittance')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('place_of_receiving_money_from_abroad')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('migration_plan_location')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('plan_after_return')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('municipality.name')
                    ->label('Municipality')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('creator.first_name')
                    ->label('Created By')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->toggleable(isToggledHiddenByDefault: true)
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
            ->deferLoading()
            ->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListCurrentMigrantWorkers::route('/'),
            'create' => Pages\CreateCurrentMigrantWorker::route('/create'),
            'edit' => Pages\EditCurrentMigrantWorker::route('/{record}/edit'),
        ];
    }
}
