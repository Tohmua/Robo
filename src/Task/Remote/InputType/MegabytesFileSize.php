<?php

namespace Robo\Task\Remote\InputType;

use Robo\Exception\TaskException;

class MegabytesFileSize implements FileSizeInterface {

    protected $megabytes = 0;

    public function __construct($megabytes)
    {
        if (!is_numeric($megabytes)) {
            throw new TaskException($this, 'Megabytes must be a number of megabytes');
        }

        $this->megabytes = (int) $megabytes;
    }

    /**
     * Return a string formatted for Wget
     *
     * @return string
     */
    public function value()
    {
        return sprintf('%sm', $this->megabytes);
    }

}
