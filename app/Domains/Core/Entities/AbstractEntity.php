<?php
declare(strict_types=1);

namespace Core\Entities;

use Core\Contracts\Collection\Collection;
use Core\Contracts\Entity\Entity;
use Core\Helpers\Strings;

abstract class AbstractEntity implements Entity
{
    /**
     * Ignore Properties.
     *
     * @var
     */
    protected $ignoreProperties = ['helper', 'ignoreProperties'];
    
    /**
     * Helper.
     *
     * @var Strings
     */
    private $helper;
    
    /**
     * AbstractEntity constructor.
     *
     * @param Strings $strings
     */
    public function __construct(Strings $strings)
    {
        $this->helper = $strings;
    }

    /**
     * toArray.
     *
     * @return array
     */
    public function toArray(): array
    {
        $properties = get_object_vars($this);

        $data = [];

        foreach ($properties as $property => $value) {

            if (in_array($property, $this->ignoreProperties)) {
                continue;
            }

            $property = $this->helper->fromCamelCaseToUnderscore($property);

            switch (is_object($value)){

            case true:
                $data[$property] = ($value instanceof Collection) ? $value->toArray()['entities'] : $value->toArray();
                break;
            default:
                $data[$property] = $value;
                break;

            }


        }

        return $data;
    }

    /**
     * getProperties.
     *
     * @return array
     */
    public function getProperties(): array
    {
        $properties = get_object_vars($this);

        unset($properties['ignoreProperties']);
        unset($properties['helper']);

        return array_keys($properties);
    }

    /**
     * ___call.
     *
     * @param  $name
     * @param  $arguments
     * @return $this
     */
    public function __call($name, $arguments)
    {
        $property = lcfirst(substr($name, 3));

        $objProperties = array_keys(get_object_vars($this));

        if (in_array($property, $objProperties)) {

            if (strpos($name, 'get') !== false) {
                return $this->{$property};
            }

            if (strpos($name, 'set') !== false) {
                $this->{$property} = $arguments[0];
                return $this;
            }
        }
        return $this;
    }

}