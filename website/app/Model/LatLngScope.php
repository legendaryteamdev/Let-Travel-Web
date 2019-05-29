<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class LatLngScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        $builder->addSelect('created_at');
    }
}