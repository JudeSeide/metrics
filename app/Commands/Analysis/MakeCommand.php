<?php declare(strict_types=1);

namespace App\Commands\Analysis;

use App\Commands\Traits\HasProgressBar;
use Illuminate\Support\Collection;
use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class MakeCommand extends Command
{
    use HasProgressBar;

    /** @var string - The signature of the command. */
    protected $signature = 'analysis:make';

    /** @var string - The description of the command. */
    protected $description = 'Analyse the php libraries downloaded from github.';

    public function handle(Finder $finder): void
    {
        $libraries = $this->getDownloadedLibraries($finder);
        $this->line("\n<info>Analysing {$libraries->count()} php libraries.</info>\n");

        $this->process($libraries, function (SplFileInfo $library) {
            exec($this->buildCommand($library));
        });

        $this->line("\n<info>Done</info>\n");
    }

    protected function getDownloadedLibraries(Finder $finder): Collection
    {
        $libraries = collect();
        $directories = $finder->directories()->depth('< 1')->in(config('filesystems.resources.directory'));

        foreach ($directories as $library) {
            $libraries->push($library);
        }

        return $libraries;
    }

    protected function buildCommand(SplFileInfo $library): string
    {
        return './vendor/bin/phpmetrics --report-json='.config('filesystems.resources.artefacts').DIRECTORY_SEPARATOR.$library->getFilename().'.json '.$library->getRealPath().' >> /dev/null 2>&1 ';
    }
}
