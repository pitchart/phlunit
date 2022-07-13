<?php


namespace Tests\Pitchart\Phlunit\Fixture;

class Person implements \JsonSerializable
{
    private $name;

    /**
     * Person constructor.
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }


    public function jsonSerialize(): mixed
    {
        return ['name' => $this->name];
    }
}