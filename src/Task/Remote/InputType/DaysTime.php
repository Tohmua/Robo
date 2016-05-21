<?php

namespace Robo\Task\Remote\InputType;

use Robo\Exception\TaskException;

class DaysTime implements TimeInterface {

    protected $days = 0;

    public function __construct($days)
    {
        if (!is_numeric($days)) {
            throw new TaskException($this, 'Days must be a number of days');
        }

        $this->days = (int) $days;
    }

    /**
     * Return a string formatted for Wget
     *
     * @return string
     */
    public function value()
    {
        return sprintf('%dd', $this->days);
    }

}
