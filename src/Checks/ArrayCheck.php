<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;

class ArrayCheck extends CollectionCheck
{
    public function __construct(array $collection)
    {
        parent::__construct($collection);
    }

    public function hasElementAt($expected, $message = ''): self
    {
        Assert::assertArrayHasKey($expected, $this->value, $message);
        return $this;
    }

    public function hasNoElementAt($expected, $message = ''): self
    {
        Assert::assertArrayNotHasKey($expected, $this->value, $message);
        return $this;
    }
}
