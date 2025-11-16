<?php
declare(strict_types=1);

namespace Core\Factories;

use Core\Contracts\Collection\Collection;
use Core\Contracts\Entity\Entity;
use Core\Contracts\Factory\FactoryContract;
use Core\Exceptions\ValidationException;
use Core\Helpers\Strings;

abstract class AbstractFactory implements FactoryContract
{
    /**
     * entityInstance.
     *
     * @var Entity
     */
    protected $entityInstance;

    /**
     * ignoreClassCreation.
     *
     * @var array
     */
    protected $ignoreClassCreation = ['aggregateType'];

    /**
     * defaultAnnotations.
     *
     * @var array
     */
    protected $defaultAnnotations = ['collection', 'factory', 'aggregateType'];

    /**
     * create.
     *
     * @param  array $data
     * @return Entity
     * @throws \ReflectionException
     */
    public function create(array $data): Entity
    {
        $this->entityInstance = clone $this->entityInstance;
        $properties = $this->getProperties();

        foreach ($data as $key => $value) {
            $key = str_replace('_', '', ucwords($key, '_'));
            $setterMethod = 'set' . $key;

            if (isset($properties[lcfirst($key)])) {
                $classes = $properties[lcfirst($key)];
                if (!isset($classes['aggregateType'])) {
                    $classes['aggregateType'] = 'collection';
                }

                if (!is_array($value) || empty($value)) {
                    $value = null;
                }

                if (!empty($value)) {
                    $value = $classes['aggregateType'] === 'entity' ?
                        $this->setAggreateValueAsEntity($classes, $value):
                        $this->setAggreateValueAsCollection($classes, $value);
                }
            }
            $this->entityInstance->{$setterMethod}($value);
        }

        $returnData = $this->entityInstance;
        $this->entityInstance = new $this->entityInstance(new Strings());

        return $returnData;
    }

    /**
     * set Aggreate Value As Collection.
     *
     * @param  array $classes
     * @param  array $value
     * @return Collection
     */
    public function setAggreateValueAsCollection(array $classes, array $value): Collection
    {
        foreach ($value as $row){
            $classes['collection']->addEntity($classes['factory']->create($row));
        }

        return $classes['collection'];
    }

    /**
     * Set Aggreate Value As Entity.
     *
     * @param  array $classes
     * @param  array $value
     * @return Entity
     */
    public function setAggreateValueAsEntity(array $classes, array $value): Entity
    {
        $classes['collection']->addEntity($classes['factory']->create($value));
        return $classes['collection']->getEntities()[0];
    }

    /**
     * getProperties.
     *
     * @return array
     * @throws \ReflectionException
     */
    public function getProperties(): array
    {
        $properties = new \ReflectionClass(get_class($this->entityInstance));
        $properties = $properties->getProperties();
        $formatedProperties = [];

        foreach ($properties as $property){

            preg_match_all('#@(.*?)\n#s', $property->getDocComment(), $annotations);
            foreach ($annotations[1] as $key =>$annotation){
                $classes = $this->handleAnnotations($annotation, $property);

                if (!empty($classes)) {
                    $formatedProperties[$property->name] = isset($formatedProperties[$property->name]) ? $formatedProperties[$property->name] : [];

                    $formatedProperties[$property->name] = array_merge($formatedProperties[$property->name], $classes);
                }
            }
        }

        return $formatedProperties;
    }

    /**
     * handleAnnotations.
     *
     * @param  $annotation
     * @return array
     */
    protected function handleAnnotations($annotation): array
    {
        $formatedProperties =[];

        foreach ($this->defaultAnnotations as $defaultAnnotation) {
            if (strpos($annotation, $defaultAnnotation) !== false) {
                $class = trim(str_replace($defaultAnnotation, '', $annotation));

                if (class_exists($class)) {
                    $formatedProperties[$defaultAnnotation] = app($class);
                }else{
                    $formatedProperties[$defaultAnnotation] = explode(' ', trim($annotation))[1];
                }
            }
        }
        return $formatedProperties;
    }
}