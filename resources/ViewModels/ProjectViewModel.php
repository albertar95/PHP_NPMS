<?php

namespace resources\ViewModels;

use App\DTOs\projectDetailDTO;
use App\DTOs\scholarDetailDTO;
use Illuminate\Support\Collection;

class ProjectViewModel
{
    public Collection $Units;
    public Collection $UnitGroups;
    public Collection $Scholars;
    public projectDetailDTO $Project;
    public scholarDetailDTO $Scholar;
}
