<?php

namespace Tests\Pitchart\Phlunit\Validator;

use PHPUnit\Util\Xml;
use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Constraint\Xml\XmlUtility;
use Pitchart\Phlunit\Validator\ValidationError;
use Pitchart\Phlunit\Validator\XmlSchemaValidator;
use PHPUnit\Framework\TestCase;

class XmlSchemaValidatorTest extends TestCase
{
    /**
     * @var XmlSchemaValidator
     */
    private $validator;

    protected function setUp(): void
    {
        $schema = file_get_contents(TEST_FILES_PATH.'hero.xsd');
        $this->validator = new XmlSchemaValidator($schema);
    }

    public function test_has_errors_when_no_content_is_provided()
    {
        $valid = $this->validator->validate('');

        Check::that($valid)->isFalse();
        Check::that($this->validator->getErrors())->hasLength(1);

        $error = $this->validator->getErrors()[0];
        Check::that($error)->isAnInstanceOf(ValidationError::class);
        Check::that($error->getMessage())->isEqualTo("Provided content is not valid XML.");
    }

    public function test_has_errors_when_no_xml_is_provided()
    {
        $valid = $this->validator->validate('not an xml string');

        Check::that($valid)->isFalse();
        Check::that($this->validator->getErrors())->hasLength(1);

        $error = $this->validator->getErrors()[0];
        Check::that($error)->isAnInstanceOf(ValidationError::class);
        Check::that($error->getMessage())->isEqualTo("Provided content is not valid XML.");
    }

    public function test_has_errors_when_xml_not_matching_schema_is_provided()
    {
        $valid = $this->validator->validate(TEST_FILES_PATH.'jocker.xml');

        Check::that($valid)->isFalse();
        Check::that($this->validator->getErrors())->hasLength(1);

        $error = $this->validator->getErrors()[0];
        Check::that($error)->isAnInstanceOf(ValidationError::class);
        Check::that($error->getMessage())->isEqualTo("Element 'enemy': This element is not expected.");
    }

    /**
     * @param $xml
     * @dataProvider validXmlProvider
     */
    public function test_validates_xml_against_schema($xml)
    {
        Check::that($this->validator->validate($xml))->isTrue();
    }

    public function validXmlProvider()
    {
        $batman = file_get_contents(TEST_FILES_PATH.'batman.xml');
        $xml = XmlUtility::load($batman);
        yield from [
            'string xml' => [$batman],
            '\DOMDocument xml' => [$xml],
            'xml file path' => [TEST_FILES_PATH.'batman.xml'],
        ];
    }

    /**
     * @param $schema
     * @dataProvider  validSchemaProvider
     */
    public function test_is_built_from_schema($schema)
    {
        $validator = new XmlSchemaValidator($schema);
        $xml = XmlUtility::load(file_get_contents(TEST_FILES_PATH.'batman.xml'));
        Check::that($validator->validate($xml))->isTrue();
    }

    public function validSchemaProvider()
    {
        $heroPath = TEST_FILES_PATH.'hero.xsd';
        $hero = file_get_contents($heroPath);
        $heroDocument = XmlUtility::load($hero);
        yield from [
            'a schema file path' => [$heroPath],
            'a schema string' => [$hero],
            'a \DOMDocument schema ' => [$heroDocument],
        ];
    }

}
