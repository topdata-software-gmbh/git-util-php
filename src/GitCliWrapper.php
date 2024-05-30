<?php

namespace Topdata\GitUtil;


/**
 * 05/2024 created
 */
class GitCliWrapper
{

    public static function getBranch(string $pluginPathFull): string
    {
        $cmd = "/usr/bin/git -C $pluginPathFull -c safe.directory=$pluginPathFull branch --show-current 2>&1";

        return UtilProcess::exec($cmd);
    }

    public static function getCommitId(string $pluginPathFull): string
    {
        $cmd = "/usr/bin/git -C $pluginPathFull -c safe.directory=$pluginPathFull rev-parse HEAD 2>&1";

        return UtilProcess::exec($cmd);
    }

    public static function getCommitIdShort(string $pluginPathFull): string
    {
        $cmd = "/usr/bin/git -C $pluginPathFull -c safe.directory=$pluginPathFull rev-parse --short HEAD 2>&1";

        return UtilProcess::exec($cmd);
    }

    public static function getAuthor(string $pluginPathFull): string
    {
        $cmd = "/usr/bin/git -C $pluginPathFull -c safe.directory=$pluginPathFull log -1 --pretty=format:'%an' 2>&1";

        return UtilProcess::exec($cmd);
    }

    public static function getDate(string $pluginPathFull): ?string
    {
        $cmd = "/usr/bin/git -C $pluginPathFull -c safe.directory=$pluginPathFull log -1 --pretty=format:'%ad' 2>&1";

        return UtilProcess::exec($cmd, null);
    }

    public static function getEmail(string $pluginPathFull): string
    {
        $cmd = "/usr/bin/git -C $pluginPathFull -c safe.directory=$pluginPathFull log -1 --pretty=format:'%ae' 2>&1";

        return UtilProcess::exec($cmd);
    }

    public static function getMessage(string $pluginPathFull): string
    {
        $cmd = "/usr/bin/git -C $pluginPathFull -c safe.directory=$pluginPathFull log -1 --pretty=format:'%s' 2>&1";

        return UtilProcess::exec($cmd);
    }

    /**
     * 05/2024 created
     * 05/2024 added --ff-only to avoid "You have divergent branches and need to specify how to reconcile them."
     * 05/2024 added --ff-only removed, now we do fetch and reset --hard, renamed method from pull() to fetchAndResetHard()
     *
     * @return string - full output of the command (stdout and stderr)
     */
    public static function fetchAndResetHard(string $fullPath, string $pathSshKey): string
    {
        $cmd1 = "/usr/bin/git -C $fullPath -c safe.directory=$fullPath -c 'core.sshCommand=ssh -i $pathSshKey'  fetch";
        $cmd2 = "/usr/bin/git -C $fullPath -c safe.directory=$fullPath -c 'core.sshCommand=ssh -i $pathSshKey'  reset --hard";

        return UtilProcess::execOrFail($cmd1 . ' && ' . $cmd2 . ' 2>&1');
    }


    /**
     * 05/2024 created
     * @return string - full output of the command (stdout and stderr)
     */
    public static function pull(string $fullPath, string $pathSshKey): string
    {
        $cmd1 = "/usr/bin/git -C $fullPath -c safe.directory=$fullPath -c 'core.sshCommand=ssh -i $pathSshKey'  pull";

        return UtilProcess::execOrFail($cmd1 . ' 2>&1');
    }


    /**
     * 05/2024 created
     * @return string - full output of the command (stdout and stderr)
     */
    public static function pullRebase(string $fullPath, string $pathSshKey): string
    {
        $cmd1 = "/usr/bin/git -C $fullPath -c safe.directory=$fullPath -c 'core.sshCommand=ssh -i $pathSshKey'  pull --rebase";

        return UtilProcess::execOrFail($cmd1 . ' 2>&1');
    }


}