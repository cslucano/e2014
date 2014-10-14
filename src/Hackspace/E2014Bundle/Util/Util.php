<?php

namespace Hackspace\E2014Bundle\Tests\Util;

class Util
{
    public static function setPropertyValue($object, $property, $value)
    {
        $rObj = new \ReflectionObject($object);
        $pObj = $rObj->getProperty($property);
        $pObj->setAccessible(true);
        $pObj->setValue($object, $value);
    }

    public static function getPropertyValue($object, $property)
    {
        $rObj = new \ReflectionObject($object);
        $pObj = $rObj->getProperty($property);
        $pObj->setAccessible(true);

        return $pObj->getValue($object);
    }
}
