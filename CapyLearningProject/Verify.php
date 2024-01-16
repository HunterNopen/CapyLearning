<?php

$dbuser = 'root';
$dbpass = '';
trait Verify
{
    private $truePassword;
    private function setPassword($passwordDb){
        $this->truePassword=$passwordDb;
    }
    public function getPassword(){
        return $this->truePassword;
    }
public function verifyPass($login,$password){
    $this->setPassword($this->truePassword);
    if ($this->getPassword()==$password){
        return true;
    }
}
}