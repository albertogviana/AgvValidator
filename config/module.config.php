<?php

namespace AgvBootstrap;

return array(
    'view_helpers' => array(
        'invokables' => array(
            'cnpjMask' => 'AgvValidator\View\Helper\Cnpj',
            'cpfMask' => 'AgvValidator\View\Helper\Cpf',
        ),
    ),
);
