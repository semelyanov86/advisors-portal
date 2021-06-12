<?php

namespace App\Models;

use App\Casts\DescriptionCast;
use App\Casts\MoneyCast;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class Advisor extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;

    public const RESOURCE_NAME = 'advisors';

    public $table = 'advisors';

    protected $appends = [
        'profile',
    ];

    protected $casts = [
        'description' => DescriptionCast::class,
        'availability' => 'bool',
        'price' => MoneyCast::class
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'description',
        'availability',
        'price',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /*public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 120, 120);
        $this->addMediaConversion('preview')->fit('crop', 800, 800);
    }*/

    public function getProfileAttribute()
    {
        $file = $this->getMedia('profile')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl();
            $file->preview   = $file->getUrl();
        }

        return $file;
    }

    public function languages(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Language::class);
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
