<?php
namespace Main\Traits;

trait ConnectionATrait
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->connection = getConnectionName('mysql_a');
        $this->table = getDatabaseName('mysql_a') . $this->getTable();
    }
}