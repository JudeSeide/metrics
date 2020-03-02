<?php declare(strict_types=1);

namespace App\Commands\Library;

use Exception;
use Illuminate\Support\Collection;
use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Console\Helper\ProgressBar;

class DownloadCommand extends Command
{
    /** @var string - The signature of the command. */
    protected $signature = 'library:download';

    /** @var string - The description of the command. */
    protected $description = 'Download the repositories of the selected php libraries to analyse.';

    public function handle(): void
    {
        $libraries = $this->getSelectedLibraries();
        $this->line("\n<info>Downloading {$libraries->count()} php libraries.</info>\n");

        $this->process($libraries, static function (array $library) {
            exec('cd '.config('filesystems.resources.directory').' && git clone -q '.$library['clone_url'].' >> /dev/null 2>&1 ');
        });

        $this->line("\n<info>Done</info>\n");
    }

    protected function getSelectedLibraries(): Collection
    {
        $content = (string) file_get_contents(config('filesystems.resources.metadata'));
        return collect(json_decode($content, true));
    }

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
                $bar->advance(); // ignore failure to clone libraries already downloaded
            }
        }

        $bar->finish();
        $this->line('');
    }
}
