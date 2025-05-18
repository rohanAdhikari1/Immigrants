<?php

namespace App\Filament\Resources;

use App\Filament\Exports\VaccinatorExporter;
use App\Filament\Resources\RecordCollectorUsersResource\Pages;
use App\Models\DataEntryUser;
use App\Models\Muncipality;
use App\Models\User;
use Filament\Tables\Actions\ExportAction;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RecordCollectorUsersResource extends Resource
{

    protected static ?string $model = DataEntryUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Record Collector Users';

    protected static ?string $modelLabel = "Surveyor";

    protected static ?string $navigationGroup = 'Users';

    public static function generateUniqueUsername($firstName)
    {
        if (!empty($firstName)) {
            $baseUsername = Str::slug($firstName);
            $count = User::where('username', 'like', "{$baseUsername}%")->count();
            if ($count > 0) {
                return "{$baseUsername}" . ($count + 1);
            }
            return $baseUsername;
        }
        return null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('is_active')
                    ->default(true),
                Forms\Components\Hidden::make('created_by')
                    ->default(Filament::auth()->id()),
                Forms\Components\Hidden::make('district_id')
                    ->visible(fn() => Filament::auth()->user()->hasRole('Muncipality') || Filament::auth()->user()->hasRole('district'))
                    ->default(Filament::auth()->user()->district_id),
                Forms\Components\Hidden::make('muncipality_id')
                    ->visible(fn() => Filament::auth()->user()->hasRole('Muncipality'))
                    ->default(Filament::auth()->user()->muncipality_id),
                Forms\Components\Select::make('district_id')
                    ->relationship('district', 'name')
                    ->label('District')
                    ->preload()
                    ->live(onBlur: true)
                    ->default(Filament::auth()->user()->district_id)
                    ->searchable()
                    ->hidden(fn() => Filament::auth()->user()->hasRole('Muncipality') || Filament::auth()->user()->hasRole('district')),
                Forms\Components\Select::make('muncipality_id')
                    ->options(function (Forms\Get $get) {
                        if (!$get('district_id')) {
                            return [];
                        }
                        return Muncipality::where('district_id', $get('district_id'))->pluck('name', 'id');
                    })
                    ->label('Muncipality')
                    ->searchable()
                    ->preload()
                    ->hidden(fn() => Filament::auth()->user()->hasRole('Muncipality')),
                Forms\Components\Fieldset::make('User Information')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->label('First Name')
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, string $operation, ?string $state) {
                                if ($operation === 'create') {
                                    $set('username', self::generateUniqueUsername($state));
                                }
                            })
                            ->required(),
                        Forms\Components\TextInput::make('middle_name')
                            ->label('Middle Name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('last_name')
                            ->label('Last Name')
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('primary_phone')
                            ->unique(ignoreRecord: true)
                            ->label('Primary Phone')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('secondary_phone')
                            ->label('Secondary Phone')
                            ->numeric(),
                        Forms\Components\Grid::make('qual')
                            ->schema([
                                Forms\Components\TextInput::make('email')
                                    ->unique(ignoreRecord: true)
                                    ->label('Email')
                                    ->maxLength(255),
                            ])
                            ->columns(2),
                        Forms\Components\Textarea::make('address')
                            ->label('Address')
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('qualification_document')
                            ->label('Qualification Document')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/gif'])
                            ->helperText('Only PDF and image files With Maximum Size 2MB are allowed.')
                            ->maxSize(2048)
                            ->disk('public')
                            ->directory('document_images/vacinators/qualifications/')
                            ->downloadable()
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('official_document')
                            ->label('Official Document')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/gif'])
                            ->helperText("Citizenship,National Id Card etc.")
                            ->maxSize(2048)
                            ->disk('public')
                            ->directory('document_images/vacinators/officials/')
                            ->downloadable()
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('avatar_url')
                            ->label('Profile')
                            ->image()
                            ->disk('public')
                            ->directory('profile_images/data_collecotrs/')
                            ->nullable()
                            ->avatar()
                            ->imageEditor()
                            ->maxSize(1024)
                            ->circleCropper(),
                    ])
                    ->columns(3),

                Forms\Components\Fieldset::make('User Credentials')
                    ->schema([
                        Forms\Components\TextInput::make('username')
                            ->label('Username')
                            ->prefixIcon('heroicon-m-user')
                            ->autocomplete(false)
                            ->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/')
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->prefixIcon('heroicon-m-shield-check')
                            ->visibleOn('create')
                            ->revealable()
                            ->default(fn() => Str::random(8))
                            ->autocomplete(false)
                            ->required()
                            ->suffixAction(
                                Action::make('regenerate')
                                    ->icon('heroicon-o-arrow-path')
                                    ->action(function (Set $set) {
                                        $set('password', Str::random(8));
                                    })
                            )
                            ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                            ->maxLength(255),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->label('Profile')
                    ->simpleLightbox()
                    ->circular()
                    ->disk('public'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('primary_phone')
                    ->label('Phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('muncipality.name')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->action(function ($record) {
                        if (!auth()->user()->hasRole('user') && !auth()->user()->hasRole('Muncipality')) {
                            $record->is_active = !$record->is_active;
                            $record->created_by = Filament::auth()->user()->id;
                            $record->save();
                            Notification::make()
                                ->title($record->is_active ? 'Vaccinator Request Approved' : 'Vaccinator Request Discarded')
                                ->success()
                                ->send();
                        }
                    }),
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
                Tables\Filters\SelectFilter::make('muncipality_id')
                    ->label('Muncipality')
                    ->relationship('muncipality', 'name')
                    ->searchable()
                    ->hidden(fn() => Filament::auth()->user()->hasRole('Muncipality')),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('toggleStatus')
                        ->label(fn(User $record) => $record->is_active ? 'Deactivate' : 'Activate')
                        ->action(function (User $record) {
                            $record->update([
                                'is_active' => !$record->is_active,
                            ]);
                        })
                        ->icon(fn(User $record) => $record->is_active ? 'heroicon-s-x-circle' : 'heroicon-s-check')
                        ->color(fn(User $record) => $record->is_active ? 'danger' : 'success')
                        ->hidden(fn() => auth()->user()->hasRole('user') || auth()->user()->hasRole('Muncipality')),
                    Tables\Actions\Action::make('report')
                        ->label('Generate Report')
                        ->url(fn($record) => static::getUrl('report', ['record' => $record]))
                        ->icon('heroicon-s-clipboard-document-list'),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('reset-password')
                        ->label('Reset Password')
                        ->icon('heroicon-o-key')
                        ->modalHeading('Reset Password')
                        ->form([
                            Forms\Components\TextInput::make('new_password')
                                ->label('New Password')
                                ->password()
                                ->required()
                                ->minLength(8),
                            Forms\Components\TextInput::make('new_password_confirmation')
                                ->label('Confirm New Password')
                                ->password()
                                ->required()
                                ->same('new_password'),
                        ])
                        ->action(function ($record, $data) {
                            $record->forceFill([
                                'password' => Hash::make($data['new_password'])
                            ])->setRememberToken(Str::random(60));
                            $record->save();
                            Notification::make()
                                ->title('Password Reset successfully')
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\DeleteAction::make(),
                    // Tables\Actions\Action::make('test')
                    //     ->action(fn($data, $livewire) => dd($livewire->getFilteredTableQuery()->get())),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query->whereHas('user', fn($q) => auth()->user()->hasRole('Muncipality') ? $q->where('muncipality_id', auth()->user()->muncipality_id) : (auth()->user()->hasRole('district') ? $q->where('district_id', auth()->user()->district_id) : $q)));
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
            'index' => Pages\ListRecordCollectorUsers::route('/'),
            'create' => Pages\CreateRecordCollectorUsers::route('/create'),
            'view' => Pages\ViewRecordCollectorUsers::route('/{record}'),
            'edit' => Pages\EditRecordCollectorUsers::route('/{record}/edit'),
            'report' => Pages\VaccinatorReport::route('/{record}/report'),
        ];
    }
}
