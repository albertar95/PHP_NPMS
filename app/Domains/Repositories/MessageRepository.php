<?php

namespace App\Domains\Repositories;

use App\Domains\Eloquent\BaseRepository;
use App\Domains\Interfaces\IMessageRepository;
use App\DTOs\DataMapper;
use App\Models\Messages;
use App\DTOs\messageDTO;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class MessageRepository extends BaseRepository implements IMessageRepository
{
    private $_mapper;
    public function __construct(Messages $model)
    {
        parent::__construct($model);
    }
    public function SendMessage(Messages $Message):bool
    {
        $Message->CreateDate = Carbon::now();
        $Message->IsRead = false;
        $Message->IsRecieved = false;
        $Message->IsDeleted = false;
        $Message->NidMessage = Str::uuid();
        $Message->save();
        return true;
    }
    public function DeleteMessage(string $NidMessage):bool
    {
        Messages::where('NidMessage',$NidMessage)->update(
            [
                'IsDeleted' => true,
                'DeleteDate' => Carbon::now()
            ]
        );
        // $tmpMessage = $this->model->all()->where('NidMessage','=',$NidMessage)->firstOrFail();
        // $tmpMessage->IsDeleted = true;
        // // $tmpMessage.DeleteDate = DateTime.Now;//check
        // $tmpMessage->save();
        return true;
    }
    public function GetUsersMessages(string $NidUser, bool $ShowAll = false) :Collection
    {
        $result = new Collection();
        if(!$ShowAll)
        {
            $tmpMessage = $this->model->all()->where('RecieverId','=',$NidUser)->where('IsDeleted','=',false)->where('IsRead','=',$ShowAll);
            foreach ($tmpMessage as $msg)
            {
                $result->push(DataMapper::MapToMessageDTO($msg));
            }
        }
        else
        {
            $tmpMessage = $this->model->all()->where('RecieverId','=',$NidUser)->where('IsDeleted','=',false);
            foreach ($tmpMessage as $msg)
            {
                $result->push(DataMapper::MapToMessageDTO($msg));
            }
        }
        return $result;
    }
    public function GetUsersSendMessages(string $NidUser):Collection
    {
        $result = new Collection();
        $tmpMessage = $this->model->all()->where('SenderId','=',$NidUser)->where('IsDeleted','=',false);
        foreach ($tmpMessage as $msg)
        {
            $result->push(DataMapper::MapToMessageDTO($msg));
        }
        return $result;
    }
    public function ReadMessage(string $NidMessage,bool $ReadStatus = true):bool
    {
        Messages::where('NidMessage',$NidMessage)->update(
            [
                'IsRead' => $ReadStatus,
                'ReadDate' => Carbon::now()
            ]
        );
        // $tmpMessage = $this->model->all()->where('NidMessage','=',$NidMessage)->firstOrFail();

        // $tmpMessage->IsRead = $ReadStatus;
        // $tmpMessage->ReadDate = Carbon::now();
        // $tmpMessage->save();
        return true;
    }
    public function RecieveMessage(string $NidMessage, bool $RecieveStatus = true):bool
    {
        Messages::where('NidMessage',$NidMessage)->update(
            [
                'IsRecieved' => $RecieveStatus
            ]
        );
        $tmpMessage = $this->model->all()->where('NidMessage','=',$NidMessage)->firstOrFail();
        $tmpMessage->IsRecieved = $RecieveStatus;
        $tmpMessage->save();
        return true;
    }
    public function RecieveMessageNeeded(string $NidUser) :bool
    {
        return $this->model->all()->where('RecieverId','=',$NidUser)->where('IsRecieved','=',false)->exists();
    }
    public function GetMessageDTOById(string $NidMessage):messageDTO
    {
        return DataMapper::MapToMessageDTO($this->model->all()->where('NidMessage','=',$NidMessage)->firstOrFail());
    }
    public function GetMessageHirarchyById(string $NidMessage)
    {
        $result = new Collection();
        $tmpHirarchy = $this->GetHirarchyById($NidMessage);
        foreach ($tmpHirarchy as $hir)
        {
            if($this->model->all()->where('NidMessage','=',$hir)->count() > 0)
            $result->push(DataMapper::MapToMessageDTO($this->model->all()->where('NidMessage','=',$hir)->firstOrFail()));
        }
        return $result;
        // return $tmpHirarchy;
    }
    private function GetHirarchyById(string $NidMessage)
    {
        $MasterId = $NidMessage;
        $msgs = new Collection();
        $RelateFlag = false;
        // $relateSource = Messages::all()->groupBy(['NidMessage','RelatedId']);
        $relateSource = collect(DB::select('select NidMessage,RelatedId from messages group by NidMessage,RelatedId'));
    FindMasterId:
    if($relateSource->where('NidMessage','=',$MasterId)->count() > 0)
    {
        if($relateSource->where('NidMessage','=',$MasterId)->firstOrFail()->RelatedId == null)
        {
            $RelateFlag = true;
        }
    }
        if (!$RelateFlag)
        {
            if($relateSource->where('NidMessage','=',$MasterId)->count() > 0)
            {
                $MasterId = $relateSource->where('NidMessage','=',$MasterId)->firstOrFail()->RelatedId;
                goto FindMasterId;
            }
        }
        // return $relateSource;
        return $this->ProbeMessageById($MasterId,$relateSource,new Collection());
    }
    private function FindMasterId(Collection $Hirarchy,string $masterid)
    {
        $RelateFlag = false;
        if($Hirarchy->where('NidMessage','=',$masterid)->count() > 0)
        {
            if($Hirarchy->where('NidMessage','=',$masterid)->firstOrFail()->RelatedId == null)
            $RelateFlag = true;
            if(!$RelateFlag)
            {
                $this->FindMasterId($Hirarchy,$Hirarchy->where('NidMessage','=',$masterid)->firstOrFail()->RelatedId ?? "");
            }
            return $this->ProbeMessageById($masterid,$Hirarchy,new Collection());
        }else{
            return new Collection();
        }
    }
    private function ProbeMessageById(string $NidMaster,Collection $RelateSource,Collection $result):Collection
    {
        $result->push($NidMaster);
        $Messages = $RelateSource->where('RelatedId','=',$NidMaster);
        foreach ($Messages as $key => $childs) {
            $this->ProbeMessageById($childs->NidMessage,$Messages,$result);
        }
        return $result;
    }
}

class MessageRepositoryFactory
{
    public static function GetMessageRepositoryObj():IMessageRepository
    {
        return new MessageRepository(new Messages());
    }

}
