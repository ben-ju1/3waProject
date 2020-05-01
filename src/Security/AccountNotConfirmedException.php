<?php


namespace App\Security;


use Symfony\Component\Security\Core\Exception\AccountStatusException;

class AccountNotConfirmedException extends AccountStatusException
{
    public function getMessageKey()
    {
        return 'Votre compte n\'est pas activé';
    }
}