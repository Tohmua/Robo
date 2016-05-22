<?php

use Robo\Task\Remote\InputType\SecondsTime;

class SecondsTimeTest extends \Codeception\TestCase\Test
{
    public function testSecondsTimeImplementsFileSizeInterface()
    {
        $bytes = new SecondsTime(10);

        verify(
            in_array('Robo\Task\Remote\InputType\TimeInterface', class_implements($bytes))
        )->equals(true);
    }

    public function testSecondsTimeImplementsInputTypeInterface()
    {
        $bytes = new SecondsTime(10);

        verify(
            in_array('Robo\Task\Remote\InputType\InputTypeInterface', class_implements($bytes))
        )->equals(true);
    }

    public function testSecondsTimeWithNoParam()
    {
        \PHPUnit_Framework_TestCase::setExpectedException('PHPUnit_Framework_Exception');

        $bytes = new SecondsTime();
    }

    public function testSecondsTimeWithInt()
    {
        $bytes = new SecondsTime(10);

        verify(
            $bytes->value()
        )->equals('10');
    }

    public function testSecondsTimeWithIntAsString()
    {
        $bytes = new SecondsTime('11');

        verify(
            $bytes->value()
        )->equals('11');
    }

    public function testSecondsTimeWithFloat()
    {
        $bytes = new SecondsTime(1.1);

        verify(
            $bytes->value()
        )->equals('1');
    }

    public function testSecondsTimeWithFloatAsString()
    {
        $bytes = new SecondsTime('1.1');

        verify(
            $bytes->value()
        )->equals('1');
    }

    public function testSecondsTimeWithString()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Seconds must be a number of seconds'
        );

        $bytes = new SecondsTime('foo');
    }

    public function testSecondsTimeWithObject()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Seconds must be a number of seconds'
        );

        $bytes = new SecondsTime(new \stdClass());
    }
}