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
 * @Route("/battle")
 */
class BattleController extends AbstractController
{
    /**
     * @Route("/", name="battle_index", methods={"GET"})
     */
    public function index(ArmourTypeRepository $armourTypeRepository): Response
    {
        return $this->render('battle/index.html.twig', [
            
        ]);
    }
}
