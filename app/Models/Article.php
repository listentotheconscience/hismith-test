<?php

namespace App\Models;

use App\Traits\Filterable;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Article model class
 * @package App\Models
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property DateTime $publication_date
 * @property string $author
 * @property DateTime $created_at
 * @property DateTime $updated_at
 *
 * Relations
 *
 * @property Collection $media
 *
 * Other
 *
 * @method Builder filter(Builder $builder)
 */
class Article extends Model
{
    use HasFactory, Filterable;

    protected $guarded = ['id'];

    protected $fillable = [
        'id', 'title', 'description', 'publication_date', 'author'
    ];

    protected $relations = [
        'media'
    ];

    /**
     * @return HasMany
     */
    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    /**
     * @param Builder $query
     * @param string $value
     * @return Builder
     */
    public function scopeFilterSortByPublicationDate (Builder $query, string $value): Builder
    {
        return $query->orderBy('publication_date', $value);
    }
}
