<?php
namespace Robo\Task\Remote;

use Robo\Contract\CommandInterface;
use Robo\Task\BaseTask;
use Robo\Task\Remote;
use Robo\Exception\TaskException;

class Wget extends BaseTask implements CommandInterface
{
    use \Robo\Common\ExecOneCommand;
    use \Robo\Common\DynamicParams;

    protected $options = [];

    public static function init()
    {
        return new static();
    }

    public function __construct()
    {
        $this->command = 'wget';
    }

    public function url($url)
    {
        $this->url = $url;

        return $this;
    }

    public function contentDisposition()
    {
        $this->options[] = '--content-disposition';

        return $this;
    }

    public function outputFile($file)
    {
        $this->options[] = '-O ' . $file;

        return $this;
    }

    public function outputDirectory($directory)
    {
        $this->options[] = '-P ' . $directory;

        return $this;
    }

    public function run()
    {
        $command = $this->getCommand();
        $this->printTaskInfo("Running <info>{$command}</info>");

        return $this->executeCommand($command);
    }

    public function getCommand()
    {
        return $this->command . ' ' . implode(' ', $this->options) . ' ' . $this->url;
    }
}