<?php

namespace Admin\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
class DefaultController extends Controller {
    /**
     * @Route("/", name="principal")
     * @Template()
     */
public function indexAction()
    {
        return array();
        
    }
}
