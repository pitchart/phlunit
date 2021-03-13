<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Validator;

use Pitchart\Phlunit\Constraint\Xml\XmlUtility;
use function Pitchart\Transformer\transform;

class XmlSchemaValidator
{
    /**
     * @var array|ValidationError[]
     * @psalm-var array<ValidationError>
     */
    private $errors = [];

    /**
     * @var \DOMDocument
     */
    private $schema;

    /**
     * XmlSchemaValidator constructor.
     *
     * @param string|\DOMDocument $schema
     */
    public function __construct($schema)
    {
        $this->schema = $this->asDomdocument($schema);
    }

    /**
     * @return ValidationError[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param string|\DOMDocument $xml
     *
     * @return bool
     */
    public function validate($xml): bool
    {
        try {
            $xml = $this->asDomDocument($xml);
        } catch (\Exception $e) {
            $this->errors[] = ValidationError::emptyXml();
            return false;
        }

        $internalErrors = \libxml_use_internal_errors(true);
        \libxml_clear_errors();

        $e = null;

        $valid = $xml->schemaValidateSource($this->schema->saveXML());

        if (!$valid) {
            $this->errors  = $this->convertXmlErrors();
        }

        \libxml_clear_errors();
        \libxml_use_internal_errors($internalErrors);

        return $valid;
    }

    private function convertXmlErrors(): array
    {
        return transform(\libxml_get_errors())
            ->map(function(\LibXMLError $error): ValidationError {
                return ValidationError::fromLibXmlError($error);
            })->toArray();
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
        return  XmlUtility::load($schema);
    }
}
