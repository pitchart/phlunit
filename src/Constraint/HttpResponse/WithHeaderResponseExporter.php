<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Constraint\HttpResponse;

use Pitchart\Phlunit\Exporter\HttpResponseExporter;
use SebastianBergmann\Exporter\Exporter;

trait WithHeaderResponseExporter
{
    /**
     * @var ?HttpResponseExporter
     */
    private $responseExporter;

    /**
     * @return \Pitchart\Phlunit\Exporter\HttpResponseExporter
     */
    protected function exporter(): Exporter
    {
        if ($this->responseExporter === null) {
            $this->responseExporter = new HttpResponseExporter(true);
        }

        return $this->responseExporter;
    }
}
