<?php

use Robo\Task\Remote\InputType\BytesFileSize;

class BytesFileSizeTest extends \Codeception\TestCase\Test
{
    public function testBytesFileSizeImplementsFileSizeInterface()
    {
        $bytes = new BytesFileSize(10);

        verify(
            in_array('Robo\Task\Remote\InputType\FileSizeInterface', class_implements($bytes))
        )->equals(true);
    }

    public function testBytesFileSizeImplementsInputTypeInterface()
    {
        $bytes = new BytesFileSize(10);

        verify(
            in_array('Robo\Task\Remote\InputType\InputTypeInterface', class_implements($bytes))
        )->equals(true);
    }

    public function testBytesFileSizeWithInt()
    {
        $bytes = new BytesFileSize(10);

        verify(
            $bytes->value()
        )->equals('10');
    }

    public function testBytesFileSizeWithIntAsString()
    {
        $bytes = new BytesFileSize('11');

        verify(
            $bytes->value()
        )->equals('11');
    }

    public function testBytesFileSizeWithFloat()
    {
        $bytes = new BytesFileSize(1.1);

        verify(
            $bytes->value()
        )->equals('1');
    }

    public function testBytesFileSizeWithFloatAsString()
    {
        $bytes = new BytesFileSize('1.1');

        verify(
            $bytes->value()
        )->equals('1');
    }

    public function testBytesFileSizeWithString()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Bytes must be a number of bytes'
        );

        $bytes = new BytesFileSize('foo');
    }

    public function testBytesFileSizeWithObject()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Bytes must be a number of bytes'
        );

        $bytes = new BytesFileSize(new \stdClass());
    }
}