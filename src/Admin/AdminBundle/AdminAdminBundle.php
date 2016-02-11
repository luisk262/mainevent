<?php

namespace Admin\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AdminAdminBundle extends Bundle
{
    public function getParent() {
        return "FOSUserBundle";
    }
}
