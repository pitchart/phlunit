<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Constraint\Arrays;

use PHPUnit\Framework\Constraint\Constraint;

final class ContainsSet extends Constraint
{
    /**
     * @var iterable
     */
    private $set;

    public function __construct(iterable $subset)
    {
        $this->set = $subset;
    }

    public function evaluate($other, string $description = '', bool $returnResult = false)
    {
        //type cast $other & $this->subset as an array to allow
        //support in standard array functions.
        $other        = ArrayUtility::toArray($other);
        $this->set = ArrayUtility::toArray($this->set);

        if (ArrayUtility::isAssociative($other)) {
            $result = \array_diff_assoc($this->set, $other) === [];
        } else {
            $result = \array_diff($this->set, $other) === [];
        }

        if (!$returnResult && !$result) {
            $this->fail($other, $description);
        }

        return $result;
    }

    public function toString(): string
    {
        return ' contains the subset ' . $this->exporter()->export($this->set);
    }

    protected function failureDescription($other): string
    {
        return $this->exporter()->export($other) . $this->toString();
    }
}
