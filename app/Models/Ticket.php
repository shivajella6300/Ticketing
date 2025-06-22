<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TicketResponse;

class Ticket extends Model
{
    use HasFactory;
    protected $table="tickets";
    protected $primaryKey="ticket_id";
   protected $fillable = [
    'User_Name',
    'Ticket_Subject',
    'Ticket_Category',
    'Ticket_Description',
    "Ticket_Status"
];
//ORM HasMany 
    public function ticketResponses()
    {
        return $this->hasMany(TicketResponse::class, 'ticket_id', 'ticket_id');
    }
    public function TicketUser(){
        return $this->belongsTo(User::class,"User_Name","name");
    }


}
