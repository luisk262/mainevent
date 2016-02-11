<?php

namespace Admin\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Admin\AdminBundle\Entity\Solicitud;
use Admin\AdminBundle\Entity\SolicitudCatalogo;
use Admin\AdminBundle\Entity\Catalogo;
use Admin\AdminBundle\Entity\CatalogoHojadevida;
use Admin\AdminBundle\Entity\Notificaciones;
use Admin\AdminBundle\Pagination\Paginator;
use DateTime;

/**
 * SolicitudCatalogo controller.
 *
 * @Route("/admin/solicitudcatalogo")
 */
class SolicitudCatalogoController extends Controller {

    /**
     * Lists all SolicitudCatalogo entities.
     *
     * @Route("/", name="solicitudcatalogo")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        //Asignamos el parametro url 
        $Solicitudid = $request->get('Solicitudid');

        $estado = $request->get('Estado');
        $entryQuery = $em->createQueryBuilder()
                ->select('c')
                ->from('AdminAdminBundle:SolicitudCatalogo', 'c');
        if (!empty($Solicitudid)) {
            $entryQuery->andWhere(''
                            . 'c.idSolicitudes  = :idSolicitudes')
                    ->setParameter('idSolicitudes', $Solicitudid);
            $entryQueryfinal = $entryQuery->getQuery();
            //obtenemos el array de resultados
            $entities = $entryQueryfinal->getArrayResult();
        } else {
            $entryQueryfinal = $entryQuery->getQuery();
            //obtenemos el array de resultados
            $entities = $entryQueryfinal->getArrayResult();
        }
        if ($request->get('msg')) {
            $msg = $request->get('msg');
        } else {
            $msg = null;
        }
        return array(
            'entities' => $entities,
            'Estado' => $estado,
            'Solicitudid' => $Solicitudid,
            'msg' => $msg
        );
    }

    /**
     * Finds and displays a SolicitudCatalogo entity.
     *
     * @Route("/{id}/show", name="solicitudcatalogo_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $request = $this->getRequest();
        //recibimos la variable solicitud
        $Solicitudid = $request->query->get('Solicitudid');
        //recibimos la variable Estado
        $Estado = $request->query->get('Estado');
        $page = $request->query->get('page');
        $searchParam = $request->get('searchParam');
        return array(
            'id' => $id,
            'Solicitudid' => $Solicitudid,
            'Estado' => $Estado,
            'current_page' => $page,
            'searchParam' => $searchParam
        );
    }

    /**
     * Finds and displays a SolicitudCatalogo entity.
     *
     * @Route("/{id}/show_ajax", name="solicitudcatalogo_show_ajax")
     * @Method("GET")
     * @Template()
     */
    public function show_ajaxAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $page = $request->query->get('page');
        //Asignamos el parametro url
        $searchParam = $request->get('searchParam');
        //extraemos variables del array
        extract($searchParam);

//Buscamos el catalo segun el id
        $query = $em->createQuery(
                        'SELECT c
            FROM AdminAdminBundle:SolicitudCatalogo c
            WHERE c.id  =:id'
                )->setParameter('id', $id);
        if ($query->getResult()) {
            $em = $this->getDoctrine()->getEntityManager();
            $Catalogoaux = $query->getResult();
            // Buscamos el array de resultados, en esta consulta le decimos que solo tome el primer resultado
            $Catalogoaux = $query->setMaxResults(1)->getOneOrNullResult();
            //consultamos la tabla catalogo hoja de vida, y buscamos hojas de vida asiganadas a ese catalogo
            $query = $em->createQuery(
                            'SELECT c
                            FROM AdminAdminBundle:CatalogoHojadevida c
                            WHERE c.idCatalogo  =:idCatalogo'
                    )->setParameter('idCatalogo', $Catalogoaux->getIdCatalogos())/// id del catalogo
            ;

            if ($query->getResult()) {
                $CatalogoHojadevida = $query->getResult();
                foreach ($CatalogoHojadevida as $aux) {
                    $ids[] = $aux->getIdHojadevida(); //generamos un vector con los ids de las hojas de vida
                }
            } else {
                $ids[] = null;
            }
            $entryQuery = $em->createQueryBuilder()
                    ->select('c')
                    ->from('AdminAdminBundle:Hojadevida', 'c');
            $queryaux = $em->createQueryBuilder()
                    ->select('COUNT(c)')
                    ->from('AdminAdminBundle:Hojadevida', 'c');
            $entryQuery->andWhere('c.idhv in (:ids)')->setParameter('ids', $ids); //buscamos en bd las hojas de vida
            $queryaux->andWhere('c.idhv in (:ids)')->setParameter('ids', $ids); //buscamos en bd las hojas de vida aux
            //segmentamos la consulta
            $entryQuery->setFirstResult(($page - 1) * $perPage)->setMaxResults($perPage);
        
            $entryQueryfinal = $entryQuery->getQuery();
            //obtenemos el array de resultados
            $entities = $entryQueryfinal->getResult();
            //notificacion//
            //buscamos las notificaciones para el catalogo
            $query = $em->createQuery(
                            'SELECT n
                            FROM AdminAdminBundle:Notificaciones n
                            WHERE n.idCatalogo  =:idCatalogo'
                    )->setParameter('idCatalogo', $Catalogoaux->getIdCatalogos())/// id del catalogo
            ;
            ///obtenemos array de resultados
            $notificaciones = $query->getResult();
            $total_count = $queryaux->getQuery()->getSingleScalarResult();
            $pagination = (new Paginator())->setItems($total_count, $searchParam['perPage'])->setPage($searchParam['page'])->toArray();
        }
        return array(
            'entities' => $entities,
            'Notificaciones' => $notificaciones,
            'pagination' => $pagination,
            'entitiesLength' => 10,
            'total_pages' => 10,
            'current_page' => 10,
            'count_per_page' => 10,
        );
    }

    /**
     * Displays a form to edit an existing SolicitudCatalogo entity.
     *
     * @Route("/{id}/edit", name="solicitudcatalogo_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        //creamos una conexion a la base de datos
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        //Asignamos el parametro url para luego pasarlo a ajax
        $page = $request->query->get('page');
        $Solicitudid = $request->query->get('Solicitudid');
        //value parametro de verificacion, (valida si es nuevo segmento o editar segmento)
        $searchParam = $request->get('searchParam');
        $estado = 'Activo';
        $query = $em->createQuery(
                        'SELECT h.idhv
            FROM AdminAdminBundle:Hojadevida h WHERE h.Estado =:Estado'
                )->setParameter('Estado', $estado);
        //realizamos un query sencillo para contar cuantos registros ahi en bd
        //adquirimos el array
        $aux = $query->getResult();
        //sacamos el numero total de registros
        $total_count = count($aux);
        $SolicitudCatalogo = $em->getRepository('AdminAdminBundle:SolicitudCatalogo')->find($id);
        ///// consultamos la tabla solicitud catalogo para buscar los catalogos creados, y mostrarlos en la transferencia
        $entryQuery = $em->createQueryBuilder()
                ->select('c')
                ->from('AdminAdminBundle:SolicitudCatalogo', 'c');
        if (!empty($SolicitudCatalogo->getIdSolicitudes())) {
            $entryQuery->andWhere(''
                            . 'c.idSolicitudes  = :idSolicitudes')
                    ->setParameter('idSolicitudes', $SolicitudCatalogo->getIdSolicitudes());
            $entryQuery->andWhere(''
                            . 'c.id  !=:id')
                    ->setParameter('id', $id);
            $entryQueryfinal = $entryQuery->getQuery();
            //obtenemos el array de resultados
            $entities = $entryQueryfinal->getArrayResult();
        } else {
            $entryQueryfinal = $entryQuery->getQuery();
            //obtenemos el array de resultados
            $entities = $entryQueryfinal->getArrayResult();
        }
        //renderizamos la vista para mostrar las hojas de vida
        return $this->render('AdminAdminBundle:SolicitudCatalogo:indexhv.html.twig', array(
                    //  'entities' => $entities,
                    'entitiesLength' => $total_count,
                    'Estado' => $estado,
                    'current_page' => $page,
                    'searchParam' => $searchParam,
                    'id' => $id,
                    'entities' => $entities, //entidades catalogos
                    'Solicitudid' => $Solicitudid
        ));
    }

    /**
     * Lists all Hojadevida entities.
     *
     * @Route("/hv/Estado/{Estado}/", name="solicitudcatalogo_hv")
     * @Method("GET")
     * @Template()
     */
    public function indexhvAction($Estado) {
        //creamos una conexion a la base de datos
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        //Asignamos el parametro url para luego pasarlo a ajax
        $page = $request->query->get('page');
        //value parametro de verificacion, (valida si es nuevo segmento o editar segmento)
        $id = $request->get('id');
        $searchParam = $request->get('searchParam');
        $Solicitudid = $request->get('Solicitudid');
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
        ///// consultamos la tabla solicitud catalogo para buscar los catalogos creados, y mostrarlos en la transferencia
        $entryQuery = $em->createQueryBuilder()
                ->select('c')
                ->from('AdminAdminBundle:SolicitudCatalogo', 'c');
        if (!empty($Solicitudid)) {
            $entryQuery->andWhere(''
                            . 'c.idSolicitudes  = :idSolicitudes')
                    ->setParameter('idSolicitudes', $Solicitudid);
            $entryQueryfinal = $entryQuery->getQuery();
            //obtenemos el array de resultados
            $entities = $entryQueryfinal->getArrayResult();
        } else {
            $entryQueryfinal = $entryQuery->getQuery();
            //obtenemos el array de resultados
            $entities = $entryQueryfinal->getArrayResult();
        }
        //renderizamos la vista para mostrar las hojas de vida
        return $this->render('AdminAdminBundle:SolicitudCatalogo:indexhv.html.twig', array(
                    //  'entities' => $entities,
                    'entitiesLength' => $total_count,
                    'Estado' => $estado,
                    'current_page' => $page,
                    'searchParam' => $searchParam,
                    'Solicitudid' => $Solicitudid,
                    'id' => $id,
                    'entities' => $entities, //entidades catalogos
        ));
    }

    /**
     * consulta a Hojadevida entity.
     *
     * @Route("/{Estado}/ajax/consulta", name="solicitudcatalogo_ajax")
     * @Method("GET")
     */
    public function indexhvajaxAction(Request $request, $Estado) {
        $em = $this->getDoctrine()->getManager();
        //pagina donde se esta ubicado
        $page = $request->query->get('page');
        ///tomamos el valor value (verifica si es nuevo segmento o edicion)
        //estado de la hoja de vida
        $estado = $Estado;
        ///retomamos el id de la solicitud
        $Solicitudid = $request->get('Solicitudid');
        $id = $request->get('id');
        //Asignamos el parametro url
        $searchParam = $request->get('searchParam');
        //extraemos variables del array
        extract($searchParam);
        ////consultamos las hojas de vidas no disponibles
        //consultamos catalogo

        if (!empty($id)) {
            $query = $em->createQuery(
                            'SELECT c
            FROM AdminAdminBundle:SolicitudCatalogo c
            WHERE c.id  =:solicitud'
                    )->setParameter('solicitud', $id);
        } else {
            $query = $em->createQuery(
                            'SELECT c
            FROM AdminAdminBundle:SolicitudCatalogo c
            WHERE c.idSolicitudes  =:solicitud'
                    )->setParameter('solicitud', $Solicitudid);
        }

        if ($query->getResult()) {
            $Catalogoaux = $query->getResult();
            // Buscamos el array de resultados
            $Catalogoaux = $query->setMaxResults(1)->getOneOrNullResult();
            $query = $em->createQuery(
                            'SELECT ch
                            FROM AdminAdminBundle:CatalogoHojadevida ch
                            WHERE ch.idCatalogo  =:idCatalogo'
                    )->setParameter('idCatalogo', $Catalogoaux->getIdCatalogos());
        }
        $Hojasdevida = $query->getResult();
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
        return $this->render('AdminAdminBundle:SolicitudCatalogo:indexhvajax.html.twig', array(
                    'entities' => $entities,
                    'pagination' => $pagination,
                    'Estado' => $estado,
                    'Hojasdevida' => $Hojasdevida
        ));
    }

    /**
     * consulta a Hojadevida entity.
     *
     * @Route("/personal/add/{idSCatalogo}/", name="solicitudcatalogo_add")
     * @Method("GET")
     */
    public function addsolicitudAction(Request $request, $idSCatalogo) {

        $em = $this->getDoctrine()->getEntityManager();
        $SoliCata = $em->getRepository('AdminAdminBundle:SolicitudCatalogo')->find($idSCatalogo);
        ///retomamos el id de la solicitud
        //recibimos las hojas de vida por id
        $ids = $request->get('entities');
        //declaramos la tabla solicitud Solicitudcatalogo
        $SolicitudCatalogo = new SolicitudCatalogo();
        //declaramos la tabla catalogo
        $Catalogo = new Catalogo();
        //declaramos la tabla solicitud
        $solicitud = new Solicitud();
        ///buscamos la fecha actual 
        $date = new DateTime('now', new \DateTimeZone('America/Bogota'));
        //damos formato a la fecha
        $date->format('l, Y-F-d H:i:s');
        /// buscamos hojas de vida en base de datos
        $entryQuery = $em->createQueryBuilder()
                ->select('c')
                ->from('AdminAdminBundle:Hojadevida', 'c');
        if (!empty($ids)) {
            $entryQuery->andWhere('c.idhv in (:ids)')->setParameter('ids', $ids);
        }
        $entryQueryfinal = $entryQuery->getQuery();
        //obtenemos el array de resultados
        $Hojadevida = $entryQueryfinal->getResult();
        //necesitamos consultar la tabla de solicitud para sacar el nombre de las imagenes
        //// para poder actualizar 
        $query = $em->createQuery(
                        'SELECT s
        FROM AdminAdminBundle:Solicitud s
        WHERE s.idSolicitud  =:id'
                )->setParameter('id', $SoliCata->getIdSolicitudes());

        $Solicitudes = $query->getResult();
        // en esta instruccion sacamos los nombres de las imagenes que estan en la base de datos
        $Solicitudes = $query->setMaxResults(1)->getOneOrNullResult();
        //guardamos nombre de imagen y archivo, en variables, para no perder el valor, cuando se actualize
        //la solicitud
        $imagen1 = $Solicitudes->getImage();
        $File = $Solicitudes->getFile();
        //identificamos la solicitud segun el id
        $solicitud = $em->getRepository('AdminAdminBundle:Solicitud')->find($SoliCata->getIdSolicitudes());
        /// vamos a verificar si en la tabla solicitudcatalogo ahi entradas
        $entryQuery = $em->createQueryBuilder()
                        ->select('sc')
                        ->from('AdminAdminBundle:SolicitudCatalogo', 'sc')
                        ->Where('sc.idSolicitudes =:id')->setParameter('id', $SoliCata->getIdSolicitudes());
        $entryQueryfinal = $entryQuery->getQuery();
        //validamos si ya ahi un catalogo creado para ese segmento
        if ($solicitud->getEstado() != 'Tramite' or ! $entryQueryfinal->getResult() or $idSCatalogo == 'null') {

            //si la solicitud es diferente de tramite, le decimos que la ponga en tramite
            $solicitud->setEstado('Tramite');
            //enviamos el nombre de la imagen y el archivo 
            $solicitud->setAux($imagen1);
            $solicitud->setAux1($File);
            //actualizamos la fecha 
            $solicitud->setFechaupdate($date);
            //creamos el catalogo
            $Catalogo->setNombre($solicitud->getNombre());
            $Catalogo->setFecha($date);
            $Catalogo->setFechaupdate($date);
            $em->persist($Catalogo);
            $em->flush();
            //consultamos catalogo
            $query = $em->createQuery(
                            'SELECT c
        FROM AdminAdminBundle:Catalogo c
        WHERE c.idCata  =:solicitud'
                    )->setParameter('solicitud', $Catalogo->getIdCata());
            $Catalogoaux = $query->getResult();
            // Buscamos el array de resultados
            $Catalogoaux = $query->setMaxResults(1)->getOneOrNullResult();
            $SolicitudCatalogo->setFecha($date);
            $SolicitudCatalogo->setIdSolicitudes($solicitud);
            $SolicitudCatalogo->setIdCatalogos($Catalogoaux);
            $em->persist($SolicitudCatalogo);
            $em->flush();
        }
        if ($idSCatalogo != 'null') {
            $SCatalogo = $entryQueryfinal->getResult();
            foreach ($SCatalogo as $SoliCatalogo) {

                if ($SoliCatalogo->getId() == $idSCatalogo) {

                    $query = $em->createQuery(
                                    'SELECT c
                        FROM AdminAdminBundle:Catalogo c
                        WHERE c.idCata  =:solicitud'
                            )->setParameter('solicitud', $SoliCatalogo->getIdCatalogos());
                }
            }
        } else {

            $query = $em->createQuery(
                            'SELECT sc
        FROM AdminAdminBundle:SolicitudCatalogo sc
        WHERE sc.idSolicitudes  =:id'
                    )->setParameter('id', $Solicitudid);
            $SCatalogo = $query->setMaxResults(1)->getOneOrNullResult();

            $query = $em->createQuery(
                            'SELECT c
                        FROM AdminAdminBundle:Catalogo c
                        WHERE c.idCata  =:solicitud'
                    )->setParameter('solicitud', $SCatalogo->getIdCatalogos());
        }

        $Catalogoaux = $query->getResult();
        // Buscamos el array de resultados
        $Catalogoaux = $query->setMaxResults(1)->getOneOrNullResult();
        foreach ($Hojadevida as $entity) {
            //declaramos la tabla catalogo hojadevida
            $CatalogoHojadevida = new CatalogoHojadevida;
            $CatalogoHojadevida->setIdHojadevida($entity);
            $CatalogoHojadevida->setIdCatalogo($Catalogoaux);
            $em->persist($CatalogoHojadevida);
            $em->flush();
        }
        $solicitud->setFechaupdate($date);
        //enviamos el nombre de la imagen y el archivo 
        $solicitud->setAux($imagen1);
        $solicitud->setAux1($File);

        $em->persist($solicitud);
        $em->flush();
        return new Response('1');
    }

    /**
     *
     * @Route("/personal/remover", name="solicitudcatalogo_remover")
     * @Method("GET")
     */
    public function removeSolicitudAction() {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getEntityManager();

        ///retomamos el id de el segmento 
        $Scataid = $request->get('Scataid');
        ///declaramos la solicitud
        //recibimos las hojas de vida por id
        $ids = $request->get('entities');
        if ($Scataid) {
            $SoliCata = $em->getRepository('AdminAdminBundle:SolicitudCatalogo')->find($Scataid);
            $Cataaux = $em->getRepository('AdminAdminBundle:Catalogo')->find($SoliCata->getIdCatalogos());
            //variable nesesaria para realizar la actualizacion de la fecha
            $solicitud = $em->getRepository('AdminAdminBundle:Solicitud')->find($SoliCata->getIdSolicitudes());
            $imagen1 = $solicitud->getImage();
            $File = $solicitud->getFile();
        }
        ///buscamos la fecha actual 
        $date = new DateTime('now', new \DateTimeZone('America/Bogota'));
        //damos formato a la fecha
        $date->format('l, Y-F-d H:i:s');


        if ($Cataaux) {
            echo 'entramos idcata' . $SoliCata->getIdCatalogos() . 'idsoli' . $solicitud->getIdSolicitud();
            //buscamos las hojas de vida se se encuentran asignadas al catalogo
            $query = $em->createQuery(
                            'SELECT ch
        FROM AdminAdminBundle:CatalogoHojadevida ch
        WHERE (ch.idCatalogo  =:idCatalogo) and (ch.idHojadevida in (:idHojadevida))'
                    )->setParameter('idCatalogo', $SoliCata->getIdCatalogos())
                    ->setParameter('idHojadevida', $ids);
            if ($query->getResult()) {
                $Catalogoaux = $query->getResult();
                foreach ($Catalogoaux as $entity) {
                    $em->remove($entity);
                    $em->flush();
                }
            }
            //actualizamos la solicitud
            $solicitud->setFechaupdate($date);
            $solicitud->setAux($imagen1);
            $solicitud->setAux1($File);
            $em->persist($solicitud);
            $em->flush();
        }
        return new Response('1');
    }

    /**
     *
     * @Route("/personal/guardar/{Solicitudid}", name="solicitudcatalogo_guardar")
     * @Method("GET")
     */
    public function guardarSolicitudAction($Solicitudid) {
        $em = $this->getDoctrine()->getEntityManager();
        ///buscamos la fecha actual 
        $date = new DateTime('now', new \DateTimeZone('America/Bogota'));
        //damos formato a la fecha
        $date->format('l, Y-F-d H:i:s');
        if ($Solicitudid) {
            $solicitud = $em->getRepository('AdminAdminBundle:Solicitud')->find($Solicitudid);
            $query = $em->createQuery(
                            'SELECT sc
        FROM AdminAdminBundle:SolicitudCatalogo sc
        WHERE (sc.idSolicitudes =:id) and (sc.estado =:Est)'
                    )->setParameter('id', $solicitud->getIdSolicitud())
                    ->setParameter('Est', 'Proceso');
            if ($query->getResult()) {
                $msg = 'Se detecto que ahi un catalogo en proceso por favor finalize el catalogo, ingresando al catalogo y dando clic '
                        . 'en terminar catalogo.';
                return $this->redirect($this->generateUrl('solicitudcatalogo', array('Solicitudid' => $Solicitudid, 'Estado' => 'Tramite', 'msg' => $msg)));
            }
            $imagen1 = $solicitud->getImage();
            $File = $solicitud->getFile();
            ///////
            $solicitud->setFechaupdate($date);
            $solicitud->setEstado('Aprobado');
            $solicitud->setAux($imagen1);
            $solicitud->setAux1($File);
            $em->persist($solicitud);
            $em->flush();
            return $this->redirect($this->generateUrl('solicitud', array('estado' => 'Aprobado')));
        }
        return $this->redirect($this->generateUrl('solicitud', array('estado' => 'Aprobado')));
    }

    /**
     *
     * @Route("/segmento/new/{Solicitudid}/{id}/", name="solicitudcatalogo_new")
     * @Method("GET")
     */
    public function newAction($Solicitudid, $id) {

        $em = $this->getDoctrine()->getEntityManager();
        ///buscamos la fecha actual 
        $date = new DateTime('now', new \DateTimeZone('America/Bogota'));
        //declaramos la tabla solicitud Solicitudcatalogo
        $SolicitudCatalogo = new SolicitudCatalogo();
        //declaramos la tabla solicitud
        $solicitud = new Solicitud();
        //necesitamos consultar la tabla de solicitud para sacar el nombre de las imagenes
        //// para poder actualizar 
        $query = $em->createQuery(
                        'SELECT s
        FROM AdminAdminBundle:Solicitud s
        WHERE s.idSolicitud  =:id'
                )->setParameter('id', $Solicitudid);

        $Solicitudes = $query->getResult();
        // en esta instruccion sacamos los nombres de las imagenes que estan en la base de datos
        $Solicitudes = $query->setMaxResults(1)->getOneOrNullResult();
        //guardamos nombre de imagen y archivo, en variables, para no perder el valor, cuando se actualize
        //la solicitud
        $imagen1 = $Solicitudes->getImage();
        $File = $Solicitudes->getFile();
        //identificamos la solicitud segun el id
        $solicitud = $em->getRepository('AdminAdminBundle:Solicitud')->find($Solicitudid);
        //si la solicitud es diferente de tramite, le decimos que la ponga en tramite
        $solicitud->setEstado('Tramite');
        //enviamos el nombre de la imagen y el archivo 
        $solicitud->setAux($imagen1);
        $solicitud->setAux1($File);
        //actualizamos la fecha 
        $solicitud->setFechaupdate($date);
        //creamos el catalogo        
//declaramos la tabla catalogo
        $Catalogo = new Catalogo();
        //creamos el catalogo
        $Catalogo->setNombre($solicitud->getNombre());
        $Catalogo->setFecha($date);
        $Catalogo->setFechaupdate($date);
        $em->persist($Catalogo);
        $em->flush();
        //consultamos catalogo
        $query = $em->createQuery(
                        'SELECT c
        FROM AdminAdminBundle:Catalogo c
        WHERE c.idCata  =:solicitud'
                )->setParameter('solicitud', $Catalogo->getIdCata());
        $Catalogoaux = $query->getResult();
        // Buscamos el array de resultados
        $Catalogoaux = $query->setMaxResults(1)->getOneOrNullResult();
        $SolicitudCatalogo->setFecha($date);
        $SolicitudCatalogo->setIdSolicitudes($solicitud);
        $SolicitudCatalogo->setIdCatalogos($Catalogoaux);
        $SolicitudCatalogo->setEstado('Proceso');
        $em->persist($SolicitudCatalogo);
        $em->flush();

        return $this->redirect($this->generateUrl('solicitudcatalogo_edit', array('id' => $SolicitudCatalogo->getId(), 'Solicitudid' => $Solicitudid)));
    }

    /**
     * Deletes a SolicitudCatalogo entity.
     *
     * @Route("/{id}/delete", name="SolicitudCatalogo_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id) {
        ///buscamos la fecha actual 
        $date = new DateTime('now', new \DateTimeZone('America/Bogota'));
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AdminAdminBundle:SolicitudCatalogo')->find($id);
        $idsolicitud = $entity->getIdSolicitudes();
        $catalogo = $em->getRepository('AdminAdminBundle:Catalogo')->find($entity->getIdCatalogos());
        $query = $em->createQuery(
                        'SELECT CH
                        FROM AdminAdminBundle:CatalogoHojadevida CH
                        WHERE CH.idCatalogo  =:catalogo'
                )->setParameter('catalogo', $entity->getIdCatalogos());
        if ($query->getResult()) {
            $catalogosHojadevidas = $query->getResult();
            ///eliminamos hojas de vida del catalogo
            foreach ($catalogosHojadevidas as $catalogoHojadevida)
                $em->remove($catalogoHojadevida);
            //actualizamos solicitud
            $solicitud = $em->getRepository('AdminAdminBundle:Solicitud')->find($idsolicitud);
            $Est = $solicitud->getEstado();
            echo 'ss' . $Est;
            $imagen1 = $solicitud->getImage();
            $File = $solicitud->getFile();
            ///////
            $solicitud->setFechaupdate($date);
            $solicitud->setAux($imagen1);
            $solicitud->setAux1($File);
            $em->persist($solicitud);
            $em->flush();
        } else {
            $solicitud = $em->getRepository('AdminAdminBundle:Solicitud')->find($idsolicitud);
            $Est = $solicitud->getEstado();
            $imagen1 = $solicitud->getImage();
            $File = $solicitud->getFile();
            ///////
            $solicitud->setFechaupdate($date);
            $solicitud->setAux($imagen1);
            $solicitud->setAux1($File);
            $em->persist($solicitud);
            $em->flush();
        }
        //removemos solicitudcatalogo
        $em->remove($entity);
        //removemos el catalogo
        $em->remove($catalogo);
        $em->flush();

        return $this->redirect($this->generateUrl('solicitudcatalogo', array('Solicitudid' => intval($idsolicitud->getIdSolicitud()), 'Estado' => $Est)));
    }

    /**
     * transferencia a SolicitudCatalogo entity.
     *
     * @Route("/solici/tranfer", name="SolicitudCatalogo_Transferencia")
     * @Method("GET")
     */
    public function TransferenciaAction(Request $request) {
        $desde = $request->query->get('iddesde');
        $hasta = $request->query->get('idhasta');
        if ($desde && $hasta) {
            $em = $this->getDoctrine()->getManager();
            $SC_desde = $em->getRepository('AdminAdminBundle:SolicitudCatalogo')->find($desde);
            $SC_desde->getIdCatalogos();
            //consultamos hojas de vida asignadas a ese catalogo
            $query = $em->createQuery(
                            'SELECT c
                            FROM AdminAdminBundle:CatalogoHojadevida c
                            WHERE c.idCatalogo  =:idCatalogo'
                    )->setParameter('idCatalogo', $SC_desde->getIdCatalogos())
            ;
            if ($query->getResult()) {
                $CatalogoHojadevida = $query->getResult();
                foreach ($CatalogoHojadevida as $aux) {
                    $ids[] = $aux->getIdHojadevida()->getIdhv(); //sacamos id de hojas de vida
                }
            } else {
                $ids[] = null;
            }
            return $this->redirect($this->generateUrl('solicitudcatalogo_add', array('entities' => $ids, 'idSCatalogo' => $hasta)));
        } else {
            return;
        }

        return new Response('1');
    }

    /**
     * notificacion de personal
     * 
     * @Route("/solici/notifi", name="SolicitudCatalogo_notificar")
     * @Method({"GET"})
     */
    public function notificarAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $info_general = $request->get('informacion_general');
        $ids = $request->get('entities');
        $solicitudcatalogo = $em->getRepository('AdminAdminBundle:SolicitudCatalogo')->find($id);
        $idcatalogo = $solicitudcatalogo->getIdCatalogos();
        $query = $em->createQuery(
                        'SELECT ch
                    FROM AdminAdminBundle:CatalogoHojadevida ch
                    WHERE (ch.idCatalogo  =:idCatalogo) and (ch.idHojadevida in (:idHojadevida))')
                ->setParameter('idCatalogo', $idcatalogo)
                ->setParameter('idHojadevida', $ids);
        if ($query->getResult()) {
            $personal = $query->getResult();
            foreach ($personal as $hojadevida) {
                $query = $em->createQuery(
                                'SELECT nt
                    FROM AdminAdminBundle:Notificaciones nt
                    WHERE (nt.idCatalogo  =:idCatalogo) and (nt.idHojadevida =:idHojadevida)')
                        ->setParameter('idCatalogo', $idcatalogo)
                        ->setParameter('idHojadevida', $hojadevida->getidHojadevida()->getidhv());

                if (!$query->getResult()) {
                    $notificacion = new Notificaciones();
                    $notificacion->setIdHojadevida($hojadevida->getIdHojadevida()->getIdHv());
                    $notificacion->setIdCatalogo($hojadevida->getIdCatalogo());
                    $notificacion->setNombre($hojadevida->getIdHojadevida()->getNombre());
                    $notificacion->setApellido($hojadevida->getIdHojadevida()->getApellido());
                    $notificacion->setNit($hojadevida->getIdHojadevida()->getNit());
                    $notificacion->setEstado('Enviado');
                    $notificacion->setInformacionGeneral($info_general);
                    $date = new DateTime('now', new \DateTimeZone('America/Bogota'));
                    $notificacion->setFecha($date);
                    $notificacion->setFechaupdate($date);
                    $em->persist($notificacion);
                    $em->flush();
                    ///notificamos al usuario que ha sido activado, enviandole un correo electronico
                            $names = $hojadevida->getIdHojadevida()->getNombre() . ' ' . $hojadevida->getIdHojadevida()->getApellido();
                            $email = $hojadevida->getIdHojadevida()->getEmailPersonal();
                            $Subject = 'Mainevent informa';
                            $Body = 'Has sido pre-seleccionado para una grabacion, comunicate con nosotros para obtener mas informacion.'
                                    . 'Tel:3099734'
                                    .'Celular:3012512864'
                                    . 'Whatsapp:3192211762.'
                                    . $info_general.
                                    ' ESTE CORREO ES AUTOMATICO, NO RESPONDA ESTE EMAIL';
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
             
            }
        }
        return new Response('1');
    }

    /**
     * notificacion de personal
     * 
     * @Route("/solici/notifi_deta", name="SolicitudCatalogo_notificar_deta")
     * @Method({"GET"})
     */
    public function notificar_detaAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $info_detallada = $request->get('informacion_detallada');
        $tarifa = $request->get('Tarifa');
        $solicitudcatalogo = $em->getRepository('AdminAdminBundle:SolicitudCatalogo')->find($id);
        $idcatalogo = $solicitudcatalogo->getIdCatalogos();
        $query = $em->createQuery(
                        'SELECT nt
        FROM AdminAdminBundle:Notificaciones nt
        WHERE (nt.idCatalogo  =:idCatalogo)')
                ->setParameter('idCatalogo', $idcatalogo);
        if ($query->getResult()) {
            $notificaciones = $query->getResult();
            foreach ($notificaciones as $notificacion) {
                $notificacion->setEstado('Cord_A');
                $notificacion->setTarifa($tarifa);
                $notificacion->setInformacionDetallada($info_detallada);
                $date = new DateTime('now', new \DateTimeZone('America/Bogota'));
                $notificacion->setFechaupdate($date);
                $em->persist($notificacion);
                $em->flush();
            }
        }
        $date = new DateTime('now', new \DateTimeZone('America/Bogota'));
        $solicitudcatalogo->setFechaupdate($date);
        $solicitudcatalogo->setEstado('Terminado');
        $em->persist($solicitudcatalogo);
        $em->flush();
        return new Response('1');
    }

}
