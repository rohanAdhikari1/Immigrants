<?php

namespace App\Filament\Pages;

use App\Models\Muncipality;
use Exception;
use Filament\Facades\Filament;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;
    public ?array $profileData = [];
    public ?array $passwordData = [];
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.edit-profile';
    protected static bool $shouldRegisterNavigation = false;

    public function mount(): void
    {
        $this->fillForms();
    }

    protected function getForms(): array
    {
        return [
            'editProfileForm',
            'editPasswordForm',
        ];
    }

    protected function getUpdateProfileFormActions(): array
    {
        return [
            Forms\Components\Actions\Action::make('updateProfileAction')
                ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
                ->action(fn() => $this->updateProfile()),
        ];
    }

    protected function getUpdatePasswordFormActions(): array
    {
        return [
            Forms\Components\Actions\Action::make('updatePasswordAction')
                ->label('Update Password')
                ->action(fn() => $this->updatePassword()),
        ];
    }

    public function editProfileForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Profile Information')
                    ->aside()
                    ->description('Update your account\'s profile information')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->label('First Name')
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('middle_name')
                            ->label('Middle Name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('last_name')
                            ->label('Last Name')
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('username')
                            ->label('Username')
                            ->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/')
                            ->prefixIcon('heroicon-m-user')
                            ->autocomplete(false)
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->label(__('filament-panels::pages/auth/register.form.email.label'))
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('primary_phone')
                            ->unique(ignoreRecord: true)
                            ->label('Primary Phone')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('secondary_phone')
                            ->label('Secondary Phone')
                            ->numeric(),
                        Forms\Components\TextInput::make('counsil_no')
                            ->label('Council Registration No')
                            ->numeric()
                            ->visible(fn() => Filament::auth()->user()->hasRole('user'))
                            ->maxLength(255),
                        Forms\Components\Select::make('qualification')
                            ->required()
                            ->options([
                                'VAHW' => 'VAHW',
                                'JTA' => 'JTA',
                                'JT' => 'JT',
                                'Veterinary Doctor' => 'Veterinary Doctor',
                                'Others' => 'Others',
                            ])
                            ->visible(fn() => Filament::auth()->user()->hasRole('user'))
                            ->searchable(),
                        Forms\Components\Select::make('muncipality_id')
                            ->label('Preferred Muncipality')
                            ->options(Muncipality::get()->pluck('name', 'id'))
                            ->searchable()
                            ->visible(fn() => Filament::auth()->user()->hasRole('user'))
                            ->required()
                            ->preload(),
                        Forms\Components\TextInput::make('national_id_number')
                            ->label('National Id Number (NIN)'),
                        Forms\Components\Textarea::make('address')
                            ->label('Address')
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
                        Forms\Components\Actions::make($this->getUpdateProfileFormActions()),
                    ]),
            ])
            ->model($this->getUser())
            ->statePath('profileData');
    }
    public function editPasswordForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Update Password')
                    ->aside()
                    ->description('Ensure your account uses a long, random password for optimal security.')
                    ->schema([
                        Forms\Components\TextInput::make('current_password')
                            ->label('Current Password')
                            ->password()
                            ->currentPassword()
                            ->revealable()
                            ->autocomplete(false)
                            ->dehydrated(false)
                            ->required(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        Forms\Components\Actions::make($this->getUpdatePasswordFormActions()),
                    ]),
            ])
            ->model($this->getUser())
            ->statePath('passwordData');
    }

    protected function getPasswordFormComponent(): Component
    {
        return Forms\Components\TextInput::make('password')
            ->label(__('filament-panels::pages/auth/register.form.password.label'))
            ->password()
            ->revealable(true)
            ->required()
            ->minLength(8)
            ->dehydrateStateUsing(fn($state) => Hash::make($state))
            ->same('passwordConfirmation')
            ->validationAttribute(__('filament-panels::pages/auth/register.form.password.validation_attribute'));
    }

    protected function getPasswordConfirmationFormComponent(): Component
    {
        return Forms\Components\TextInput::make('passwordConfirmation')
            ->label(__('filament-panels::pages/auth/register.form.password_confirmation.label'))
            ->password()
            ->revealable(true)
            ->required()
            ->dehydrated(false);
    }

    protected function getUser(): Authenticatable & Model
    {
        $user = Filament::auth()->user();
        if (! $user instanceof Model) {
            throw new Exception('The authenticated user object must be an Eloquent model to allow the profile page to update it.');
        }
        return $user;
    }

    protected function fillForms(): void
    {
        $data = $this->getUser()->attributesToArray();
        $this->editProfileForm->fill($data);
        $this->editPasswordForm->fill();
    }

    public function updateProfile(): void
    {
        $data = $this->editProfileForm->getState();
        $this->handleRecordUpdate($this->getUser(), $data);
        $this->sendSuccessNotification(false);
    }

    public function updatePassword(): void
    {
        $data = $this->editPasswordForm->getState();
        $this->handleRecordUpdate($this->getUser(), $data);
        if (request()->hasSession() && array_key_exists('password', $data)) {
            request()->session()->put(['password_hash_' . Filament::getAuthGuard() => $data['password']]);
        }
        $this->editPasswordForm->fill();
        $this->sendSuccessNotification(true);
    }

    protected function sendSuccessNotification($password): void
    {
        Notification::make()
            ->title($password ? 'Password Updated' : 'Profile Updated')
            ->success()
            ->send();
    }
    private function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);
        return $record;
    }
}
