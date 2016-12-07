<?php
/**
 * User: Ivan de la Beldad Fernandez
 * Date: 07/12/2016
 * Time: 5:03
 */

namespace Akimah\Database;
use ReflectionClass;


class Cloner
{

    public static function cloneProperties($reference, $destination)
    {
        $referenceReflection = new ReflectionClass($reference);
        $destinationReflection = new ReflectionClass($destination);
        $propertiesReference = $referenceReflection->getProperties();
        $propertiesDestination = $destinationReflection->getProperties();

        foreach ($propertiesReference as $property) {
            $property->setAccessible(true);
        }

        foreach ($propertiesDestination as $property) {
            $property->setAccessible(true);
        }

        foreach ($propertiesDestination as $destinationProperty) {
            foreach ($propertiesReference as $referenceProperty) {
                if ($referenceProperty->getName() === $destinationProperty->getName()) {
                    $destinationProperty->setValue($destination, $referenceProperty->getValue($reference));
                }
            }
        }
    }

}