<?php declare(strict_types=1);

namespace App\Commands\Analysis;

use Illuminate\Contracts\Filesystem\Filesystem;
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

    public function handle(Finder $finder, Filesystem $filesystem): void
    {
        $this->getGitHubMetadata();
        $this->getReportedMetrics($finder);

        $this->consolidate();
        $this->saveAnalysisResults($filesystem);
    }

    protected function getGitHubMetadata(): void
    {
        $this->task('get github metadata', function () {
            $this->metadata = collect();
            $repositories = json_decode((string) file_get_contents(config('filesystems.resources.metadata')), true);

            foreach ($repositories as $metadata) {
                $this->metadata->push($this->parseRepository($metadata));
            }

            $this->metadata = $this->metadata->groupBy('name');
            return $this->metadata->isNotEmpty();
        });
    }

    protected function getReportedMetrics(Finder $finder): void
    {
        $this->task('get reported metrics for each library', function () use ($finder) {
            $this->metrics = collect();
            $artefacts = $finder->files()->name('*.json')->in(config('filesystems.resources.artefacts'));

            foreach ($artefacts as $file) {
                if (!empty($parsed = $this->parseAnalysis($file))) {
                    $this->metrics->push($parsed);
                }
            }

            return $this->metrics->isNotEmpty();
        });
    }

    protected function consolidate(): void
    {
        $this->task('consolidate analysis results', function () {
            $analysis = collect();
            $regression = [
                'rsysc' => [],
                'mi' => [],
            ];

            foreach ($this->metrics as $metric) {
                $metadata = $this->metadata->get($metric['name'])->first();
                $analysis->push(array_merge($metadata, $metric));
                $regression['rsysc'][] = [$metadata['stargazers_count'], $metric['relative_system_complexity']];
                $regression['mi'][] = [$metadata['stargazers_count'], $metric['maintainability_index']];
            }

            $this->consolidated = collect([
                'analysis' => array_values($analysis->sortByDesc('stargazers_count')->all()),
                'regression' => $regression
            ]);

            return $this->consolidated->isNotEmpty();
        });
    }

    public function saveAnalysisResults(Filesystem $filesystem): void
    {
        $this->task('save analysis results', function () use ($filesystem) {
            $filesystem->put(config('filesystems.resources.results'), json_encode($this->consolidated->all()));
            return true;
        });
    }

    protected function parseAnalysis(SplFileInfo $file): array
    {
        $metrics = json_decode($file->getContents(), true);
        $data = [
            'name' => str_replace('.json', '', $file->getFilename()),
            'relative_system_complexity' => 0,
            'maintainability_index' => 0,
            'afferent_coupling' => 0,
            'efferent_coupling' => 0,
            'bugs' => 0,
            'wmc' => 0
        ];

        $counter = 0;
        foreach ($metrics as $metric) {
            if (array_has($metric, 'relativeSystemComplexity')) {
                $data['relative_system_complexity'] += (float) array_get($metric, 'relativeSystemComplexity');
                $data['maintainability_index'] += (float) array_get($metric, 'mi');
                $data['afferent_coupling'] += (float) array_get($metric, 'afferentCoupling');
                $data['efferent_coupling'] += (float) array_get($metric, 'efferentCoupling');
                $data['bugs'] += (float) array_get($metric, 'bugs');
                $data['wmc'] += (float) array_get($metric, 'wmc');
                $counter++;
            }
        }

        return $counter === 0 ? [] : array_map(static function ($value) use ($counter) {
            return is_string($value) ? $value : $value / $counter;
        }, $data);
    }

    protected function parseRepository(array $metadata): array
    {
        return [
            'id' => (int) array_get($metadata, 'id'),
            'name' => (string) array_get($metadata, 'name'),
            'full_name' => (string) array_get($metadata, 'full_name'),
            'description' => (string) array_get($metadata, 'description'),
            'stargazers_count' => (int) array_get($metadata, 'stargazers_count')
        ];
    }
}
