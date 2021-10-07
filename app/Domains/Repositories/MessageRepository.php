<?php

namespace App\Domains\Repositories;

use App\Domains\Eloquent\BaseRepository;
use App\Domains\Interfaces\IMessageRepository;
use App\DTOs\DataMapper;
use App\Models\Messages;
use App\DTOs\messageDTO;
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
        // $Message->CreateDate = DateTime.Now;//check
        $Message->IsRead = false;
        $Message->IsRecieved = false;
        $Message->IsDeleted = false;
        $Message->NidMessage = Str::uuid();
        $Message->save();
        return true;
    }
    public function DeleteMessage(string $NidMessage):bool
    {
        $tmpMessage = $this->model->all()->where('NidMessage','=',$NidMessage)->firstOrFail();
        $tmpMessage->IsDeleted = true;
        // $tmpMessage.DeleteDate = DateTime.Now;//check
        $tmpMessage->save();
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
        $tmpMessage = $this->model->all()->where('NidMessage','=',$NidMessage)->firstOrFail();
        $tmpMessage->IsRead = $ReadStatus;
        // tmpMessage.ReadDate = DateTime.Now;
        $tmpMessage->save();
        return true;
    }
    public function RecieveMessage(string $NidMessage, bool $RecieveStatus = true):bool
    {
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
    public function GetMessageHirarchyById(string $NidMessage):Collection
    {
        $result = new Collection();
        $tmpHirarchy = $this->GetHirarchyById($NidMessage);
        foreach ($tmpHirarchy as $hir)
        {
            $result->push(DataMapper::MapToMessageDTO($this->model->all()->where('NidMessage','=',$hir)->firstOrFail()));
        }
        return $result;
    }
    private function GetHirarchyById(string $NidMessage):Collection
    {
        $MasterId = $NidMessage;
        $msgs = new Collection();
        $RelateFlag = false;
        $relateSource = new Collection();
        $tmpMessage = DB::select('select NidMessage,RelateId from messages group by NidMessage,RelateId');
        foreach ($tmpMessage as $tup)
        {
            $relateSource->push([$tup->NidMessage,$tup->RelateId]);
        }
    FindMasterId:
        // if (relateSource.Where(p => p.Item1 == MasterId).FirstOrDefault().Item2 == null)
        //     RelateFlag = true;
        // if (!RelateFlag)
        // {
        //     MasterId = relateSource.Where(p => p.Item1 == MasterId).FirstOrDefault().Item2 ?? string.Empty;
        //     goto FindMasterId;
        // }
        // RelateSource = relateSource;
        // return ProbeMessageById(MasterId);
        return collect([]);
    }
    private function ProbeMessageById(string $NidMaster,Collection $RelateSource):Collection
    {
        // $result = new Collection();
        // $result->push($NidMaster);
        // $relate = $relateSource->
        // foreach (var childs in RelateSource.Where(p => p.Item2 == NidMaster).ToList())
        // {
        //     ProbeMessageById(childs.Item1).ForEach(f => { result.Add(f); });
        // }
        // return result;
        return collect([]);
    }
}

class MessageRepositoryFactory
{
    public static function GetMessageRepositoryObj():IMessageRepository
    {
        return new MessageRepository(new Messages());
    }

}
