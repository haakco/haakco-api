<?php

namespace App\Models\ModelTraits;

trait DataJsonTrait
{

    /**
     * @param $value
     *
     * @return mixed
     */
    public function getDataJsonAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * @param $value
     */
    public function setDataJsonAttribute($value): void
    {
        $this->attributes['data_json'] = \json_encode($value, JSON_PRETTY_PRINT);
    }
}
