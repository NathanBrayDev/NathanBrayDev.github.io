<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Artifacts extends Model
{


    public function language(): BelongsToMany
    {
        return $this->BelongsToMany(Languages::class);
    }

    public function type(): HasOne
    {
        return $this->hasOne(ArtifactType::class);
    }

    public function locations(): BelongsToMany
    {
        return $this->BelongsToMany(Locations::class);
    }

    public function keywords(): belongsToMany
    {
        return $this->belongsToMany(Keywords::class);
    }

    public function tags(): belongsToMany
    {
        return $this->belongsToMany(Tags::class);
    }

    use HasFactory;
    use SoftDeletes;
    use HasSEO;


    protected $fillable = ['originalTitle', 'translatedTitle', 'fileName', 'creatorName', 
    'creatorRole', 'type', 'dayOfRelease', 'monthOfRelease', 'yearOfRelease', 'shortDesc', 'longDesc',  
    'locations', 'language', 'publisher', 'producer', 'printer', 'copyright', 'institute', 
    'bibliography', 'documenter', 'keywords', 'tags', 'slug', 'themeing', 'deleted_at', 'artifactImage'];

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