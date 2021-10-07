<?php

namespace resources\ViewModels;

use Illuminate\Support\Collection;

class ManageBaseInfoViewModel
{
    public Collection $Grades;
    public Collection $MillitaryStatuses;
    public Collection $CollaborationTypes;
    public Collection $Colleges;
    public Collection $Units;
    public Collection $UnitGroups;
    public Collection $Majors;
    public Collection $Oreintations;
    public int $TblId;
}
