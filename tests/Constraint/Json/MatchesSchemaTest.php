<?php

namespace Tests\Pitchart\Phlunit\Constraint\Json;

use Pitchart\Phlunit\Constraint\Json\MatchesSchema;
use PHPUnit\Framework\TestCase;
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
        $this->constraint = new MatchesSchema(['type' => 'object', 'required' => ['name'], 'properties' => ['name' => ['type' => 'string']]]);
    }

    public function test_succeeds_when_sut_is_a_string_matching_provided_format()
    {
        $this->assertTrue($this->constraint->evaluate('{"name": "Batman"}', '', true));
    }

    public function test_succeeds_when_sut_is_an_array_matching_provided_format()
    {
        $this->assertTrue($this->constraint->evaluate(['name' => 'Batman'], '', true));
    }

    public function test_succeeds_when_sut_is_an_object_matching_provided_format()
    {
        $this->assertTrue($this->constraint->evaluate(new Person('Batman'), '', true));
    }

    public function test_succeeds_when_sut_is_is_more_than_provided_format()
    {
        $this->assertTrue($this->constraint->evaluate(['name' => 'Batman', 'city' => 'Gotham City'], '', true));
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
        $json = '{"name":null}';

        $this->assertHasFailingMessage(
            <<<EOF
Failed asserting that '{"name":null}' matches Json Schema {"type":"object","required":["name"],"properties":{"name":{"type":"string"}}}.
[name] NULL value found, but a string is required
EOF
            , $json);
    }

}
