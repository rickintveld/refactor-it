<?php
namespace Refactor\Component\Serializer;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class JsonSerializer
{
    private Serializer $serializer;

    public function __construct()
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @param array $data
     * @return string
     */
    public function serialize(array $data): string
    {
        return $this->serializer->serialize($data, 'json');
    }

    /**
     * @param string $data
     * @return array
     */
    public function decode(string $data): array
    {
        return $this->serializer->decode($data, 'json');
    }
}
