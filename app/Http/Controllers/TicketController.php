<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    //
    public function getAdminTickets(Request $request){
        try
        {
            return response()->json(["status"=>200,"message"=>"Tickets Data Fetched Successfully",]);

        }catch(\Exception $e)
        {
            return response()->json(['status'=>500,
            "message"=>"Internal Server Error",
            "error"=>$e->getMessage()]);
        }
    }
}
