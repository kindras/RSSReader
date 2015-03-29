<?php

class Finder
{
    private static $identityMap = [];

    public static function loadEntity($class, $id)
    {
        $key = self::generateKey($class, $id);
        if (isset(self::$identityMap[$key])) {
            return self::$identityMap[$key];
        }

        return false;
    }

    public static function storeEntity($entity)
    {
        $class = get_class($entity);
        $id = $entity->getId();
        $key = self::generateKey($class, $id);
        self::$identityMap[$key] = $entity;
    }

    public static function isInMap($class, $id)
    {
        $key = self::generateKey($class, $id);

        return isset(self::$identityMap[$key]);
    }

    private static function generateKey($class, $id)
    {
        return $class.'-'.$id;
    }
}
