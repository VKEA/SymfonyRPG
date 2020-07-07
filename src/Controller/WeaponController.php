<?php

namespace App\Controller;

use App\Entity\Weapon;
use App\Form\WeaponType;
use App\Repository\WeaponRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/weapon")
 */
class WeaponController extends AbstractController
{
    /**
     * @Route("/", name="weapon_index", methods={"GET"})
     */
    public function index(WeaponRepository $weaponRepository): Response
    {
        return $this->render('weapon/index.html.twig', [
            'weapons' => $weaponRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="weapon_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $weapon = new Weapon();
        $form = $this->createForm(WeaponType::class, $weapon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($weapon);
            $entityManager->flush();

            return $this->redirectToRoute('weapon_index');
        }

        return $this->render('weapon/new.html.twig', [
            'weapon' => $weapon,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="weapon_show", methods={"GET"})
     */
    public function show(Weapon $weapon): Response
    {
        return $this->render('weapon/show.html.twig', [
            'weapon' => $weapon,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="weapon_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Weapon $weapon): Response
    {
        $form = $this->createForm(WeaponType::class, $weapon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('weapon_index');
        }

        return $this->render('weapon/edit.html.twig', [
            'weapon' => $weapon,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="weapon_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Weapon $weapon): Response
    {
        if ($this->isCsrfTokenValid('delete'.$weapon->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($weapon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('weapon_index');
    }
}
