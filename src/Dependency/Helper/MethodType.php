<?php

namespace uSIreF\AutoWire\Dependency\Helper;

use uSIreF\AutoWire\Dependency\Resolver\Definition;
use ReflectionMethod;

/**
 * This file defines class for ...
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class MethodType {

    /**
     * Resolves method type.
     *
     * @param ReflectionMethod $method Method name
     *
     * @return string
     */
    public static function resolve(ReflectionMethod $method): string {
        $type = null;
        switch (true) {
            case $method->isStatic() && $method->isPublic():
                $type = Definition::TYPE_STATIC_PUBLIC_METHOD;
                break;
            case $method->isStatic() && $method->isProtected():
                $type = Definition::TYPE_STATIC_PROTECTED_METHOD;
                break;
            case $method->isStatic() && $method->isPrivate():
                $type = Definition::TYPE_STATIC_PRIVATE_METHOD;
                break;
            case $method->isPublic():
                $type = Definition::TYPE_PUBLIC_METHOD;
                break;
            case $method->isProtected():
                $type = Definition::TYPE_PROTECTED_METHOD;
                break;
            case $method->isPrivate():
                $type = Definition::TYPE_PRIVATE_METHOD;
                break;
        }

        return $type;
    }

}