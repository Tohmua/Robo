<?php

use Robo\Task\Remote\InputType\DaysTime;

class DaysTimeTest extends \Codeception\TestCase\Test
{
    public function testDaysTimeImplementsFileSizeInterface()
    {
        $bytes = new DaysTime(10);

        verify(
            in_array('Robo\Task\Remote\InputType\TimeInterface', class_implements($bytes))
        )->equals(true);
    }

    public function testDaysTimeImplementsInputTypeInterface()
    {
        $bytes = new DaysTime(10);

        verify(
            in_array('Robo\Task\Remote\InputType\InputTypeInterface', class_implements($bytes))
        )->equals(true);
    }

    public function testDaysTimeWithInt()
    {
        $bytes = new DaysTime(10);

        verify(
            $bytes->value()
        )->equals('10d');
    }

    public function testDaysTimeWithIntAsString()
    {
        $bytes = new DaysTime('11');

        verify(
            $bytes->value()
        )->equals('11d');
    }

    public function testDaysTimeWithFloat()
    {
        $bytes = new DaysTime(1.1);

        verify(
            $bytes->value()
        )->equals('1d');
    }

    public function testDaysTimeWithFloatAsString()
    {
        $bytes = new DaysTime('1.1');

        verify(
            $bytes->value()
        )->equals('1d');
    }

    public function testDaysTimeWithString()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Days must be a number of days'
        );

        $bytes = new DaysTime('foo');
    }

    public function testDaysTimeWithObject()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Days must be a number of days'
        );

        $bytes = new DaysTime(new \stdClass());
    }
}