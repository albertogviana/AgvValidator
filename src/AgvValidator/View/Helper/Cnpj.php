<?php

namespace AgvValidator\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Description of Cnpj
 *
 * @author alberto
 */
class Cnpj extends AbstractHelper
{

    public function __invoke($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', trim($cnpj));
        if (strlen($cnpj) != 14) {
            // quantidade de numeros inválidos para cnpj
            return null;
        }

        $cnpjMask = substr($cnpj, 0, 2) . '.';
        $cnpjMask .= substr($cnpj, 2, 3) . '.';
        $cnpjMask .= substr($cnpj, 5, 3) . '/';
        $cnpjMask .= substr($cnpj, 8, 4) . '-';
        $cnpjMask .= substr($cnpj, 12, 2);
        
        return $cnpjMask;
    }

}
