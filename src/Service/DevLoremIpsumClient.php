<?php

namespace App\Service;

use App\Contract\IpsumClientInterface;
use http\Client;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DevLoremIpsumClient implements IpsumClientInterface
{
    public function __construct(private HttpClientInterface $client)
    {
    }

    /**
     * @return mixed
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getTexts()
    {
        $response = $this->client->request(
            'GET',
            'https://devlorem.kovah.de/api/4?paragraphs=true'
        );

        return json_decode($response->getContent())->paragraphs;
    }
}

