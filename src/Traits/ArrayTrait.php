<?php

namespace EntityFactory\Traits;

trait ArrayTrait
{
    public function toArray(): array
    {
        $class = new \ReflectionClass($this);
        $properties = [];
        foreach ($class->getDefaultProperties() as $key => $property) {
            $getter = sprintf('get%s', ucfirst($key));
            $properties[$key] = $this->$getter();
        }
        return $properties;
    }
}
