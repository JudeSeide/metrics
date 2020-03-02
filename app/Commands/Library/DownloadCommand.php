<?php declare(strict_types=1);

namespace App\Commands\Library;

use App\Commands\Traits\HasProgressBar;
use Illuminate\Support\Collection;
use LaravelZero\Framework\Commands\Command;

class DownloadCommand extends Command
{
    use HasProgressBar;

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
        $this->notify('Metrics', $libraries->count().' php libraries downloaded.', 'icon.png');
    }

    protected function getSelectedLibraries(): Collection
    {
        $content = (string) file_get_contents(config('filesystems.resources.metadata'));
        return collect(json_decode($content, true));
    }
}
