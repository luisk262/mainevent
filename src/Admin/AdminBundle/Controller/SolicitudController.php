<?php

namespace Admin\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Admin\AdminBundle\Entity\Solicitud;
use Admin\AdminBundle\Entity\UsuarioSolicitud;
use Admin\AdminBundle\Form\SolicitudType;
use Admin\AdminBundle\Pagination\Paginator;
use DateTime;

/**
 * Solicitud controller.
 *
 * @Route("/admin/solicitud")
 */
class SolicitudController extends Controller {

    /**
     * Lists all Solicitud entities.
     *
     * @Route("/estado/{estado}", name="solicitud")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($estado) {
        //verificamos que usuario se encuentra logeado
        $security_context = $this->get('security.context');
        //abrimos conexion con bd
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $page = $request->query->get('page');
        $searchParam = $request->get('searchParam');
        $total_count=0;        
///procedemos a averiguar cual rol tiene el usuario
        if ($this->get('security.context')->isGranted('ROLE_CORDI') ||
                $this->get('security.context')->isGranted('ROLE_ADMIN') ||
                $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            $entryQuery = $em->createQueryBuilder()
                    ->select('S')
                    ->from('AdminAdminBundle:Solicitud', 'S')
                    ->andWhere('S.estado=:estado')
                    ->addOrderBy('S.fechainicio', 'DESC')
                    ->setParameter('estado', $estado);
        } else {
            $security_token = $security_context->getToken();
            //definimos el usuario, con rol diferentea cordinador, administrador,suberadmin,usuario
            $user = $security_token->getUser();
            //buscamos solicitudes generadas por usuario 
            $query = $em->createQuery(
                            'SELECT c
                            FROM AdminAdminBundle:UsuarioSolicitud c
                            WHERE c.idUsuario  =:idUsuario'
                    )->setParameter('idUsuario', $user->getId())
            ;
            if ($query->getResult()) {
                $aux = $query->getResult();
                $UsuarioSolicitud = $query->getResult();
                foreach ($UsuarioSolicitud as $aux) {
                    $ids[] = $aux->getIdSolicitud(); //convertimos la consulta en un array
                }
                
        
            } else {
                $ids[] = null;
            }
            $entryQuery = $em->createQueryBuilder()
                    ->select('S')
                    ->from('AdminAdminBundle:Solicitud', 'S')
                    ->andWhere('S.idSolicitud in (:ids)')
                    ->andWhere('S.estado=:estado')
                    ->addOrderBy('S.fechainicio', 'DESC')
                    ->setParameter('estado', $estado)
                    ->setParameter('ids', $ids);
        }



        $entryQueryfinal = $entryQuery->getQuery();
        //obtenemos el array de resultados
        $entities = $entryQueryfinal->getArrayResult();
        $aux = $entities;
        if ($estado == 'Tramite') {
            // en caso que el estado sea en tramite se verifica se buscan todos los catalogos con el fin de verificar en el formulario
            $catalogo = $em->getRepository('AdminAdminBundle:SolicitudCatalogo')->findAll();
        } else {
            $catalogo = null;
        }
        
        //sacamos el numero total de registros
        $total_count = count($aux);
        return array(
            'entities' => $entities,
            'catalogo' => $catalogo,
            'Estado'=>$estado,
            'current_page' => $page,
            'entitiesLength' => $total_count,
            'searchParam' =>$searchParam
        );
    }
    /**
     * consulta a Solicitud entity.
     *
     * @Route("/{Estado}/ajax/consulta", name="Solicitud_ajax")
     * @Method("GET")
     */
    public function ajaxListAction(Request $request, $Estado) {
        //verificamos que usuario se encuentra logeado
        $security_context = $this->get('security.context');
        //abrimos conexion con bd
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $page = $request->query->get('page');
        $searchParam = $request->get('searchParam');
        $estado = $Estado;     
        ///procedemos a averiguar cual rol tiene el usuario
        if ($this->get('security.context')->isGranted('ROLE_CORDI') ||
                $this->get('security.context')->isGranted('ROLE_ADMIN') ||
                $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            $entryQuery = $em->createQueryBuilder()
                    ->select('S')
                    ->from('AdminAdminBundle:Solicitud', 'S')
                    ->andWhere('S.estado=:estado')
                    ->addOrderBy('S.fechainicio', 'DESC')
                    ->setParameter('estado', $estado);
            
            /////
            $queryaux = $em->createQueryBuilder()
                ->select('COUNT(S)')
                ->from('AdminAdminBundle:Solicitud', 'S')
                ->andWhere('S.estado=:estado')
                ->addOrderBy('S.fechainicio', 'DESC')
                ->setParameter('estado', $estado);
            
        
        } else {
            $security_token = $security_context->getToken();
            //definimos el usuario, con rol diferentea cordinador, administrador,suberadmin,usuario
            $user = $security_token->getUser();
            //buscamos solicitudes generadas por usuario 
            $query = $em->createQuery(
                            'SELECT c
                            FROM AdminAdminBundle:UsuarioSolicitud c
                            WHERE c.idUsuario  =:idUsuario'
                    )->setParameter('idUsuario', $user->getId())
            ;
            ////
            $queryaux = $em->createQueryBuilder()
                ->select('COUNT(US)')
                    ->from('AdminAdminBundle:UsuarioSolicitud', 'US')
                    ->andWhere('US.idUsuario=:idUsuario')
                    ->setParameter('idUsuario', $user->getId());
            if ($query->getResult()) {
                $aux = $query->getResult();
                $UsuarioSolicitud = $query->getResult();
                foreach ($UsuarioSolicitud as $aux) {
                    $ids[] = $aux->getIdSolicitud(); //convertimos la consulta en un array
                }
                
        
            } else {
                $ids[] = null;
            }
            $entryQuery = $em->createQueryBuilder()
                    ->select('S')
                    ->from('AdminAdminBundle:Solicitud', 'S')
                    ->andWhere('S.idSolicitud in (:ids)')
                    ->andWhere('S.estado=:estado')
                    ->addOrderBy('S.fechainicio', 'DESC')
                    ->setParameter('estado', $estado)
                    ->setParameter('ids', $ids);
            $queryaux = $em->createQueryBuilder()
                ->select('COUNT(S)')
                    ->from('AdminAdminBundle:Solicitud', 'S')
                    ->andWhere('S.idSolicitud in (:ids)')
                    ->andWhere('S.estado=:estado')
                    ->addOrderBy('S.fechainicio', 'DESC')
                    ->setParameter('estado', $estado)
                    ->setParameter('ids', $ids);
        }
        $entryQueryfinal = $entryQuery->getQuery();
        //obtenemos el array de resultados
        $entities = $entryQueryfinal->getArrayResult();
        $aux = $entities;
        if ($estado == 'Tramite') {
            // en caso que el estado sea en tramite se verifica se buscan todos los catalogos con el fin de verificar en el formulario
            $catalogo = $em->getRepository('AdminAdminBundle:SolicitudCatalogo')->findAll();
        } else {
            $catalogo = null;
        }               
        $total_count = $queryaux->getQuery()->getSingleScalarResult();
        
        if (!empty($perPage))
        $entryQuery->setFirstResult(($page - 1) * $perPage)->setMaxResults($perPage);
        $entryQueryfinal = $entryQuery->getQuery();
        //obtenemos el array de resultados
        $entities = $entryQueryfinal->getArrayResult();
        $pagination = (new Paginator())->setItems($total_count, $searchParam['perPage'])->setPage($searchParam['page'])->toArray();
//buscamos los usuarios que crearon la solicutud
$query = $em->createQuery(
                            'SELECT c
                            FROM AdminAdminBundle:UsuarioSolicitud c
                            '
                    );
$TotalUS = $query->getResult();
//renderizamos la vista para mostrar las hojas de vida
        return $this->render('AdminAdminBundle:Solicitud:ajax_list.html.twig', array(
                    'entities' => $entities,
                    'pagination' => $pagination,
                    'Estado' => $estado,
                    'TotalUS' =>$TotalUS,
                    'total_pages' => 10,
                    'current_page' => 10,
                    'count_per_page' => 10,
                    'restar' => 10,
                    'query' => true
        ));
    }


    /**
     * Creates a new Solicitud entity.
     *
     * @Route("/", name="solicitud_create")
     * @Method("POST")
     * @Template("AdminAdminBundle:Solicitud:new.html.twig")
     */
    public function createAction(Request $request) {

        $entity = new Solicitud();
        $Usuarioentity = new UsuarioSolicitud();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $date = new DateTime('now', new \DateTimeZone('America/Bogota'));
            $date->format('yyyy-MM-dd HH:i');
            $entity->setFecha($date);
            $entity->setFechaupdate($date);
            $entity->setEstado('Pendiente');
            $em = $this->getDoctrine()->getManager();
            //guardamos en bd
            $em->persist($entity);
            $em->flush();
            //verificamos que usuario se encuentra logeado
            $user = $this->get('security.context')->getToken()->getUser();
            //si es super administrador no genere el registro
            if ($this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
                
            } else {
                //verificamos que usuario se encuentra logeado
                $security_context = $this->get('security.context');
                $security_token = $security_context->getToken();
                //definimos el usuario, con rol diferentea cordinador, administrador,suberadmin,usuario
                $user = $security_token->getUser();

                $Usuarioentity->setIdUsuario($user);
                $Usuarioentity->setIdSolicitud($entity);
                //guardamos en base de datos
                $em->persist($Usuarioentity);
                $em->flush();
            }

            ///procedemos a notificar a los coordinadores
            $em = $this->getDoctrine()->getManager();
            //creamos query de consulta, para buscar todos los coordinadores activos en la base de datos
            $query = $em->createQuery(
                            'SELECT u
                        FROM AdminAdminBundle:User u
                        WHERE u.roles  LIKE :roles'
                    )->setParameter('roles', '%"ROLE_CORDI"%');
            if ($query->getResult()) {
                ///procedemos a notificar a los coordinadores  enviando email
                $coordinadores = $query->getResult();
                foreach ($coordinadores as $coordinador) {
                    $names = $coordinador->getNombre() . ' ' . $coordinador->getApellidos();
                    $email = $coordinador->getEmail();
                    $Subject = 'Mainevent Informa';
                    $Body = 'Llego trabajo, Es hora de laborar!!.';
                    $correo = 'maineventltda@gmail.com';
                    $nombregraba = $entity->getNombre();
                    $detalle = $entity->getObservaciones();
                    $message = \Swift_Message::newInstance()
                            ->setSubject($Subject)
                            ->setFrom($correo)
                            ->setTo($email)
                            ->setBody(
                            <<<EOF
                Nombres: $names
                Asunto: $Subject
                Nombre: $nombregraba
                Detalle: $detalle
                $Body
EOF
                            )
                    ;
                    $this->get('mailer')->send($message);
                }
                ///notificamos al usuario que ha sido activado, enviandole un correo electronico
                return $this->redirect($this->generateUrl('solicitud_show', array('id' => $entity->getIdSolicitud())));
            } else {
                return $this->redirect($this->generateUrl('solicitud_show', array('id' => $entity->getIdSolicitud())));
            }
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Solicitud entity.
     *
     * @param Solicitud $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Solicitud $entity) {
        $form = $this->createForm(new SolicitudType(), $entity, array(
            'action' => $this->generateUrl('solicitud_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear Solicitud', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }

    /**
     * Displays a form to create a new Solicitud entity.
     *
     * @Route("/new", name="solicitud_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Solicitud();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Solicitud entity.
     *
     * @Route("/{id}", name="solicitud_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminAdminBundle:Solicitud')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitud entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Solicitud entity.
     *
     * @Route("/{id}/edit", name="solicitud_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminAdminBundle:Solicitud')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitud entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Solicitud entity.
     *
     * @param Solicitud $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Solicitud $entity) {
        $form = $this->createForm(new SolicitudType(), $entity, array(
            'action' => $this->generateUrl('solicitud_update', array('id' => $entity->getIdSolicitud())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }

    /**
     * Edits an existing Solicitud entity.
     *
     * @Route("/{id}", name="solicitud_update")
     * @Method("PUT")
     * @Template("AdminAdminBundle:Solicitud:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
         $Usuarioentity = new UsuarioSolicitud();
        $query = $em->createQuery(
                        'SELECT s
        FROM AdminAdminBundle:Solicitud s
        WHERE s.idSolicitud  =:id'
                )->setParameter('id', $id);

        $Solicitudes = $query->getResult();
        // en esta instruccion sacamos los nombres de las imagenes que estan en la base de datos
        $Solicitudes = $query->setMaxResults(1)->getOneOrNullResult();
        $imagen1 = $Solicitudes->getImage();
        $File = $Solicitudes->getFile();
        //continuamos 
        $entity = $em->getRepository('AdminAdminBundle:Solicitud')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitud entity.');
        }
        else{
             $query = $em->createQuery(
                            'SELECT c
                            FROM AdminAdminBundle:UsuarioSolicitud c
                            WHERE c.idSolicitud  =:idSolicitud'
                    )->setParameter('idSolicitud', $id);
            if (!$query->getResult()) {
                //verificamos que usuario se encuentra logeado
                $security_context = $this->get('security.context');
                $security_token = $security_context->getToken();
                //definimos el usuario, con rol diferentea cordinador, administrador,suberadmin,usuario
                $user = $security_token->getUser();

                $Usuarioentity->setIdUsuario($user);
                $Usuarioentity->setIdSolicitud($entity);
                //guardamos en base de datos
                $em->persist($Usuarioentity);
                $em->flush();
            } 
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $date = new DateTime('now', new \DateTimeZone('America/Bogota'));
            $entity->setAux($imagen1);
            $entity->setAux1($File);
            $entity->setFechaupdate($date);
            $em->flush();

            return $this->redirect($this->generateUrl('solicitud_show', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Solicitud entity.
     *
     * @Route("/{id}", name="solicitud_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminAdminBundle:Solicitud')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Solicitud entity.');
            }
            else{
                //buscamos solicitud                
            $query = $em->createQuery(
                            'SELECT c
                            FROM AdminAdminBundle:UsuarioSolicitud c
                            WHERE c.idSolicitud  =:idSolicitud'
                    )->setParameter('idSolicitud', $id);
            if ($query->getResult()) {
                
                 $UsuarioSolicitud = $query->setMaxResults(1)->getOneOrNullResult();
                $em->remove($UsuarioSolicitud);
                $em->flush();
            } 
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('solicitud', array('estado' => 'Pendiente')));
    }

    /**
     * Creates a form to delete a Solicitud entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('solicitud_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Eliminar', 'attr' => array('class' => 'btn btn-danger btn-block')))
                        ->getForm()
        ;
    }
}
