<?php

namespace App\Models;

use App\Casts\UrlCast;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * Media model class
 * @package App\Models
 *
 * @property int $id
 * @property string $url
 * @property int $article_id
 * @property DateTime $created_at
 * @property DateTime $updated_at
 *
 * Relations
 *
 * @property Article $article
 */
class Media extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $hidden = ['id', 'article_id', 'created_at', 'updated_at'];

    protected $casts = [
        'url' => UrlCast::class
    ];

    /**
     * @return BelongsTo
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

}
