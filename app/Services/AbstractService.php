<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AbstractService.
 *
 * This class serves as a base class for domain service layer, that should
 * contain high level model interactions and business logic, that could
 * be easily tested. By default it declares an interface for model
 * instance creation, fetching and saving.
 */
abstract class AbstractService
{
    /**
     * Create a new model instance.
     *
     * @return Model
     */
    abstract public function createModel();

    /**
     * Find model by given $id.
     *
     * @param mixed $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    abstract public function find($id, $columns = ['*']);

    /**
     * Saves a model.
     *
     * @param Model $model
     * @return bool
     */
    public function save(Model $model)
    {
        return $model->save();
    }
}
