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
    public function index(Request $request)
    {
        $players = explode(',', $request->query->get('players'));

        return $this->render('battle/index.html.twig', [
            'players' => $players
        ]);
    }

    /**
     * @Route("/api/get/player", name="api_player_get", methods={"GET", "POST"})
     */
    public function getPlayerApi(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $requestData = json_decode($request->getContent());
        $id = $requestData->id;
        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $id]);
        return new JsonResponse(
            [
                'status' => '200',
                'data' => $user
            ],
            200
        );
    }

    /**
     * @Route("/api/get/weapons", name="api_weapons_get", methods={"GET", "POST"})
     */
    public function getWeaponsApi(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $requestData = json_decode($request->getContent());
        $id = $requestData->id;
        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $id]);
        return new JsonResponse(
            [
                'status' => '200',
                'data' => $user->getWeapons()
            ],
            200
        );
    }

    /**
     * @Route("/api/get/armours", name="api_armours_get", methods={"GET", "POST"})
     */
    public function getArmoursApi(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $requestData = json_decode($request->getContent());
        $id = $requestData->id;
        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $id]);
        return new JsonResponse(
            [
                'status' => '200',
                'data' => $user->getArmours()
            ],
            200
        );
    }

    /**
     * @Route("/api/attack", name="api_attack", methods={"GET", "POST"})
     */
    public function attackApi(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $requestData = json_decode($request->getContent());

        // Get attacker
        $attackerId = $requestData->attackerId;
        $attacker = $entityManager->getRepository(User::class)->findOneBy(['id' => $attacker]);

        // Get target
        $targetId = $requestData->targetId;
        $target = $entityManager->getRepository(User::class)->findOneBy(['id' => $target]);

        // Roll hit
        $randomInt = rand(0, 100);
        if ($randomInt > $attacker->getAccuracy()) {
            return new JsonResponse(
                [
                    'status' => '200',
                    'data' => $attacker->getUsername().' missed!'
                ],
                200
            );
        }

        // Roll evasion
        $randomInt = rand(0, 100);
        if ($randomInt > $attacker->getEvasion()) {
            return new JsonResponse(
                [
                    'status' => '200',
                    'data' => $target->getUsername().' evaded!'
                ],
                200
            );
        }

        // Determine the attacker weapon
        $attackerWeapon = $attacker->getPrimaryWeapon(); // temp solution

        // Determine the target armour
        $bodyTargetInt = rand(0, 4);
        switch ($bodyTargetInt) {
            case 1:
                $targetArmour = $target->getHeadArmour();
                break;
            case 2:
                $targetArmour = $target->getChestArmour();
                break;
            case 3:
                $targetArmour = $target->getLegArmour();
                break;
            default:
                $targetArmour = null;
                break;
        }
        
        // Determine attacker strength
        if ($attackerWeapon != null) {
            
            $attackerStrength = $attacker->getAttack() + $attackerWeapon->getType()->getPower();

            // Attack modifiers
            $attackerWeaponEffects = json_decode($attackerWeapon->getType()->getEffects());
            $attackerWeaponMods = $attackerWeaponEffects['modifiers'];
            $targetArmourClass = $targetArmour->getType()->getClass()->getName();
            if (isset($attackerWeaponMods[$targetArmourClass])) {
                $attackerStrength = $attackerStrength * $attackerWeaponMods[$targetArmourClass];
            }
        }
        else {
            $attackerStrength = $attacker->getAttack();
        }

        // Determine target strength
        if ($targetArmour != null) {

            $targetStrength = $target->getDefence() + $targetArmour->getType()->getProtection();

            // Defence modifiers
            $targetArmourEffects = json_decode($targetArmour->getType()->getEffects());
            $targetArmourMods = $targetArmourEffects['modifiers'];
            $attackerWeaponClass = $attackerWeapon->getType()->getClass()->getName();
            if (isset($targetArmourMods[$attackerWeaponClass])) {
                $targetStrength = $targetStrength * $targetArmourMods[$attackerWeaponClass];
            }
        }
        else {
            $targetStrength = $target->getDefence();
        }

        // Calculate damage
        $damage = $attackerStrength - $targetStrength;

        // Round the damage to an integer
        $damage = round($damage);

        // At least give the attacker a chance lol
        if ($damage <= 0) {
            $damage = 1;
        }

        // Apply the damage
        $target->setCurrentHitpoints($target->getCurrentHitpoints() - $damage);

        // Update durability stats
        $attackerWeapon->setDurability($attackerWeapon->getDurability() - 1);
        $targetArmour->setDurability($targetArmour->getDurability() - 1);

        // Send all thew changes to the database
        $entityManager->flush();

        return new JsonResponse(
            [
                'status' => '200',
                'data' => [
                    'attacker' => $attacker,
                    'target' => $target
                ]
            ],
            200
        );
    }
}
