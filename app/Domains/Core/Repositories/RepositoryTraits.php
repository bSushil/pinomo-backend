<?php
declare(strict_types=1);

namespace Core\Repositories;

use Core\Models\AbstractModel;
use Core\Packages\QueryBuilder\QueryBuilder;
use Core\Exceptions\ValidationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;
use Core\Contracts\Request\Request;
use Illuminate\Support\Facades\DB;

trait RepositoryTraits
{

    /**
     * startTransaction.
     */
    public function startTransaction()
    {
        DB::beginTransaction();
    }

    /**
     * endTransaction.
     */
    public function endTransaction()
    {
        DB::commit();
    }

    /**
     * Rollback transaction.
     */
    public function rollbackTransaction()
    {
        DB::rollBack();
    }

    /**
     * Sync.
     *
     * @param int    $id
     * @param string $relation
     * @param $data
     * @param string $method
     */
    public function sync(int $id, string $relation, $data, $method = 'sync'): void
    {
        if (is_array($data) && (!empty($data) || (empty($data) && $method === "sync"))) {
            $this->model->find($id)->$relation()->$method($this->getSyncMethod($id, $relation, $data, $method));
        }
    }

    /**
     * Get Ids according to sync method.
     *
     * @param  $id
     * @param  $relation
     * @param  $ids
     * @param  $method
     * @return array
     */
    public function getSyncMethod($id, $relation, $ids, $method)
    {
        if (!in_array($method, static::availableSyncMethods)) {
            return array_filter($ids);
        }

        $faqIds = $this->model->find($id)->$relation()->whereIn('id', $ids)->pluck('id')->toArray();

        switch ($method) {
        case 'attach':
            $newIds = array_values(array_diff($ids, $faqIds));
            break;
        case 'detach':
            $newIds = array_values(array_intersect($faqIds, $ids));
            break;
        default:
            $newIds = $ids;
            break;
        }

        return array_filter($newIds);
    }

    /**
     * with.
     *
     * @param  array $with
     * @param  array $withConditions
     * @param  $conditionStrategy
     * @return mixed
     */
    protected function with(array $with, array $withConditions, $conditionStrategy)
    {
        if (!empty($with) && is_array($with)) {

            $final = [];

            foreach ($with as $relation) {
                if (!isset($withConditions[$relation])) {
                    $final[] = $relation;
                } else {
                    $columns = Schema::getColumnListing($this->coreModel->$relation()->getRelated()->getTableName());
                    $final[$relation] = $this->withConditions($relation, $withConditions[$relation], $columns, $conditionStrategy);
                }
            }
            $this->model = $this->model->with($final);
        }
        return $this->model;
    }

    /**
     * withConditions.
     *
     * @param  $relation
     * @param  $withCondition
     * @param  $columns
     * @param  $conditionStrategy
     * @return \Closure
     */
    public function withConditions($relation, $withCondition, $columns, $conditionStrategy)
    {
        $relationMethod = function ($q) use ($withCondition, $relation, $columns) {

            foreach ((array)$withCondition as $column => $value) {
                $column = explode(':', $column);
                $operation = $this->operator->get($this->getOperator($column));
                $operation->validate($this->coreModel, $column, $columns, $value);
                $parameters = $operation->getParameters($column[0], $value);

                call_user_func_array(array($q, $operation->getMethod()), $parameters);
            }
        };

        $conditionStrategyClass = $this->conditionStrategy->get($conditionStrategy);

        $this->model = call_user_func_array([$this->model, $conditionStrategyClass->getMethod()], $conditionStrategyClass->getParameters($relation, $relationMethod));


        return $relationMethod;
    }

    /**
     * getOperator.
     *
     * @param  $column
     * @return string
     */
    public function getOperator($column)
    {
        $operator = 'equal';

        if (!isset($column[1])) {
            return $operator;
        }

        return $column[1];
    }

    /**
     * conditions.
     *
     * @param  array $conditions
     * @param  $columns
     * @return mixed
     */
    protected function conditions(array $conditions, $columns)
    {
        if (!empty($conditions) && is_array($conditions)) {

            $model = $this->coreModel;

            foreach ($conditions as $column => $value) {
                $column = explode(':', $column);
                $operation = $this->operator->get($this->getOperator($column));
                $operation->validate($model, $column, $columns, $value);
                $parameters = $operation->getParameters($column[0], $value);

                $this->model = call_user_func_array(array($this->model, $operation->getMethod()), $parameters);
            }
        }

        return $this->model;
    }

    /**
     * sorting.
     *
     * @param  array $sorting
     * @return mixed
     */
    protected function sorting(array $sorting)
    {
        foreach ($sorting as $column => $direction) {
            $this->model = $this->model->orderBy($column, $direction);
        }

        return $this->model;
    }

    /**
     * sorting.
     *
     * @param  array $sorting
     * @return mixed
     */
    protected function sortingRaw(array $sorting)
    {
        foreach ($sorting as $orderStatement) {
            $this->model = $this->model->orderByRaw($orderStatement);
        }

        return $this->model;
    }

    /**
     * pagination.
     *
     * @param  bool $paginate
     * @return AbstractModel
     */
    protected function pagination(bool $paginate, $tableName, $perPage)
    {
        if ($paginate) {
            $this->model = $this->model->paginate($perPage);
        } else {
            $this->model = $this->model->get();
        }

        return $this->model;
    }
}