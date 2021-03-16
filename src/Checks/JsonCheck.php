<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;
use Pitchart\Phlunit\Checks\Mixin\ConstraintCheck;
use Pitchart\Phlunit\Checks\Mixin\FluentChecks;
use Pitchart\Phlunit\Checks\Mixin\TypeCheck;
use Pitchart\Phlunit\Checks\Mixin\WithMessage;
use Pitchart\Phlunit\Constraint\Json\MatchesSchema;

/**
 * Class JsonCheck
 *
 * @package Pitchart\Phlunit\Checks
 *
 * @author Julien VITTE <julien.vitte@insidegroup.fr>
 *
 * @implements FluentCheck<string>
 */
class JsonCheck implements FluentCheck
{
    use WithMessage, ConstraintCheck, TypeCheck, FluentChecks;

    /**
     * @var string
     */
    private $value;

    /**
     * JsonCheck constructor.
     *
     * @param $value
     */
    public function __construct(string $value)
    {
        Assert::assertJson($value);
        $this->value = $value;
    }

    public function isEqualTo(string $expected): self
    {
        Assert::assertJsonStringEqualsJsonString($expected, $this->value, $this->message);
        return $this;
    }

    public function isNotEqualTo(string $expected): self
    {
        Assert::assertJsonStringNotEqualsJsonString($expected, $this->value, $this->message);
        return $this;
    }

    public function isEqualToFileContent(string $path): self
    {
        Assert::assertJsonStringEqualsJsonFile($path, $this->value, $this->message);
        return $this;
    }

    public function isNotEqualToFileContent(string $path): self
    {
        Assert::assertJsonStringNotEqualsJsonFile($path, $this->value, $this->message);
        return $this;
    }

    /**
     * @param string|array|object $schema
     *
     * @return JsonCheck
     */
    public function matchesSchema($schema): self
    {
        Assert::assertThat($this->value, new MatchesSchema($schema), $this->message);
        return $this;
    }
}
