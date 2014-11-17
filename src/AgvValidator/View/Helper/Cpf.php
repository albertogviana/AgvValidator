<?php

namespace AgvValidator\Validator;

use Zend\View\Helper\AbstractHelper;

/**
 * Description of Cpf
 *
 * @author alberto
 */
class Cpf extends AbstractHelper
{
    public function __invoke($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', trim($cpf));
        if (strlen($cpf) != 11) {
            return null;
        }

        $cpfMask = substr($cpf, 0, 3) . '.';
        $cpfMask .= substr($cpf, 3, 3) . '.';
        $cpfMask .= substr($cpf, 6, 3) . '-';
        $cpfMask .= substr($cpf, 9, 3);

        return $cpfMask;
    }
}
