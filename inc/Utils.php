<?php

namespace Boilerplate;

/**
 * Supporting methods
 */
class Utils
{
    /**
     * Returns the value of an array by key
     * Only if argument $array is type array and array item exists, otherwise returns default value
     *
     * @param array $array
     * @param string|int $key
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    public static function arrayGet($array, $key, $default = null)
    {
        if (!is_array($array)) {
            return $default;
        }

        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        return $default;
    }

    /**
     * Returns custom or site URL plus custom query string
     *
     * @param string|null $url
     * @param array $query
     * @return string
     */
    public static function createUrl($url = null, array $query = []): string
    {
        if (!$url) {
            $url = site_url();
        }

        if (count($query) === 0) {
            return $url;
        }

        $parsedUrl = parse_url($url);
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $parsedQuery);
            $query = array_merge($parsedQuery, $query);
        }

        $parsedUrl['query'] = http_build_query($query);

        return self::_buildUrl($parsedUrl);
    }

    /**
     * Retrieves the full permalink for the current post or post ID.
     *
     * @param int|\WP_Post $post      Optional. Post ID or post object. Default is the global `$post`.
     * @param bool        $leavename Optional. Whether to keep post name or page name. Default false.
     * @return string|null The permalink URL or null if post does not exist.
     */
    public static function getPermalink($post = 0, bool $leavename = false): ?string
    {
        $permalink = get_permalink($post, $leavename);
        if (is_wp_error($permalink) || !is_string($permalink)) {
            return null;
        }

        return $permalink;
    }

    /**
     * This is the missing function to reverse the `parse_url` function.
     *
     * @see https://www.php.net/manual/en/function.parse-url.php#106731
     * @param array $parsedUrl  result of the library `parse_url()` function
     * @return string
     */
    protected static function _buildUrl(array $parsedUrl): string
    {
        $scheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'].'://' : '';
        $host = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
        $port = isset($parsedUrl['port']) ? ':'.$parsedUrl['port'] : '';
        $user = isset($parsedUrl['user']) ? $parsedUrl['user'] : '';
        $pass = isset($parsedUrl['pass']) ? ':'.$parsedUrl['pass'] : '';
        $pass = ($user || $pass) ? "$pass@" : '';
        $path = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
        $query = isset($parsedUrl['query']) ? '?'.$parsedUrl['query'] : '';
        $fragment = isset($parsedUrl['fragment']) ? '#'.$parsedUrl['fragment'] : '';

        return $scheme.$user.$pass.$host.$port.$path.$query.$fragment;
    }

    /**
     * Decodes JSON string into an associative array
     *
     * @param string $json
     * @param string $errorMessage
     * @return array|null
     */
    public static function jsonDecode(string $json, string &$errorMessage = ''): ?array
    {
        $output = null;

        try {
            $output = json_decode($json, true, 512, JSON_THROW_ON_ERROR | JSON_BIGINT_AS_STRING);
        } catch (\JsonException $e) {
            $errorMessage = _x('Error when decoding JSON: ', 'runtime-error', 'boilerplate') . $e->getMessage();
        }

        if (!is_array($output)) {
            $errorMessage = _x('Error when decoding JSON: JSON cannot be decoded!', 'runtime-error', 'boilerplate');
        }

        return $output;
    }

    /**
     * Encodes array into an JSON string
     *
     * @param array $data
     * @param string $errorMessage
     * @return string|null
     */
    public static function jsonEncode(array $data, string &$errorMessage = ''): ?string
    {
        $output = null;

        try {
            $output = json_encode($data, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            $errorMessage = _x('Error encoding to JSON: ', 'runtime-error', 'boilerplate') . $e->getMessage();
        }

        return $output;
    }
}
