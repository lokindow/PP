<?php

namespace Src\Components\Users\Domain;

class User
{
    private $id;
    private $name;
    private $email;
    private $cpf;
    private $cnpj;
    private $password;
    private $type;

    public function __construct($arrArgs)
    {
        foreach ($arrArgs as $prop => $value) {
            if (property_exists($this, $prop)) {
                $this->{$prop} = $value;
            }
        }

        $this->setPasswordEncode();
        $this->setTypeUser();
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of cpf_cnpj
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the value of cnpj
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * Get the value of type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return void
     */
    public function setTypeUser(): void
    {
        if (!empty($this->cpf)) {
            $this->type = "user";
        } elseif (!empty($this->cnpj)) {
            $this->type = "seller";
        }
    }

    /**
     * Set the encode of password
     *
     * @return void
     */
    public function setPasswordEncode(): void
    {
        if (!empty($this->password)) {
            $this->password = base64_encode($this->password);
        }
    }

    public function validate()
    {
        $arrErrors = [];

        if (is_null($this->name)) {
            $arrErrors[] = [
                "validation" => 'validation.required',
                "extra" => ['key' => 'name', 'attribute' => 'name null']
            ];
        }

        if (is_null($this->email) or $this->validaEmail($this->email) == false) {
            $arrErrors[] = [
                "validation" => 'validation.required',
                "extra" => ['key' => 'email', 'attribute' => 'email null']
            ];
        }
        if (!(is_null($this->cpf)) and $this->validaCPF($this->cpf) == false) {
            $arrErrors[] = [
                "validation" => 'validation.required',
                "extra" => ['key' => 'cpf', 'attribute' => 'cpf inválido']
            ];
        }

        if (!(is_null($this->cnpj)) and $this->validaCNPJ($this->cnpj) == false) {
            $arrErrors[] = [
                "validation" => 'validation.required',
                "extra" => ['key' => 'cnjpj', 'attribute' => 'cnpj inválido']
            ];
        }

        if (is_null($this->type)) {
            $arrErrors[] = [
                "validation" => 'validation.required',
                "extra" => ['key' => 'cpf e cnpj', 'attribute' => 'cpf e cnpj invalidos']
            ];
        }

        if (is_null($this->password)) {
            $arrErrors[] = [
                "validation" => 'validation.required',
                "extra" => ['key' => 'cep', 'attribute' => 'cep invalido']
            ];
        }

        return $arrErrors;
    }

    private function validaCPF($cpf)
    {

        // Extrai somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    // Validar numero de CNPJ
    private function validaCNPJ($cnpj)
    {
        // Remover caracteres especias
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj))
            return false;

        $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        for ($i = 0, $n = 0; $i < 12; $n += $cnpj[$i] * $b[++$i]);

        if ($cnpj[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        for ($i = 0, $n = 0; $i <= 12; $n += $cnpj[$i] * $b[$i++]);

        if ($cnpj[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;
    }

    private function validaEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
}
