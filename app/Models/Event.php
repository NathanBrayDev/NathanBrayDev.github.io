<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Awcodes\Curator\Models\Media;


class Event extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasSEO;


    protected $fillable = ['title', 'slug', 'subtitle','summary', 'image', 'start_date', 'end_date', 'times', 'location','content', 'deleted_at'];

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
        return 'slug';
    }

}