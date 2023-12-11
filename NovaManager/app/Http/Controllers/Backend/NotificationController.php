<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Account_Notifi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifi($id = null)
    {
        if(empty($id)) {
            $data = Notification::all();
        } else {
            $data = Notification::where('notifi_id', $id);
        }
        return $data;
    }

    public function getNotifiByUser($account_id){
        $notifiIds = Account_Notifi::where('account_id', $account_id)->pluck('notifi_id');

        $data = Notification::whereIn('notifi_id',$notifiIds)->get();
        return $data;
    }

    function compareTime($time1, $time2) {
        $carbonTime1 = Carbon::parse($time1);
        $carbonTime2 = Carbon::parse($time2);
    
        $differenceInSeconds = $carbonTime1->diffInSeconds($carbonTime2);
    
        if ($differenceInSeconds < 60) {
            return $differenceInSeconds . ' giây trước';
        } elseif ($differenceInSeconds < 3600) {
            $differenceInMinutes = floor($differenceInSeconds / 60);
            return $differenceInMinutes . ' phút trước';
        } elseif ($differenceInSeconds < 86400) {
            $differenceInHours = floor($differenceInSeconds / 3600);
            return $differenceInHours . ' giờ trước';
        } else {
            $differenceInDays = $carbonTime1->diffInDays($carbonTime2);
            return $differenceInDays . ' ngày trước';
        }
    }
    public function getSumNoti($account_id){
        $notifiIds = Account_Notifi::where('account_id', $account_id)->pluck('notifi_id');

        $data = Notification::whereIn('notifi_id',$notifiIds)->count();
        return $data;
    }

    public function delete($notifiId,$link){
        // $accNotifi = Account_Notifi::where('notifiId', $notifiId);
        // dd($accNotifi);
        // $notifi = Notification::where('notifi_id',$notifiId);
        // dd($notifi);
        // if($accNotifi && $notifi) {
        //     $accNotifi->delete();
        //     $notifi->delete();
        //     return redirect()->away($link);
        // }

        return url($link);
        
    }
    
}
