<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Article.
 *
 * @package namespace App\Models;
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $author
 * @property string $content
 * @property string $thumbnail
 * @property int $seen
 * @property string $created_by_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $status 1: Hoạt động. -1: Không hoạt động.
 * @property-read \App\User $created_by
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereSeen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Article extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'author',
        'description',
        'content',
        'status',
        'seen',
        'thumbnail',
    ];

    public function created_by() {
        return $this->belongsTo(User::class, 'created_by_id');
    }

}
