<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Pages\Login;
use Filament\Navigation\NavigationGroup;
use Filament\Facades\Filament;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use Filament\Navigation\MenuItem;


class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->colors([
                'primary' => Color::Purple,
            ])
            ->font('Actor')
            ->brandLogo(asset('logo.png'))
            ->brandName('KMSystem')
            ->favicon(asset('logo.png'))
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Forum Management')
                    ->collapsed(true),
                NavigationGroup::make()
                    ->label('Document Management')
                    ->collapsed(true),
                NavigationGroup::make()
                    ->label('User Management')
                    ->collapsed(true),
                NavigationGroup::make()
                    ->label('Academic')
                    ->collapsed(true),
                NavigationGroup::make()
                    ->label('Analytics')
                    ->collapsed(true),
                NavigationGroup::make()
                    ->label('System')
                    ->collapsed(true),
            ])
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
                \App\Filament\Widgets\RecommendationWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
                FilamentEditProfilePlugin::make()
                    ->shouldShowAvatarForm(true)
                    ->shouldRegisterNavigation(false),
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->userMenuItems([
                MenuItem::make('Edit Profile')
                    ->label('Edit Profile')
                    ->url(fn (): string => EditProfilePage::getUrl())
                    ->icon('heroicon-o-user'),
            ])
            ->databaseNotifications()
            ->databaseNotificationsPolling('10s')
            ->sidebarCollapsibleOnDesktop()
            ->path('');
    }
}
