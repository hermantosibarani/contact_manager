<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contact';
    protected $fillable = [
        'name', 'phone', 'email', 'remark', 'status', 'agent', 'created_by', 'created_at', 'updated_at'
    ];

	public function user()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function to_agent()
    {
        return $this->belongsTo('App\Models\User', 'agent', 'id');
    }


}
