<?php
/**
 * Created by PhpStorm.
 * User: brunop
 * Date: 12/09/2016
 * Time: 14:59
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 *
 * @Route("/game")
 *
 * Class GameController
 * @package AppBundle\Controller
 */
class GameController extends Controller
{
    /**
     * @Route("/", name="game_homepage")
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
     * @Route("/letter", name="game_letter")
     *
     * @param $letter
     */
    public function letterAction($letter)
    {

    }
}