<?php

namespace Robo\Task\Remote\InputType;

use Robo\Exception\TaskException;

class KilobytesFileSize implements FileSizeInterface {

    protected $kilobytes = 0;

    public function __construct($kilobytes)
    {
        if (!is_numeric($kilobytes)) {
            throw new TaskException($this, 'Kilobytes must be a number of kilobytes');
        }

        $this->kilobytes = (int) $kilobytes;
    }

    /**
     * Return a string formatted for Wget
     *
     * @return string
     */
    public function value()
    {
        return sprintf('%sk', $this->kilobytes);
    }

}
