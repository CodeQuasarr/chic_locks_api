<?php

namespace App\Services;

use Illuminate\Support\Collection;

abstract class BaseService
{
    /**
     * @description Reduce fields to those of the model
     *
     * This method reduces the fields to those of the model according to the fields passed as parameters.
     * If the model has fields that are not passed as parameters, they will not be taken into account.
     *
     * @param $model
     * @param Collection $requestField
     * @return Collection
     */
    protected function getModelFields($model, Collection $requestField): Collection {
        $modelFields = $model->getFillable();
        $fields = collect();
        foreach ($modelFields as $oneKey) {
            if ($requestField->has($oneKey)) {
                $fields->put($oneKey, $requestField->get($oneKey));
            }
        }
        return $fields;
    }
}
