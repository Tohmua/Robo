<?php
namespace Robo\Task\Comparison;

trait loadTasks
{
    protected function taskCompareStrings($string1, $string2)
    {
        return new Strings($string1, $string2);
    }
}
