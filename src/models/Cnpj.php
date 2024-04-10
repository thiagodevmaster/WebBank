<?php

namespace App\models;
use App\models\Exceptions\InvalidCNPJException;

class Cnpj 
{

    public function __construct(private string $cnpj)
    {
        $this->setCnpj();
    }

    public function __toString()
    {
        return $this->cnpj;
    }

    public function getValue(): string
    {
        return $this->cnpj;
    }

    public function isValid(): bool
    {
        $cnpj = preg_replace('/[^0-9]/', '', $this->cnpj);
    
        if (strlen($cnpj) != 14) {
            return false;
        }
    
        if (preg_match('/^(\d)\1{13}$/', $cnpj)) {
            return false;
        }
    
        // Calcula o primeiro dígito verificador
        $sum = 0;
        $multipliers = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        for ($i = 0; $i < 12; $i++) {
            $sum += intval($cnpj[$i]) * $multipliers[$i];
        }
        $digit1 = ($sum % 11 < 2) ? 0 : (11 - ($sum % 11));
    
        // Calcula o segundo dígito verificador
        $sum = 0;
        $multipliers = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        for ($i = 0; $i < 13; $i++) {
            $sum += intval($cnpj[$i]) * $multipliers[$i];
        }
        $digit2 = ($sum % 11 < 2) ? 0 : (11 - ($sum % 11));
    
        // Verifica se os dígitos verificadores estão corretos
        if ($cnpj[12] != $digit1 || $cnpj[13] != $digit2) {
            return false;
        }
    
        return true;
    }

    public function format(): string 
    {
        $cnpj = preg_replace('/[^0-9]/', "", $this->cnpj);
        if (strlen($cnpj) != 14) {
            throw new InvalidCnpjException("CNPJ inválido.");
        }
        return $cnpj;
    }

    public function generate(): string
    {
        $randomCnpj = "";
        for ($i = 0; $i < 12; $i++) {
            $randomCnpj .= mt_rand(0, 9);
        }
    
        // Calcula o primeiro dígito verificador
        $sum = 0;
        $multipliers = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        for ($i = 0; $i < 12; $i++) {
            $sum += intval($randomCnpj[$i]) * $multipliers[$i];
        }
        $digit1 = ($sum % 11 < 2) ? 0 : (11 - ($sum % 11));
    
        // Adiciona o primeiro dígito verificador
        $randomCnpj .= $digit1;
    
        // Calcula o segundo dígito verificador
        $sum = 0;
        $multipliers = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        for ($i = 0; $i < 13; $i++) {
            $sum += intval($randomCnpj[$i]) * $multipliers[$i];
        }
        $digit2 = ($sum % 11 < 2) ? 0 : (11 - ($sum % 11));
    
        // Adiciona o segundo dígito verificador
        $randomCnpj .= $digit2;
    
        return $randomCnpj;
    }
    
    public function mask(): string
    {
        $cnpj = preg_replace('/[^0-9]/', '', $this->cnpj);
        return substr($cnpj, 0, 2) . '.' . substr($cnpj, 2, 3) . '.' . substr($cnpj, 5, 3) . '/' . substr($cnpj, 8, 4) . '-' . substr($cnpj, 12, 2);
    }


    protected function setCnpj(): void
    {
        if(!$this->isValid()){
            throw new InvalidCNPJException;
        }

        $this->cnpj = $this->format();
    }
}