<?php


namespace Tests\Pitchart\Phlunit\Fixture;


class Contact
{
    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var \DateTimeInterface
     */
    private $dateOfBirth;

    /**
     * Contact constructor.
     *
     * @param string $firstname
     * @param string $lastname
     * @param \DateTimeInterface $dateOfbirth
     */
    public function __construct($firstname, $lastname, \DateTimeInterface $dateOfBirth)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDateOfBirth(): \DateTimeInterface
    {
        return $this->dateOfBirth;
    }

}