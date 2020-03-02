<?php declare(strict_types=1);

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class MainCommand extends Command
{
    /** @var string - The signature of the command. */
    protected $signature = 'metrics:execute';

    /** @var string - The description of the command. */
    protected $description = 'Analyse the design quality and the popularity of web libraries in php.';

    public function handle(): void
    {
        // todo - menu
        // todo - command coordination
        // todo - generate visualization
    }

    protected function visualize(): void
    {
        //        exec('xdg-open /home/jude/cdev/reports/index.html');
    }
}
