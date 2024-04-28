<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;



class Locations extends Model
{
    public function artifacts(): belongsToMany
    {
        return $this->belongsToMany(Artifacts::class);
    }

    use HasFactory;
    use SoftDeletes;
    use HasSEO;


    protected $fillable = ['wholeAddress', 'area', 'city', 'country', 'longitude', 'latitude', 'deleted_at'];

    protected $casts = [
        'content' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function getDynamicSEOData(): SEOData
    {
        $image = null;
        if($this->image) {
            $image = Media::find($this->image);
        } 
        return new SEOData(
            image: ($image)?$image->path:''
        );
    }

    public function getRouteKeyName()
    {
        return 'wholeAddress';
    }

}