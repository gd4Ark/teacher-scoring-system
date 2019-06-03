<?php

/**
 * @param string $value
 * @param string $delimiter
 * @return array
 */
function split(string $value, string $delimiter = "\n")
{
    return explode($delimiter, $value);
}

/**
 * @param string $string
 * @return string|string[]|null
 */
function removeBlank(string $string)
{
    return preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string);
}
