<?php
declare(strict_types=1);

namespace Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class AbstractModel extends Model
{
    use SoftDeletes;

    /**
     * relationships.
     *
     * @var array
     */
    protected array $relationships = [];

    /**
     * nullables.
     *
     * @var array
     */
    protected array $nullables = [];

    /**
     * The priority fields config for search
     *
     * @var array
     */
    protected array $priority_data_fields = [];

    /**
     * enable tracking CRUD store into log
     *
     * @var boolean
     */
    protected bool $enableLog = false;

    /**
     * model name use in tracking CRUD store into log
     *
     * @var string
     */
    protected string $modelNameLog = '';

    public function getEnableLogStatus()
    {
        return $this->enableLog;
    }

    public function getModelNameLog()
    {
        return $this->modelNameLog;
    }

    /**
     * getRelationShips.
     *
     * @return array
     */
    public function getRelationships(): array
    {
        return $this->relationships;
    }

    public function getNullables(): array 
    {
        return $this->nullables;
    }

    /**
     * getTableName.
     *
     * @return mixed
     */
    public function getTableName(): string
    {
        return with(new static())->getTable();
    }

    /**
     * newModel.
     *
     * @return static
     */
    public function newModel()
    {
        return new static();
    }

    public static function tableName(): string
    {
        return (new static())->getTable();
    }
}