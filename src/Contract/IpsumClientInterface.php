<?php

namespace App\Contract;
/**
 * Plan was to create more clients from different apis so user can choose which generator to use
 * Implementing that I would add factory pattern similar to algorithm where depending on selected generator desired client is created
 */
interface IpsumClientInterface
{
    public function getTexts();
}
