<?php
/**
 * @author Aaron Francis <aarondfrancis@gmail.com|https://twitter.com/aarondfrancis>
 */

namespace AaronFrancis\Pulse\Outdated;

use AaronFrancis\Pulse\Outdated\Commands\OutdatedClearCommand;
use AaronFrancis\Pulse\Outdated\Livewire\NpmOutdated;
use AaronFrancis\Pulse\Outdated\Livewire\ComposerOutdated;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Livewire\LivewireManager;

class OutdatedServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'outdated');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'npm_outdated');

        $this->callAfterResolving('livewire', function (LivewireManager $livewire, Application $app) {
            $livewire->component('composer_outdated', ComposerOutdated::class);
            $livewire->component('npm_outdated', NpmOutdated::class);
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                OutdatedClearCommand::class,
            ]);
        }
    }
}
