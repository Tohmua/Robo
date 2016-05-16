<?php

use AspectMock\Test as test;
use Robo\Config;

class WgetTest extends \Codeception\TestCase\Test
{
    protected $container;

    protected function _before()
    {
        $this->container = Config::getContainer();
        $this->container->addServiceProvider(\Robo\Task\Remote\loadTasks::getRemoteServices());
    }

    public function testBasicCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/");
    }

    public function testUrlCommand()
    {
        verify(
            $this->container->get('taskWget')
                            ->url('http://fly.srk.fer.hr/')
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/");
    }

    public function testUrlCommandRejectsObject()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Url must be a string'
        );

        $this->container->get('taskWget')
                        ->url(new \StdClass)
                        ->getCommand();
    }

    public function testUrlCommandRejectsInt()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Url must be a string'
        );

        $this->container->get('taskWget')
                        ->url(10)
                        ->getCommand();
    }

    public function testCommandCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->command('foo')
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ -e foo");
    }

    public function testCommandCommandRejectsObject()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'command must be a string'
        );

        $this->container->get('taskWget')
                        ->command(new \StdClass)
                        ->getCommand();
    }

    public function testCommandCommandRejectsInt()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'command must be a string'
        );

        $this->container->get('taskWget')
                        ->command(10)
                        ->getCommand();
    }

    public function testOutputFileCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->outputFile('foo')
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ -o foo");
    }

    public function testOutputFileCommandRejectsObject()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Filepath must be a string'
        );

        $this->container->get('taskWget')
                        ->outputFile(new \StdClass)
                        ->getCommand();
    }

    public function testOutputFileCommandRejectsInt()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Filepath must be a string'
        );

        $this->container->get('taskWget')
                        ->outputFile(10)
                        ->getCommand();
    }

    public function testAppendOutputCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->appendOutput('foo')
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ -a foo");
    }

    public function testAppendOutputCommandRejectsObject()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Filepath must be a string'
        );

        $this->container->get('taskWget')
                        ->appendOutput(new \StdClass)
                        ->getCommand();
    }

    public function testAppendOutputCommandRejectsInt()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Filepath must be a string'
        );

        $this->container->get('taskWget')
                        ->appendOutput(10)
                        ->getCommand();
    }

    public function testDebugCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->debug()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ -d");
    }

    public function testQuietCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->quiet()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ -q");
    }

    public function testVerboseCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->verbose()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ -v");
    }

    public function testNoVerboseCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->noVerbose()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ -nv");
    }

    public function testReportSpeedCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->reportSpeed()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --report-speed=bites");
    }

    public function testInputFileCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->inputFile('foo')
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ -i foo");
    }

    public function testInputFileCommandRejectsObject()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Filepath must be a string'
        );

        $this->container->get('taskWget')
                        ->inputFile(new \StdClass)
                        ->getCommand();
    }

    public function testInputFileCommandRejectsInt()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Filepath must be a string'
        );

        $this->container->get('taskWget')
                        ->inputFile(10)
                        ->getCommand();
    }

    public function testInputMetalinkCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->inputMetalink('foo')
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --input-metalink=foo");
    }

    public function testInputMetalinkCommandRejectsObject()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Filepath must be a string'
        );

        $this->container->get('taskWget')
                        ->inputMetalink(new \StdClass)
                        ->getCommand();
    }

    public function testInputMetalinkCommandRejectsInt()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Filepath must be a string'
        );

        $this->container->get('taskWget')
                        ->inputMetalink(10)
                        ->getCommand();
    }

    public function testMetalinkOverHttpCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->metalinkOverHttp()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --metalink-over-http");
    }

    public function testPreferredLocationCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->preferredLocation()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --preferred-location");
    }

    public function testForceHtmlCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->forceHtml()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ -F");
    }

    public function testBaseCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->base('foo')
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ -B foo");
    }

    public function testBaseCommandRejectsObject()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Url must be a string'
        );

        $this->container->get('taskWget')
                        ->base(new \StdClass)
                        ->getCommand();
    }

    public function testBaseCommandRejectsInt()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Url must be a string'
        );

        $this->container->get('taskWget')
                        ->base(10)
                        ->getCommand();
    }

    public function testConfigCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->config('foo')
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --config=foo");
    }

    public function testConfigCommandRejectsObject()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Filepath must be a string'
        );

        $this->container->get('taskWget')
                        ->config(new \StdClass)
                        ->getCommand();
    }

    public function testConfigCommandRejectsInt()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Filepath must be a string'
        );

        $this->container->get('taskWget')
                        ->config(10)
                        ->getCommand();
    }

    public function testRejectedLogCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->rejectedLog('foo')
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --rejected-log=foo");
    }

    public function testRejectedLogCommandRejectsObject()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Filepath must be a string'
        );

        $this->container->get('taskWget')
                        ->rejectedLog(new \StdClass)
                        ->getCommand();
    }

    public function testRejectedLogCommandRejectsInt()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Filepath must be a string'
        );

        $this->container->get('taskWget')
                        ->rejectedLog(10)
                        ->getCommand();
    }
}
