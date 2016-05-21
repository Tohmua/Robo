<?php

namespace Robo\Task\Remote\InputType;

interface InputTypeInterface {

    /**
     * Return a string formatted for Wget
     *
     * @return string
     */
    public function value();
}