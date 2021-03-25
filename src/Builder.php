<?php declare(strict_types=1);


namespace Pitchart\Phlunit;

use function Pitchart\Transformer\transform;

abstract class Builder
{
    /** @var array */
    private $arguments = [];

    /**
     * @var array
     */
    private $constructorArguments = [];

    /** @var string|null */
    private $staticFactoryMethod;

    /**
     * @var \ReflectionClass
     */
    private $reflection;

    /**
     * @var bool|\ReflectionClass|string
     */
    protected $class;

    abstract public function build();

    protected function __construct(string $class, array $arguments, string $staticFactoryMethod = null)
    {
        $this->staticFactoryMethod = $staticFactoryMethod;
        $this->arguments = $arguments;
        $this->class = $class;
        $this->reflection = new \ReflectionClass($class);

        $this->extractConstructorArguments($staticFactoryMethod);

        $missingConstructorArguments = transform($this->constructorArguments)
            ->remove(static function(string $key) use ($arguments) {
                return \array_key_exists($key, $arguments);
            })
            ->toArray()
        ;

        if (\count($missingConstructorArguments) > 0) {
            throw new \InvalidArgumentException(\sprintf(
                'The following arguments key(s) must be provided with default value : [%s]',
                \implode(', ', $missingConstructorArguments)
            ));
        }
    }

    /**
     * Override arguments
     *
     * @param $name
     * @param $value
     *
     * @return void
     */
    final protected function setArgument(string $name, $value): void
    {
        if (! \array_key_exists($name, $this->arguments)) {
            throw new \InvalidArgumentException("There is no argument $name");
        }
        $this->arguments[$name] = $value;
    }

    /**
     * Allows to call with*() and and*() for defined arguments
     *
     * @param $name
     * @param $arguments
     *
     * @return Builder
     */
    final public function __call($name, $arguments): self
    {
        if (\strpos($name, 'with') === 0) {
            $property = \substr($name, 4);
        }
        if (\strpos($name, 'and') === 0) {
            $property = \substr($name, 3);
        }
        if (!isset($property)) {
            throw new \BadMethodCallException("Method $name is not supported. Supported methods are with*() and and*()");
        }
        if (\count($arguments) !== 1) {
            throw new \InvalidArgumentException(\sprintf("There must be exactly one argument for method '%s', %d given", $name, \count($arguments)));
        }
        $property = \lcfirst($property);
        $this->setArgument($property, \current($arguments));
        return $this;
    }

    /**
     * Builds the instance using the constructor or a static factory method
     *
     * @return mixed|object
     */
    final protected function buildInstance()
    {
        if (!$this->staticFactoryMethod) {
            $args = transform($this->constructorArguments)->map(function(string $argumentName) {
                return $this->arguments[$argumentName];
            })->toArray();

            return $this->reflection->newInstanceArgs($args);
        }
        return \call_user_func_array([$this->class, $this->staticFactoryMethod], $this->arguments);
    }

    /**
     * Extracts the names of the instanciation method arguments
     *
     * @param null|string $staticFactoryMethod
     *
     * @return void
     */
    private function extractConstructorArguments(?string $staticFactoryMethod): void
    {
        $instanciationMethod = $staticFactoryMethod === null ? $this->reflection->getConstructor() : $this->reflection->getMethod($staticFactoryMethod);

        $this->constructorArguments = transform($instanciationMethod->getParameters())
            ->map(static function(\ReflectionParameter $parameter) { return $parameter->getName(); })
            ->toArray()
        ;
    }
}
