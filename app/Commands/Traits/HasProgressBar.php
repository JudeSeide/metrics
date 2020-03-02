<?php declare(strict_types=1);

namespace App\Commands\Traits;

use Exception;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Helper\ProgressBar;

trait HasProgressBar
{
    protected function process(Collection $collection, callable $callback): void
    {
        /** @var ProgressBar $bar */
        $bar = $this->output->createProgressBar($collection->count());
        $bar->start();

        foreach ($collection as $item) {
            try {
                $callback($item);
                $bar->advance();
            } catch (Exception $exception) {
                $bar->advance(); // ignore failure
            }
        }

        $bar->finish();
        $this->line('');
    }
}
