<?php

use Robo\Task\Remote\InputType\HoursTime;

class HoursTimeTest extends \Codeception\TestCase\Test
{
    public function testHoursTimeImplementsFileSizeInterface()
    {
        $bytes = new HoursTime(10);

        verify(
            in_array('Robo\Task\Remote\InputType\TimeInterface', class_implements($bytes))
        )->equals(true);
    }

    public function testHoursTimeImplementsInputTypeInterface()
    {
        $bytes = new HoursTime(10);

        verify(
            in_array('Robo\Task\Remote\InputType\InputTypeInterface', class_implements($bytes))
        )->equals(true);
    }

    public function testHoursTimeWithInt()
    {
        $bytes = new HoursTime(10);

        verify(
            $bytes->value()
        )->equals('10h');
    }

    public function testHoursTimeWithIntAsString()
    {
        $bytes = new HoursTime('11');

        verify(
            $bytes->value()
        )->equals('11h');
    }

    public function testHoursTimeWithFloat()
    {
        $bytes = new HoursTime(1.1);

        verify(
            $bytes->value()
        )->equals('1h');
    }

    public function testHoursTimeWithFloatAsString()
    {
        $bytes = new HoursTime('1.1');

        verify(
            $bytes->value()
        )->equals('1h');
    }

    public function testHoursTimeWithString()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Hours must be a number of hours'
        );

        $bytes = new HoursTime('foo');
    }

    public function testHoursTimeWithObject()
    {
        \PHPUnit_Framework_TestCase::setExpectedException(
            'Robo\Exception\TaskException',
            'Hours must be a number of hours'
        );

        $bytes = new HoursTime(new \stdClass());
    }
}