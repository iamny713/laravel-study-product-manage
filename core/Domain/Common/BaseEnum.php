<?php

namespace NohYooHan\Domain\Common;

use JsonSerializable;

/**
 * Base Enum Singleton class
 *
 * Create an enum by extending this class and adding class constants.
 *
 * Usage:
 *    final class Color extends BaseEnum
 *    {
 *        // Enum value must be string type
 *        const RED = '1',
 *              BLUE = '2';
 *    }
 * $a = Color::getInstance(Color::RED);
 * // Syntactic sugar
 * $b = Color::BLUE();
 *
 * // Since BaseEnum overrides __toString(), it is possible to compare
 * // BaseEnum Object with string constant using '==' operator
 * if ($a == Color::RED)
 *     echo "Color is RED";
 *
 * // We can also use switch statement
 * switch ($a) {
 *     case Color::RED: echo "Color is RED";
 * }
 *
 * // Two enum values can be compared against each other
 * $a = Color::RED();
 * $b = Color::BLUE();
 * $c = Color::RED();
 *
 * if ($a == $b) {} // false
 * if ($a == $c) {} // true
 * if ($a === $c) {} // true
 */
abstract class BaseEnum implements JsonSerializable
{
    /**
     * Enum value
     *
     * NOTE: To use '==' operator, we made a convention that
     *       value must be string type.
     *
     * @var string
     */
    protected $value;

    const EMPTY = "EMPTY";

    /**
     * Store existing constants in a static cache per object.
     * @var array
     */
    private static $constantsCache = array();

    private static $enumSingletonCache = array();

    /**
     * @param $value
     *
     * @return static
     * @throws \InvalidArgumentException
     */
    public static function getInstance(string $value = null)
    {
        if ($value === null) {
            $value = "EMPTY";
        }

        $calledClass = get_called_class();
        if (!isset(self::$enumSingletonCache[$calledClass][$value])) {
            self::$enumSingletonCache[$calledClass][$value] = new static($value);
        }

        return self::$enumSingletonCache[$calledClass][$value];
    }

    /**
     * Creates a new value of some type
     *
     * @param string $value
     *
     * @throws \UnexpectedValueException if incompatible type is given.
     */
    private function __construct($value)
    {
        $possibleValues = self::toArray();
        if (!in_array($value, $possibleValues)) {
            throw new \UnexpectedValueException("Value '$value' is not part of the enum " . get_called_class());
        }
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }

    /**
     * Returns all possible values as an array
     * @return array Constant name in key, constant value in value
     */
    public static function toArray()
    {
        $calledClass = get_called_class();
        if(!array_key_exists($calledClass, self::$constantsCache)) {
            $reflection = new \ReflectionClass($calledClass);
            self::$constantsCache[$calledClass] = $reflection->getConstants();
        }
        return self::$constantsCache[$calledClass];
    }

    /**
     * Returns a value when called statically like so: MyEnum::SOME_VALUE() given SOME_VALUE is a class constant
     * @param string $name
     * @param array  $arguments
     * @return static
     * @throws \BadMethodCallException
     */
    public static function __callStatic($name, $arguments)
    {
        if (defined("static::$name")) {
            return self::getInstance(constant("static::$name"));
        }
        throw new \BadMethodCallException("No static method or enum constant '$name' in class " . get_called_class());
    }

    public function isEmpty(){
        return $this->value === "EMPTY";
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
        return $this->getValue();
    }

}