<?php


namespace Tests\Pitchart\Phlunit\Fixture;


use Pitchart\Phlunit\Builder;

/**
 * Class ContactBuilder
 *
 * @package Tests\Pitchart\Phlunit\Fixture
 *
 * @author Julien VITTE <julien.vitte@insidegroup.fr>
 *
 * @method ContactBuilder withFirstname(string $firstname)
 * @method ContactBuilder andFirstname(string $firstname)
 * @method ContactBuilder withLastname(string $lastname)
 * @method ContactBuilder andLastname(string $lastname)
 * @method ContactBuilder withDateOfBirth(\DateTimeImmutable $lastname)
 * @method ContactBuilder andDateOfBirth(\DateTimeImmutable $lastname)
 */
class ContactBuilder extends Builder
{
    public function __construct(array $arguments)
    {
        parent::__construct(Contact::class, $arguments);
    }


    public static function create() {
        return new self([
            'lastname' => 'Wayne',
            'firstname' => 'Bruce',
            'dateOfBirth' => new \DateTimeImmutable(),
        ]);
    }

    public static function createWithMissingArguments() {
        return new self([
            'firstname' => 'Bruce',
            'lastname' => 'Wayne',
        ]);
    }

    public static function createWithMoreArgumentsThanConstructorNeeds() {
        return new self([
            'firstname' => 'Bruce',
            'lastname' => 'Wayne',
            'name' => 'Batman',
            'dateOfBirth' => new \DateTimeImmutable(),

        ]);
    }

    public function build(): Contact
    {
        return $this->buildInstance();
    }
}