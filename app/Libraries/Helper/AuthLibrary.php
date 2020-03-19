<?php

namespace App\Libraries\Helper;

class AuthLibrary
{
    public function isAllowedToView()
    {
        $ipLibrary = new IpLibrary();

        return \in_array(
            $ipLibrary->getMyIp(),
            [
                '169.1.0.33', //Outie
                '195.201.169.240', //hz06
                '196.50.196.145', //tim
                '127.0.0.1', //local
                request()->server('SERVER_ADDR'), //local
            ],
            true
        );
    }
}
