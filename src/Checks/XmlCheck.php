<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks;

use PHPUnit\Framework\Assert;
use Pitchart\Phlunit\Checks\Mixin\TypeCheck;
use Pitchart\Phlunit\Checks\Mixin\WithMessage;
use Pitchart\Phlunit\Constraint\Xml\MatchesSchema;
use Pitchart\Phlunit\Constraint\Xml\XmlUtility;

class XmlCheck implements FluentCheck
{
    use TypeCheck, WithMessage;

    /**
     * @var \DOMDocument
     */
    private $value;

    /**
     * XmlCheck constructor.
     *
     * @param string|\DOMDocument $value
     */
    public function __construct($value)
    {
        $this->value = XmlUtility::load($value);
    }

    public function isEqualTo($expected): self
    {
        Assert::assertXmlStringEqualsXmlString($expected, $this->value, $this->message);
        return $this;
    }

    public function isNotEqualTo($expected): self
    {
        Assert::assertXmlStringNotEqualsXmlString($expected, $this->value, $this->message);
        return $this;
    }

    public function isEqualToFileContent(string $path): self
    {
        Assert::assertXmlStringEqualsXmlFile($path, $this->value, $this->message);
        return $this;
    }

    public function isNotEqualToFileContent(string $path): self
    {
        Assert::assertXmlStringNotEqualsXmlFile($path, $this->value, $this->message);
        return $this;
    }

    public function matchesSchema(string $schema): self
    {
        Assert::assertThat($this->value, new MatchesSchema($schema), $this->message);
        return $this;
    }
}
