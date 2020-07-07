<?php

namespace App\Controller;

use App\Entity\WeaponType;
use App\Form\WeaponTypeType;
use App\Repository\WeaponTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/weapon_type")
 */
class WeaponTypeController extends AbstractController
{
    /**
     * @Route("/", name="weapon_type_index", methods={"GET"})
     */
    public function index(WeaponTypeRepository $weaponTypeRepository): Response
    {
        return $this->render('weapon_type/index.html.twig', [
            'weapon_types' => $weaponTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="weapon_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $weaponType = new WeaponType();
        $form = $this->createForm(WeaponTypeType::class, $weaponType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($weaponType);
            $entityManager->flush();

            return $this->redirectToRoute('weapon_type_index');
        }

        return $this->render('weapon_type/new.html.twig', [
            'weapon_type' => $weaponType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="weapon_type_show", methods={"GET"})
     */
    public function show(WeaponType $weaponType): Response
    {
        return $this->render('weapon_type/show.html.twig', [
            'weapon_type' => $weaponType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="weapon_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, WeaponType $weaponType): Response
    {
        $form = $this->createForm(WeaponTypeType::class, $weaponType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('weapon_type_index');
        }

        return $this->render('weapon_type/edit.html.twig', [
            'weapon_type' => $weaponType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="weapon_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, WeaponType $weaponType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$weaponType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($weaponType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('weapon_type_index');
    }
}
