<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        //dd($request->name);
        $user = auth()->user();
        $query = Ticket::query();
        // Only admins can see all tickets
        if ($user->role !== 'admin') 
        {
            $query->where('User_Name', $user->name);
        }
        // Optional filters
        if ($request->has('status')) 
        {
            $query->where('Ticket_Status', $request->status);
        }
        if ($request->has('name') && $user->role === 'admin') 
        {
            $query->where('User_Name', $request->name); // Only admin can filter by user_id
        }
        return response()->json($query->get());
    }
}
