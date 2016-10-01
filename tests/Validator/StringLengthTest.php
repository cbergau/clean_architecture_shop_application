<?php

namespace Bws\Validator;

class StringLengthTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var StringLength
     */
    private $validator;

    public function setUp()
    {
        $this->validator = new StringLength(array('min' => 2, 'max' => 5));
    }

    public function testGivenNullReturnsFalseAndMessageTooShort()
    {
        $this->assertFalse($this->validator->isValid(null));
        $this->assertEquals(array('STRING_TOO_SHORT'), $this->validator->getMessages());
    }

    public function testGivenTooShortStringReturnsFalseAndMessageTooShort()
    {
        $this->assertFalse($this->validator->isValid('a'));
        $this->assertEquals(array('STRING_TOO_SHORT'), $this->validator->getMessages());
    }

    public function testGivenTooLongStringReturnsFalseAndMessageTooLong()
    {
        $this->assertFalse($this->validator->isValid('abcdefgh'));
        $this->assertEquals(array('STRING_TOO_LONG'), $this->validator->getMessages());
    }

    public function testGivenValidStringReturnsTrueAndNoMessages()
    {
        $this->assertTrue($this->validator->isValid('abcd'));
        $this->assertEquals(array(), $this->validator->getMessages());
    }
}
