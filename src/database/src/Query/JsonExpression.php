<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Hyperf\Database\Query;

use InvalidArgumentException;

class JsonExpression extends Expression
{
    /**
     * Create a new raw query expression.
     * @param mixed $value
     */
    public function __construct($value)
    {
        parent::__construct(
            $this->getJsonBindingParameter($value)
        );
    }

    /**
     * Translate the given value into the appropriate JSON binding parameter.
     *
     * @param mixed $value
     * @throws \InvalidArgumentException
     * @return string
     */
    protected function getJsonBindingParameter($value)
    {
        if ($value instanceof Expression) {
            return $value->getValue();
        }

        $type = gettype($value);
        return match ($type) {
            'boolean' => $value ? 'true' : 'false',
            'NULL', 'integer', 'double', 'string', 'object', 'array' => '?',
            default => throw new InvalidArgumentException("JSON value is of illegal type: {$type}")
        };
    }
}
