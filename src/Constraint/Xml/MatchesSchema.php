<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Constraint\Xml;

use LSS\Array2XML;
use PHPUnit\Framework\Constraint\Constraint;
use Pitchart\Phlunit\Validator\ValidationError;
use Pitchart\Phlunit\Validator\XmlSchemaValidator;

class MatchesSchema extends Constraint
{
    /**
     * @var \DOMDocument
     */
    private $xsd;

    /**
     * @var XmlSchemaValidator
     */
    private $validator;

    /**
     * MatchesSchema constructor.
     *
     * @param string|\DOMDocument $xsd
     */
    public function __construct($xsd)
    {
        $this->xsd = $this->asDomDocument($xsd);
        $this->validator = new XmlSchemaValidator($xsd);
    }

    protected function matches($other): bool
    {
        return $this->validator->validate($this->asDomDocument($other));
    }

    /**
     * @param string|\DOMDocument $schema
     *
     * @return \DOMDocument
     */
    private function asDomDocument($schema): \DOMDocument
    {
        if (\is_string($schema) && \file_exists($schema) && \is_file($schema)) {
            return XmlUtility::loadFile($schema);
        }
        if (\is_array($schema)) {
            $schema = Array2XML::createXML('root', $schema);
        }
        return  XmlUtility::load($schema);
    }

    public function toString(): string
    {
        return 'matches xsd schema ' . $this->xsd->saveXML() . " because:\n"
            . \implode("\n", \array_map(function(ValidationError $error) {
                return $error->getMessage();
            }, $this->validator->getErrors()));
    }

    protected function failureDescription($other): string
    {
        $other = $this->exporter()->export($this->asDomDocument($other)->saveXML());
        $other = \preg_replace("/\n+/", "\n", $other);
        return  $other . ' ' . $this->toString();
    }
}
