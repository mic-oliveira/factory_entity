<?php

namespace EntityFactory\Traits;

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
            $this->$setter($value);
        }
        return $this;
    }
}
