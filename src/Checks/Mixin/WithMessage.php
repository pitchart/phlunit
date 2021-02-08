<?php declare(strict_types=1);


namespace Pitchart\Phlunit\Checks\Mixin;

trait WithMessage
{
    protected $message = '';

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
