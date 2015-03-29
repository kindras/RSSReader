<?php

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class ObjectSerializer
{

    private static $instance = null;

    private $serializer;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new ObjectSerializer();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $encoders = array(new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    public function serialize($object, $format)
    {
        return $this->serializer->serialize($object, $format);
    }
}
