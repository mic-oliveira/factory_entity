<?php

namespace SymphonyFactory\Tests;

use EntityFactory\Factory\AbstractFactory;
use EntityFactory\Interfaces\FactoryInterface;
use EntityFactory\Traits\ArrayTrait;
use EntityFactory\Traits\FillableTrait;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    public function test_should_factory_make()
    {
        $factory = new PersonFactory();
        $result = $factory->count(2)->make();
        $this->assertCount(2, $result);
    }

    public function test_should_factory_make_one()
    {
        $factory = new PersonFactory();
        $result = $factory->makeOne();
        $this->assertNotEmpty($result->getName());
        $this->assertNotEmpty($result->getBirthdate());
    }

    public function test_should_create_children_factory()
    {
        $factory = new LegalPersonFactory();
        $result = $factory->makeOne();
        $this->assertNotEmpty($result->getDocument());
        $this->assertInstanceOf(Person::class, $result->getPerson());
    }
}

class PersonFactory extends AbstractFactory {
    protected $entity = Person::class;

    protected function define(): array
    {
        return [
            'name' => $this->faker->name,
            'birthdate' => $this->faker->date()
        ];
    }
}

class LegalPersonFactory extends AbstractFactory {
    protected $entity = LegalPerson::class;

    protected function define()
    {
        return [
            'document' => $this->faker->numerify('###.###.###-##'),
            'person' => (new PersonFactory())->makeOne(),
        ];
    }


}

class Person implements FactoryInterface
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

class LegalPerson implements FactoryInterface{
    use ArrayTrait;
    use FillableTrait;

    private $document;
    private $person;


    /**
     * @return mixed
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param mixed $document
     */
    public function setDocument($document): void
    {
        $this->document = $document;
    }

    /**
     * @return mixed
     */
    public function getPerson(): Person
    {
        return $this->person;
    }

    /**
     * @param mixed $person
     */
    public function setPerson(Person $person): void
    {
        $this->person = $person;
    }

}
