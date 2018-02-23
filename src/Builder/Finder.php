<?php

namespace uSIreF\AutoWire\Builder;

/**
 * This file defines class for find creator way of class.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Finder {

    const PATTERNS = [
        Pattern\Singleton::class,
        Pattern\Construct::class,
    ];

    /**
     * Finds creator pattern for class name.
     *
     * @param string $className Class name
     *
     * @return Pattern\APattern|null
     */
    public function findPattern(string $className): ?Pattern\APattern {
        $result = null;
        foreach (self::PATTERNS as $pattern) {
            $instance = new $pattern(); /* @var $instance Pattern\APattern */
            if ($instance->match($className)) {
                $result = $instance;
                break;
            }
        }

        return $result;
    }

}