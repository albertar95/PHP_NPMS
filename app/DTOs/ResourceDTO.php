<?php

namespace App\DTOs;

use Illuminate\Database\Eloquent\Model;

class resourceDTO extends Model
{
    public string $NidResource;
    public string $ResourceName;
    public string $ParentId;
    public int $ClassLevel;
    public int $SortNumber;
}
