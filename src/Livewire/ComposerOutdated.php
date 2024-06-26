<?php
/**
 * @author Aaron Francis <aarondfrancis@gmail.com|https://twitter.com/aarondfrancis>
 */

namespace AaronFrancis\Pulse\Outdated\Livewire;

use Illuminate\Support\Facades\View;
use Laravel\Pulse\Facades\Pulse;
use Livewire\Attributes\Lazy;

class ComposerOutdated extends OutdatedCard
{
    public bool $showAge = false;

    #[Lazy]
    public function render()
    {
        // Get the data out of the Pulse data store.
        $outdated = Pulse::values('composer_outdated', ['time', 'result']);

        $packages = isset($outdated['result'])
            ? json_decode($outdated['result']->value, associative: true, flags: JSON_THROW_ON_ERROR)['installed']
            : [];

        $packages = $this->parsePackages($packages);

        return View::make('outdated::livewire.composer_outdated', [
            'packages' => $packages,
            'time' => $outdated?->get('time')?->value ?? null,
        ]);
    }
}
