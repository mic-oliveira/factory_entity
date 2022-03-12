<?php

namespace EntityFactory\Factory;


use Faker\Factory;

abstract class AbstractFactory
{
    private $count;
    protected $faker;
    protected $entity;

    public function __construct()
    {
        $this->count = 1;
        $this->faker = Factory::create();
    }

    public function count(?int $count = 1): AbstractFactory
    {
        $this->count = $count;
        return $this;
    }

    public function make(): array
    {
        $collect = [];
        for($i = 0; $i < $this->count; $i++) {
            $collect[] = $this->makeOne();
        }
        return $collect;
    }

    public function makeOne()
    {
        return (new $this->entity)->fill($this->define());
    }

    public function create()
    {

    }

    abstract public function define();
}
