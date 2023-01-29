<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DataUriNormalizer;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
/**
 * Class ProjectController
 * @Route("admin")
 * @IsGranted("ROLE_ADMIN")
 */

class ProjectController extends AbstractController
{
    /**
     * @Route("/addproject", name="add_project")
     *
     */
    public function index(Request $request,SluggerInterface $slugger): Response
    {

        $project  = new Project();
        $form = $this->createForm(ProjectType::class,$project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('image')->getData();
            $file = $form->get('url')->getData();
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),
                $newFilename
            );

            $fichier = md5(uniqid()) . '.' . $image->guessExtension();

            // On copie le fichier dans le dossier uploads
            $image->move(
                $this->getParameter('images_directory'),
                $fichier
            );
            $normalizer = new DataUriNormalizer();
            $avatar = $normalizer->normalize(new \SplFileObject('uploads/'.$fichier));

            $project->setImage($avatar);
            $project->setUrl($newFilename);
            $project->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($project);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('project/addproject.html.twig',[
            'format' => $form->createView(),

        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit_project",methods={"GET","POST"})
     */
    public function editProject(Request $request , Project $project,SluggerInterface $slugger)
    {
        $file = $project->getImage();
        $file2 = $project->getUrl();

        if ($file !== null) {
            $project->setImage($file);

        }
        if ($file2 !== null) {
            $project->setUrl($file2);

        }
        $editform = $this->createForm(ProjectType::class, $project);
        $editform->handleRequest($request);
        $oldImage = $project->getImage();
        $oldFile = $project->getUrl();
        if ($editform->isSubmitted() && $editform->isValid()) {

            if ($editform->get('image')->getData() != null) {
                $imageFile = $editform->get('image')->getData();
                $newimageName = md5(uniqid()) . '.' . $imageFile->guessExtension();
                $imageFile->move($this->getParameter('images_directory'), $newimageName);
                $normalizer = new DataUriNormalizer();
                $avatar = $normalizer->normalize(new \SplFileObject('uploads/' . $newimageName));
                $project->setImage($avatar);

                //edit file
                $File = $editform->get('url')->getData();
                if( $File !== null){
                    $originalFilename = pathinfo($File->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$File->guessExtension();
                    $File->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                    $project->setUrl($newFilename);
                }


            } else {
                $project->setImage($oldImage);
                $project->setUrl($oldFile);
            }
            $project->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('project/editproject.html.twig', [
            'format' => $editform->createView()
        ]);
    }


    /**
     * @Route("delete/{id}", name="project_delete", methods={"GET","DELETE"})
     */
    public function delete(Project $project)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($project);
        $em->flush();
        return $this->redirectToRoute('home');
    }

}
