<?php

namespace App\Controller;

use App\Data\searchTeam;
use App\Entity\Pokemon;
use App\Entity\Team;
use App\Form\SearchTeamType;
use App\Repository\TeamRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('main/index.html.twig');
    }

    /**
     * @Route("/liste-des-equipes", name="search")
     * @param TeamRepository $repo
     * @return Response
     */
    public function search(TeamRepository $repo, Request $request)
    {
        // Classe qui récupèrera les infos du formulaire
       $data = new SearchTeam();

       // Formulaire des filtres de recherche
       $form = $this->createForm(SearchTeamType::class, $data);
       $form->handleRequest($request);


       $teamRepository = $this->getDoctrine()->getRepository(Team::class);

       $teams = $teamRepository->findTeam($data);

        return $this->render('main/search.html.twig', [
            'teams' => $teams,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/equipe-{id}", name="team", requirements={"id"="\d+"})
     * @param Team $team
     * @return Response
     */
    public function team(Team $team)
    {
        $teamOutput['name'] = $team->getName();
        $teamOutput['author'] = $team->getAuthor();
        $teamOutput['tier'] = $team->getTier();
        $teamOutput['sets'] = $team->getSets();

        return $this->render('main/team.html.twig',
            [
                'team' => $teamOutput,
            ]);
    }

}
