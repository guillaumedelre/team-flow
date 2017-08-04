<?php

namespace AppBundle\Service\Lifx;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class Light
{
    const API_PATH = '/v1/lights/';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var JsonEncoder
     */
    protected $jsonEncoder;

    /**
     * @var string
     */
    protected $lifxSelector;

    /**
     * AbstractClient constructor.
     *
     * @param Client $client
     * @param JsonEncoder $jsonEncoder
     * @param string $lifxSelector
     */
    public function __construct(
        Client $client,
        JsonEncoder $jsonEncoder,
        string $lifxSelector
    ) {
        $this->client = $client;
        $this->jsonEncoder = $jsonEncoder;
        $this->lifxSelector = $lifxSelector;
    }

    /**
     * @see https://api.developer.lifx.com/docs/list-lights
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get()
    {
        return $this->json($this->client->get(self::API_PATH . $this->lifxSelector));
    }

    /**
     * @param ResponseInterface $response
     *
     * @return array
     */
    private function json(ResponseInterface $response): array
    {
        return $this->jsonEncoder->decode($response->getBody()->getContents(), JsonEncoder::FORMAT);
    }

    /**
     * @see https://api.developer.lifx.com/docs/set-state
     *
     * @param array $options
     *
     * @return array
     */
    public function state(array $options = []): array
    {
        return $this->json($this->client->put(self::API_PATH . $this->lifxSelector . '/state', $options));
    }

    /**
     * @see https://api.developer.lifx.com/docs/set-states
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function states()
    {
        return $this->json($this->client->put(self::API_PATH . $this->lifxSelector . '/states'));
    }

    /**
     * @see https://api.developer.lifx.com/docs/state-delta
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function stateDelta()
    {
        return $this->json($this->client->post(self::API_PATH . $this->lifxSelector . '/state/delta'));
    }

    /**
     * @see https://api.developer.lifx.com/docs/toggle-power
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function toggle()
    {
        return $this->json($this->client->post(self::API_PATH . $this->lifxSelector . '/toggle'));
    }

    /**
     * @see https://api.developer.lifx.com/docs/breathe-effect
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function breathe()
    {
        return $this->json($this->client->post(self::API_PATH . $this->lifxSelector . '/effects/breathe'));
    }

    /**
     * @see https://api.developer.lifx.com/docs/pulse-effect
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function pulse()
    {
        return $this->json($this->client->post(self::API_PATH . $this->lifxSelector . '/effects/pulse'));
    }

    /**
     * @see https://api.developer.lifx.com/docs/cycle
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function cycle()
    {
        return $this->json($this->client->post(self::API_PATH . $this->lifxSelector . '/cycle'));
    }
}
