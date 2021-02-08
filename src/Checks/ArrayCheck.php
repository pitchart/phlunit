<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;

class ArrayCheck extends CollectionCheck
{
    public function __construct(array $collection)
    {
        parent::__construct($collection);
    }

    public function hasElementAt($expected): self
    {
        Assert::assertArrayHasKey($expected, $this->value, $this->message);
        return $this;
    }

    public function hasNoElementAt($expected): self
    {
        Assert::assertArrayNotHasKey($expected, $this->value, $this->message);
        return $this;
    }
}
