<?php

namespace resources\ViewModels;

use App\DTOs\messageDTO;
use Illuminate\Support\Collection;

class MessageViewModel
{
    public Collection $Inbox;
    public Collection $SendMessage;
    public Collection $Recievers;
    public messageDTO $SingleMessage;
    public int $ReadBy;
}
