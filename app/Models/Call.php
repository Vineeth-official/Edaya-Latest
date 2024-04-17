<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    use HasFactory;
    protected $fillable = [
        'phone_number',
        'purpose',
        'status',
        'duration',
        'client',
        'comments',
        'name',
        'date',
        'user'
    ];
    public function userName()
    {
        return $this->belongsTo(User::class,'user','id');
    }
    public function Statuses()
    {
        return $this->belongsTo(Status::class,'status','id');
    }
}
