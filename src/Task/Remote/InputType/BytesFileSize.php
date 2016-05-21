<?php

namespace Robo\Task\Remote\InputType;

use Robo\Exception\TaskException;

class BytesFileSize implements FileSizeInterface {

    protected $bytes = 0;

    public function __construct($bytes)
    {
        if (!is_numeric($bytes)) {
            throw new TaskException($this, 'Bytes must be a number of bytes');
        }

        $this->bytes = (int) $bytes;
    }

    /**
     * Return a string formatted for Wget
     *
     * @return string
     */
    public function value()
    {
        return (string) $this->bytes;
    }

}
