<?php

namespace Src\Components\Wallet\Domain\Interfaces;

interface ISendNotificationApi
{
    public function checkAvailability();

    public function sendData($arrUsers);
}
