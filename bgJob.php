<?php

namespace jadedaniel;

/**
 * Class that can execute a background job, and check if the
 * background job is still running
 *
 * @package main
 */
class bgJob
{

    /**
     * Executes a background job using exec. A file with the content
     * of the background job's output will be created, and a file holding the
     * job's pid (process id).
     *
     * @param string $cmd the command
     * @param string $outputfile an output file where output of command will be written
     * @param string $pidArray a file where the process number is written
     * @return boolean $res true on success and false on failure
     */
    public function execute(string $outputfile, $cmd, ...$args)
    {
        $cmd = escapeshellcmd($cmd);
        $args = $this->prepareArgs($args);

        $cmd .= " " . implode(" ", $args);
        $res = exec(sprintf("%s > %s 2>&1 & echo $!", $cmd, $outputfile), $pid);
        if ($pid) {
            return $pid[0];
        }
        return false;
    }

    /**
     * Check if a background process is running.
     *
     * @param int $pid the process id to check for
     * @return boolean $res true if running or else false
     */
    public function isRunning($pid)
    {
        try {
            $result = shell_exec(sprintf("ps %d", $pid));
            if (count(preg_split("/\n/", $result)) > 2) {
                return true;
            }
        } catch (Exception $e) {

        }
        return false;
    }

    /**
     * @param array $args
     * @return array
     */
    public function prepareArgs(array $args): array
    {
        array_walk($args, function (&$v) {
            if ($v === null || $v === '') {
                $v = "''";
            } elseif ($v === false || $v === "0" || $v === 0) {
                $v = "0";
            } else {
                $v = escapeshellarg($v);
            }
        });
        return $args;
    }
}

