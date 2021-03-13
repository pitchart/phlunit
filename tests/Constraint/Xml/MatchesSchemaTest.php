<?php

namespace Tests\Pitchart\Phlunit\Constraint\Xml;

use PHPUnit\Util\Xml;
use Pitchart\Phlunit\Constraint\Xml\MatchesSchema;
use Pitchart\Phlunit\Constraint\Xml\XmlUtility;
use Tests\Pitchart\Phlunit\Constraint\ConstraintTestCase;
use Tests\Pitchart\Phlunit\Fixture\Person;

class MatchesSchemaTest extends ConstraintTestCase
{
    /**
     * @var MatchesSchema
     */
    protected $constraint;

    public function setUp(): void
    {
        $schema = file_get_contents(TEST_FILES_PATH.'hero.xsd');
        $this->constraint = new MatchesSchema($schema);
    }

    public function test_succeeds_when_sut_is_a_string_matching_provided_format()
    {
        $batman = file_get_contents(TEST_FILES_PATH.'batman.xml');
        $this->assertTrue($this->constraint->evaluate($batman, '', true));
    }

    public function test_succeeds_when_sut_is_a_file_matching_provided_format()
    {
        $this->assertTrue($this->constraint->evaluate(TEST_FILES_PATH.'batman.xml', '', true));
    }

    public function test_succeeds_when_sut_is_a_DOMDocument_matching_provided_format()
    {

        $this->assertTrue($this->constraint->evaluate(XmlUtility::loadFile(TEST_FILES_PATH.'batman.xml'), '', true));
    }

    public function test_fails_when_sut_is_more_than_provided_format()
    {
        $this->assertFalse($this->constraint->evaluate(['name' => 'Batman', 'city' => 'Gotham City'], '', true));
    }

    public function test_fails_when_sut_has_a_property_missing()
    {
        $this->assertFalse($this->constraint->evaluate(['lastname' => 'Batman'], '', true));
    }

    public function test_fails_when_sut_do_not_respect_format()
    {
        $this->assertFalse($this->constraint->evaluate(['name' => null], '', true));
    }

    public function test_fails_with_a_clear_and_complete_error_message()
    {
        $xml = file_get_contents(TEST_FILES_PATH.'jocker.xml');

        $this->assertHasFailingMessage(
            <<<EOF
Failed asserting that '<?xml version="1.0" encoding="UTF-8"?>\\n
<hero><name>Jocker</name><city>Gotham City</city><enemy>Bruce Wayne</enemy><level>10</level></hero>\\n
' matches xsd schema <?xml version="1.0"?>
<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema" elementFormDefault="qualified"><xs:element name="hero"><xs:complexType><xs:all><xs:element name="name" type="xs:string" minOccurs="1" maxOccurs="1" nillable="false"/><xs:element name="city" type="xs:string" minOccurs="1" maxOccurs="1"/><xs:element name="level" type="xs:integer" minOccurs="0" maxOccurs="1"/><xs:element name="realName" type="xs:string" minOccurs="0" maxOccurs="1"/></xs:all></xs:complexType></xs:element></xs:schema>
 because:
Element 'enemy': This element is not expected..
EOF
            , $xml);
    }

}
