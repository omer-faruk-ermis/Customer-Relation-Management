<?php

namespace App\Models;

use App\Enums\DefaultConstant;
use DateTimeInterface;
use Eloquent;

/**
 * Abstract class AbstractModel
 *
 * @package App\Models
 */
abstract class AbstractModel extends Eloquent
{
    use QualifiableTrait, StatusTrait, DatabaseTrait;

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
     * The default attributes that should be in RecorderTrait.
     *
     * @var string
     */
    public string $recordField = 'kayit_id';

    public static array $rules = [];
    public static array $ensRules = [];

    /**
     * @param $filters
     *
     * @return null
     */
    protected function filter($filters)
    {
        return null;
    }

    /**
     * @param        $builder
     * @param array  $filters
     *
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
     * @param DateTimeInterface  $date
     *
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format(DefaultConstant::DEFAULT_DATETIME_FORMAT);
    }
}
