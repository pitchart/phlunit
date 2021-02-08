<?php

namespace Tests\Pitchart\Phlunit\Constraint\HttpResponse;

use GuzzleHttp\Psr7\Response;
use Pitchart\Phlunit\Constraint\HttpResponse\HeaderContains;
use Tests\Pitchart\Phlunit\Constraint\ConstraintTestCase;
use Tests\Pitchart\Phlunit\Constraint\UniqueConstraint;

class HeaderContainsTest extends ConstraintTestCase
{
    use UniqueConstraint;

    /**
     * @var HeaderContains
     */
    protected $constraint;

    protected function setUp(): void
    {
        $this->constraint = new HeaderContains('test', 'test');
    }

    public function test_succeeds_for_single_value_header_with_matching_value()
    {
        $response = (new Response(200))->withHeader('test', 'test');

        $this->assertTrue($this->constraint->evaluate($response, '', true));
    }

    /**
     * @param string $part
     * @dataProvider matchingPartsProvider
     */
    public function test_succeeds_for_multi_values_header(string $part)
    {
        $response = (new Response(200))
            ->withHeader('Accept-Charset', 'utf-8')
            ->withAddedHeader('Accept-Charset', 'iso-8859-1;q=0.5')
            ->withAddedHeader('Accept-Charset', '*;q=0.1')
        ;

        $constraint = new HeaderContains('Accept-Charset', $part);

        $this->assertTrue($constraint->evaluate($response, '', true));
    }

    public function matchingPartsProvider()
    {
        yield from [
            'starting part' => ['utf-8'],
            'ending part' => ['q=0.1'],
            'contained part' => ['8859'],
            'mixed parts' => ['utf-8, iso-8859-1']
        ];
    }

    public function test_fails_for_missing_header()
    {
        $response = (new Response(200))->withHeader('test', 'fail');

        $this->assertFalse($this->constraint->evaluate($response, '', true));
    }

    public function test_fails_for_single_value_header_with_wrong_value()
    {
        $response = (new Response(200))->withHeader('test', 'fail');

        $this->assertFalse($this->constraint->evaluate($response, '', true));
    }

    public function test_fails_for_multi_values_header_with_wrong_value()
    {
        $response = (new Response(200))
            ->withHeader('Accept-Charset', 'utf-8')
            ->withAddedHeader('Accept-Charset', '*;q=0.1')
        ;

        $constraint = new HeaderContains('Accept-Charset', 'missing value');

        $this->assertFalse($constraint->evaluate($response, '', true));
    }

    public function test_fails_with_a_clear_and_complete_error_message()
    {
        $response = (new Response(200))->withHeader('xxx-header', 'xxx-header-value');

        $this->assertHasFailingMessage(
            <<<EOF
Failed asserting that GuzzleHttp\Psr7\Response Object (
    'headers' (
        xxx-header: xxx-header-value
    )
)  contains value 'test' for header 'test'.
EOF
            , $response);
    }

}
