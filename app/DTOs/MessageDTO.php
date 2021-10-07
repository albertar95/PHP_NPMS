<?php

namespace App\DTOs;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\Nullable;

class messageDTO extends Model
{
    public string $NidMessage;
    public string $SenderId;
    public string $RecieverId;
    public string $RelateId;
    public string $Title;
    public string $MessageContent;
    public Boolean $IsRead;
    public Boolean $IsRecieved;
    public Boolean $IsDeleted;
    public string $SenderUsername;
    public string $SenderName;
    public string $RecieverUsername;
    public string $RecieverName;
    public DateTime $CreateDate;
    public DateTime $ReadDate;
    public DateTime $DeleteDate;
}
