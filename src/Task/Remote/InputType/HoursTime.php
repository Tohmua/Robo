<?php

namespace Robo\Task\Remote\InputType;

use Robo\Exception\TaskException;

class HoursTime implements TimeInterface {

    protected $hours = 0;

    public function __construct($hours)
    {
        if (!is_numeric($hours)) {
            throw new TaskException($this, 'Hours must be a number of hours');
        }

        $this->hours = (int) $hours;
    }

    /**
     * Return a string formatted for Wget
     *
     * @return string
     */
    public function value()
    {
        return sprintf('%dh', $this->hours);
    }

}
