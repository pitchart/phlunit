<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Exporter;

use Psr\Http\Message\ResponseInterface;
use SebastianBergmann\Exporter\Exporter;

class HttpResponseExporter extends Exporter
{
    private $withHeaders = false;

    private $withContent = false;

    /**
     * HttpResponseExporter constructor.
     *
     * @param bool $withHeaders
     * @param bool $withContent
     */
    public function __construct(bool $withHeaders = false, bool $withContent = false)
    {
        $this->withHeaders = $withHeaders;
        $this->withContent = $withContent;
    }

    /**
     * @param ResponseInterface $value
     * @param int $indentation
     *
     * @return string
     */
    public function export($value, $indentation = 0)
    {
        $content = parent::shortenedExport($value);
        $replace = '';
        if ($this->withHeaders || $this->withContent) {
            $properties = parent::toArray($value);
            $whitespace = \str_repeat(' ', (int) (4 * ($indentation + 1)));
            /** @var array<string, array> $properties */
            if (isset($properties['headers']) && \count($properties['headers'])) {
                $replace = "\n$whitespace'headers' (\n";
                /**
                 * @var string $name
                 * @var array $values
                 */
                foreach ($properties['headers'] as $name => $values) {
                    $replace .= \sprintf("%s%s%s: %s\n", $whitespace, $whitespace, $name, \implode(', ', $values));
                }
                $replace .= "$whitespace)\n";
            }
        }

        return \preg_replace('/\.\.\./', $replace, $content);
    }
}
