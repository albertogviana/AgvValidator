<?php

namespace AgvValidator\Validator;

use Core\Test\TestCase;
use AgvValidator\Validator\Cnpj;

/**
 * @group Validator
 */
class CnpjTest extends \PHPUnit_Framework_TestCase
{

    public function testInvalid()
    {
        $validator = new Cnpj();
        $this->assertFalse($validator->isValid('11.111.111/0001-11'));
    }
    
    public function testInvalidWithoutSeparate()
    {
        $validator = new Cnpj();
        $this->assertFalse($validator->isValid('11111111000111'));
    }

    public function testValidCnpj()
    {
        $validator = new Cnpj();
        $this->assertTrue($validator->isValid('96.268.838/0001-30'));
    }
    
    public function testValidCnpjWithoutSeparate()
    {
        $validator = new Cnpj();
        $this->assertTrue($validator->isValid('96268838000130'));
    }

}
