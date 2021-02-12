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

    function jsonSerialize()
    {
        return ['name' => $this->name];
    }


}