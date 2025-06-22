<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use App\Models\TicketResponse;
use Yajra\DataTables\DataTables;


class TicketController extends Controller
{
    public function ticketForm()
    {
        return view('ticket.ticketRaiserForm');
    }
    public function getAdminTickets(Request $request)
    {
        try
        {
            return response()->json(["status"=>200,"message"=>"Tickets Data Fetched Successfully",]);

        }
        catch(\Exception $e)
        {
            return response()->json(['status'=>500,
            "message"=>"Internal Server Error",
            "error"=>$e->getMessage()]);
        }
    }
    public function raiseTicket(Request $request)
{
    //dd($request->validate());
    $validated = $request->validate([
        'User_Name' => 'required|string|max:255',
        'Ticket_Subject' => 'required|string|max:255',
        'Ticket_Category' => 'required|string|max:255',
        'Ticket_Description' => 'required|string|max:1000',
    ]);

    Ticket::create([
        'User_Name'          => $request->User_Name,
        'Ticket_Subject'     => $request->Ticket_Subject,
        'Ticket_Category'    => $request->Ticket_Category,
        'Ticket_Description' => $request->Ticket_Description,
        "Ticket_Status"=>   "Pending"
    ]);
    return redirect()->route('user.ticketlist')->with('success', 'Ticket raised successfully.');
}

public function getAuthentTickets(Request $request)
{
    try{
         if ($request->ajax()) 
         {
           $getAuthTickets = Ticket::where('User_Name', auth()->user()->name)->with('TicketUser');
            return Datatables::of($getAuthTickets)->addIndexColumn()
                ->addColumn('User_Name', function ($row) {
                    return $row->TicketUser->name ?? 'N/A';
                })
                ->addColumn('Ticket_Subject', function ($row) {
                    return $row->Ticket_Subject;
                })
                ->addColumn('Ticket_Category', function ($row) {
                    return $row->Ticket_Category;
                })
                ->addColumn('Ticket_Description', function ($row) {
                    return $row->Ticket_Description;
                })
                ->editColumn('Ticket_Status', function ($row) {
                    if ($row->Ticket_Status == "Pending") {
                        return "<span style='color: blue;'>Pending</span>";
                    } else if ($row->Ticket_Status == "Closed") {
                        return "<span style='color: red;'>Closed</span>";
                    } elseif ($row->Ticket_Status == "Opened") {
                        return "<span style='color: green;'>Opened</span>";
                    }
                })
            ->escapeColumns(['User_Name','Ticket_Subject','Ticket_Category','Ticket_Description','Ticket_Status'])
            ->filter(function ($instance) use ($request) {
                if ($request->get('Ticket_Status')) {
                    $instance->where('Ticket_Status', $request->get('Ticket_Status'));
                }
            }, true)
        ->rawColumns(['action', 'Ticket_Status']) // include Ticket_Status so HTML colors show
        ->make(true);
        }
        return view('ticket.authRaiserList');
    }
    catch(\Exception $e){
     DB::rollBack();
     return redirect('ticket.raise')->with('error', $e->getMessage());
    }
}
//Get All Tickets ---
public function getAllTickets(Request $request)
{
    try{
         if ($request->ajax()) 
         {
             $getAuthTickets = Ticket::select("*")->latest();
             return Datatables::of($getAuthTickets)->addIndexColumn()
             ->editColumn('Ticket_Status', function ($row) {
                    if ($row->Ticket_Status == "Pending") 
                    {
                        return "<span style='color: blue;'>Pending</span>" ;
                    }
                    else if($row->Ticket_Status == "Closed")
                        return "<span style='color: red;'>Closed</span>";
                     elseif ($row->Ticket_Status == "Opened") {
                        return "<span style='color: green;'>Opened</span>";
                    }
                })
                ->escapeColumns('Ticket_Status')
             ->addColumn('action', function ($row) {
                    $id = $row->ticket_id;
                    if(($row->Ticket_Status=="Closed")){
                        return "";
                    }
                    else if($row->Ticket_Status=="Opened"){
                        return '
                        <div class="d-flex gap-2 justify-content-start">
                            <button type="button" class="btn btn-danger btn-sm change-status" data-id="' . $id . '" data-status="Closed">
                                Closed
                            </button>
                        </div>';
                    }
                    return '
                    <div class="d-flex gap-2 justify-content-start">
                        <button type="button" class="btn btn-success btn-sm change-status" data-id="' . $id . '" data-status="Opened">
                            Open
                        </button>
                        <button type="button" class="btn btn-danger btn-sm change-status" data-id="' . $id . '" data-status="Closed">
                            Closed
                        </button>
                    </div>';
                })
              ->filter(function ($instance) use ($request) 
              {
                    if ($request->get('Ticket_Status')) {
                        $instance->where('Ticket_Status', $request->get('Ticket_Status'));
                    }
                }, true)
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('ticket.adminTicketList');
    }catch(\Exception $e){
     DB::rollBack();
     return redirect('ticket.raise')->with('error', $e->getMessage());
    }
}
public function updateTicketStatus(Request $request)
{
    try{
        TicketResponse::create([
             "ticket_id"      => $request->id,
             "ticket_response"=> $request->comment
        ]);
        $ticketStatusUpdate=Ticket::where('ticket_id',$request->id)->first();
        $ticketStatusUpdate->update([
            "Ticket_Status"=>$request->status
        ]);
        return response()->json(["status"=>201,"message"=>"Ticket Updated And Raised Successfully","success"=>true]);

    }catch(\Exception $e)
    {
        return response()->json(["Status"=>500,"message"=>"Internal Sever Error","error"=>$e->getMessage(),"success"=>false]);
    }

}


public function TicketManyResponses(Request $request)
{
    if ($request->ajax()) {
        $getdetails = TicketResponse::with('belongsToTicket')->get();
        return DataTables::of($getdetails)
            ->addIndexColumn()
            ->addColumn('ticket_response_id', function ($row) {
                return $row->ticket_response_id ?? 'N/A';
            })
            ->addColumn('ticket_id', function ($row) {
                return $row->ticket_id ?? 'N/A';
            })
            ->addColumn('ticket_response', function ($row) {
                return $row->ticket_response ?? 'N/A';
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('Y-m-d H:i') : 'N/A';
            })
            // Optional fields from the related ticket
            ->addColumn('Ticket_Category', function ($row) {
                return $row->belongsToTicket->Ticket_Category ?? 'N/A';
            })
            ->addColumn('Ticket_Description', function ($row) {
                return $row->belongsToTicket->Ticket_Description ?? 'N/A';
            })
            ->make(true);
    }

    return view('ticket.ticketResponseList'); // Your Blade view file
}

public function userHasManyTickets(Request $request){
    try{
if ($request->ajax()) 
{
        $getUserManyTickets = User::with('UserManyTickets')->get();
        return DataTables::of($getUserManyTickets)
            ->addIndexColumn()
             ->addColumn('User_Name', function ($row) 
             {
                    return $row->name;
            })
            ->addColumn('Ticket_Subject', function ($row) 
            {
                if ($row->UserManyTickets->isEmpty()) 
                {
                    return 'No Tickets';
                }
                return $row->UserManyTickets->pluck('Ticket_Subject')->implode(', ');
            })
             ->addColumn('Ticket_Category', function ($row) 
             {
                if ($row->UserManyTickets->isEmpty()) 
                {
                    return 'No Tickets';
                }
                return $row->UserManyTickets->pluck('Ticket_Category')->implode(', ');
            })
            ->rawColumns(['Ticket_Subject','User_Name','Ticket_Category'])
            ->make(true);
        }
        return view('ticket.AuthUserHasManyTicket');
    }catch(\Exception $e){
        DB::rollBack();
        return redirect('user.hasManyTickets')->with('error',$e->getMessage());
    }
}
       
}
