<?php

namespace App\Contracts;

interface HomeownerNameParser
{
    public function parse(string $homeowners): array;
}
