<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Validator;

/**
 * Class ValidationError
 *
 * @package Pitchart\Phlunit\Validator
 *
 * @author Julien VITTE <julien.vitte@insidegroup.fr>
 *
 * @internal
 */
class ValidationError
{
    const ERROR = 'ERROR';

    const WARNING = 'WARNING';

    /**
     * @var string
     */
    private $level;

    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $message;

    private function __construct(string $level, $code, string $message)
    {
        $this->level = $level;
        $this->code = (int) $code;
        $this->message = $message;
    }

    public static function emptyXml(): self
    {
        return new self(self::ERROR, "", "Provided content is not valid XML.");
    }

    public static function fromLibXmlError(\LibXMLError $error): self
    {
        return new ValidationError(
            \LIBXML_ERR_WARNING == $error->level ? self::WARNING : self::ERROR,
            $error->code,
            \trim($error->message)
        );
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }
}
