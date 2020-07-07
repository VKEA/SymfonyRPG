<?php

namespace App\Controller;

use App\Entity\ArmourType;
use App\Form\ArmourTypeType;
use App\Repository\ArmourTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/armour_type")
 */
class ArmourTypeController extends AbstractController
{
    /**
     * @Route("/", name="armour_type_index", methods={"GET"})
     */
    public function index(ArmourTypeRepository $armourTypeRepository): Response
    {
        return $this->render('armour_type/index.html.twig', [
            'armour_types' => $armourTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="armour_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $armourType = new ArmourType();
        $form = $this->createForm(ArmourTypeType::class, $armourType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($armourType);
            $entityManager->flush();

            return $this->redirectToRoute('armour_type_index');
        }

        return $this->render('armour_type/new.html.twig', [
            'armour_type' => $armourType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="armour_type_show", methods={"GET"})
     */
    public function show(ArmourType $armourType): Response
    {
        return $this->render('armour_type/show.html.twig', [
            'armour_type' => $armourType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="armour_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ArmourType $armourType): Response
    {
        $form = $this->createForm(ArmourTypeType::class, $armourType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('armour_type_index');
        }

        return $this->render('armour_type/edit.html.twig', [
            'armour_type' => $armourType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="armour_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ArmourType $armourType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$armourType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($armourType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('armour_type_index');
    }
}
