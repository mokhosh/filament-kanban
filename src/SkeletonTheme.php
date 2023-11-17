<?php

namespace VendorName\Skeleton;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Assets\Theme;
use Filament\Support\Color;
use Filament\Support\Facades\FilamentAsset;

class Skeleton implements Plugin
{
    public function getId(): string
    {
        return 'skeleton';
    }

    public function register(Panel $panel): void
    {
        FilamentAsset::register([
            Theme::make('skeleton', __DIR__ . '/../resources/dist/skeleton.css'),
        ]);

        $panel
            ->font('DM Sans')
            ->primaryColor(Color::Amber)
            ->secondaryColor(Color::Gray)
            ->warningColor(Color::Amber)
            ->dangerColor(Color::Rose)
            ->successColor(Color::Green)
            ->grayColor(Color::Gray)
            ->theme('skeleton');
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
