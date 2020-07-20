<?php

namespace App\Controller;

use App\Entity\ArmourType;
use App\Form\ArmourTypeType;
use App\Repository\ArmourTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;

/**
 * @Route("/battle")
 */
class BattleController extends AbstractController
{
    /**
     * @Route("/", name="battle_index", methods={"GET"})
     */
    public function index()
    {
        return $this->render('battle/index.html.twig', [
            
        ]);
    }

    /**
     * @Route("/api/get/player", name="player_api", methods={"GET", "POST"})
     */
    public function getPlayerApi(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $id = $request->request->get('id');
        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => 1]);
        return new JsonResponse(
            [
                'status' => '200',
                'data' => $user
            ],
            200
        );
    }
}
