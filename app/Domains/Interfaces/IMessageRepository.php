<?php
namespace App\Domains\Interfaces;

use App\DTOs\messageDTO;
use App\Models\Messages;
use Illuminate\Support\Collection;

interface IMessageRepository
{
    public function SendMessage(Messages $Message):bool;
    public function DeleteMessage(string $NidMessage):bool;
    public function GetUsersMessages(string $NidUser, bool $ShowAll = false) :Collection;
    public function GetUsersSendMessages(string $NidUser):Collection;
    public function ReadMessage(string $NidMessage,bool $ReadStatus = true):bool;
    public function RecieveMessage(string $NidMessage, bool $RecieveStatus = true):bool;
    public function RecieveMessageNeeded(string $NidUser) :bool;
    public function GetMessageDTOById(string $NidMessage):messageDTO;
    public function GetMessageHirarchyById(string $NidMessage):Collection;
}
