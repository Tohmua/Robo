<?php

use Robo\Task\Remote\InputType\MinutesTime;

class MinutesTimeTest extends \Codeception\TestCase\Test
{
    public function testMinutesTimeImplementsFileSizeInterface()
    {
        $bytes = new MinutesTime(10);

        verify(
            in_array('Robo\Task\Remote\InputType\TimeInterface', class_implements($bytes))
        )->equals(true);
    }

    public function testMinutesTimeImplementsInputTypeInterface()
    {
        $bytes = new MinutesTime(10);

        verify(
            in_array('Robo\Task\Remote\InputType\InputTypeInterface', class_implements($bytes))
        )->equals(true);
    }

    public function testMinutesTimeWithInt()
    {
        $bytes = new MinutesTime(10);

        verify(
            $bytes->value()
        )->equals('10m');
    }

    public function testMinutesTimeWithIntAsString()
    {
        $bytes = new MinutesTime('11');

        verify(
            $bytes->value()
        )->equals('11m');
    }

    public function testMinutesTimeWithFloat()
    {
        $bytes = new MinutesTime(1.1);

        verify(
            $bytes->value()
        )->equals('1m');
    }

    public function testMinutesTimeWithFloatAsString()
    {
        $bytes = new MinutesTime('1.1');

        verify(
            $bytes->value()
        )->equals('1m');
    }

    public function testMinutesTimeWithString()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Minutes must be a number of minutes'
        );

        $bytes = new MinutesTime('foo');
    }

    public function testMinutesTimeWithObject()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Minutes must be a number of minutes'
        );

        $bytes = new MinutesTime(new \stdClass());
    }
}