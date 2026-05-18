<?php

namespace App\Traits\Models;

trait LowercaseAttribute
{
    protected static function bootLowercaseAttributes()
    {
        static::saving(function ($model) {

            foreach ($model->lowercase ?? [] as $attribute) {

                if (! is_null($model->{$attribute})) {
                    $model->{$attribute} = mb_strtoupper($model->{$attribute});
                }
            }
        });
    }
}
