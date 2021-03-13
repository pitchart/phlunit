<?php


namespace Tests\Pitchart\Phlunit\Fixture;


class Address
{
    /**
     * @var string
     */
    private $recipient;

    /**
     * @var string
     */
    private $line1;

    /**
     * @var string|null
     */
    private $line2;

    /**
     * @var string|null
     */
    private $line3;

    /**
     * @var string
     */
    private $zip;

    /**
     * @var string
     */
    private $city;

    /**
     * Address constructor.
     *
     * @param string $recipient
     * @param string $line1
     * @param null|string $line2
     * @param null|string $line3
     * @param string $zip
     * @param string $city
     */
    public function __construct(string $recipient, string $line1, ?string $line2, ?string $line3, string $zip, string $city)
    {
        $this->recipient = $recipient;
        $this->line1 = $line1;
        $this->line2 = $line2;
        $this->line3 = $line3;
        $this->zip = $zip;
        $this->city = $city;
    }

    public static function simple(string $recipient, string $line1, string $zip, string $city)
    {
        return new self($recipient, $line1, null, null, $zip, $city);
    }

}