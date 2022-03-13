<?php

namespace EntityFactory\Traits;

use EntityFactory\Factory\AbstractFactory;
use Exception;

trait FillableTrait
{
    /**
     * @throws Exception
     */
    public function fill(array $attributes)
    {
        $class = new \ReflectionClass($this);
        foreach ($attributes as $key => $value) {
            $setter = sprintf('set%s', ucfirst($key));
            if(!array_key_exists($key, $class->getDefaultProperties())) {
                throw new Exception('Property not found in class.');
            }
            class_parents(AbstractFactory::class) ? $this->$setter($value->make()) : $this->$setter($value);
        }
        return $this;
    }
}
