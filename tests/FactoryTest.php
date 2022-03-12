<?php

namespace SymphonyFactory\Tests;

use EntityFactory\Factory\AbstractFactory;
use EntityFactory\Traits\ArrayTrait;
use EntityFactory\Traits\FillableTrait;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    public function test_should_factory_make()
    {
        $factory = new StubFactory();
        $result = $factory->count(2)->make();
        $this->assertCount(2, $result);
    }

    public function test_should_factory_make_one()
    {
        $factory = new StubFactory();
        $result = $factory->makeOne();
        $this->assertNotEmpty($result->getName());
        $this->assertNotEmpty($result->getBirthdate());
    }
}

class StubFactory extends AbstractFactory {
    protected $entity = Person::class;

    public function define(): array
    {
        return [
            'name' => $this->faker->name,
            'birthdate' => $this->faker->date()
        ];
    }
}

class Person
{
    use ArrayTrait;
    use FillableTrait;

    private $name;
    private $birthdate;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param mixed $birthdate
     */
    public function setBirthdate($birthdate): void
    {
        $this->birthdate = $birthdate;
    }
}
