<?php

namespace App\Providers\Filament;

use App\Filament\Resources\GpsLogResource\Widgets\VehicleMapWidget;
use App\Filament\Resources\RentalResource\Widgets\Rental;
use App\Filament\Widgets\RentalChart;
use App\Filament\Widgets\RentalStatsOverview;
use App\Http\Middleware\AdminMiddleware;
use App\Providers\FilamentServiceProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Pages\Auth\EditProfile;
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

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->navigationItems([
                NavigationItem::make('Home')
                    ->url('/')
                    ->icon('heroicon-o-home')
                    ->sort(-10)
                    // ->openUrlInNewTab(),
            ])
            ->spa()
            ->default()
            ->brandLogo(asset('favicon.ico'))
            ->brandLogoHeight('3rem')
            ->brandName('Twayne Garage')
            ->id('admin')
            ->path('admin')
            ->profile()
            ->authGuard('web')
            // ->domain('admin.twaynegarage.com')
            // ->emailVerification()
            ->colors([
                'primary' => Color::Red,
                'gray' => Color::Slate
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
                RentalStatsOverview::class,
                RentalChart::class,
                VehicleMapWidget::class,
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
                AdminMiddleware::class,
            ])
            ->authMiddleware([
                AdminMiddleware::class,
                Authenticate::class,
            ]);
    }
}
