<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\District;
use App\Models\Muncipality;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Illuminate\Support\Str;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?string $recordTitleAttribute = 'first_name';

    public static function getGlobalSearchResultUrl($record): string
    {
        return UserResource::getUrl('view', ['record' => $record]);
    }

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
                Forms\Components\Select::make('roles')
                    ->relationship('roles', 'name')
                    ->live()
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('muncipality_id')
                    ->label('Muncipality')
                    ->relationship('muncipality', 'name')
                    ->searchable()
                    ->options(function () {
                        return Muncipality::get()
                            ->pluck('name', 'id');
                    })
                    ->preload()
                    ->required(function (Get $get) {
                        $role = $get('roles');
                        $muncipalityRoleId = Role::where('name', 'muncipality')->first()->id;
                        $userRoleId = Role::where('name', 'user')->first()->id;
                        if ($muncipalityRoleId == $role || $userRoleId == $role) {
                            return true;
                        }
                        return false;
                    })
                    ->suffixIcon('heroicon-m-globe-alt'),
                Forms\Components\Select::make('district_id')
                    ->label('District')
                    ->relationship('district', 'name')
                    ->searchable()
                    ->options(function () {
                        return District::get()
                            ->pluck('name', 'id');
                    })
                    ->preload()
                    ->required(function (Get $get) {
                        $role = $get('roles');
                        $muncipalityRoleId = Role::where('name', 'district')->first()->id;
                        $userRoleId = Role::where('name', 'user')->first()->id;
                        if ($muncipalityRoleId == $role || $userRoleId == $role) {
                            return true;
                        }
                        return false;
                    })
                    ->suffixIcon('heroicon-m-globe-alt'),
                Forms\Components\Fieldset::make('User Information')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->label('First Name')
                            ->maxLength(255)
                            ->live(debounce: 500)
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
                            ->directory('profile_images/users/')
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
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(Tables\Actions\ViewAction::class)
            ->recordUrl(null)
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
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
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
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\Action::make('reset-password')
                        ->visible(function ($record) {
                            return auth()->user()->hasRole('super_admin') || (!($record->hasRole('admin') || $record->hasRole('super_admin')) && auth()->user()->id !== $record->id);
                        })
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
                    Tables\Actions\EditAction::make()->visible(function ($record) {
                        return auth()->user()->hasRole('super_admin') || (!($record->hasRole('admin') || $record->hasRole('super_admin')) && auth()->user()->id !== $record->id);
                    }),
                    Tables\Actions\DeleteAction::make()
                        ->visible(function ($record) {
                            return (auth()->user()->hasRole('super_admin') || !($record->hasRole('admin') || $record->hasRole('super_admin'))) && auth()->user()->id !== $record->id;
                        }),
                ]),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
