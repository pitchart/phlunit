<?php

namespace Tests\Pitchart\Phlunit;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\TestCase;
use Pitchart\Phlunit\Checks\ResponseCheck;
use Pitchart\Phlunit\Check;
use Psr\Http\Message\ResponseInterface;

class ResponseCheckTest extends TestCase
{
    /**
     * @param ResponseInterface $sut
     * @param string $method
     * @param array $arguments
     * @dataProvider methodsAreFulentProvider
     */
    public function test_has_fluent_methods(ResponseInterface $sut, string $method, array $arguments = [])
    {
        Check::that(call_user_func_array([Check::that($sut), $method], $arguments))
            ->isAnInstanceOf(ResponseCheck::class);
    }

    public function methodsAreFulentProvider()
    {
        $response = (new Response(200))->withHeader('xxx-header', 'xxx-header-value');
        $htmlResponse = $response->withHeader('Content-Type', 'text/html');
        $xmlResponse = $response->withHeader('Content-Type', 'application/xml');
        $jsonResponse = $response->withHeader('Content-Type', 'application/json');
        yield from [
            'hasHeader' => [$response, 'hasHeader', ['xxx-header']],
            'hasStatus' => [$response, 'hasStatus', [200]],
            'hasReason' => [$response, 'hasReason', ['OK']],
            'isJson' => [$jsonResponse, 'isJson'],
            'isHtml' => [$htmlResponse, 'isHtml'],
            'isXml' => [$xmlResponse, 'isXml'],
        ];
    }

    public function test_verifies_that_response_contains_a_specific_header()
    {
        $response = (new Response(200))->withHeader('xxx-header', 'xxx-header-value');

        Check::that($response)->hasHeader('xxx-header');
    }

    public function test_verifies_header_content()
    {
        $response = (new Response(200))->withHeader('xxx-header', 'xxx-header-value');

        Check::that($response)
            ->whoseHeader('xxx-header')
                ->isEqualTo('xxx-header-value')
                ->contains('value')
        ;
    }

    public function test_verifies_status_code()
    {
        $response = (new Response(200))->withHeader('xxx-header', 'xxx-header-value');

        Check::that($response)->hasStatus(200);
    }

    public function test_verifies_reason_phrase()
    {
        $response = (new Response(200))->withHeader('xxx-header', 'xxx-header-value');

        Check::that($response)->hasReason('OK');
    }

    public function test_checks_json_responses()
    {
        $response = (new Response(200))
            ->withHeader('xxx-header', 'xxx-header-value')
            ->withBody(Utils::streamFor('{"name": "Batman"}'))
        ;

        $expectedSchema = ['type' => 'object', 'required' => ['name'], 'properties' => ['name' => ['type' => 'string']]];

        Check::that($response)->asJson()->matchesSchema($expectedSchema);
    }

}