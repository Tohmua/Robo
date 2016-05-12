<?php
namespace Robo\Task\Comparison;

use Robo\Result;
use Robo\Task\BaseTask;

class Strings extends BaseTask
{
    public function __construct($string1, $string2)
    {
        $this->string1 = $string1;
        $this->string2 = $string2;
    }

    public function run()
    {
        if ($this->string1 !== $this->string2) {
            return Result::error($this, 'Strings don\'t match');
        }

        return Result::success($this);
    }
}
