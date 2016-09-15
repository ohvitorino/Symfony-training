<?php
/**
 * Created by PhpStorm.
 * User: brunop
 * Date: 12/09/2016
 * Time: 14:59
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 *
 * @Route("/game")
 * @Cache(maxage=120)
 *
 * @Security("has_role('ROLE_USER')")
 *
 * Class GameController
 * @package AppBundle\Controller
 */
class GameController extends Controller
{
    /**
     * @Route("/", name="game_homepage")
     *
     * @Cache(smaxage=30)
     */
    public function homepageAction()
    {
        return $this->render('game/homepage.html.twig', [
            'word' => 'symfony',
            'remaining_attempts' => 10
        ]);
    }

    /**
     * @Route("/won", name="game_won")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function wonAction()
    {
        return $this->render('game/won.html.twig');
    }

    /**
     * @Route("/failed", name="game_failed")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function failedAction()
    {
        return $this->render('game/failed.html.twig');
    }

    /**
     * @Cache(smaxage=2)
     */
    public function lastPlayersAction()
    {
        $players = ['Pierre', 'Jacques', 'Jan', 'Lies', 'Maria'];
        return $this->render('game/fragments/last_players.html.twig', [
            'players' => array_rand(array_flip($players), 3)
        ]);
    }

    /**
     * @Route("/letter", name="game_letter")
     *
     * @param $letter
     */
    public function letterAction($letter)
    {

    }
}