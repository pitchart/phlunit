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
            'recipient' => 'Batman',
            'line1' => 'On top of the hill',
            'city' => 'Gotham City',
            'zip' => '53540',
        ]);
    }

    public function build(): Address
    {
        return $this->buildInstance();
    }

}