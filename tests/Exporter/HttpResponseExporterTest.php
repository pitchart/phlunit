<?php

namespace Tests\Pitchart\Phlunit\Exporter;

use GuzzleHttp\Psr7\Response;
use Pitchart\Phlunit\Check;
use Pitchart\Phlunit\Exporter\HttpResponseExporter;
use PHPUnit\Framework\TestCase;

class HttpResponseExporterTest extends TestCase
{
    public function test_exports_response_with_headers()
    {
        $response = (new Response(200))
            ->withHeader('Accept-Charset', 'utf-8')
            ->withAddedHeader('Accept-Charset', '*;q=0.1')
            ->withHeader('Content-Type', 'text/html; charset=utf-8')
        ;

        $exporter = new HttpResponseExporter(true);

        $exported = $exporter->export($response);

        Check::that($exported)->isEqualTo(
            <<<EOF
GuzzleHttp\Psr7\Response Object (
    'headers' (
        Accept-Charset: utf-8, *;q=0.1
        Content-Type: text/html; charset=utf-8
    )
)
EOF
        );
    }
}
