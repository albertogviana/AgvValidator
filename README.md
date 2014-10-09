AgvValidator
============

Módulo criado para Zend Framework 2, ele possuí Validators e Helpers para CPF e CPNJ que podem ser utilizados maneira:

Habilite o módulo AgvValidator no conf/application.config.php


Validators:

	public function getInputFilterSpecification()
    {
        return array(
        	// Valida CNPJ
            'cnpj' => array(
                'required' => true,
                'filters' => array(
                    array('name' => 'Digits'),
                ),
                'validators' => array(
                    array(
                        'name' => 'AgvValidator\Validator\Cnpj',
                    ),
                ),
            ),

            // Valida CPF
            'cpf' => array(
                'required' => true,
                'filters' => array(
                    array('name' => 'Digits'),
                ),
                'validators' => array(
                    array(
                        'name' => 'AgvValidator\Validator\Cpf',
                    ),
                ),
            ),
        );
    }

Helper usado nas views:

	$this->cnpjMask('96268838000130');
	$this->cpfMask('83411671238');