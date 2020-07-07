<?php

namespace App\Controller;

use App\Entity\WeaponClass;
use App\Form\WeaponClassType;
use App\Repository\WeaponClassRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/weapon_class")
 */
class WeaponClassController extends AbstractController
{
    /**
     * @Route("/", name="weapon_class_index", methods={"GET"})
     */
    public function index(WeaponClassRepository $weaponClassRepository): Response
    {
        return $this->render('weapon_class/index.html.twig', [
            'weapon_classes' => $weaponClassRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="weapon_class_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $weaponClass = new WeaponClass();
        $form = $this->createForm(WeaponClassType::class, $weaponClass);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($weaponClass);
            $entityManager->flush();

            return $this->redirectToRoute('weapon_class_index');
        }

        return $this->render('weapon_class/new.html.twig', [
            'weapon_class' => $weaponClass,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="weapon_class_show", methods={"GET"})
     */
    public function show(WeaponClass $weaponClass): Response
    {
        return $this->render('weapon_class/show.html.twig', [
            'weapon_class' => $weaponClass,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="weapon_class_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, WeaponClass $weaponClass): Response
    {
        $form = $this->createForm(WeaponClassType::class, $weaponClass);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('weapon_class_index');
        }

        return $this->render('weapon_class/edit.html.twig', [
            'weapon_class' => $weaponClass,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="weapon_class_delete", methods={"DELETE"})
     */
    public function delete(Request $request, WeaponClass $weaponClass): Response
    {
        if ($this->isCsrfTokenValid('delete'.$weaponClass->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($weaponClass);
            $entityManager->flush();
        }

        return $this->redirectToRoute('weapon_class_index');
    }
}
