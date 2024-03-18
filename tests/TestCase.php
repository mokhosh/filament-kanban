<?php

namespace Mokhosh\FilamentKanban\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Livewire\LivewireServiceProvider;
use Mokhosh\FilamentKanban\FilamentKanbanServiceProvider;
use Mokhosh\FilamentKanban\Tests\Models\User;
use Mokhosh\FilamentKanban\Tests\Providers\TestPanelProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Mokhosh\\FilamentKanban\\Tests\\Factories\\' . class_basename($modelName) . 'Factory'
        );

        $this->setUpDatabase($this->app);
    }

    protected function getPackageProviders($app)
    {
        return [
            ActionsServiceProvider::class,
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            InfolistsServiceProvider::class,
            LivewireServiceProvider::class,
            NotificationsServiceProvider::class,
            SupportServiceProvider::class,
            TablesServiceProvider::class,
            WidgetsServiceProvider::class,
            FilamentKanbanServiceProvider::class,
            TestPanelProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('view.paths', [__DIR__ . '/Views']);
    }

    protected function setUpDatabase($app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('status');
            $table->integer('order_column');
            $table->timestamps();
        });

        $app['db']->connection()->getSchemaBuilder()->create('ulid_tasks', function (Blueprint $table) {
            $table->ulid();
            $table->string('title');
            $table->string('status');
            $table->integer('order_column');
            $table->timestamps();
        });

        $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('password');
            $table->string('name');
        });

        $app['db']->connection()->getSchemaBuilder()->create('task_user', function (Blueprint $table) {
            $table->foreignId('task_id');
            $table->foreignId('user_id');
        });

        $this->admin = User::create(['email' => 'admin@domain.com', 'password' => 'password', 'name' => 'Admin']);
    }
}
