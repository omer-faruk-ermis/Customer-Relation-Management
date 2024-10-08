<?php

namespace App\Models;

use App\Enums\DefaultConstant;
use DateTimeInterface;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Abstract class AbstractSmsKimlik
 *
 * @package App\Models
 *
 * @mixin Eloquent
 */
abstract class AbstractSmsKimlik extends Authenticatable
{
    use HasFactory, Notifiable, QualifiableTrait, HasApiTokens, StatusTrait, DatabaseTrait;

    /**
     * set fillable fields
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get a new instance of the model.
     *
     * @return static
     */
    public static function getModel(): static
    {
        return new static();
    }

    /**
     * @param $filters
     * @return null
     */
    protected function filter($filters)
    {
        return null;
    }

    /**
     * @param $builder
     * @param array $filters
     * @return mixed
     */
    public function scopeFilter($builder, array $filters = []): mixed
    {
        if (empty($filters)) {
            return $builder;
        }

        $filter = $this->filter($filters);
        return $filter ? $filter->apply($builder, $filters) : $builder;
    }

    /**
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format(DefaultConstant::DEFAULT_DATETIME_FORMAT);
    }
}
