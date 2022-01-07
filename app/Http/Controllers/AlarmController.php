<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\NPMSController;
use Illuminate\Http\Request;

class AlarmController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function GetAlarms()
    {
        $api = new NPMSController();
        $result = new JsonResults();
        $alarms = $api->GetFirstPageAlarms();
        $result->Html = view('Alarm._AlarmSection',compact('alarms'))->render();
        $result->HasValue = true;
        $result->Message = $alarms->count();
        return response()->json($result);
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     HttpResponseMessage response = client.GetAsync($"Alarm/GetFirstPageAlarms").Result;
        //     if (response.IsSuccessStatusCode)
        //     {
        //         List<Alarm> res = response.Content.ReadAsAsync<List<Alarm>>().Result;
        //         return Json(new JsonResults() { HasValue = true, Html = JsonResults.RenderViewToString(this.ControllerContext, "_AlarmSection", res), Message = res.Count.ToString() });
        //     }
        //     else
        //     {
        //         return Json(new JsonResults() { HasValue = false, Html = "", Message = "0" });
        //     }
        // }
    }
    public function Alarms(int $type = 0)
    {
        $api = new NPMSController();
        $Alarms = $api->GetAllAlarms();
        $Typo = $type;
        return view('Alarm.Alarms',compact('Alarms','Typo'));
        // AlarmsViewModel avm = new AlarmsViewModel();
        // List<Alarm> res = new List<Alarm>();
        // using (var client = new HttpClient())
        // {
        //     client.BaseAddress = new Uri(ApiBaseAddress);
        //     client.DefaultRequestHeaders.Accept.Add(new System.Net.Http.Headers.MediaTypeWithQualityHeaderValue("application/json"));
        //     HttpResponseMessage response = client.GetAsync($"Alarm/GetAllAlarms").Result;
        //     if (response.IsSuccessStatusCode)
        //         res = response.Content.ReadAsAsync<List<Alarm>>().Result;
        // }
        // avm.Alarms = res;
        // avm.Typo = type;
        // return View(avm);
    }
}
