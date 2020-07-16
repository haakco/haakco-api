<?php

namespace App\Libraries\Helper;

class AuthLibrary
{
    public function isAllowedToView()
    {
        $ipLibrary = new IpLibrary();
        return \in_array(
            $ipLibrary->getMyIp(),
            array_merge(
                config('haakco.ip_authed_list'),
                [request()->server('SERVER_ADDR')] //local
            ),
            true
        );
    }
}
