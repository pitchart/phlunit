<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Constraint\LogicalNot;
use Pitchart\Phlunit\Checks\Converter\ToDateTime;
use Pitchart\Phlunit\Checks\Converter\ToInteger;
use Pitchart\Phlunit\Checks\Mixin\TypeCheck;
use Pitchart\Phlunit\Constraint\String\EndsWith;
use Pitchart\Phlunit\Constraint\String\IsBlank;
use Pitchart\Phlunit\Constraint\String\IsDigits;
use Pitchart\Phlunit\Constraint\String\IsHexadecimal;
use Pitchart\Phlunit\Constraint\String\IsLetters;
use Pitchart\Phlunit\Constraint\String\StartsWith;

class StringCheck implements FluentCheck
{
    use TypeCheck, ToDateTime, ToInteger;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var bool
     */
    private $ignoreCase = false;

    /**
     * GenericCheck constructor.
     *
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function isEqualTo(string $expected, string $message = ''): self
    {
        if ($this->ignoreCase) {
            Assert::assertEqualsIgnoringCase($expected, $this->value, $message);
        } else {
            Assert::assertSame($expected, $this->value, $message);
        }
        return $this;
    }

    public function isNotEqualTo(string $expected, string $message = ''): self
    {
        Assert::assertNotEquals($expected, $this->value, $message, 0.0, 10, false, $this->ignoreCase);
        return $this;
    }

    public function isEmpty(string $message = ''): self
    {
        Assert::assertEmpty($this->value, $message);
        return $this;
    }

    public function isNotEmpty(string $message = ''): self
    {
        Assert::assertNotEmpty($this->value, $message);
        return $this;
    }

    public function isBlank(string $message = ''): self
    {
        Assert::assertThat($this->value, new IsBlank(), $message);
        return $this;
    }

    public function isNotBlank(string $message = ''): self
    {
        Assert::assertThat($this->value, new LogicalNot(new IsBlank()), $message);
        return $this;
    }

    public function isGreaterThan(string $expected, string $message = ''): self
    {
        Assert::assertGreaterThan($expected, $this->value, $message);
        return $this;
    }

    public function isGreaterThanOrEqualTo(string $expected, string $message = ''): self
    {
        Assert::assertGreaterThanOrEqual($expected, $this->value, $message);
        return $this;
    }

    public function isLessThan(string $expected, string $message = ''): self
    {
        Assert::assertLessThan($expected, $this->value, $message);
        return $this;
    }

    public function isLessThanOrEqualTo(string $expected, string $message = ''): self
    {
        Assert::assertLessThanOrEqual($expected, $this->value, $message);
        return $this;
    }

    public function contains(string $expected, string $message = ''): self
    {
        if ($this->ignoreCase) {
            Assert::assertStringContainsStringIgnoringCase($expected, $this->value, $message);
        } else {
            Assert::assertStringContainsString($expected, $this->value, $message);
        }

        return $this;
    }

    public function startsWith(string $expected, string $message = ''): self
    {
        if ($this->ignoreCase) {
            Assert::assertThat($this->value, new StartsWith($expected), $message);
        } else {
            Assert::assertStringStartsWith($expected, $this->value, $message);
        }
        return $this;
    }

    public function endsWith(string $expected, string $message = ''): self
    {
        if ($this->ignoreCase) {
            Assert::assertThat($this->value, new EndsWith($expected), $message);
        } else {
            Assert::assertStringEndsWith($expected, $this->value, $message);
        }
        return $this;
    }

    public function isDigits(string $message = ''): self
    {
        Assert::assertThat($this->value, new IsDigits(), $message);
        return $this;
    }

    public function isLetters(string $message = ''): self
    {
        Assert::assertThat($this->value, new IsLetters(), $message);
        return $this;
    }

    public function isWhitespaces(string $message = ''): self
    {
        return $this->isBlank($message);
    }

    public function isHexadecimal(string $message = ''): self
    {
        Assert::assertThat($this->value, new IsHexadecimal(), $message);
        return $this;
    }

    public function matches(string $pattern, string $message = ''): self
    {
        Assert::assertRegExp($pattern, $this->value, $message);
        return $this;
    }

    public function ignoringCase(): self
    {
        $this->ignoreCase = true;
        return $this;
    }

    public function respectingCase(): self
    {
        $this->ignoreCase = false;
        return $this;
    }
}
