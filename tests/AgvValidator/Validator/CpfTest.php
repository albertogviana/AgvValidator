<?php

namespace AgvValidator\Validator;

/**
 * @group Validator
 */
class CpfTest extends \PHPUnit_Framework_TestCase
{
    public function testInvalid()
    {
        $validator = new Cpf();
        $this->assertFalse($validator->isValid('111.111.111-11'));
    }

    public function testInvalidWithoutSeparate()
    {
        $validator = new Cpf();
        $this->assertFalse($validator->isValid('11111111111'));
    }

    public function testValidCnpj()
    {
        $validator = new Cpf();
        $this->assertTrue($validator->isValid('834.116.712-38'));
    }

    public function testValidCnpjWithoutSeparate()
    {
        $validator = new Cpf();
        $this->assertTrue($validator->isValid('83411671238'));
    }
}
