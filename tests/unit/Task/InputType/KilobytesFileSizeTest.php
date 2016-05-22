<?php

use Robo\Task\Remote\InputType\KilobytesFileSize;

class KilobytesFileSizeTest extends \Codeception\TestCase\Test
{
    public function testKilobytesFileSizeImplementsFileSizeInterface()
    {
        $bytes = new KilobytesFileSize(10);

        verify(
            in_array('Robo\Task\Remote\InputType\FileSizeInterface', class_implements($bytes))
        )->equals(true);
    }

    public function testKilobytesFileSizeImplementsInputTypeInterface()
    {
        $bytes = new KilobytesFileSize(10);

        verify(
            in_array('Robo\Task\Remote\InputType\InputTypeInterface', class_implements($bytes))
        )->equals(true);
    }

    public function testKilobytesFileSizeWithNoParam()
    {
        \PHPUnit_Framework_TestCase::setExpectedException('PHPUnit_Framework_Exception');

        $bytes = new KilobytesFileSize();
    }

    public function testKilobytesFileSizeWithInt()
    {
        $bytes = new KilobytesFileSize(10);

        verify(
            $bytes->value()
        )->equals('10k');
    }

    public function testKilobytesFileSizeWithIntAsString()
    {
        $bytes = new KilobytesFileSize('11');

        verify(
            $bytes->value()
        )->equals('11k');
    }

    public function testKilobytesFileSizeWithFloat()
    {
        $bytes = new KilobytesFileSize(1.1);

        verify(
            $bytes->value()
        )->equals('1.1k');
    }

    public function testKilobytesFileSizeWithFloatAsString()
    {
        $bytes = new KilobytesFileSize('1.1');

        verify(
            $bytes->value()
        )->equals('1.1k');
    }

    public function testKilobytesFileSizeWithString()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Kilobytes must be a number of kilobytes'
        );

        $bytes = new KilobytesFileSize('foo');
    }

    public function testKilobytesFileSizeWithObject()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Kilobytes must be a number of kilobytes'
        );

        $bytes = new KilobytesFileSize(new \stdClass());
    }
}