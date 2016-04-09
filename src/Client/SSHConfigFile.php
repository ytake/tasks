<?php

namespace Ytake\ContentSerializer\Client;

/**
 * Class SSHConfigFile
 */
class SSHConfigFile
{
    /**
     * The SSH configuration groups.
     *
     * @var array
     */
    protected $groups = [];

    /**
     * Create a new SSH configuration file.
     *
     * @param  array  $groups
     */
    public function __construct(array $groups)
    {
        $this->groups = $groups;
    }

    public static function parse($file)
    {
        return static::parseString(file_get_contents($file));
    }

    public static function parseString($string)
    {
        $groups = [];

        $index = 0;

        $matchSection = false;

        foreach (explode(PHP_EOL, $string) as $line) {
            $line = trim($line);

            if ('' == $line || starts_with($line, '#')) {
                continue;
            }

            if (preg_match('/^\s*(\S+)\s*=(.*)$/', $line, $match)) {
                $key = strtolower($match[1]);
                $value = self::unquote($match[2]);
            } else {
                $segments = preg_split('/\s+/', $line, 2);
                $key = strtolower($segments[0]);
                $value = self::unquote($segments[1]);
            }

            if ('host' === $key) {
                $index++;
                $matchSection = false;
            } elseif ('match' === $key) {
                $matchSection = true;
            }

            if (! $matchSection) {
                $groups[$index][$key] = $value;
            }
        }

        return new self(array_values($groups));
    }

    /**
     * Get the configured SSH host by name or IP.
     *
     * @param  string  $host
     * @return string|null
     */
    public function findConfiguredHost($host)
    {
        list($user, $host) = $this->parseHost($host);

        foreach ($this->groups as $group) {
            if ((isset($group['host']) && $group['host'] == $host) ||
                (isset($group['hostname']) && $group['hostname'] == $host)) {
                if (! empty($user)) {
                    // User is not specified in the SSH configuration...
                    if (! isset($group['user'])) {
                        continue;
                    }

                    // User is specified in the SSH configuration but is not the given user....
                    if (isset($group['user']) && $group['user'] != $user) {
                        continue;
                    }
                }

                return $group['host'];
            }
        }
    }

    /**
     * Parse the host into user and host segments.
     *
     * @param  string  $host
     * @return array
     */
    protected function parseHost($host)
    {
        return str_contains($host, '@') ? explode('@', $host) : [null, $host];
    }

    /**
     * Unquote an optionally double quoted string.
     *
     * @param  string $string
     * @return string
     */
    private static function unquote($string)
    {
        if ('"' === substr($string, 0, 1) && '"' === substr($string, -1, 1)) {
            return substr($string, 1, -1);
        }

        return $string;
    }
}
