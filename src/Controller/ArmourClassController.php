<?php

namespace App\Controller;

use App\Entity\ArmourClass;
use App\Form\ArmourClassType;
use App\Repository\ArmourClassRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/armour_class")
 */
class ArmourClassController extends AbstractController
{
    /**
     * @Route("/", name="armour_class_index", methods={"GET"})
     */
    public function index(ArmourClassRepository $armourClassRepository): Response
    {
        return $this->render('armour_class/index.html.twig', [
            'armour_classes' => $armourClassRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="armour_class_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $armourClass = new ArmourClass();
        $form = $this->createForm(ArmourClassType::class, $armourClass);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($armourClass);
            $entityManager->flush();

            return $this->redirectToRoute('armour_class_index');
        }

        return $this->render('armour_class/new.html.twig', [
            'armour_class' => $armourClass,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="armour_class_show", methods={"GET"})
     */
    public function show(ArmourClass $armourClass): Response
    {
        return $this->render('armour_class/show.html.twig', [
            'armour_class' => $armourClass,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="armour_class_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ArmourClass $armourClass): Response
    {
        $form = $this->createForm(ArmourClassType::class, $armourClass);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('armour_class_index');
        }

        return $this->render('armour_class/edit.html.twig', [
            'armour_class' => $armourClass,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="armour_class_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ArmourClass $armourClass): Response
    {
        if ($this->isCsrfTokenValid('delete'.$armourClass->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($armourClass);
            $entityManager->flush();
        }

        return $this->redirectToRoute('armour_class_index');
    }
}
