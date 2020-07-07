<?php

namespace App\Controller;

use App\Entity\Armour;
use App\Form\ArmourType;
use App\Repository\ArmourRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/armour")
 */
class ArmourController extends AbstractController
{
    /**
     * @Route("/", name="armour_index", methods={"GET"})
     */
    public function index(ArmourRepository $armourRepository): Response
    {
        return $this->render('armour/index.html.twig', [
            'armours' => $armourRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="armour_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $armour = new Armour();
        $form = $this->createForm(ArmourType::class, $armour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($armour);
            $entityManager->flush();

            return $this->redirectToRoute('armour_index');
        }

        return $this->render('armour/new.html.twig', [
            'armour' => $armour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="armour_show", methods={"GET"})
     */
    public function show(Armour $armour): Response
    {
        return $this->render('armour/show.html.twig', [
            'armour' => $armour,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="armour_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Armour $armour): Response
    {
        $form = $this->createForm(ArmourType::class, $armour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('armour_index');
        }

        return $this->render('armour/edit.html.twig', [
            'armour' => $armour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="armour_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Armour $armour): Response
    {
        if ($this->isCsrfTokenValid('delete'.$armour->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($armour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('armour_index');
    }
}
