<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\SocketController;

class Game1Controller extends Controller
{
    //
    public function index(Request $req){
       
    }
    /********* Process of Bidding **********/
    public function getBidData(Request $req){
        error_log('received data from '.Auth::user()->id);
        
        if($req->digit == null || $req->date == null || $req->bid == null){
            return response()->json(['status' => false, 'error' => 'Please select number, date and bet amount fields correctly.']);
        }

        if($req->date < date('Y-m-d')){
            return response()->json(['status' => false, 'error' => "You can't bet for past days, please choose today or following days"]);
        }

        $bids_today = DB::table("game_ones")->where('date', $req->date)
            ->where('user_id', Auth::user()->id)->get();
        if(count($bids_today) >= 1){
           return response()->json(['status' => false, 'error' => 'You have already betted today.<br> Please try following days']);
        }
        DB::insert('insert into game_ones (digit, date, bid, user_id, created_at) values (?,?,?,?,?)',[$req->digit, $req->date, $req->bid, Auth::user()->id, date('Y-m-d H:i:s') ]);
        return response()->json(['status' => true, 'bid' => $req->bid]);
    }

    /*******  Calculation of betting result  ********/
    // public function calculateBid(){
    //     //DB Size ?
    //     // error_log(date('Y-m-d H:i:s'));
    //     $answer = $this->generateRandomNumber();
    //     $today = date("Y-m-d H:i:s");
    //     $yesterday = date('Y-m-d H:i:s',strtotime("-1 days"));
    //     // dd($today); dd($yesterday);
    //     // 1. update the 'win' and 'seen' true of game_one table 
    //         DB::table('game_ones')->where('date', '<=',$today)->where('date','>', $yesterday)->where('digit', $answer)->update(['win' => true]);
    //         DB::table('game_ones')->where('date', '<=',$today)->where('date','>', $yesterday)->update(['win' => false]);     
    //         $winners = DB::table('game_ones')->where('date', '<=',$today)->where('date','>', $yesterday)->where('digit', $answer)->where('win', true)->get();
    //         $losers = DB::table('game_ones')->where('date', '<=',$today)->where('date','>', $yesterday)->where('win', false)->get();            
    //         // dd("winners = ", $winners);
    //         // dd("losers = ", count($losers));
    //         //dd("losers = ", $losers);
    //     // 2. update the coin amount of the user + or -
    //         $times = env('GAME1_WIN_TIMES');
    //         foreach($winners as $winner){
    //             $ori_coin = DB::table('users')->where('id', $winner->id)->first()->coin; 
    //             DB::table('users')->where('id', $winner->user_id)->update(['coin' => ($times * $winner->bid + $ori_coin)]);
    //         }
    //         foreach($losers as $loser){
    //             $ori_coin = DB::table('users')->where('id', $loser->id)->first()->coin;
    //             DB::table('users')->where('id', $loser->user_id)->update(['coin' => ($ori_coin - $loser->bid)]);
    //         }
       
    //     // 3. ping to users their success or failure
    //         foreach($winners as $winner){
    //             $row = DB::table('users')->where('id', $winner->id)->first();
    //             SocketController::sendBettingResult($row->connection_id, $winner->bid * $times , true);
    //         }
    //         foreach($losers as $loser){
    //             $row = DB::table('users')->where('id', $loser->id)->first();
    //             SocketController::instance()->sendBettingResult($row->connection_id, $loser->bid * $times , false);
                
    //         }
    //         // dd("db checked");
    // }

    // public funtion checkRead(Request $req){ //check the bet result row as  the user have read

    // }

    public function generateRandomNumber(){
        return rand(1,50);
    }

    public function user_game1_statistics()
    {
        
    }

    
}
