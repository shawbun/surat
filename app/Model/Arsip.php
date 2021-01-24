<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    protected $guarded = [];
    protected $date = ['tgl_surat'];

    /**
     * Relationships
     */

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Model\Category', 'category_id');
    }

}
