<?php

namespace Bws\Validator;

class RegexTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Regex
     */
    private $validator;

    public function setUp()
    {
        $this->validator = new Regex(array('pattern' => '/^[a-z]{1,2}$/'));
    }

    public function testNonMatchingValueReturnsFalseAndErrorMessage()
    {
        $this->assertFalse($this->validator->isValid('99'));
        $this->assertEquals(array('NOT_MATCH'), $this->validator->getMessages());
    }

    public function testMatchingReturnsTrueAndNoErrorMessages()
    {
        $this->assertTrue($this->validator->isValid('ae'));
        $this->assertEquals(array(), $this->validator->getMessages());
    }
}
