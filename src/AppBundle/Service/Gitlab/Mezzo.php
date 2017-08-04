<?php

namespace AppBundle\Service\Gitlab;

use AppBundle\Entity\Gitlab\Build;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class Mezzo
{
    const API_PATH = '/api/v3/';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var int
     */
    protected $projectId;

    /**
     * Mezzo constructor.
     *
     * @param Client $client
     * @param SerializerInterface $serializer
     * @param int $projectId
     */
    public function __construct(Client $client, SerializerInterface $serializer, int $projectId)
    {
        $this->client = $client;
        $this->serializer = $serializer;
        $this->projectId = $projectId;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get()
    {
        return $this->json($this->client->get(self::API_PATH . 'projects/' . $this->projectId));
    }

    /**
     * @param ResponseInterface $response
     *
     * @return mixed
     */
    private function json(ResponseInterface $response)
    {
        return $this->serializer->deserialize(
            $response->getBody()->getContents(),
            'array',
            JsonEncoder::FORMAT
        );
    }

    /**
     * @return Build[]
     */
    public function builds()
    {
        $response = $this->client->get(self::API_PATH . 'projects/' . $this->projectId . '/builds');

        return $this->serializer->deserialize(
            $response->getBody()->getContents(),
            Build::class . '[]',
            JsonEncoder::FORMAT
        );
    }

    /**
     * @param string $id
     *
     * @return Build
     */
    public function build(string $id): Build
    {
        $response = $this->client->get(self::API_PATH . 'projects/' . $this->projectId . '/builds/' . $id);

        return $this->serializer->deserialize(
            $response->getBody()->getContents(),
            Build::class,
            JsonEncoder::FORMAT
        );
    }

    /**
     * @param string $id
     *
     * @return ResponseInterface
     */
    public function downloadArtifact(string $id)
    {
        return $this->client->get(self::API_PATH . 'projects/' . $this->projectId . '/builds/' . $id . '/artifacts');
    }
}
