<?php

namespace Admin\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Admin\AdminBundle\Pagination\Paginator;

/**
 * Catalogo controller.
 *
 * @Route("/admin/informe")
 */
class InformeController extends Controller {

    /**
     * Lists all Catalogo entities.
     *
     * @Route("/", name="informe")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        //abrimos conexion con bd
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $page = $request->query->get('page');
        $searchParam = $request->get('searchParam');
        $entryQuery = $em->createQueryBuilder()
                    ->select('S')
                    ->from('AdminAdminBundle:Solicitud', 'S')
                    ->addOrderBy('S.fechaupdate', 'DESC');
         $entryQueryfinal = $entryQuery->getQuery();
        //obtenemos el array de resultados
        $entities = $entryQueryfinal->getArrayResult();
        $Total=count($entities);
        $entryQuery = $em->createQueryBuilder()
                    ->select('S')
                    ->from('AdminAdminBundle:Solicitud', 'S')
                    ->andWhere('S.estado=:estado')
                    ->addOrderBy('S.fechainicio', 'DESC')
                    ->setParameter('estado', 'Pendiente');
        $entryQueryfinal = $entryQuery->getQuery();
        //obtenemos el array de resultados
        $Pendientes = count($entryQueryfinal->getArrayResult());
        $entryQuery = $em->createQueryBuilder()
                    ->select('S')
                    ->from('AdminAdminBundle:Solicitud', 'S')
                    ->andWhere('S.estado=:estado')
                    ->addOrderBy('S.fechainicio', 'DESC')
                    ->setParameter('estado', 'Tramite');
        $entryQueryfinal = $entryQuery->getQuery();
        //obtenemos el array de resultados
        $Tramite = count($entryQueryfinal->getArrayResult());
        $entryQuery = $em->createQueryBuilder()
                    ->select('S')
                    ->from('AdminAdminBundle:Solicitud', 'S')
                    ->andWhere('S.estado=:estado')
                    ->addOrderBy('S.fechainicio', 'DESC')
                    ->setParameter('estado', 'Aprobado');
        $entryQueryfinal = $entryQuery->getQuery();
        //obtenemos el array de resultados
        $Aprobado = count($entryQueryfinal->getArrayResult());
        
        return array(
            'entities' => $entities,
            'Total'=>$Total,
            'current_page' => $page,
            'entitiesLength' => $Total,
            'searchParam' => $searchParam,
            'Pendientes'=>$Pendientes,
            'Tramite'=>$Tramite,
            'Aprobado'=>$Aprobado
           
        );
    }
    /**
     * consulta a Solicitud entity.
     *
     * @Route("/ajax/consulta", name="informe_ajax")
     * @Method("GET")
     */
    public function ajaxListAction(Request $request) {
        //abrimos conexion con bd
        $em = $this->getDoctrine()->getManager();
        //recuperamos la pagina en la que se encuentra el usuario
        $page = $request->query->get('page');
        //tomamos todas las variables de busqueda
        $searchParam = $request->get('searchParam');
        //extraemos las variables
        extract($searchParam);
        //creamos query principal
        $entryQuery = $em->createQueryBuilder()
                    ->select('S')
                    ->from('AdminAdminBundle:Solicitud', 'S')
                    ->addOrderBy('S.fechainicio', 'DESC');
        ///creamos query auxiliar
        $queryaux = $em->createQueryBuilder()
                ->select('COUNT(S)')
                ->from('AdminAdminBundle:Solicitud', 'S')
                ->addOrderBy('S.fechainicio', 'DESC');
        /// si el estado existe agrege una consulta
         if (!empty($Estado)) {
            $entryQuery->andWhere('S.estado=:estado')->setParameter('estado', $Estado);
            $queryaux->andWhere('S.estado=:estado')->setParameter('estado', $Estado);
        }
        $total_count = $queryaux->getQuery()->getSingleScalarResult();
        if (!empty($perPage))
        $entryQuery->setFirstResult(($page - 1) * $perPage)->setMaxResults($perPage);
        $entryQueryfinal = $entryQuery->getQuery();
        //obtenemos el array de resultados
        $entities = $entryQueryfinal->getArrayResult();
        $pagination = (new Paginator())->setItems($total_count, $searchParam['perPage'])->setPage($searchParam['page'])->toArray();
        //renderizamos la vista para mostrar las hojas de vida
        return $this->render('AdminAdminBundle:Informe:ajax_list.html.twig', array(
                    'entities' => $entities,
                    'pagination' => $pagination,
                    'entitiesLength' => 10,
                    'total_pages' => 10,
                    
                    'count_per_page' => 10
                    
        ));
    }
}
