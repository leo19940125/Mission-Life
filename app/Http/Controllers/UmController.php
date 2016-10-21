<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Um;
use App\Http\Requests;
use Auth;
use DB;
use Carbon\Carbon;

class UmController extends Controller
{
    //確認否登入狀態
	public function __construct()
	{
    	$this->middleware('auth');
	}

    public function getwork($id)
    {        
        $pieces = explode("-",DB::table('quests')->where('id',$id)->value('apply_start_at'));
        $diff = Carbon::today()->diffInDays(Carbon::create($pieces[0],$pieces[1],$pieces[2],0),false);

        $end = explode("-",DB::table('quests')->where('id',$id)->value('apply_end_at'));
        $diff_end = Carbon::today()->diffInDays(Carbon::create($end[0],$end[1],$end[2],0),false);

        if( $diff > 0 )
        {
            echo "<script>alert('目前還不能承接這個任務唷！距離報名日期還有".$diff."天呢！');location.href = '/work';</script>";
        }
        else if ( $diff_end < 0 )
        {
            echo "<script>alert('這個任務已經不能承接囉！在".abs($diff_end)."天之前就已經截止申請了呢！');location.href = '/work';</script>";
        }
        else
        {
            $apply_people = DB::table('quests')->where('id',$id)->value('now_apply_people');
            if($apply_people >= DB::table('quests')->where('id',$id)->value('max_apply_people'))
                echo "<script>alert('申請人數額滿了！下次要早點申請喔！');location.href = '/work';</script>";
            else{
                DB::table('quests')->where('id',$id)->update(['now_apply_people'=>$apply_people+1]);
        	    $um = new Um;
        	    $um->user_id = Auth::user()->id;
    	        $um->quest_id = $id;
                if(DB::table('quests')->where('id',$id)->value('verification')==0){
                    $content = "「".DB::table('quests')->where('id',$id)->value('name')."」任務接洽成功囉！";
                    $um->status = 2;
                }
                else{
                    $content = "「".DB::table('quests')->where('id',$id)->value('name')."」任務接洽成功囉！請稍待NPC審核！";
                    $um->status = 0;
                }
                $um->type = 0;
        	    $um->save();

                DB::table('message')->insert(['user_id'=>Auth::user()->id,'content'=>$content,'read'=>0,'address'=>'account']);

        	    return redirect()->route('work')->with('action','success');
            }
        }
    }
    public function cancelwork($id)
    {
        $status = DB::table('um')->where('type',0)->where('user_id', Auth::user()->id)->where('quest_id', $id)->value('status');
        if($status == 0){
            $apply_people = DB::table('quests')->where('id',$id)->value('now_apply_people');
            DB::table('quests')->where('id',$id)->update(['now_apply_people'=>$apply_people-1]);
            DB::table('um')->where('type',0)->where('user_id', Auth::user()->id)->where('quest_id', $id)->delete();
            return redirect()->route('work')->with('action','failed');
        }
        else if($status == 0)
            echo "<script>alert('你已經完成這個任務了唷！');location.href = '/work';</script>";
        else{
            $creator = DB::table('quests')->where('id',$id)->value('creator');
            echo "<script>alert('工讀任務不可以隨意放棄喔，如果真的沒辦法參與任務，必須找".$creator."取消任務喔！');location.href = '/work';</script>";
        }
    }

    public function getactivity($id)
    {
        $pieces = explode("-",DB::table('activities')->where('id',$id)->value('apply_start_at'));
        $diff = Carbon::today()->diffInDays(Carbon::create($pieces[0],$pieces[1],$pieces[2],0),false);

        $end = explode("-",DB::table('activities')->where('id',$id)->value('apply_end_at'));
        $diff_end = Carbon::today()->diffInDays(Carbon::create($end[0],$end[1],$end[2],0),false);

        if( $diff > 0 )
        {
            echo "<script>alert('目前還不能承接這個任務唷！距離報名日期還有".$diff."天呢！');location.href = '/activity';</script>";
        }
        else if ( $diff_end < 0 )
        {
            echo "<script>alert('這個任務已經不能承接囉！在".abs($diff_end)."天之前就已經過期了呢！');location.href = '/activity';</script>";
        }
        else
        {
        	$um = new Um;
        	$um->user_id = Auth::user()->id;
        	$um->quest_id = $id;
        	$um->status = 0;
            $um->type = 1;
        	$um->save();

            $apply_people = DB::table('activities')->where('id',$id)->value('now_apply_people');
            DB::table('activities')->where('id',$id)->update(['now_apply_people'=>$apply_people+1]);
            $content = "「".DB::table('activities')->where('id',$id)->value('name')."」任務接洽成功囉！";
            DB::table('message')->insert(['user_id'=>Auth::user()->id,'content'=>$content,'read'=>0,'address'=>'account']);

            return redirect()->route('activity')->with('action','success');
        }
    }
    public function cancelactivity($id)
    {
        $status = DB::table('um')->where('type',1)->where('user_id', Auth::user()->id)->where('quest_id', $id)->value('status');
        if($status == 0){
            $apply_people = DB::table('activities')->where('id',$id)->value('now_apply_people');
            DB::table('activities')->where('id',$id)->update(['now_apply_people'=>$apply_people-1]);
    	    DB::table('um')->where('type',1)->where('user_id', Auth::user()->id)->where('quest_id', $id)->delete();
    	    return redirect('/activity');
        }
        else
            echo "<script>alert('你已經完成這個任務了唷！');location.href = '/activity';</script>";
    }

    public function getconf($id)
    {        
        $pieces = explode("-",DB::table('lestures')->where('id',$id)->value('apply_start_at'));
        $diff = Carbon::today()->diffInDays(Carbon::create($pieces[0],$pieces[1],$pieces[2],0),false);

        $end = explode("-",DB::table('lestures')->where('id',$id)->value('apply_end_at'));
        $diff_end = Carbon::today()->diffInDays(Carbon::create($end[0],$end[1],$end[2],0),false);

        if( $diff > 0 )
        {
            echo "<script>alert('目前還不能承接這個任務唷！距離報名日期還有".$diff."天呢！');location.href = '/conf';</script>";
        }
        else if ( $diff_end < 0 )
        {
            echo "<script>alert('這個任務已經不能承接囉！在".abs($diff_end)."天之前就已經截止申請了呢！');location.href = '/conf';</script>";
        }
        else
        {
            $apply_people = DB::table('lestures')->where('id',$id)->value('now_apply_people');
            if($apply_people >= DB::table('lestures')->where('id',$id)->value('max_people'))
                echo "<script>alert('申請人數額滿了！下次要早點申請喔！');location.href = '/conf';</script>";
            else{
                DB::table('lestures')->where('id',$id)->update(['now_apply_people'=>$apply_people+1]);
    	        $um = new Um;
            	$um->user_id = Auth::user()->id;
    	        $um->quest_id = $id;
            	$um->status = 0;
                $um->type = 2;
    	        $um->save();

                $content = "「".DB::table('lestures')->where('id',$id)->value('name')."」任務接洽成功囉！";
                DB::table('message')->insert(['user_id'=>Auth::user()->id,'content'=>$content,'read'=>0,'address'=>'account']);

            	return redirect('/conf');
            }
        }
    }
    public function cancelconf($id)
    {
        $status = DB::table('um')->where('type',2)->where('user_id', Auth::user()->id)->where('quest_id', $id)->value('status');
        if($status == 0){
            $apply_people = DB::table('lestures')->where('id',$id)->value('now_apply_people');
            DB::table('lestures')->where('id',$id)->update(['now_apply_people'=>$apply_people-1]);
    	    DB::table('um')->where('user_id', Auth::user()->id)->where('quest_id', $id)->delete();
    	    return redirect('/conf');
        }
        else
            echo "<script>alert('你已經完成這個任務了唷！');location.href = '/conf';</script>";
    }
    public function checkconf($id)
    {
        if(DB::table('um')->where('user_id', Auth::user()->id)->where('quest_id', $id)->value('status')==0){
            $point = DB::table('users')->where('id',Auth::user()->id)->value('point');
            $fame = DB::table('users')->where('id',Auth::user()->id)->value('fame');
            DB::table('users')->where('id',Auth::user()->id)->update(['point'=>$point+10,'fame'=>$fame+1]);
            DB::table('um')->where('user_id', Auth::user()->id)->where('quest_id', $id)->update(['status'=>1,'finish_at'=>Carbon::today()]);
        }
        return redirect('/');
    }
}
