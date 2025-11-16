<?php
namespace Core\Contracts\Repository;

use Core\Contracts\Collection\Collection;
use Core\Contracts\Entity\Entity;

/**
 * Repository Contract
 *
 * Class Repository
 *
 * @package Core\Contracts\Repositories
 */
interface Repository
{
    /**
     * index.
     *
     * @param  array $array
     * @return Collection
     */
    public function index(array $array): Collection;

    /**
     * search.
     *
     * @param  array $array
     * @return Collection
     */
    public function search(array $array): Collection;

    /**
     * store.
     *
     * @param  array $array
     * @param  array $request
     * @return Entity
     */
    public function store(array $array, array $request): Entity;

    /**
     * Store Many.
     *
     * @param  array  $array
     * @param  string $relation
     * @return Collection
     */
    public function storeMany(array $array, string $relation): Collection;

    /**
     * show.
     *
     * @param  array $array
     * @param  int   $id
     * @return Entity
     */
    public function show(array $array, int $id): Entity;

    /**
     * update.
     *
     * @param  array $array
     * @param  array $request
     * @param  int   $id
     * @return Entity
     */
    public function update(array $array, array $request,int $id): Entity;

    /**
     * update Many.
     *
     * @param  array  $array
     * @param  string $relation
     * @return Collection
     */
    public function updateMany(array $array, string $relation): Collection;

    /**
     * delete.
     *
     * @param  int $id
     * @return bool
     */
    public function destroy(int $id): bool;

    /**
     * findById.
     *
     * @param  int   $id
     * @param  array $with
     * @return Entity
     */
    public function findById(int $id, array $with): Entity;

    /**
     * Filter.
     *
     * @param  array $filters
     * @param  array $request
     * @return Collection
     */
    public function filter(array $filters, array $request): Collection;

    /**
     * startTransaction.
     *
     * @return mixed
     */
    public function startTransaction();

    /**
     * endTransaction.
     *
     * @return mixed
     */
    public function endTransaction();
}