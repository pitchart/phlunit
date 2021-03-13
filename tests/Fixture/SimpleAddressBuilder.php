<?php


namespace Tests\Pitchart\Phlunit\Fixture;


use Pitchart\Phlunit\Builder;

class SimpleAddressBuilder extends Builder
{
    protected function __construct(array $arguments)
    {
        parent::__construct(Address::class, $arguments, 'simple');
    }


    public static function create()
    {
        return new self([
            'Batman', 'On top of the hill', '53540', 'Gotham City'
        ]);
    }

    public function build(): Address
    {
        return $this->buildInstance();
    }

}