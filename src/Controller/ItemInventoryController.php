<?php

namespace App\Controller;

use App\Entity\ItemInventory;
use App\Form\ItemInventoryType;
use App\Repository\ItemInventoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/item_inventory")
 */
class ItemInventoryController extends AbstractController
{
    /**
     * @Route("/", name="item_inventory_index", methods={"GET"})
     */
    public function index(ItemInventoryRepository $itemInventoryRepository): Response
    {
        return $this->render('item_inventory/index.html.twig', [
            'item_inventories' => $itemInventoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="item_inventory_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $itemInventory = new ItemInventory();
        $form = $this->createForm(ItemInventoryType::class, $itemInventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($itemInventory);
            $entityManager->flush();

            return $this->redirectToRoute('item_inventory_index');
        }

        return $this->render('item_inventory/new.html.twig', [
            'item_inventory' => $itemInventory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="item_inventory_show", methods={"GET"})
     */
    public function show(ItemInventory $itemInventory): Response
    {
        return $this->render('item_inventory/show.html.twig', [
            'item_inventory' => $itemInventory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="item_inventory_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ItemInventory $itemInventory): Response
    {
        $form = $this->createForm(ItemInventoryType::class, $itemInventory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('item_inventory_index');
        }

        return $this->render('item_inventory/edit.html.twig', [
            'item_inventory' => $itemInventory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="item_inventory_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ItemInventory $itemInventory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itemInventory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($itemInventory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('item_inventory_index');
    }
}
