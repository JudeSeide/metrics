<?php declare(strict_types=1);

namespace App\Commands\Library;

use App\Services\Contracts\GitHubClient;
use App\Services\Contracts\PackagistClient;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use LaravelZero\Framework\Commands\Command;

class SearchCommand extends Command
{
    /** @var string - The signature of the command. */
    protected $signature = 'library:search';

    /** @var string - The description of the command. */
    protected $description = 'Search the repositories of php libraries to analyse.';

    /** @var Collection - The php libraries container. */
    protected $libraries;

    /** @var Collection - The associated repositories of the php libraries. */
    protected $repositories;

    /** @var Collection - The the php libraries selected for the analysis. */
    protected $selected;

    public function handle(PackagistClient $packagist, GitHubClient $github, Filesystem $filesystem): void
    {
        $this->fetchLibrariesFrom($packagist);
        $this->fetchRepositoriesFrom($github);

        $this->selectLibraries();
        $this->saveSelectedLibraries($filesystem);
    }

    protected function fetchLibrariesFrom(PackagistClient $client): void
    {
        $this->task('get available php libraries from packagist', function () use ($client) {
            $this->libraries = $client->fetchLibraryList();
            $this->line("\n<info>Found {$this->libraries->count()} php libraries</info>\n");

            return $this->libraries->isNotEmpty();
        });
    }

    protected function fetchRepositoriesFrom(GitHubClient $client): void
    {
        $this->task('get associated repositories on github', function () use ($client) {
            $this->repositories = $client->fetchRepositories();
            $this->line("\n<info>Found {$this->repositories->count()} repositories</info>\n");

            return $this->repositories->isNotEmpty();
        });
    }

    protected function selectLibraries(): void
    {
        $this->task('select libraries for the analysis', function () {
            $this->selected = $this->repositories->filter(function (array $repository) {
                return in_array(strtolower($repository['full_name']), $this->libraries->all(), true);
            });

            $this->line("\n<info>Selected {$this->selected->count()} repositories</info>\n");

            return $this->selected->isNotEmpty();
        });
    }

    public function saveSelectedLibraries(Filesystem $filesystem): void
    {
        $this->task('save selected libraries github metadata', function () use ($filesystem) {
            $filesystem->put(config('filesystems.resources.metadata'), json_encode($this->selected->all()));
            return true;
        });
    }
}
