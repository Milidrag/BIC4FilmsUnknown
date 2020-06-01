<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Carbon;

/**
 * Class Actor
 *
 * @package App
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property int $film_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Film newModelQuery()
 * @method static Builder|Film newQuery()
 * @method static Builder|Film query()
 * @method static Builder|Film whereCreatedAt($value)
 * @method static Builder|Film whereId($value)
 * @method static Builder|Film whereName($value)
 * @method static Builder|Film whereSlug($value)
 * @method static Builder|Film whereDescription($value)
 * @method static Builder|Film whereDomainId($value)
 * @method static Builder|Film whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Film $film
 */
class Actor extends BaseModel
{
    public function film()
    {
        return $this->belongsToMany(Film::class);
    }
}
