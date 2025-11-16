<?php

namespace Core\Packages\QueryBuilder;


/**
 * Query Builder Contract
 *
 * Class QueryBuilderContract
 *
 * @package ${NAMESPACE}
 */
class OrRLikeOperation extends RLikeOperation
{
    /**
     * method.
     *
     * @var string
     */
    protected $method = 'orWhere';

    /**
     * name.
     *
     * @var string
     */
    protected $name = 'or_rlike';
}
