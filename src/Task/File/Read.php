<?php

namespace Robo\Task\File;

use Robo\Result;
use Robo\Task\BaseTask;

class Read extends BaseTask
{
    use \Robo\Common\DynamicParams;

    protected $filename;
    protected $append = false;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    protected function getContents()
    {
        return file_get_contents($this->filename);
    }

    public function run()
    {
        $this->printTaskInfo("Reading from <info>{$this->filename}</info>.");

        return $this->getContents();
    }

    public function getPath()
    {
        return $this->filename;
    }
}
