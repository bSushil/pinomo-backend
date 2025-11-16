<?php
declare(strict_types=1);

namespace Core\Repositories;

use Core\Contracts\Repository\Repository;
use Core\Contracts\Entity\Entity;
use Core\Exceptions\NotFoundException;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Core\Contracts\Collection\Collection;
use Core\Contracts\Factory\FactoryContract;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Core\Packages\QueryBuilder\QueryBuilder;
use Core\Packages\ConditionStrategy\ConditionStrategy;

abstract class AbstractRepository implements Repository
{
    use RepositoryTraits;

        /**
     * Available Sync Methods
     */
    const availableSyncMethods = [
        'sync',
        'attach',
        'detach'
    ];

    /**
     * factory.
     *
     * @var FactoryContract
     */
    protected $factory;

    /**
     * collection.
     *
     * @var Collection
     */
    protected $collection;

    /**
     * Operator.
     *
     * @var
     */
    protected $operator;

    /**
     * coreModel.
     *
     * @var
     */
    protected $coreModel;

    /**
     * Model.
     *
     * @var Model
     */
    public $model;

    /**
     * conditionStrategy.
     *
     * @var
     */
    protected $conditionStrategy;

    /**
     * applyRequestParams.
     *
     * @param  array $request
     * @return \Core\ApplicationLayer\Laravel\Models\AbstractModel|Model
     */
    protected function applyRequestParams(array $request)
    {
        $this->coreModel = $this->model;

        $tableName = $this->model->getTableName();
        $this->operator = app(QueryBuilder::class);
        $this->conditionStrategy = app(ConditionStrategy::class);

        $this->model = $this->with(
            is_array($request['with']) ? $request['with'] : explode(',', $request['with']), 
            $request['with_conditions'], $request['condition_strategy']
        );

        $this->model = $this->conditions($request['conditions'], Schema::getColumnListing($tableName));

        $this->model = $this->sorting($request['sorting']);

        $this->model = $this->sortingRaw($request['sortingRaw']);

        $this->model = $this->pagination($request['paginate'], $tableName, $request['per_page']);

        $this->collection->setPagination($request['paginate']);

        return $this->model;
    }

    /**
     * index.
     *
     * @param  array $request
     * @return Collection
     */
    public function index(array $request): Collection
    {
        $this->applyRequestParams($request);
        $data = $this->model->toArray();
        if ($request['paginate']) {
            $this->collection->setPaginationAttributes($data);
            $entities = $data['data'];
        }else{
            $entities = $data;
        }
        foreach ($entities as $entity) {
            $this->collection->addEntity($this->factory->create($entity));
        }

        return $this->collection;
    }

    /**
     * Search.
     *
     * @param  array $request
     * @return Collection
     */
    public function search(array $request): Collection
    {
        $data = $this->model->search($request['query'])->paginate($request['per_page'])->toArray();

        $this->collection->setPaginationAttributes($data);

        foreach ($data['data'] as $row) {
            $this->collection->addEntity($this->factory->create($row));
        }

        return $this->collection;
    }

    /**
     * storeMany.
     *
     * @param  array  $request
     * @param  string $relation
     * @return Collectionconditions
     * @throws NotFoundException
     */
    public function storeMany(array $request,string $relation): Collection
    {
        $data = $this->model->$relation()->createMany($request['data']);

        $this->applyRequestParams($request);

        $data = $this->model->toArray();

        if (!$data) {
            throw new NotFoundException();
        }

        if ($request['paginate']) {
            $this->collection->setPaginationAttributes($data);
            $entities = $data['data'];
        }else{
            $entities = $data;
        }

        foreach ($entities as $entity) {
            $this->collection->addEntity($this->factory->create($entity));
        }

        $this->model = $this->model->first()->newModel();

        return $this->collection;

    }

    /**
     * store.
     *
     * @param  array $modelRequest
     * @param  array $request
     * @return Entity
     * @throws NotFoundException
     */
    public function store(array $modelRequest, array $request): Entity
    {
        // $modelRequest[$this->model->getKeyName()] = generateHash();
        $data = $this->model->create($modelRequest);

        $request['conditions'] = [$this->model->getKeyName() => $data->getKey()];
        $request['paginate'] = false;

        $this->applyRequestParams($request);

        $data = $this->model->toArray()[0] ?? null;

        if (!$data) {
            throw new NotFoundException();
        }

        $this->model = $this->model->first()->newModel();

        return $this->factory->create($data);
    }

    /**
     * show.
     *
     * @param  array $request
     * @param  int   $id
     * @return Entity
     * @throws NotFoundException
     */
    public function show(array $request, int $id): Entity
    {
        $request['conditions'] = [$this->model->getKeyName() => $id];
        $request['paginate'] = false;
        $this->applyRequestParams($request);

        $data = (!empty($this->model->toArray()))? $this->model->toArray()[0] : $this->model->toArray();

        if (!$data) {
            throw new NotFoundException();
        }

        $this->model = $this->model->first()->newModel();

        return $this->factory->create($data);
    }

    /**
     * update.
     *
     * @param  array $modelRequest
     * @param  array $request
     * @param  int   $id
     * @return Entity
     * @throws NotFoundException
     */
    public function update(array $modelRequest,array $request, int $id): Entity
    {
        $entity = $this->model->find($id);
        $entity->update($modelRequest);

        $request['conditions'] = [$this->model->getKeyName() => $id];
        $request['paginate'] = false;

        $this->applyRequestParams($request);

        $data = $this->model->toArray();

        if (!$data) {
            throw new NotFoundException();
        }

        $data = $data[0];

        $this->model = $this->model->first()->newModel();

        return $this->factory->create($data);
    }

    /**
     * updateMany.
     *
     * @param  array  $request
     * @param  string $relation
     * @return Collection
     * @throws NotFoundException
     */
    public function updateMany(array $request, string $relation): Collection
    {
        $models =[];

        foreach ($request['data'] as $row){
            $models[] = $this->model->first()->newModel()->fill($row);
        }

        $data = $this->model->first()->newModel()->saveMany($models);

        $request['paginate'] = 0;

        $this->applyRequestParams($request);

        $data = $this->model->toArray();

        if (!$data) {
            throw new NotFoundException();
        }

        if ($request['paginate']) {
            $this->collection->setPaginationAttributes($data);
            $entities = $data['data'];
        }else{
            $entities = $data;
        }

        foreach ($entities as $entity) {
            $this->collection->addEntity($this->factory->create($entity));
        }

        return $this->collection;
    }

    /**
     * destroy.
     *
     * @param  int $id
     * @return bool
     * @throws NotFoundException
     */
    public function destroy(int $id): bool
    {
        $entity = $this->model->find($id);
        if (!$entity) {
            throw new NotFoundException();
        }
        $result = $entity->delete();

        return $result;
    }

    /**
     * filter.
     *
     * @param  array $filters
     * @param  array $request
     * @return Collection
     */
    public function filter(array $filters, array $request): Collection
    {
        $this->applyRequestParams($request);

        $data = $this->model->toArray();
        if ($request['paginate']) {
            $this->collection->setPaginationAttributes($data);
            $entities = $data['data'];
        }else{
            $entities = $data;
        }

        foreach ($entities as $entity) {
            $this->collection->addEntity($this->factory->create($entity));
        }

        return $this->collection;
    }


    /**
     * findById
     *
     * @param  int   $id
     * @param  array $with
     * @return Entity
     * @throws NotFoundException
     */
    public function findById(int $id, array $with): Entity
    {
        try {
            $data = $this->model->with($with)->find($id);
        } catch(RelationNotFoundException $e) {
            $data = $this->model->find($id);
        }

        if (!$data) {
            throw new NotFoundException();
        }

        return $this->factory->create($data->toArray());
    }

    public function next($id): Entity
    {
        $model = $this->model->where('id', '>', $id)->first();

        if (!$model) {
            throw new NotFoundException();
        }
        $data = $model->toArray();
        return $this->factory->create($data);
    }

    public function previous($id): Entity
    {
        $model =$this->model->where('id', '<', $id)->first();
        if (!$model) {
            throw new NotFoundException();
        }
        $data = $model->toArray();
        $model = $this->model->newModel();
        return $this->factory->create($data);
    }

}