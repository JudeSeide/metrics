<?php declare(strict_types=1);

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class MainCommand extends Command
{
    /** @var string - The signature of the command. */
    protected $signature = 'main:execute';

    /** @var string - The description of the command. */
    protected $description = 'Analyse the design quality and the popularity of web libraries in php.';

    public function handle(): void
    {
        $options = ['automate', 'search', 'download', 'analyse', 'visualize'];

        $selected = $this->menu('Metrics - '.$this->description, [
            'Run automatically',
            'Search php libraries',
            'Download selected php libraries',
            'Analyse downloaded php libraries',
            'Visualize results',
        ])->open();

        if ($selected !== null) {
            $this->{$options[$selected]}();
        }
    }

    protected function automate(): void
    {
        $this->search();
        $this->download();
        $this->analyse();
        $this->visualize();
    }

    protected function search(): void
    {
        $this->call('library:search');
    }

    protected function download(): void
    {
        $this->call('library:download');
    }

    protected function analyse(): void
    {
        $this->call('analysis:make');
        $this->call('analysis:consolidate');
    }

    protected function visualize(): void
    {
        exec('xdg-open '.config('filesystems.resources.view'));
    }
}
