<?php

namespace App\Models;

use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class News extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasSEO;

    protected $fillable = ['title', 'slug', 'subtitle', 'image', 'summary', 'content', 'publish_at', 'deleted_at'];

    protected $casts = [
        'summary' => 'array',
        'content' => 'array',
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
