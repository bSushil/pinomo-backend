<?php

namespace Core\Packages\QueryBuilder;

use Core\Models\AbstractModel;
use Core\Exceptions\QueryBuilderItemNotFoundException;
use Core\Exceptions\ValidationException;
use Illuminate\Support\Facades\Validator;

/**
 * Query Builder Contract
 *
 * Class QueryBuilderContract
 *
 * @package ${NAMESPACE}
 */
class QueryBuilder implements QueryBuilderContract
{
    /**
     * method.
     *
     * @var string
     */
    protected $method;

    /**
     * validator.
     *
     * @var Validator
     */
    protected $validator;

    /**
     * operator.
     *
     * @var string
     */
    protected $operator;

    /**
     * name.
     *
     * @var
     */
    protected $name;

    /**
     * Roles.
     *
     * @var
     */
    protected $roles = [];

    /**
     * Data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * queryBuilderClasses.
     *
     * @var array
     */
    protected $queryBuilderClasses = [
        'equal' => EqualOperation::class,
        'not_equal' => NotEqualOperation::class,
        'like' => LikeOperation::class,
        'rlike' => RLikeOperation::class,
        'gte' => GreaterEqualOperation::class,
        'lte' => LessEqualOperation::class,
        'date_between' => DateBetweenOperation::class,
        'or_equal' => OrEqualOperation::class,
        'or_like' => OrLikeOperation::class,
        'or_rlike' => OrRLikeOperation::class,
        'concat_column_like' => ConcatColumnLikeOperation::class,
        'concat_column_rlike' => ConcatColumnRLikeOperation::class,
        'in' => InOperation::class,
        'not_in' => NotInOperation::class,
    ];

    /**
     * QueryBuilder constructor.
     *
     * @param Validator $validator
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * validate.
     *
     * @param  AbstractModel $model
     * @param  array         $condition
     * @param  array         $columns
     * @param  $value
     * @return mixed|void
     * @throws ValidationException
     */
    public function validate(AbstractModel $model, array $condition, array $columns, $value)
    {
        if (!in_array($condition[0], $columns)) {
            throw new ValidationException(['One or more columns of "Conditions" not exists']);
        }
    }

    /**
     * getMethod.
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * getOperator.
     *
     * @return string
     */
    public function getOperator(): string
    {
        return $this->operator;
    }

    /**
     * Get Name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * data.
     *
     * @param  array $data
     * @return array
     */
    public function data(array $data): array
    {
        $this->data = $data;

        return $this->data;
    }

    /**
     * Get Roles.
     *
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * get.
     *
     * @param  string $operator
     * @return QueryBuilderContract
     * @throws QueryBuilderItemNotFoundException
     */
    public function get(string $operator): QueryBuilderContract
    {
        if (isset($this->queryBuilderClasses[$operator]) && class_exists($this->queryBuilderClasses[$operator])) {
            return app($this->queryBuilderClasses[$operator]);
        }

        throw new QueryBuilderItemNotFoundException('The operator "' . $operator . '" isn\'t supported');
    }

    /**
     * Get Parameters.
     *
     * @param  string $column
     * @param  $value
     * @return array
     */
    public function getParameters(string $column, $value): array
    {
        $v = $value;

        if (is_string($v) && strtolower($v) === 'null') {
            $v = null;
        }

        return [$column, $this->operator, $v];
    }
}
