<?php

namespace App\Models;

use Awcodes\Curator\Models\Media;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;


class Page extends \Z3d0X\FilamentFabricator\Models\Page
{
    use HasSEO;

    protected $fillable = [
        'title',
        'slug',
        'blocks',
        'layout',
        'parent_id',
        'active',
    ];

    protected $casts = [
        'blocks' => 'array',
        'parent_id' => 'integer',
    ];

    public function getDynamicSEOData(): SEOData
    {
        $image = null;
        if($this->blocks[0]['data']['image']) {
            $image = Media::find($this->blocks[0]['data']['image']);
        } 
         return new SEOData(
             image: ($image)?$image->path:''
         );
    }
}
