<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Activity extends Model
{   
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'activity_log';
    protected $primaryKey = 'id';
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    
	/**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'id';
    }
    
    /**
     * Get all the addresses for a country.
     */
    public function isAddress()
    {
        return $this->belongsTo(
            'App\Address',
            'subject_id',
            'uuid'
        );
    }
    
    /**
     * Get all the addresses for a country.
     */
    public function isCategory()
    {
        return $this->belongsTo(
            'App\Category',
            'subject_id',
            'uuid'
        );
    }
    
    /**
     * Get all the addresses for a country.
     */
    public function isUser()
    {
        return $this->belongsTo(
            'App\User',
            'subject_id',
            'uuid'
        );
    }

}
