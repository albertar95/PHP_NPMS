<?php

namespace Resources\ViewModels;

use App\DTOs\scholarDTO;
use Illuminate\Support\Collection;

class ScholarViewModel
{
    public Collection $Grades;
    public Collection $MillitaryStatuses;
    public Collection $CollaborationTypes;
    public Collection $Colleges;
    public Collection $Majors;
    public Collection $Oreintations;
    public scholarDTO $Scholar;
}
