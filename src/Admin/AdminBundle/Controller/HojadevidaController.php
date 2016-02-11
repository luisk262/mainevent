<?php

namespace Admin\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Admin\AdminBundle\Entity\Hojadevida;
use Admin\AdminBundle\Entity\User;
use Admin\AdminBundle\Form\HojadevidaType;
use Admin\AdminBundle\Pagination\Paginator;
use DateTime;

/**
 * Hojadevida controller.
 *
 * @Route("/admin/hojadevida")
 */
class HojadevidaController extends Controller {

    /**
     * Lists all Hojadevida entities.
     *
     * @Route("/Estado/{Estado}/", name="hojadevida")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($Estado) {
        //creamos una conexion a la base de datos
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        //Asignamos el parametro url para luego pasarlo a ajax
        $page = $request->query->get('page');
        $searchParam = $request->get('searchParam');
        $estado = $Estado;
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
        //realizamos un query sencillo para contar cuantos registros ahi en bd
        //adquirimos el array
        $aux = $query->getResult();
        //sacamos el numero total de registros
        $total_count = count($aux);
        //renderizamos la vista para mostrar las hojas de vida
        return $this->render('AdminAdminBundle:Hojadevida:index.html.twig', array(
                    //  'entities' => $entities,
                    'entitiesLength' => $total_count,
                    'Estado' => $estado,
                    'current_page' => $page,
                    'searchParam' => $searchParam
        ));
    }

    /**
     * consulta a Hojadevida entity.
     *
     * @Route("/{Estado}/ajax/consulta", name="hojadevida_ajax")
     * @Method("GET")
     */
    public function ajaxListAction(Request $request, $Estado) {

        $em = $this->getDoctrine()->getManager();
        //pagina donde se esta ubicado
        $page = $request->query->get('page');
        //estado de la hoja de vida
        $estado = $Estado;

        $restar = 0;
        $x = 0;
        //Asignamos el parametro url
        $searchParam = $request->get('searchParam');
        //extraemos variables del array
        extract($searchParam);
        $entryQuery = $em->createQueryBuilder()
                ->select('c')
                ->from('AdminAdminBundle:Hojadevida', 'c')
                ->addOrderBy('c.fechaupdate', 'DESC');
        //query aux
        $queryaux = $em->createQueryBuilder()
                ->select('COUNT(c)')
                ->from('AdminAdminBundle:Hojadevida', 'c');
        if ($estado != 'Todas') {
            $entryQuery->andWhere(''
                            . 'c.Estado  = :Estado')
                    ->setParameter('Estado', $estado);
            $queryaux->andWhere(''
                            . 'c.Estado  = :Estado')
                    ->setParameter('Estado', $estado);
        }
        if (!empty($general)) {
            $entryQuery->andWhere(''
                            . 'c.nombre Like :general or '
                            . 'c.apellido Like :general or '
                            . 'c.telCasa Like :general or '
                            . 'c.telCe Like :general or '
                            . 'c.telefonoAdic Like :general or '
                            . 'c.tipoDocumento Like :general or '
                            . 'c.nit Like :general or '
                            . 'c.sexo Like :general or '
                            . 'c.ciudad Like :general or '
                            . 'c.emailPersonal Like :general or '
                            . 'c.piel Like :general or '
                            . 'c.ojos Like :general or '
                            . 'c.pelo Like :general or '
                            . 'c.peso Like :general or '
                            . 'c.deportes Like :general or '
                            . 'c.habilidades Like :general or '
                            . 'c.idiomas Like :general or '
                            . 'c.maneja Like :general or '
                            . 'c.categoria Like :general or '
                            . 'c.tallaCamisa Like :general or '
                            . 'c.tallaChaqueta Like :general or '
                            . 'c.tallaPantalon Like :general or '
                            . 'c.tallaZapato Like :general or '
                            . 'c.Tags Like :general or '
                            . 'c.estatura Like :general')
                    ->setParameter('general', '%' . $general . '%');
            $queryaux->andWhere(''
                            . 'c.nombre Like :general or '
                            . 'c.apellido Like :general or '
                            . 'c.telCasa Like :general or '
                            . 'c.telCe Like :general or '
                            . 'c.telefonoAdic Like :general or '
                            . 'c.tipoDocumento Like :general or '
                            . 'c.nit Like :general or '
                            . 'c.sexo Like :general or '
                            . 'c.ciudad Like :general or '
                            . 'c.emailPersonal Like :general or '
                            . 'c.piel Like :general or '
                            . 'c.ojos Like :general or '
                            . 'c.pelo Like :general or '
                            . 'c.peso Like :general or '
                            . 'c.deportes Like :general or '
                            . 'c.habilidades Like :general or '
                            . 'c.idiomas Like :general or '
                            . 'c.maneja Like :general or '
                            . 'c.categoria Like :general or '
                            . 'c.tallaCamisa Like :general or '
                            . 'c.tallaChaqueta Like :general or '
                            . 'c.tallaPantalon Like :general or '
                            . 'c.tallaZapato Like :general or '
                            . 'c.Tags Like :general or '
                            . 'c.estatura Like :general')
                    ->setParameter('general', '%' . $general . '%');
        }
        if (!empty($idhv)) {
            $entryQuery->andWhere('c.idhv =:id ')->setParameter('id', $idhv);
            $queryaux->andWhere('c.idhv =:id ')->setParameter('id', $idhv);
        }
        if (!empty($ciudad)) {
            $entryQuery->andWhere('c.ciudad =:ciudad ')->setParameter('ciudad', $ciudad);
            $queryaux->andWhere('c.ciudad =:ciudad ')->setParameter('ciudad', $ciudad);
        }
        if (!empty($telCe)) {
            $entryQuery->andWhere('c.telCe =:telCe ')->setParameter('telCe', $telCe);
            $queryaux->andWhere('c.telCe =:telCe ')->setParameter('telCe', $telCe);
        }
        if (!empty($fechaNac)) {
            $entryQuery->andWhere('c.fechaNac =:fechaNac ')->setParameter('fechaNac', $fechaNac);
            $queryaux->andWhere('c.fechaNac =:fechaNac ')->setParameter('fechaNac', $fechaNac);
        }
        if (!empty($EdadMin) && !empty($EdadMax)) {
            $date = new \DateTime('now');
            $entryQuery->andWhere('((:now - YEAR(c.fechaNac)) >= :EdadMin ) and ((:now - YEAR(c.fechaNac)) <= :EdadMax )')
                    ->setParameter('now', $date->format('Y'))
                    ->setParameter('EdadMin', $EdadMin)
                    ->setParameter('EdadMax', $EdadMax);
            $queryaux->andWhere('((:now - YEAR(c.fechaNac)) >= :EdadMin ) and ((:now - YEAR(c.fechaNac)) <= :EdadMax )')
                    ->setParameter('now', $date->format('Y'))
                    ->setParameter('EdadMin', $EdadMin)
                    ->setParameter('EdadMax', $EdadMax);
        }
        if (!empty($nit)) {
            $entryQuery->andWhere('c.nit =:nit ')->setParameter('nit', $nit);
            $queryaux->andWhere('c.nit =:nit ')->setParameter('nit', $nit);
        }
        if (!empty($sexo)) {
            $entryQuery->andWhere('c.sexo =:sexo ')->setParameter('sexo', $sexo);
            $queryaux->andWhere('c.sexo =:sexo ')->setParameter('sexo', $sexo);
        }
        if (!empty($lugarNacimiento)) {
            $entryQuery->andWhere('c.lugarNacimiento =:lugarNacimiento ')->setParameter('lugarNacimiento', $lugarNacimiento);
            $queryaux->andWhere('c.lugarNacimiento =:lugarNacimiento ')->setParameter('lugarNacimiento', $lugarNacimiento);
        }
        if (!empty($estatura)) {
            $entryQuery->andWhere('c.estatura Like :estatura ')->setParameter('estatura', $estatura);
            $queryaux->andWhere('c.estatura  Like :estatura ')->setParameter('estatura', $estatura);
        }
        if (!empty($piel)) {
            $entryQuery->andWhere('c.piel =:piel ')->setParameter('piel', $piel);
            $queryaux->andWhere('c.piel =:piel ')->setParameter('piel', $piel);
        }
        if (!empty($ojos)) {
            $entryQuery->andWhere('c.ojos =:ojos ')->setParameter('ojos', $ojos);
            $queryaux->andWhere('c.ojos =:ojos ')->setParameter('ojos', $ojos);
        }
        if (!empty($pelo)) {
            $entryQuery->andWhere('c.pelo =:pelo ')->setParameter('pelo', $pelo);
            $queryaux->andWhere('c.pelo =:pelo ')->setParameter('pelo', $pelo);
        }
        if (!empty($peso)) {
            $entryQuery->andWhere('c.peso =:peso ')->setParameter('peso', $peso);
            $queryaux->andWhere('c.peso =:peso ')->setParameter('peso', $peso);
        }
        if (!empty($deportes)) {
            $entryQuery->andWhere('c.deportes Like :deportes ')->setParameter('deportes', $deportes);
            $queryaux->andWhere('c.deportes Like :deportes ')->setParameter('deportes', $deportes);
        }
        if (!empty($habilidades)) {
            $entryQuery->andWhere('c.habilidades Like :habilidades ')->setParameter('habilidades', $habilidades);
            $queryaux->andWhere('c.habilidades Like :habilidades ')->setParameter('habilidades', $habilidades);
        }
        if (!empty($idiomas)) {
            $entryQuery->andWhere('c.idiomas Like :idiomas ')->setParameter('idiomas', $idiomas);
            $queryaux->andWhere('c.idiomas Like :idiomas ')->setParameter('idiomas', $idiomas);
        }
        if (!empty($maneja)) {
            $entryQuery->andWhere('c.maneja =:maneja ')->setParameter('maneja', $maneja);
            $queryaux->andWhere('c.maneja =:maneja ')->setParameter('maneja', $maneja);
        }
        if (!empty($entidadSalud)) {
            $entryQuery->andWhere('c.entidadSalud Like :entidadSalud ')->setParameter('entidadSalud', $entidadSalud);
            $queryaux->andWhere('c.entidadSalud Like :entidadSalud')->setParameter('entidadSalud', $entidadSalud);
        }
        if (!empty($categoria)) {
            $entryQuery->andWhere('c.categoria =:categoria ')->setParameter('categoria', $categoria);
            $queryaux->andWhere('c.categoria =:categoria ')->setParameter('categoria', $categoria);
        }
        if (!empty($tallaCamisa)) {
            $entryQuery->andWhere('c.tallaCamisa =:tallaCamisa')->setParameter('tallaCamisa', $tallaCamisa);
            $queryaux->andWhere('c.tallaCamisa=:tallaCamisa')->setParameter('tallaCamisa', $tallaCamisa);
        }
        if (!empty($tallaChaqueta)) {
            $entryQuery->andWhere('c.tallaChaqueta =:tallaChaqueta')->setParameter('tallaChaqueta', $tallaChaqueta);
            $queryaux->andWhere('c.tallaChaqueta =:tallaChaqueta')->setParameter('tallaChaqueta', $tallaChaqueta);
        }
        if (!empty($tallaPantalon)) {
            $entryQuery->andWhere('c.tallaPantalon =:tallaPantalon')->setParameter('tallaPantalon', $tallaPantalon);
            $queryaux->andWhere('c.tallaPantalon=:tallaPantalon')->setParameter('tallaPantalon', $tallaPantalon);
        }
        if (!empty($tallaZapato)) {
            $entryQuery->andWhere('c.tallaZapato =:tallaZapato')->setParameter('tallaZapato', $tallaZapato);
            $queryaux->andWhere('c.tallaZapato=:tallaZapato')->setParameter('tallaZapato', $tallaZapato);
        }
        if (!empty($Tags)) {
            $entryQuery->andWhere('c.Tags Like :Tags')->setParameter('Tags', $Tags);
            $queryaux->andWhere('c.Tags Like :Tags')->setParameter('Tags', $Tags);
        }

        $total_count = $queryaux->getQuery()->getSingleScalarResult();
        if (!empty($perPage))
            $entryQuery->setFirstResult(($page - 1) * $perPage)->setMaxResults($perPage);
        $entryQueryfinal = $entryQuery->getQuery();
        //obtenemos el array de resultados
        $entities = $entryQueryfinal->getArrayResult();
        $pagination = (new Paginator())->setItems($total_count, $searchParam['perPage'])->setPage($searchParam['page'])->toArray();
        //renderizamos la vista para mostrar las hojas de vida
        return $this->render('AdminAdminBundle:Hojadevida:ajax_list.html.twig', array(
                    'entities' => $entities,
                    'pagination' => $pagination,
                    'Estado' => $estado,
                    'entitiesLength' => 10,
                    'total_pages' => 10,
                    'current_page' => 10,
                    'count_per_page' => 10,
                    'restar' => 10,
                    'query' => true
        ));
    }

        /**
     * Creates a new Hojadevida entity.
     *
     * @Route("/", name="hojadevida_create")
     * @Method("POST")
     * @Template("AdminAdminBundle:Hojadevida:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Hojadevida();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        if ($form->isValid()) {

            //creamos una conexion a la base de datos
            $em = $this->getDoctrine()->getEntityManager();
            //realizamos un query sencillo para contar cuantos registros ahi en bd
            $query = $em->createQuery(
                    'SELECT h.nit
            FROM AdminAdminBundle:Hojadevida h where h.nit=' . $entity->getNit() . ''
            );
            //adquirimos el array
            if ($query->getResult()) {
                return $this->redirect($this->generateUrl('hojadevida_new'));
            } else {
                switch ($entity->getEstado()) {
                    case 'Activo':
                        //buscamos  si el usuario ya esta registrado en tabla User
                        $query = $em->createQuery(
                                        'SELECT u
                        FROM AdminAdminBundle:User u
                        WHERE u.username  =:username'
                                )->setParameter('username', $entity->getEmailPersonal());
                        if (!$query->getResult()) {
                            //creamos usuario con rol_default para que pueda iniciar sesion
                            $user1 = new User();
                            //agregamos email
                            $user1->setEmail($entity->getEmailPersonal());
                            //colocamos email como nick name
                            $user1->setUsername($entity->getEmailPersonal());
                            $user1->setNombre($entity->getNombre());
                            $user1->setApellidos($entity->getApellido());
                            $user1->setTelefono($entity->getTelCe());
                            $user1->setFechaNaci($entity->getFechaNac());
                            //numedo de documento de identidad como contrasenia 
                            $user1->setPlainPassword($entity->getNit());
                            $user1->setEnabled(true);
                            $user1->setRoles(array(User :: ROLE_DEFAULT));
                            $em->persist($user1);
                            ///notificamos al usuario que ha sido activado, enviandole un correo electronico
                            $names = $entity->getNombre() . ' ' . $entity->getApellido();
                            $email = $entity->getEmailPersonal();
                            $Subject = 'Bienvenido a Mainevent';
                            $Body = 'Te damos la bienvenida a la familia AITV, has completado tu registro satisfactoriamente'
                                    . ' estas listo para para trabajar con nosotros.ESTE CORREO ES AUTOMATICO, NO RESPONDA ESTE EMAIL';
                            $correo = 'maineventltda@gmail.com';
                            $message = \Swift_Message::newInstance()
                                    ->setSubject($Subject)
                                    ->setFrom($correo)
                                    ->setTo($email)
                                    ->setBody(
                                    <<<EOF
                Nombres: $names
                Asunto: $Subject
                Correo: $email
                
                $Body
EOF
                                    )
                            ;
                            $this->get('mailer')->send($message);
                        }

                        break;
                }

                $date = new DateTime('now', new \DateTimeZone('America/Bogota'));
                $entity->setFecha($date);
                $entity->setFechaupdate($date);
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('hojadevida_show', array('id' => $entity->getIdhv(), 'Estado' => $entity->getEstado())));
            }
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }
    /**
     * Creates a form to create a Hojadevida entity.
     *
     * @param Hojadevida $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Hojadevida $entity) {
        $form = $this->createForm(new HojadevidaType(), $entity, array(
            'action' => $this->generateUrl('hojadevida_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new Hojadevida entity.
     *
     * @Route("/new", name="hojadevida_new")
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
     * Finds and displays a Hojadevida entity.
     *
     * @Route("/{id}", name="hojadevida_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $estado = $request->query->get('Estado');
        $entity = $em->getRepository('AdminAdminBundle:Hojadevida')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Hojadevida entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'Estado' => $estado,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Finds and displays a Hojadevida entity.
     *
     * @Route("/fullimage/{nit}/{id}/{foto}", name="hojadevida_showfoto")
     * @Method("GET")
     * @Template()
     */
    public function showfotoAction($nit, $id, $foto) {
        //mostrarmos la foto origunal
        $request = $this->getRequest();
        $estado = $request->query->get('Estado');
        return array(
            'foto' => $foto,
            'nit' => $nit,
            'id' => $id,
            'Estado' => $estado
        );
    }

    /**
     * Displays a form to edit an existing Hojadevida entity.
     *
     * @Route("/{id}/edit", name="hojadevida_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminAdminBundle:Hojadevida')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Hojadevida entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        $request = $this->getRequest();
        $estado = $request->query->get('Estado');


        return array(
            'entity' => $entity,
            'Estado' => $estado,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Hojadevida entity.
     *
     * @param Hojadevida $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Hojadevida $entity) {
        $form = $this->createForm(new HojadevidaType(), $entity, array(
            'action' => $this->generateUrl('hojadevida_update', array('id' => $entity->getIdhv())),
            'method' => 'POST',
        ));
        $form->add('tipoDocumento', 'choice', array(
            'choices' => array(
                'CC' => 'CC',
                'TI' => 'TI',
                'PAS' => 'PAS',
                'CE' => 'CE'
            ),
            'disabled' => true,
            'empty_value' => 'Seleccione tipo',
            'empty_data' => null
        ));
        $form->add('nit', 'text', array('read_only' => true));
        $form->add('image', 'file', array(
            'data_class' => null,
            'required' => false
        ));
        $form->add('image1', 'file', array(
            'data_class' => null,
            'required' => false
        ));
        $form->add('image2', 'file', array(
            'data_class' => null,
            'required' => false
        ));
        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }

    /**
     * Edits an existing Hojadevida entity.
     *
     * @Route("/{id}", name="hojadevida_update")
     * @Method("POST")
     * @Template("AdminAdminBundle:Hojadevida:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        //creamos un query para buscar la entidad a la cual le tenemos que enviar nuevamente las imagenes
        $query = $em->createQuery(
                        'SELECT h
        FROM AdminAdminBundle:Hojadevida h
        WHERE h.idhv  =:id'
                )->setParameter('id', $id);

        $products = $query->getResult();
        // en esta instruccion sacamos los nombres de las imagenes que estan en la base de datos
        $products = $query->setMaxResults(1)->getOneOrNullResult();
        $imagen1 = $products->getImage();
        $imagen2 = $products->getImage1();
        $imagen3 = $products->getImage2();
        //continuamos 
        $entity = $em->getRepository('AdminAdminBundle:Hojadevida')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Hojadevida entity.');
        }
        $deleteForm = $this->createDeleteForm($id);

        $editForm = $this->createEditForm($entity);

        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $date = new DateTime('now', new \DateTimeZone('America/Bogota'));
            $entity->setAux($imagen1);
            $entity->setAux1($imagen2);
            $entity->setAux2($imagen3);
            $entity->setFechaupdate($date);
            // creamos un usuario nuevo para logear
            switch ($entity->getEstado()) {
                case 'Activo':
                    //buscamos  si el usuario ya esta registrado en tabla User
                    $query = $em->createQuery(
                                    'SELECT u
                        FROM AdminAdminBundle:User u
                        WHERE u.username  =:username'
                            )->setParameter('username', $entity->getEmailPersonal());
                    if ($query->getResult()) {
                        ///notificamos al usuario que ha sido activado, enviandole un correo electronico
                        $names = $entity->getNombre() . ' ' . $entity->getApellido();
                        $email = $entity->getEmailPersonal();
                        $Subject = 'Tu registro Aitv te informa';
                        $Body = 'La informacion de tu registro en AITV ha sido actualizada. '
                                . 'Para mas informacion visita nuestra pagina web www.aitv.com.co '
                                . 'ESTE CORREO ES AUTOMATICO NO RESPONDA ESTE MENSAJE.';
                        $correo = 'maineventltda@gmail.com';
                        $message = \Swift_Message::newInstance()
                                ->setSubject($Subject)
                                ->setFrom($correo)
                                ->setTo($email)
                                ->setBody(
                                <<<EOF
                Nombres: $names
                Asunto: $Subject
                Correo: $email
                
                $Body
EOF
                                )
                        ;
                        $this->get('mailer')->send($message);
                    } else {
                        //creamos usuario con rol_default para que pueda iniciar sesion
                        $user1 = new User();
                        //agregamos email
                        $user1->setEmail($entity->getEmailPersonal());
                        //colocamos email como nick name
                        $user1->setUsername($entity->getEmailPersonal());
                        $user1->setNombre($entity->getNombre());
                        $user1->setApellidos($entity->getApellido());
                        $user1->setTelefono($entity->getTelCe());
                        $user1->setFechaNaci($entity->getFechaNac());
                        //numedo de documento de identidad como contrasenia 
                        $user1->setPlainPassword($entity->getNit());
                        $user1->setEnabled(true);
                        $user1->setRoles(array(User :: ROLE_DEFAULT));
                        $em->persist($user1);
                        ///notificamos al usuario que ha sido activado, enviandole un correo electronico
                        $names = $entity->getNombre() . ' ' . $entity->getApellido();
                        $email = $entity->getEmailPersonal();
                        $Subject = 'Bienvenido a Mainevent';
                        $Body = 'Te damos la bienvenida a la familia AITV, has completado tu registro satisfactoriamente'
                                . ' estas listo para para trabajar con nosotros. '
                                . 'Para mas informacion visita nuestra pagina web www.aitv.com.co '
                                . ' ESTE CORREO ES AUTOMATICO NO RESPONDA ESTE MENSAJE.';
                        $correo = 'maineventltda@gmail.com';
                        $message = \Swift_Message::newInstance()
                                ->setSubject($Subject)
                                ->setFrom($correo)
                                ->setTo($email)
                                ->setBody(
                                <<<EOF
                Nombres: $names
                Asunto: $Subject
                Correo: $email
                
                $Body
EOF
                                )
                        ;
                        $this->get('mailer')->send($message);
                    }
                    break;
                case 'Vetado':
                    //buscamos  si el usuario ya esta registrado en tabla User
                    $query = $em->createQuery(
                                    'SELECT u
                        FROM AdminAdminBundle:User u
                        WHERE u.username  =:username'
                            )->setParameter('username', $entity->getEmailPersonal());
                    if ($query->getResult()) {
                        ///eliminamos el usuario
                        $Usuario = $query->setMaxResults(1)->getOneOrNullResult();
                        $em->remove($Usuario);
                    } else {
                        
                    }
                    break;
            }

            /////
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('hojadevida_show', array('id' => $entity->getIdhv(), 'Estado' => $entity->getEstado())));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Hojadevida entity.
     *
     * @Route("/{id}", name="hojadevida_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminAdminBundle:Hojadevida')->find($id);
            $estado = $entity->getEstado();
            //buscamos  si el usuario ya esta registrado en tabla User
            $query = $em->createQuery(
                            'SELECT u
                        FROM AdminAdminBundle:User u
                        WHERE u.username  =:username'
                    )->setParameter('username', $entity->getEmailPersonal());
            if ($query->getResult()) {
                ///eliminamos el usuario
                $Usuario = $query->setMaxResults(1)->getOneOrNullResult();
                $em->remove($Usuario);
            } else {
                
            }
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Hojadevida entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('hojadevida', array('Estado' => $estado)));
    }
    
    /**
     * Creates a form to delete a Hojadevida entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('hojadevida_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Eliminar', 'attr' => array('class' => 'btn btn-danger btn-block')))
                        ->getForm()
        ;
    }

    /**
     * Displays a form to create a new Hojadevida entity.
     *
     * @Route("/ajax/remove", name="hojadevida_remove")
     * @Method("GET")
     * @Template()
     */
    public function removeAction(Request $request) {
        $em = $this->getDoctrine()->getEntityManager();

        $ids = $request->get('entities');

        $entryQuery = $em->createQueryBuilder()
                ->select('c')
                ->from('AdminAdminBundle:Hojadevida', 'c');
        if (!empty($ids)) {
            $entryQuery->andWhere('c.idhv in (:ids)')->setParameter('ids', $ids);
        }
        $entryQueryfinal = $entryQuery->getQuery();
        //obtenemos el array de resultados
        $entities = $entryQueryfinal->getResult();


        foreach ($entities as $entity)
            $em->remove($entity);
        $em->flush();
        return new Response('1');
    }

    /**
     * Displays a form to create a new Hojadevida entity.
     *
     * @Route("/ajax/mail", name="hojadevida_mail")
     * @Method("GET")
     * @Template()
     */
    public function enviaremailAction(Request $request) {
        $em = $this->getDoctrine()->getEntityManager();
        $ids = $request->get('entities');
        //Asignamos el parametro url
        $mail = $request->get('mail');
        //extraemos variables del array
        extract($mail);
        $entryQuery = $em->createQueryBuilder()
                ->select('c')
                ->from('AdminAdminBundle:Hojadevida', 'c');
        if (!empty($ids)) {
            $entryQuery->andWhere('c.idhv in (:ids)')->setParameter('ids', $ids);
        }
        $entryQueryfinal = $entryQuery->getQuery();
        //obtenemos el array de resultados
        $entities = $entryQueryfinal->getResult();
        $correo_remitente = 'maineventltda@gmail.com';
        foreach ($entities as $entity) {
            $email = $entity->getEmailPersonal();
            $names = $entity->getNombre() . ' ' . $entity->getApellido();
            $message = \Swift_Message::newInstance()
                    ->setSubject($Subject)
                    ->setFrom($correo_remitente)
                    ->setTo($email)
                    ->setBody(
                    <<<EOF
                Nombres: $names
                Asunto: $Subject
                Correo: $email
                
                $Body
EOF
                    )
            ;
            $this->get('mailer')->send($message);
        }
        return new Response('1');
    }

}
