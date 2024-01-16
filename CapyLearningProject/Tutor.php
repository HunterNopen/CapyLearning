<?php

class Tutor extends User
{

    public $id, $login, $email, $password;
    private $idTutor, $publicName;
    public function __construct($idTutor, $publicName, $id, $login, $email, $password)
    {
        parent::__construct($id, $login, $email, $password);
        $this->idTutor = $idTutor;
        $this->publicName = $publicName;
    }

}