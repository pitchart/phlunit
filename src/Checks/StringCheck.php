<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Constraint\LogicalNot;
use Pitchart\Phlunit\Checks\Converter\ToDateTime;
use Pitchart\Phlunit\Checks\Converter\ToInteger;
use Pitchart\Phlunit\Checks\Converter\ToJson;
use Pitchart\Phlunit\Checks\Converter\ToXml;
use Pitchart\Phlunit\Checks\Mixin\ConstraintCheck;
use Pitchart\Phlunit\Checks\Mixin\FluentChecks;
use Pitchart\Phlunit\Checks\Mixin\TypeCheck;
use Pitchart\Phlunit\Checks\Mixin\WithMessage;
use Pitchart\Phlunit\Constraint\String\EndsWith;
use Pitchart\Phlunit\Constraint\String\IsBlank;
use Pitchart\Phlunit\Constraint\String\IsDigits;
use Pitchart\Phlunit\Constraint\String\IsHexadecimal;
use Pitchart\Phlunit\Constraint\String\IsLetters;
use Pitchart\Phlunit\Constraint\String\StartsWith;

/**
 * Class StringCheck
 *
 * @package Pitchart\Phlunit\Checks
 *
 * @author Julien VITTE <julien.vitte@insidegroup.fr>
 *
 * @template-implements FluentCheck<string>
 */
class StringCheck implements FluentCheck
{
    use TypeCheck, FluentChecks, WithMessage, ConstraintCheck,
        ToDateTime, ToInteger, ToJson, ToXml;

    /**
     * @var string
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
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function isEqualTo(string $expected): self
    {
        if ($this->ignoreCase) {
            Assert::assertEqualsIgnoringCase($expected, $this->value, $this->message);
        } else {
            Assert::assertSame($expected, $this->value, $this->message);
        }
        $this->resetMessage();
        return $this;
    }

    public function isNotEqualTo(string $expected): self
    {
        if ($this->ignoreCase) {
            Assert::assertNotEqualsIgnoringCase($expected, $this->value, $this->message);
        } else {
            Assert::assertNotEquals($expected, $this->value, $this->message);
        }
        $this->resetMessage();
        return $this;
    }

    public function isEmpty(): self
    {
        Assert::assertEmpty($this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isNotEmpty(): self
    {
        Assert::assertNotEmpty($this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isBlank(): self
    {
        Assert::assertThat($this->value, new IsBlank(), $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isNotBlank(): self
    {
        Assert::assertThat($this->value, new LogicalNot(new IsBlank()), $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isGreaterThan(string $expected): self
    {
        Assert::assertGreaterThan($expected, $this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isGreaterThanOrEqualTo(string $expected): self
    {
        Assert::assertGreaterThanOrEqual($expected, $this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isLessThan(string $expected): self
    {
        Assert::assertLessThan($expected, $this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isLessThanOrEqualTo(string $expected): self
    {
        Assert::assertLessThanOrEqual($expected, $this->value, $this->message);
        $this->resetMessage();
        return $this;
    }

    public function contains(string $expected): self
    {
        if ($this->ignoreCase) {
            Assert::assertStringContainsStringIgnoringCase($expected, $this->value, $this->message);
        } else {
            Assert::assertStringContainsString($expected, $this->value, $this->message);
        }
        $this->resetMessage();
        return $this;
    }

    public function startsWith(string $expected): self
    {
        if ($this->ignoreCase) {
            Assert::assertThat($this->value, new StartsWith($expected), $this->message);
        } else {
            Assert::assertStringStartsWith($expected, $this->value, $this->message);
        }
        $this->resetMessage();
        return $this;
    }

    public function endsWith(string $expected): self
    {
        if ($this->ignoreCase) {
            Assert::assertThat($this->value, new EndsWith($expected), $this->message);
        } else {
            Assert::assertStringEndsWith($expected, $this->value, $this->message);
        }
        $this->resetMessage();
        return $this;
    }

    public function isDigits(): self
    {
        Assert::assertThat($this->value, new IsDigits(), $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isLetters(): self
    {
        Assert::assertThat($this->value, new IsLetters(), $this->message);
        $this->resetMessage();
        return $this;
    }

    public function isWhitespaces(): self
    {
        return $this->isBlank();
    }

    public function isHexadecimal(): self
    {
        Assert::assertThat($this->value, new IsHexadecimal(), $this->message);
        $this->resetMessage();
        return $this;
    }

    public function matches(string $pattern): self
    {
        Assert::assertRegExp($pattern, $this->value, $this->message);
        $this->resetMessage();
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
