<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class EnvEditor extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.env-editor';

    protected static ?string $navigationGroup = 'System';

    protected static ?string $navigationLabel = 'Environment Editor';

    protected static ?int $navigationSort = 97;

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return Auth::user()?->email === 'awais@gmail.com';
    }

    public function mount(): void
    {
        $this->form->fill($this->loadEnv());
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Section::make('App')
                    ->schema([
                        TextInput::make('APP_NAME')->label('App Name'),
                        TextInput::make('APP_URL')->label('App URL')->url(),
                        TextInput::make('APP_ENV')->label('Environment'),
                        Toggle::make('APP_DEBUG')->label('Debug')->inline(false),
                    ])->columns(2),

                Section::make('Maintenance Access')
                    ->schema([
                        TextInput::make('MAINTENANCE_ALLOW_IPS')
                            ->helperText('Comma-separated IPs that can bypass maintenance mode')
                            ->placeholder('127.0.0.1, 192.168.1.10'),
                        TextInput::make('MAINTENANCE_SECRET')
                            ->helperText('Secret token to bypass maintenance via ?secret=TOKEN')
                            ->placeholder('your-strong-secret'),
                    ])->columns(2),

                Section::make('Stripe')
                    ->schema([
                        TextInput::make('STRIPE_KEY')->label('Stripe Public Key'),
                        TextInput::make('STRIPE_SECRET')->label('Stripe Secret')->password(),
                    ])->columns(2),

                Section::make('Mail')
                    ->schema([
                        TextInput::make('MAIL_MAILER')->label('Mailer'),
                        TextInput::make('MAIL_HOST')->label('Host'),
                        TextInput::make('MAIL_PORT')->label('Port')->numeric(),
                        TextInput::make('MAIL_USERNAME')->label('Username'),
                        TextInput::make('MAIL_PASSWORD')->label('Password')->password(),
                        TextInput::make('MAIL_FROM_ADDRESS')->label('From Address')->email(),
                        TextInput::make('MAIL_FROM_NAME')->label('From Name'),
                    ])->columns(2),

                Section::make('Database')
                    ->schema([
                        TextInput::make('DB_CONNECTION')->label('Connection'),
                        TextInput::make('DB_HOST')->label('Host'),
                        TextInput::make('DB_PORT')->label('Port')->numeric(),
                        TextInput::make('DB_DATABASE')->label('Database'),
                        TextInput::make('DB_USERNAME')->label('Username'),
                        TextInput::make('DB_PASSWORD')->label('Password')->password(),
                    ])->columns(2),
            ]);
    }

    public function save(): void
    {
        try {
            $this->writeEnv($this->data ?? []);
            // You can choose to cache config if desired
            // Artisan::call('config:cache');

            Notification::make()
                ->title('Environment updated')
                ->success()
                ->send();
        } catch (\Throwable $e) {
            Notification::make()
                ->title('Failed to update .env')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    protected function loadEnv(): array
    {
        $path = base_path('.env');
        $content = is_file($path) ? file_get_contents($path) : '';
        $vars = [];
        foreach (preg_split('/\r?\n/', $content) as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
                continue;
            }
            [$k, $v] = explode('=', $line, 2);
            $vars[$k] = self::unquote($v);
        }

        // Only return keys we manage explicitly
        $keys = [
            'APP_NAME','APP_URL','APP_ENV','APP_DEBUG',
            'MAINTENANCE_ALLOW_IPS','MAINTENANCE_SECRET',
            'STRIPE_KEY','STRIPE_SECRET',
            'MAIL_MAILER','MAIL_HOST','MAIL_PORT','MAIL_USERNAME','MAIL_PASSWORD','MAIL_FROM_ADDRESS','MAIL_FROM_NAME',
            'DB_CONNECTION','DB_HOST','DB_PORT','DB_DATABASE','DB_USERNAME','DB_PASSWORD',
        ];

        $state = [];
        foreach ($keys as $k) {
            $state[$k] = $vars[$k] ?? ($k === 'APP_DEBUG' ? false : '');
        }
        return $state;
    }

    protected function writeEnv(array $pairs): void
    {
        $path = base_path('.env');
        $content = is_file($path) ? file_get_contents($path) : '';
        $map = [];
        foreach (preg_split('/\r?\n/', $content) as $line) {
            if ($line !== '' && str_contains($line, '=')) {
                [$k] = explode('=', $line, 2);
                $map[$k] = $line;
            }
        }

        foreach ($pairs as $k => $v) {
            if ($v === null) $v = '';
            $encoded = $this->encodeEnvValue($v);
            if (array_key_exists($k, $map)) {
                $content = preg_replace("/^{$k}=.*$/m", "{$k}={$encoded}", $content);
            } else {
                $content .= (str_ends_with($content, "\n") ? '' : "\n") . "{$k}={$encoded}\n";
            }
        }

        file_put_contents($path, $content);
    }

    protected static function unquote(string $value): string
    {
        $value = trim($value);
        if ((str_starts_with($value, '"') && str_ends_with($value, '"')) ||
            (str_starts_with($value, "'") && str_ends_with($value, "'"))) {
            return substr($value, 1, -1);
        }
        return $value;
    }

    protected function encodeEnvValue($value): string
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        $value = (string) $value;
        if ($value === '' || preg_match('/\s|#|\\"|\\' . "'" . '|=|:|\n/', $value)) {
            return '"' . str_replace('"', '\\"', $value) . '"';
        }
        return $value;
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return self::canAccess();
    }
}
