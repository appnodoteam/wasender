<?php

namespace App\Models\V1;

use App\Http\Traits\UUID;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Number extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $fillable = [
        'id',
        'token',
        'number_id',
        'waba_id',
        'user_id',
        'status',
        'save_messages',
        'save_media',
        'name',
        'api_version'
    ];

    protected $casts = [
        'save_messages' => 'boolean',
        'save_media' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function getRouteKeyName()
    {
        return 'id';
    }
}
