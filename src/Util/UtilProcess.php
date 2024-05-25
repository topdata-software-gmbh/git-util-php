<?php


namespace Topdata\TopdataPluginManagerSW6\Util;


/**
 * 05/2024 created
 */
class UtilProcess
{


    /**
     * it returns just single line of output
     * if the command execution fails, it returns $default instead
     *
     * 05/2024 created
     */
    public static function exec(string $cmd, $default = '-'): mixed
    {
        exec($cmd, $out, $code);
        if ($code !== 0) {
            return $default;
//            throw new \Exception("Error running git command: $cmd / exit code: $code | output: " . implode("\n", $out) . "\n");
        }

        return $out[0];
    }

    /**
     * It returns full output (stdout and stderr)
     * 05/2024 created
     *
     * @throws \RuntimeException
     */
    public static function execOrFail(string $cmd): string
    {
        exec($cmd, $out, $code);
        if ($code !== 0) {
            throw new \RuntimeException("Error running git command: $cmd / exit code: $code | output: " . implode("\n", $out) . "\n");
        }

        return implode("\n", $out);
    }

}