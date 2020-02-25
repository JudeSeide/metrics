<?php declare(strict_types=1);

namespace App\Services\Contracts;

use Illuminate\Support\Collection;

interface PackagistClient
{
    public function fetchLibraryList(): Collection;
}
