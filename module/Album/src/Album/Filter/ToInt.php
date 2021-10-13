<?php

namespace Album\Filter;

use Zend\Filter\AbstractFilter;

class ToInt extends AbstractFilter
{
    /**
     * Returns (int) $value
     *
     * If the value provided is non-scalar, the value will remain unfiltered
     *
     * @param  string $value
     * @return ToInt|mixed
     */
    public function filter($value)
    {
        if (!is_scalar($value)) {
            return $value;
        }
        $value = (string) $value;

        return (int) $value;
    }
}