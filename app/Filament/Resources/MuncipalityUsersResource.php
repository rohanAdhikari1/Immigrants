<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MuncipalityUsersResource\Pages;
use App\Models\District;
use App\Models\Muncipality;
use App\Models\MuncipalityUser;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class MuncipalityUsersResource extends Resource
{
    protected static ?string $model = MuncipalityUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Muncipality Users';

    protected static ?string $navigationGroup = 'Users';

    protected static ?string $modelLabel = "Muncipality";

    public static function generateUniqueUsername($firstName)
    {
        if (!empty($firstName)) {
            $baseUsername = Str::slug($firstName);
            $count = User::where('username', 'like', "{$baseUsername}%")->count();
            if ($count > 0) {
                return "{$baseUsername}_" . ($count + 1);
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
                Forms\Components\Select::make('district_id')
                    ->label('District')
                    ->relationship('district', 'name')
                    ->searchable()
                    ->options(function () {
                        return District::pluck('name', 'id');
                    })
                    ->hidden(fn() => auth()->user()->hasRole('district'))
                    ->preload()
                    ->required()
                    ->live()
                    ->default(Filament::auth()->user()->district_id)
                    ->afterStateUpdated(fn($set) => $set('muncipality_id', null))
                    ->suffixIcon('heroicon-m-globe-alt'),
                Forms\Components\Select::make('muncipality_id')
                    ->label('Muncipality')
                    ->relationship('muncipality', 'name')
                    ->searchable()
                    ->options(function (Forms\Get $get) {
                        if (!$get('district_id')) {
                            return [];
                        }
                        return Muncipality::whereDoesntHave('users', function ($q) {
                            $q->whereHas('roles', function ($q) {
                                $q->where('name', 'Muncipality');
                            });
                        })
                            ->where('district_id', $get('district_id'))->pluck('name', 'id');
                    })
                    ->preload()
                    ->required()
                    ->suffixIcon('heroicon-m-globe-alt'),
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
                        Forms\Components\TextInput::make('email')
                            ->unique(ignoreRecord: true)
                            ->label('Email')
                            ->maxLength(255)
                            ->email(),
                        Forms\Components\TextInput::make('primary_phone')
                            ->unique(ignoreRecord: true)
                            ->label('Primary Phone')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('secondary_phone')
                            ->label('Secondary Phone')
                            ->numeric(),
                        Forms\Components\Textarea::make('address')
                            ->label('Address')
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('avatar_url')
                            ->label('Profile')
                            ->image()
                            ->disk('public')
                            ->directory('profile_images/muncipalities/')
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
                            ->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/')
                            ->prefixIcon('heroicon-m-user')
                            ->autocomplete(false)
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
                        $record->is_active = !$record->is_active;
                        $record->save();
                        Notification::make()
                            ->title($record->is_active ? 'Muncipality User Activated' : 'Muncipality User Deavtivated')
                            ->success()
                            ->send();
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
                //
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
                        ->color(fn(User $record) => $record->is_active ? 'danger' : 'success'),
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
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query->whereHas('user', fn($q) => auth()->user()->hasRole('district') ? $q->where('district_id', auth()->user()->district_id) : $q));
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
            'index' => Pages\ListMuncipalityUsers::route('/'),
            'create' => Pages\CreateMuncipalityUsers::route('/create'),
            'view' => Pages\ViewMuncipalityUsers::route('/{record}'),
            'edit' => Pages\EditMuncipalityUsers::route('/{record}/edit'),
        ];
    }
}
