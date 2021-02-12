<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks\Mixin;

trait WithMessage
{
    /**
     * @var string
     */
    protected $message = '';

    public function __get(string $name): self
    {
        if (\in_array($name, ['and', 'which'])) {
            return $this;
        }
        throw new \Error(\sprintf('Undefined property: %s::$%s', \get_class($this), $name));
    }

    public function withMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    protected function resetMessage(): self
    {
        $this->message = '';
        return $this;
    }
}
