<?php declare(strict_types=1);

namespace App\Commands\Analysis;

use Illuminate\Support\Collection;
use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class ConsolidateCommand extends Command
{
    /** @var string - The signature of the command. */
    protected $signature = 'analysis:consolidate';

    /** @var string - The description of the command. */
    protected $description = 'Consolidate the analysis artefacts and github metadata.';

    /** @var Collection */
    protected $metrics;

    /** @var Collection */
    protected $metadata;

    /** @var Collection */
    protected $consolidated;

    public function handle(Finder $finder): void
    {
        $this->getGitHubMetadata();
        $this->getReportedMetrics($finder);
        // consolidate data
        // calculate linear regression ?
    }

    protected function getGitHubMetadata(): void
    {
        $this->task('get github metadata', function () {
            $this->metadata = collect();
            $repositories = json_decode((string) file_get_contents(config('filesystems.resources.metadata')), true);

            foreach ($repositories as $metadata) {
                $this->metadata->push($this->parseRepository($metadata));
            }

            return $this->metadata->isNotEmpty();
        });
    }

    protected function getReportedMetrics(Finder $finder): void
    {
        $this->task('get reported metrics for each library', function () use ($finder) {
            $this->metrics = collect();
            $artefacts = $finder->files()->name('*.json')->in(config('filesystems.resources.artefacts'));

            foreach ($artefacts as $metrics) {
                $this->metrics->push($this->parseArtefact($metrics));
            }

            return $this->metrics->isNotEmpty();
        });
    }

//    protected function consolidate(): void

    protected function parseArtefact(SplFileInfo $metrics): array
    {
        // todo - cleanup - average - only return metrics we need here
        // $name = str_replace('.json', '', $metrics->getFilename());
        // return [$name => json_decode($metrics->getContents(), true)];

        return [];
    }

    protected function parseRepository(array $metadata): array
    {
        // todo - parse github metadata - only return what is necessary for visualization
        return [];
    }
}
