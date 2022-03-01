<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Auth;
use App\Models\Logs;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class LogExecptions extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report(){
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception){
        try {
            if (Auth::check())
            {
                $newlog = new Logs();
                $newlog->NidLog = Str::uuid();
                $newlog->UserId = auth()->user()->NidUser;
                $newlog->Username = auth()->user()->UserName;
                $newlog->LogDate = Carbon::now()->toDateString();
                $newlog->IP = $request->ip();
                $newlog->LogTime = Carbon::now()->toTimeString();
                $newlog->ActionId = 100;
                if(strpos($exception->getMessage(),':'))
                {
                    $newlog->Description = substr($exception->getMessage(),0,strpos($exception->getMessage(),':'));
                }else
                {
                    $newlog->Description = substr($exception->getMessage(),0,50);
                }
                $newlog->LogStatus = 1;
                $newlog->ImportanceLevel = 1;
                $newlog->ConfidentialLevel = 1;
                $newlog->save();
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        return view('errors.500');
    }
}
