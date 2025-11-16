<?php
namespace Core\Helpers;

/**
 * Helper Methods
 *
 * Class Strings
 *
 * @package Core\Helpers
 */
class Strings
{
    /**
     * Convert text from camel case to underscore.
     *
     * @param  string $input
     * @return string
     */
    public function fromCamelCaseToUnderscore(string $input): string
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);

        $ret = $matches[0];

        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }

        return implode('_', $ret);
    }

    /**
     * Convert text from Underscore To CamelCase.
     *
     * @param  string $string
     * @return string
     */
    public function fromUnderscoreToCamelCase(string $string): string
    {
        $str = str_replace(' ', '', lcfirst(ucwords(str_replace('_', ' ', $string))));

        return $str;
    }
}