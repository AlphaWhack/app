<?php

namespace WhackUp\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class WhackUpUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }

}
