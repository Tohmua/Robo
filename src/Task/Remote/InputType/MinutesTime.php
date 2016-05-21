<?php

namespace Robo\Task\Remote\InputType;

use Robo\Exception\TaskException;

class MinutesTime implements TimeInterface {

    protected $minutes = 0;

    public function __construct($minutes)
    {
        if (!is_numeric($minutes)) {
            throw new TaskException($this, 'Minutes must be a number of minutes');
        }

        $this->minutes = (int) $minutes;
    }

    /**
     * Return a string formatted for Wget
     *
     * @return string
     */
    public function value()
    {
        return sprintf('%dm', $this->minutes);
    }

}
