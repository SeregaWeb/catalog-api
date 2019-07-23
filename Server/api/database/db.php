<?php

class db 
{   
    private $connect;

    public function getConnection()
    {
        $this->connect = new PDO('mysql:host='.HOST.';dbname='.DB.'', USER, PASSWORD);

        return $this->connect;
    }
    
}