<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketResponse extends Model
{
    use HasFactory;
    protected $table="ticket_reponse";
    protected $primaryKey="ticket_reponse_id";
    protected $fillable=[
        "ticket_id","ticket_response"
    ];

   
    public function belongsToTicket()
{
    return $this->belongsTo(Ticket::class, 'ticket_id', 'ticket_id');
}

}
