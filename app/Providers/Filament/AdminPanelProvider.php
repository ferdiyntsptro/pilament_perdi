<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Pages\Auth\Login;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default() // Menentukan ini sebagai panel default
            ->id('admin') // ID panel
            ->path('admin') // Path URL untuk panel admin
            ->login(Login::class) // Halaman login yang digunakan
            ->colors([
                'primary' => Color::Amber, // Warna utama untuk tema panel
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources') // Menemukan resources Filament
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages') // Menemukan pages Filament
            ->pages([
                Pages\Dashboard::class, // Mendefinisikan halaman dashboard
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets') // Menemukan widgets Filament
            ->widgets([
                Widgets\AccountWidget::class, // Widget Akun
                Widgets\FilamentInfoWidget::class, // Widget informasi Filament
            ])
            ->middleware([
                EncryptCookies::class, // Middleware untuk enkripsi cookies
                AddQueuedCookiesToResponse::class, // Middleware untuk menambahkan cookie ke respons
                StartSession::class, // Middleware untuk memulai sesi
                AuthenticateSession::class, // Middleware untuk mengautentikasi sesi
                ShareErrorsFromSession::class, // Middleware untuk berbagi error dari sesi
                VerifyCsrfToken::class, // Middleware untuk verifikasi token CSRF
                SubstituteBindings::class, // Middleware untuk menggantikan binding
                DisableBladeIconComponents::class, // Middleware untuk menonaktifkan komponen ikon Blade
                DispatchServingFilamentEvent::class, // Middleware untuk dispatch event Filament
            ])
            ->authMiddleware([
                Authenticate::class, // Middleware autentikasi Filament
            ]);
    }
}
