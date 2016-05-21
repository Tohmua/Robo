<?php

use AspectMock\Test as test;
use Robo\Config;
use Robo\Task\Remote\InputType\BytesFileSize;
use Robo\Task\Remote\InputType\DaysTime;
use Robo\Task\Remote\InputType\HoursTime;
use Robo\Task\Remote\InputType\KilobytesFileSize;
use Robo\Task\Remote\InputType\MegabytesFileSize;
use Robo\Task\Remote\InputType\MinutesTime;
use Robo\Task\Remote\InputType\SecondsTime;

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

    public function testBindAddressCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->bindAddress('foo')
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --bind-address=foo");
    }

    public function testBindAddressCommandRejectsObject()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Address must be a string'
        );

        $this->container->get('taskWget')
                        ->bindAddress(new \StdClass)
                        ->getCommand();
    }

    public function testBindAddressCommandRejectsInt()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Address must be a string'
        );

        $this->container->get('taskWget')
                        ->bindAddress(10)
                        ->getCommand();
    }

    public function testTriesCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->tries(10)
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ -t 10");
    }

    public function testTriesCommandRejectsObject()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'tries must be an integer'
        );

        $this->container->get('taskWget')
                        ->tries(new \StdClass)
                        ->getCommand();
    }

    public function testTriesCommandRejectsString()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'tries must be an integer'
        );

        $this->container->get('taskWget')
                        ->tries('foo')
                        ->getCommand();
    }

    public function testOutputDocumentCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->outputDocument('foo')
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ -O foo");
    }

    public function testOutputDocumentCommandRejectsObject()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Filepath must be a string'
        );

        $this->container->get('taskWget')
                        ->outputDocument(new \StdClass)
                        ->getCommand();
    }

    public function testOutputDocumentCommandRejectsInt()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Filepath must be a string'
        );

        $this->container->get('taskWget')
                        ->outputDocument(10)
                        ->getCommand();
    }

    public function testNoClobberCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->noClobber()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ -nc");
    }

    public function testBackupsCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->backups(10)
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --backups=10");
    }

    public function testBackupsCommandRejectsObject()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Backups must be an integer'
        );

        $this->container->get('taskWget')
                        ->backups(new \StdClass)
                        ->getCommand();
    }

    public function testBackupsCommandRejectsString()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Backups must be an integer'
        );

        $this->container->get('taskWget')
                        ->backups('foo')
                        ->getCommand();
    }

    public function testContinuusCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->continuus()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ -c");
    }

    public function testStartPosCommand()
    {
        \PHPUnit_Framework_TestCase::setExpectedException('TypeError');

        $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                        ->startPos()
                        ->getCommand();
    }

    public function testStartPosCommandRejectsNotInstanceOfFileSizeInterface()
    {
        \PHPUnit_Framework_TestCase::setExpectedException('TypeError');

        $this->container->get('taskWget')
                        ->startPos(new \StdClass)
                        ->getCommand();
    }

    public function testStartPosBytesCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->startPos(new BytesFileSize(10))
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --rejected-log=10");
    }

    public function testStartPosKilobytesCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->startPos(new KilobytesFileSize(11))
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --rejected-log=11k");
    }

    public function testStartPosMegabytesCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->startPos(new MegabytesFileSize(12))
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --rejected-log=12m");
    }

    public function testProgressCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->progress('bar:force:noscroll')
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --progress=bar:force:noscroll");
    }

    public function testProgressCommandRejectsObject()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Type must be a string'
        );

        $this->container->get('taskWget')
                        ->progress(new \StdClass)
                        ->getCommand();
    }

    public function testProgressCommandRejectsInt()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Type must be a string'
        );

        $this->container->get('taskWget')
                        ->progress(10)
                        ->getCommand();
    }

    public function testShowProgressCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->showProgress()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --show-progress");
    }

    public function testTimeStampingCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->timeStamping()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ -N");
    }

    public function testNoIfModifiedSinceCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->noIfModifiedSince()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --no-if-modified-since");
    }

    public function testNoUseServerTimestampsCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->noUseServerTimestamps()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --no-use-server-timestamps");
    }

    public function testServerResponseCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->serverResponse()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ -S");
    }

    public function testSpiderCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->spider()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --spider");
    }

    public function testTimeoutCommand()
    {
        \PHPUnit_Framework_TestCase::setExpectedException('TypeError');

        $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                        ->timeout()
                        ->getCommand();
    }

    public function testTimeoutSecondsCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->timeout(new SecondsTime(10))
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ -T 10");
    }

    public function testDnsTimeoutCommand()
    {
        \PHPUnit_Framework_TestCase::setExpectedException('TypeError');

        $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                        ->dnsTimeout()
                        ->getCommand();
    }

    public function testDnsTimeoutCommandWithTime()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->dnsTimeout(new SecondsTime(10))
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --dns-timeout=10");
    }

    public function testDnsTimeoutCommandRejectsNotInstanceOfSecondsTime()
    {
        \PHPUnit_Framework_TestCase::setExpectedException('TypeError');

        $this->container->get('taskWget')
                        ->dnsTimeout(new \StdClass)
                        ->getCommand();
    }

    public function testConnectTimeoutCommand()
    {
        \PHPUnit_Framework_TestCase::setExpectedException('TypeError');

        $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                        ->connectTimeout()
                        ->getCommand();
    }

    public function testConnectTimeoutCommandWithSecondsTime()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->connectTimeout(new SecondsTime(10))
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --connect-timeout=10");
    }

    public function testReadTimeoutCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->readTimeout()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --read-timeout=900");
    }

    public function testReadTimeoutCommandSecondsTime()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->readTimeout(new SecondsTime(10))
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --read-timeout=10");
    }

    public function testLimitRateCommand()
    {
        \PHPUnit_Framework_TestCase::setExpectedException('TypeError');

        $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                        ->limitRate()
                        ->getCommand();
    }

    public function testLimitRateCommandRejectsNotInstanceOfFileSizeInterface()
    {
        \PHPUnit_Framework_TestCase::setExpectedException('TypeError');

        $this->container->get('taskWget')
                        ->limitRate(new \StdClass)
                        ->getCommand();
    }

    public function testLimitRateBytesCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->limitRate(new BytesFileSize(10))
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --limit-rate=10");
    }

    public function testLimitRateKilobytesCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->limitRate(new KilobytesFileSize(11))
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --limit-rate=11k");
    }

    public function testLimitRateMegabytesCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->limitRate(new MegabytesFileSize(12))
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --limit-rate=12m");
    }

    public function testWaitCommand()
    {
        \PHPUnit_Framework_TestCase::setExpectedException('TypeError');

        $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                        ->wait()
                        ->getCommand();
    }

    public function testWaitSecondsCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->wait(new SecondsTime(10))
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ -w 10");
    }

    public function testWaitMinutesCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->wait(new MinutesTime(11))
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ -w 11m");
    }

    public function testWaitHoursCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->wait(new HoursTime(12))
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ -w 12h");
    }

    public function testWaitDaysCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->wait(new DaysTime(13))
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ -w 13d");
    }

    public function testWaitRetryCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->waitRetry()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --waitretry=10");
    }

    public function testWaitRetryCommandWithSecondsTime()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->waitRetry(new SecondsTime(11))
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --waitretry=11");
    }

    public function testWaitRetryCommandRequiresSecondsTime()
    {
        \PHPUnit_Framework_TestCase::setExpectedException('TypeError');

        $this->container->get('taskWget')
                        ->waitRetry(new \StdClass)
                        ->getCommand();
    }

    public function testRandomWaitCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->randomWait()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --random-wait");
    }

    public function testNoProxyCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->noProxy()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --no-proxy");
    }

    public function testQuotaCommand()
    {
        \PHPUnit_Framework_TestCase::setExpectedException('TypeError');

        $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                        ->quota()
                        ->getCommand();
    }

    public function testQuotaCommandRejectsNotInstanceOfFileSizeInterface()
    {
        \PHPUnit_Framework_TestCase::setExpectedException('TypeError');

        $this->container->get('taskWget')
                        ->quota(new \StdClass)
                        ->getCommand();
    }

    public function testQuotaBytesCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->quota(new BytesFileSize(10))
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --quota=10");
    }

    public function testQuotaKilobytesCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->quota(new KilobytesFileSize(11))
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --quota=11k");
    }

    public function testQuotaMegabytesCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->quota(new MegabytesFileSize(12))
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --quota=12m");
    }

    public function testNoDnsCacheCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->noDnsCache()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --no-dns-cache");
    }

    public function testRestrictFileNamesCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->restrictFileNames('foo')
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --restrict-file-names=foo");
    }

    public function testRestrictFileNamesRejectsIntCommand()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Modes must be a string'
        );

        $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                        ->restrictFileNames(10)
                        ->getCommand();
    }

    public function testRestrictFileNamesRejectsObjectCommand()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Modes must be a string'
        );

        $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                        ->restrictFileNames(new \stdClass())
                        ->getCommand();
    }

    public function testInet4OnlyCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->inet4Only()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ -4");
    }

    public function testInet6OnlyCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->inet6Only()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ -6");
    }

    public function testPreferFamilyCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->preferFamily('foo')
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --prefer-family=foo");
    }

    public function testPreferFamilyRejectsIntCommand()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Family must be a string'
        );

        $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                        ->preferFamily(10)
                        ->getCommand();
    }

    public function testPreferFamilyRejectsObjectCommand()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Family must be a string'
        );

        $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                        ->preferFamily(new \stdClass())
                        ->getCommand();
    }

    public function testRetryConnrefusedCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->retryConnrefused()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --retry-connrefused");
    }

    public function testUserCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->user('foo')
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --user=foo");
    }

    public function testUserRejectsIntCommand()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Username must be a string'
        );

        $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                        ->user(10)
                        ->getCommand();
    }

    public function testUserRejectsObjectCommand()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Username must be a string'
        );

        $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                        ->user(new \stdClass())
                        ->getCommand();
    }

    public function testPasswordCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->password('foo')
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --password=foo");
    }

    public function testPasswordRejectsIntCommand()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Password must be a string'
        );

        $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                        ->password(10)
                        ->getCommand();
    }

    public function testPasswordRejectsObjectCommand()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Password must be a string'
        );

        $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                        ->password(new \stdClass())
                        ->getCommand();
    }

    public function testNoIriCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->noIri()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --no-iri");
    }

    public function testLocalEncodingCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->localEncoding('foo')
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --local-encoding=foo");
    }

    public function testLocalEncodingRejectsIntCommand()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Encoding must be a string'
        );

        $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                        ->localEncoding(10)
                        ->getCommand();
    }

    public function testLocalEncodingRejectsObjectCommand()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Encoding must be a string'
        );

        $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                        ->localEncoding(new \stdClass())
                        ->getCommand();
    }

    public function testRemoteEncodingCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->remoteEncoding('foo')
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --remote-encoding=foo");
    }

    public function testRemoteEncodingRejectsIntCommand()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Encoding must be a string'
        );

        $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                        ->remoteEncoding(10)
                        ->getCommand();
    }

    public function testRemoteEncodingRejectsObjectCommand()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Encoding must be a string'
        );

        $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                        ->remoteEncoding(new \stdClass())
                        ->getCommand();
    }

    public function testUnlinkCommand()
    {
        verify(
            $this->container->get('taskWget', ['http://fly.srk.fer.hr/'])
                            ->unlink()
                            ->getCommand()
        )->equals("wget http://fly.srk.fer.hr/ --unlink");
    }
}
