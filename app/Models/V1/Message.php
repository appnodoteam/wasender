<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "message",
        "destination",
        "number_id",
        "status",
        "messages_id",
        "response",
    ];

    protected $casts = [
        "response" => "array",
    ];

    public function number()
    {
        return $this->belongsTo(Number::class);
    }
}
