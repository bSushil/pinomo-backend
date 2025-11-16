<?php
namespace Core\Packages\ConditionStrategy;


/**
 * Query Builder Contract
 *
 * Class QueryBuilderContract
 *
 * @package ${NAMESPACE}
 */
class WithStrategy extends ConditionStrategy
{
    /**
     * method.
     *
     * @var string
     */
    protected $method = 'with';

    /**
     * name.
     *
     * @var string
     */
    protected $name = 'with';
}
