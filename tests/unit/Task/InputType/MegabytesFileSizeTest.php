<?php

use Robo\Task\Remote\InputType\MegabytesFileSize;

class MegabytesFileSizeTest extends \Codeception\TestCase\Test
{
    public function testMegabytesFileSizeImplementsFileSizeInterface()
    {
        $bytes = new MegabytesFileSize(10);

        verify(
            in_array('Robo\Task\Remote\InputType\FileSizeInterface', class_implements($bytes))
        )->equals(true);
    }

    public function testMegabytesFileSizeImplementsInputTypeInterface()
    {
        $bytes = new MegabytesFileSize(10);

        verify(
            in_array('Robo\Task\Remote\InputType\InputTypeInterface', class_implements($bytes))
        )->equals(true);
    }

    public function testMegabytesFileSizeWithInt()
    {
        $bytes = new MegabytesFileSize(10);

        verify(
            $bytes->value()
        )->equals('10m');
    }

    public function testMegabytesFileSizeWithIntAsString()
    {
        $bytes = new MegabytesFileSize('11');

        verify(
            $bytes->value()
        )->equals('11m');
    }

    public function testMegabytesFileSizeWithFloat()
    {
        $bytes = new MegabytesFileSize(1.1);

        verify(
            $bytes->value()
        )->equals('1.1m');
    }

    public function testMegabytesFileSizeWithFloatAsString()
    {
        $bytes = new MegabytesFileSize('1.1');

        verify(
            $bytes->value()
        )->equals('1.1m');
    }

    public function testMegabytesFileSizeWithString()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Megabytes must be a number of megabytes'
        );

        $bytes = new MegabytesFileSize('foo');
    }

    public function testMegabytesFileSizeWithObject()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Megabytes must be a number of megabytes'
        );

        $bytes = new MegabytesFileSize(new \stdClass());
    }
}