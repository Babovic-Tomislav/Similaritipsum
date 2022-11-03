<?php

namespace App\Service\OptionsProvider;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AlgorithmOptionsProvider
{
    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }

    public function getAlgorithms(): array
    {
        return $this->parameterBag->get('similarity_algorithms_name');
    }

    public function getAlgorithmNameBasedOnKey($key): string
    {
        return $this->parameterBag->get('similarity_algorithms_name')[$key];
    }

	public function getAlgorithmDescriptionBasedOnKey($key)
	{
        return $this->parameterBag->get('similarity_algorithms_description')[$key];
    }
}

