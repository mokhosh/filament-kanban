<?php

namespace Mokhosh\FilamentKanban;

use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Mokhosh\FilamentKanban\Commands\MakeKanbanBoardCommand;
use Mokhosh\FilamentKanban\Testing\TestsFilamentKanban;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentKanbanServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-kanban';

    public static string $viewNamespace = 'filament-kanban';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasAssets()
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishAssets()
                    ->askToStarRepoOnGitHub('mokhosh/filament-kanban');
            });

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/filament-kanban/{$file->getFilename()}"),
                ], 'filament-kanban-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsFilamentKanban);
    }

    protected function getAssetPackageName(): ?string
    {
        return 'mokhosh/filament-kanban';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('filament-kanban', __DIR__ . '/../resources/dist/components/filament-kanban.js'),
            // Js::make('filament-kanban-scripts', __DIR__ . '/../resources/dist/filament-kanban.js'),
            Css::make('filament-kanban-styles', __DIR__ . '/../resources/dist/filament-kanban.css'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            MakeKanbanBoardCommand::class,
        ];
    }
}
