<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';
    protected $fillable = [
        'contact_id', 'action', 'remark', 'created_by'
    ];

	public function user()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

}
