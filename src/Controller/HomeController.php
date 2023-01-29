<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\ProjectSearch;
use App\Form\ProjectSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request ;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class HomeController
 *
 */


class HomeController extends AbstractController
{


    /**
     * @Route("/",name="home",methods={"GET","POST"})
     *
     */
    public function list(Request $request,PaginatorInterface $paginator): Response
    {
        $search = new ProjectSearch();
        $form = $this->createForm(ProjectSearchType::class, $search);

        $form->handleRequest($request);

        $repository = $this->getDoctrine()->getRepository(Project::class);
        $items = $repository->findAllProjects($search);

        $projects = $paginator->paginate(
            $items, // Requête contenant les données à paginer
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6// Nombre de résultats par page
        );
       return $this->render('home/index.html.twig', ['projects' => $projects, 'form' => $form->createView() ]);
    }


}