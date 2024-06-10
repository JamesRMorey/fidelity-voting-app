<?php

namespace App\Classes;

class IPLocation
{
    public function __construct(
        public ?string $city,
        public ?string $region,
        public ?string $country,
        public ?string $loc,
        public ?string $postal,
        public ?string $timezone
    )
    {

    }
}
