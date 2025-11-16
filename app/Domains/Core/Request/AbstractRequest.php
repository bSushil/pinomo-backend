<?php
namespace Core\Request;

use Core\Contracts\Request\Request;
use Core\Helpers\Strings;
use Core\Contracts\Entity\Entity;

abstract class AbstractRequest implements Request
{
    /**
     * data.
     *
     * @var array
     */
    protected $data = [
        'per_page' => 15,
        'query' => '',
        'created_by' => 0,
        'with' => [],
        'conditions' => [],
        'paginate' => true,
        'sorting' => [],
        'sortingRaw' => [],
        'with_conditions' => [],
        'condition_strategy' => 'where_has'
    ];

    protected $ip = '';

    protected $user;

    /**
     * Entity.
     *
     * @var Entity
     */
    protected $entity;

    /**
     * set.
     *
     * @param array $data
     */
    public function set(array $data, $request = null): void
    {
        $this->data = array_merge($this->data, $data);
        // $this->ip = $request ? ($request->header('CF-Connecting-IP') ? $request->header('CF-Connecting-IP')  : ($request->header('X-Forwarded-For')  ? $request->header('X-Forwarded-For')  : $request->ip())) : '';
        // $this->user = $request ? $request->user() : null;
    }

    /**
     * Add.
     *
     * @param string $key
     * @param $value
     */
    public function add(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * Remove Keys
     *
     * @param array $keys
     */
    public function removeKeys(array $keys): void
    {
        foreach ($keys as $key) {
            $this->remove($key);
        }
    }

    /**
     * remove.
     *
     * @param string $key
     */
    public function remove(string $key): void
    {
        if (isset($this->data[$key])) {
            unset($this->data[$key]);
        }
    }

    /**
     * Override.
     *
     * @param array $data
     */
    public function override(array $data): void
    {
        $data['per_page'] = $data['per_page'] ?? $this->data['per_page'];
        $data['query'] = $data['query'] ?? $this->data['query'];
        $data['created_by'] = $data['created_by'] ?? $this->data['created_by'];
        $data['with'] = $data['with'] ?? $this->data['with'];
        $data['conditions'] = $data['conditions'] ?? $this->data['conditions'];
        $data['with_conditions'] = $data['with_conditions'] ?? $this->data['with_conditions'];
        $data['paginate'] = $data['paginate'] ?? $this->data['paginate'];
        $data['sorting'] = $data['sorting'] ?? $this->data['sorting'];
        $data['sortingRaw'] = $data['sortingRaw'] ?? $this->data['sortingRaw'];
        $data['condition_strategy'] = $data['condition_strategy'] ?? $this->data['condition_strategy'];

        $this->data = $data;
    }

    /**
     * Get.
     *
     * @param  string $key
     * @param  string $default
     * @return array|string
     */
    public function get($key = '', $default = '')
    {
        if ($key) {

            if (!isset($this->data[$key])) {
                return $default;
            }

            return $this->data[$key];
        }

        return $this->data;
    }

    /**
     * @return array
     */
    public function getDataForModel(): array
    {
        $className = get_class($this->entity);
        $modelClass = str_replace('Entities', 'Models', $className);

        $nullables = [];
        $relations = [];
        if (class_exists($modelClass)) {
            $model = new $modelClass();
            $nullables = $model->getNullables();
            $relations = $model->getRelationships();
        }

        $properties = $this->entity->getProperties();

        $string = new Strings();

        $data = [];

        foreach ($properties as $prop) {
            $fieldName = $string->fromCamelCaseToUnderscore($prop);

            if (isset($this->data[$fieldName])) {
                $data[$fieldName] = $this->data[$fieldName];

                if (in_array($fieldName, ['created_by', 'updated_at']) && !$this->data[$fieldName]) {
                    unset($data[$fieldName]);
                }
            } else {
                if (in_array($fieldName, $nullables) && !in_array($prop, $relations)) {
                    $data[$fieldName] = null;
                }
            }
        }
        return $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getIP()
    {
        return $this->ip;
    }

    public function getUser()
    {
        return $this->user;
    }

}