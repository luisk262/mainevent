<?php

namespace Admin\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Admin\AdminBundle\Entity\Hojadevida;
use Admin\AdminBundle\Form\RegistroType;
use DateTime;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Catalogo controller.
 *
 * @Route("/registro")
 */
class RegistroController extends Controller {

    /**
     * Displays a form to create a new Hojadevida entity.
     *
     * @Route("/msg", name="registro_mensaje")
     * @Method("GET")
     * @Template("AdminAdminBundle:Vistas:mensaje.html.twig")
     */
    public function mensajeAction() {

        $request = $this->getRequest();
        $errormsg = '';
        $nombre = $request->query->get('nombre');
        $error = $request->query->get('error');
        $errormsg = $request->query->get('errormsg');
        $id = $request->query->get('id');
        //Asignamos el parametro 
        return array(
            'nombre' => $nombre,
            'error' => $error,
            'id' => $id,
            'errormsg' => $errormsg);
    }

    /**
     * Displays a form to create a new Hojadevida entity.
     *
     * @Route("/new", name="registro_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {

        $entity = new Hojadevida();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }
    /**
     * Displays a form to create a new Hojadevida entity.
     *
     * @Route("/terminos", name="terminos")
     * @Method("GET")
     * @Template("AdminAdminBundle:Vistas:terminos.html.twig")
     */
    public function terminosAction() {
        return array();
    }

    /**
     * Creates a form to create a Hojadevida entity.
     *
     * @param registro $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Hojadevida $entity) {
        $form = $this->createForm(new RegistroType(), $entity, array(
            'action' => $this->generateUrl('registro_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Creates a new Hojadevida entity.
     *
     * @Route("/", name="registro_create")
     * @Method("POST")
     * @Template("AdminAdminBundle:Registro:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Hojadevida();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $id = 0;
            //creamos una conexion a la base de datos
            $em = $this->getDoctrine()->getEntityManager();
            //realizamos un query sencillo para contar cuantos registros ahi en bd
            $query = $em->createQuery(
                            'SELECT h
                FROM AdminAdminBundle:Hojadevida h WHERE h.nit = :Nit OR h.emailPersonal =:Email'
                    )->setParameter('Nit', $entity->getNit())
                    ->setParameter('Email', $entity->getEmailPersonal());

            //adquirimos el array
            if ($query->getResult()) {
                $errormsg = 'La hoja de vida ya esta registrada';
                return $this->redirect($this->generateUrl('registro_mensaje', array(
                                    'nombre' => $entity->getEmailPersonal(),
                                    'error' => true,
                                    'errormsg' => $errormsg,
                                    'id' => $id
                )));
            } else {
                $date = new DateTime('now', new \DateTimeZone('America/Bogota'));
                $entity->setFecha($date);
                $entity->setFechaupdate($date);
                $entity->setEstado('Inactivo');
                $id = $entity->getIdhv();
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);

                $em->flush();
                $error = false;
                $errormsg = 'La hoja de vida fue registrada con exito';
                return $this->redirect($this->generateUrl('registro_mensaje', array(
                                    'nombre' => $entity->getEmailPersonal(),
                                    'error' => $error,
                                    'errormsg' => $errormsg,
                                    'id' => $id
                )));
            }
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    
    public function correoAction(){
        $em = $this->getDoctrine()->getEntityManager();
            //realizamos un query sencillo para contar cuantos registros ahi en bd
            $query = $em->createQuery(
                            'SELECT h.emailPersonal
                FROM AdminAdminBundle:Hojadevida h'
                    );

            //adquirimos el array
            if ($query->getResult()) {
                 $entryQueryfinal = $query->getQuery();
        //obtenemos el array de resultados
        $entities = $entryQueryfinal->getResult();
            $Body='prueba';
            $correo_remitente = 'maineventltda@gmail.com';
            $names='prueba';
            $Subject='asunto';
            foreach( $entities as $entity){
                $email=$entity->getEmailPersonal();
                enviaremail($Body, $Subject, $email, $correo_remitente, $names);
                
            } 
            }
    }

}
