<?php
namespace App\Domains\Interfaces;

use App\Domains\Repositories\SearchRepository;

interface ISearchRepository
{
    public function AdvancedSearchProcess(string $searchText,int $SectionId,int $Similar,int $ById);
    public function ComplexSearch(string $searchText,bool $Similar,int $ById);
}
