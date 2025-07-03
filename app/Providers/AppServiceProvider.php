<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\View\View;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentView::registerRenderHook(
            'panels::auth.login.form.before',
            fn (): View => view('filament.login-extra')
        );

        Filament::serving(function () {
            // Add dummy menu for mockup admin panel
            Filament::registerNavigationItems([
                // Main Dashboard
                // NavigationItem::make('Dashboard')->icon('heroicon-o-home')->group('Main')->label('Dashboard')->url('/admin'),

                // User Management
                // NavigationItem::make('Users')->icon('heroicon-o-user')->group('User Management')->label('Users')->url('/admin/users'),
                // NavigationItem::make('Student')->icon('heroicon-o-academic-cap')->group('User Management')->label('Student')->url('/admin/students'),
                // NavigationItem::make('Lecturer')->icon('heroicon-o-user-circle')->group('User Management')->label('Lecturer')->url('/admin/lecturers'),
                // NavigationItem::make('Academic Staff')->icon('heroicon-o-briefcase')->group('User Management')->label('Academic Staff')->url('/admin/academic-staff'),
                // NavigationItem::make('Roles')->icon('heroicon-o-user-group')->group('User Management')->label('Roles')->url('/admin/roles'),

                // Document Management
                NavigationItem::make('Documents')->icon('heroicon-o-document-text')->group('Document Management')->label('Documents')->url('/admin/documents'),
                NavigationItem::make('Categories')->icon('heroicon-o-folder')->group('Document Management')->label('Categories')->url('/admin/categories'),
                NavigationItem::make('Tags')->icon('heroicon-o-tag')->group('Document Management')->label('Tags')->url('/admin/tags'),
                NavigationItem::make('Document Approval')->icon('heroicon-o-clock')->group('Document Management')->label('Document Approval')->url('/admin/document-approvals'),

                // Forum System
                NavigationItem::make('Forum Topics')->icon('heroicon-o-chat-bubble-left')->group('Forum System')->label('Forum Topics')->url('/admin/forum-topics'),
                NavigationItem::make('Forum Posts')->icon('heroicon-o-chat-bubble-left-ellipsis')->group('Forum System')->label('Forum Posts')->url('/admin/forum-posts'),

                // Content Moderation
                NavigationItem::make('Content Flags')->icon('heroicon-o-exclamation-triangle')->group('Forum System')->label('Content Flags')->url('/admin/content-flags'),

                // Analytics
                NavigationItem::make('User Activities')->icon('heroicon-o-information-circle')->group('Analytics')->label('User Activities')->url('/admin/user-activities'),
                NavigationItem::make('Document Analytics')->icon('heroicon-o-document-chart-bar')->group('Analytics')->label('Document Analytics')->url('/admin/document-analytics'),

                // System
                NavigationItem::make('System Settings')->icon('heroicon-o-cog-6-tooth')->group('System')->label('System Settings')->url('/admin/settings'),
                NavigationItem::make('System Logs')->icon('heroicon-o-document-text')->group('System')->label('System Logs')->url('/admin/logs'),
            ]);
        });

    }
}
