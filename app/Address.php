<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Traits\LogsActivity;

class Address extends Model
{
    use LogsActivity, Searchable, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'addresses';
    protected $primaryKey = 'uuid';
	
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'name',
         'owner',
         'address',
         'status',
         'description',
         'phone',
         'url',
         'latlng',
         'country_uuid',
         'category_uuid',
         'place_id',
    ];
    
    /**
     * The attributes that are loggable.
     *
     * @var array
     */
    protected static $logAttributes = [
         'name',
         'owner',
         'address',
         'status',
         'description',
         'phone',
         'url',
         'latlng',
         'country_uuid',
         'category_uuid',
         'place_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];
	
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    
    protected $casts = [
        'uuid' => 'uuid',
    ];
    
    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
        
        $array = array(
            'uuid' => $this->uuid,
            'country-cca2' => $this->locatedAt->cca2,
            'country-cca3' => $this->locatedAt->cca3,
            'country-name-common' => $this->locatedAt->name_eng_common,
            'country-name-official' => $this->locatedAt->name_eng_official,
        );

        return $array;
    }
    
    // Override the toArray function (called by toJson)
    public function toArray() {
        $data = parent::toArray();
        
        if ($this->inCategory) {
            $data['category']['name'] = $this->inCategory->name;
            $data['category']['icon'] = $this->inCategory->icon;
            $data['category']['color'] = $this->inCategory->color;
        }
        
        if ($this->locatedAt) {
            $latlng = json_decode($data['country']['lat'] = $this->locatedAt->latlng, true);
            $data['country']['uuid'] = $this->locatedAt->uuid;
            $data['country']['region'] = $this->locatedAt->region;
            $data['country']['subregion'] = $this->locatedAt->subregion;
            $data['country']['cca2'] = $this->locatedAt->cca2;
            $data['country']['cca3'] = $this->locatedAt->cca3;
            $data['country']['flag'] = $this->locatedAt->flag;
            $data['country']['name_common'] = $this->locatedAt->name_eng_common;
            $data['country']['name_official'] = $this->locatedAt->name_eng_official;
            $data['country']['lat'] = $latlng['lat'];
            $data['country']['lng'] = $latlng['lng'];
        } else {
            $data['country'] = null;
        }

        return $data;
    }
	
	/**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'addresses';
    }
    
    /**
     * Boot the Model.
     */
    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }
	
	/**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * Get all the addresses for a country.
     */
    public function inCategory()
    {
        return $this->belongsTo(
            'App\Category',
            'category_uuid',
            'uuid'
            
        );
    }
    
    /**
     * Get all the addresses for a country.
     */
    public function locatedAt()
    {
        return $this->belongsTo(
            'App\Country',
            'country_uuid',
            'uuid'
        );
    }

}
