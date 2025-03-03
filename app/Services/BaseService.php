<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

    /**
     * @description Truncate a table with foreign key checks disabled and re-enabling them afterwards. This is useful for truncating tables

     * @param $table
     * @return bool
     */
    private function truncate($table): bool
    {
        if (DB::getDefaultConnection() === 'mysql') {
            DB::table($table)->truncate();
            return true;
        }
        return false;
    }
}
