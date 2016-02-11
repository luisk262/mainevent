<?php

namespace Admin\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Catalogo controller.
 *
 * @Route("/admin/dashboard")
 */
class DashboardController extends Controller {

    /**
     * Lists all Catalogo entities.
     *
     * @Route("/", name="dashboard")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
       
        $nombre='Aitv';
        return array(
            'nombre' => $nombre
           
        );
    }
    /**
     * Lists all Catalogo entities.
     *
     * @Route("/constructor", name="constructor")
     * @Method("GET")
     * @Template()
     */
    public function constructorAction(Request $request) {
        
        $em = $this->getDoctrine()->getEntityManager();
        //Asignamos el parametro url para luego pasarlo a ajax
        $estado = $request->query->get('Estado');
       switch ($estado) {
            case 'Activo':
                $query = $em->createQuery(
                                'SELECT h.idhv
            FROM AdminAdminBundle:Hojadevida h WHERE h.Estado =:Estado'
                        )->setParameter('Estado', $estado);
                
                break;
            case 'Inactivo':
                $query = $em->createQuery(
                                'SELECT h.idhv
            FROM AdminAdminBundle:Hojadevida h WHERE h.Estado =:Estado'
                        )->setParameter('Estado', $estado);
                
                break;
            case 'Vetado':
                $query = $em->createQuery(
                                'SELECT h.idhv
            FROM AdminAdminBundle:Hojadevida h WHERE h.Estado =:Estado'
                        )->setParameter('Estado', $estado);
                break;
            case 'Todas':
                $query = $em->createQuery(
                        'SELECT h.idhv
            FROM AdminAdminBundle:Hojadevida h'
                );
                break;
        }
        return new Response(count($query->getResult()));
    }
}
