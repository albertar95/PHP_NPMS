<?php

namespace resources\ViewModels;

use App\DTOs\reportDTO;
use Illuminate\Support\Collection;

class ReportViewModel
{
    public reportDTO $report;
    public Collection $inputs;
    public Collection $outputs;
}
