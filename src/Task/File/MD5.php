<?php

namespace Robo\Task\File;

use Robo\Result;
use Robo\Task\BaseTask;

class MD5 extends BaseTask
{
    // use \Robo\Common\DynamicParams;
    use \Robo\Common\ExecOneCommand;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function run()
    {
        $md5 = $this->executeCommand('md5sum ' . $this->filename);

        return substr($md5->getMessage(), 0, 32);
    }
}
