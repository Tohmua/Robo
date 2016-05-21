<?php

namespace Robo\Task\Remote\InputType;

use Robo\Exception\TaskException;

class SecondsTime implements TimeInterface {

    protected $seconds = 0;

    public function __construct($seconds)
    {
        if (!is_numeric($seconds)) {
            throw new TaskException($this, 'Seconds must be a number of seconds');
        }

        $this->seconds = (int) $seconds;
    }

    /**
     * Return a string formatted for Wget
     *
     * @return string
     */
    public function value()
    {
        return (string) $this->seconds;
    }

}
