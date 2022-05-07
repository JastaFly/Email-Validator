<?php

namespace VMeleshkin\Validators;

class EmailValidator
{
    private $emailValidRegExp = '/^(([\wА-Яа-я]{1,})@([\wА-Яа-я]{1,}\.)+[A-Za-zА-Яа-я]{2,})$/ui';
    private $emailAddress;

    public function validateEmail(string $email)
    {
        $validateResult = $this->validate($email);

        if ($validateResult == '') {
            throw new \Exception('DATA_NO_GENERATED');
        }

        return $validateResult;
    }

    public function validate(string $email): string
    {
        if ($email == '') {
            return 'EMPTY_INPUT';
        }

        $this->emailAddress = $email;

        if ($this->validateEmailAddress()) {

            if ($this->checkMXRecord()) {
                return 'EMAIL_OK';
            } else {
                return 'EMAIL_MX_FAILED';
            }
        }

        return 'EMAIL_VALID_FAILED';
    }

    private function validateEmailAddress()
    {
        return preg_match($this->emailValidRegExp, $this->emailAddress);
    }

    private function checkMXRecord(): bool
    {
        $arMailAddress = explode('@', $this->emailAddress);

        return getmxrr($arMailAddress[1], $hosts);
    }
}
