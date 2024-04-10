<?php

namespace App\models;
use App\models\Exceptions\InvalidCPFException;

class CPF
{
    public function __construct(private string $cpf){
        $this->setCpf();
    }

    public function __toString()
    {
        return $this->cpf;
    }

    public function getValue(): string
    {
        return $this->cpf;
    }

    public function isValid(): bool
    {
        $cpf = preg_replace('/[^0-9]/', '', $this->cpf);
    
        if (strlen($cpf) != 11) {
            return false;
        }
    
        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }
    
        // Calcula o primeiro dígito verificador
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += intval($cpf[$i]) * (10 - $i);
        }
        $digit1 = ($sum % 11 < 2) ? 0 : (11 - ($sum % 11));
    
        // Calcula o segundo dígito verificador
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += intval($cpf[$i]) * (11 - $i);
        }
        $digit2 = ($sum % 11 < 2) ? 0 : (11 - ($sum % 11));
    
        // Verifica se os dígitos verificadores estão corretos
        if ($cpf[9] != $digit1 || $cpf[10] != $digit2) {
            return false;
        }
    
        return true;
    }


    protected function setCpf(): Void
    {
        if(!$this->isValid()){
            throw new InvalidCPFException;
        }

        $this->cpf = $this->format();
    }
    

    public function format(): string 
    {
        $cpf = preg_replace('/[^0-9]/', "", $this->cpf);
        return $cpf;
    }

    public function generate(): string
    {
        $randomCPF = "";
        for ($i = 0; $i < 9; $i++) {
            $randomCPF .= mt_rand(0, 9);
        }
    
        // Calcula o primeiro dígito verificador
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += intval($randomCPF[$i]) * (10 - $i);
        }
        $digit1 = ($sum % 11 < 2) ? 0 : (11 - ($sum % 11));
    
        // Adiciona o primeiro dígito verificador
        $randomCPF .= $digit1;
    
        // Calcula o segundo dígito verificador
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += intval($randomCPF[$i]) * (11 - $i);
        }
        $digit2 = ($sum % 11 < 2) ? 0 : (11 - ($sum % 11));
    
        // Adiciona o segundo dígito verificador
        $randomCPF .= $digit2;
    
        return $randomCPF;
    }
    
    public function mask(): string
    {
        $cpf = preg_replace('/[^0-9]/', '', $this->cpf);
        return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
    }

}