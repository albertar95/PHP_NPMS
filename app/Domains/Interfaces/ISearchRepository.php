<?php
namespace App\Domains\Interfaces;

use App\Domains\Repositories\SearchRepository;

interface ISearchRepository
{
    public function AdvancedSearch(string $searchText,int $SectionId,bool $Similar,int $ById);
    public function ComplexSearch(string $searchText,bool $Similar,int $ById):SearchRepository;
}
