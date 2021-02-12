<?php


namespace Pitchart\Phlunit\Constraint\Json;


use JsonSchema\Validator;
use PHPUnit\Framework\Constraint\Constraint;

class MatchesSchema extends Constraint
{
    private $schema;

    public function __construct($schema)
    {
        $this->schema = $this->convertToObject($schema);
    }


    public function toString(): string
    {
        return sprintf('matches Json Schema %s', json_encode($this->schema));
    }

    /**
     * @inheritdoc
     */
    protected function matches($other): bool
    {
        $other = $this->convertToObject($other);

        $validator = new Validator();
        $validator->check($other, $this->schema);

        return $validator->isValid();
    }

    /**
     * @inheritdoc
     */
    protected function additionalFailureDescription($other): string
    {
        $other = $this->convertToObject($other);

        $validator = new Validator();
        $validator->check($other, $this->schema);

        return implode("\n", array_map(function ($error) {
            return sprintf("[%s] %s", $error['property'], $error['message']);
        }, $validator->getErrors()));
    }

    private function convertToObject($value): \stdClass
    {
        if (is_string($value)) {
            return json_decode($value);
        }

        return json_decode(json_encode($value));
    }

}