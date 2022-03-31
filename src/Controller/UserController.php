<?php

namespace App\Controller;

use App\Entity\Pokemon;
use App\Entity\Team;
use App\Entity\Tier;
use App\Entity\User;
use App\Form\TeamType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/ajouter-une-equipe", name="add_team")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
                       public function addTeam(Request $request)
                    {
                        $newTeam = new Team();

                        $form = $this->createForm(TeamType::class, $newTeam, [
                            'tierRepository' => $this->getDoctrine()->getRepository(Tier::class)
                        ]);

                        $form->handleRequest($request);



                        if ($form->isSubmitted() && $form->isValid())
                        {
                            $tier = $request->request->get('team')['tier'];

                            // Divise chaque pokemon du paste en tableau
                            $teamSplit = preg_split('/\r\n(\r\n)+/', $request->request->get('team')['paste']);

                            // Servira a stocker les pokemons dans l'ordre dans la base de données
                            $i = 0;


                            foreach ($teamSplit as $pokemon) {
                                if ($pokemon !== '') {

                                    //Divise le set en tableau pour extraire les données
                                    $set = preg_split('/  \r\n/', $pokemon);

                                    $pokemonRepository = $this->getDoctrine()->getRepository(Pokemon::class);

                                    $pokemonDepo[$i] = new Sets();

                                    // Ability will always be at index 1
                                    $pokemonDepo[$i]->setAbility(substr($set[1], 9));

                                    $line = 2;

                                    if (preg_match('/^Level:/', $set[$line]))
                                        $pokemonDepo[$i]->setLevel(substr($set[$line++], 7));

                                    // TODO : managing Shinies
                                    if (preg_match('/^Shiny:/', $set[$line]))
                                        $line++;

                                    if (preg_match('/^Happiness:/', $set[$line]))
                                        $pokemonDepo[$i]->setHappiness(substr($set[$line++], 11));



                    if (preg_match('/^EVs:/', $set[$line]))
                        $pokemonDepo[$i]->setEvs(substr($set[$line++], 5));


                    if (preg_match('/Nature$/', $set[$line]))
                        $pokemonDepo[$i]->setNature(substr($set[$line++], 0, -7));


                    if (preg_match('/^IVs:/', $set[$line]))
                        $pokemonDepo[$i]->setIvs(substr($set[$line++], 5));


                    $moves = [];

                    // TODO : manages bad lines
                     for ($end = $line + 4; $line < $end; $line++)
                     {
                         if (preg_match('/^- /', $set[$line]))
                             $moves[] = substr($set[$line], 2);
                     }

                     $pokemonDepo[$i]->setMoves($moves);


                    // Will find the name of the pokemon on the first line
                    switch ($pokemonName = $set[0]) {
                        // only name
                        case (preg_match('/^[A-Z][0-9a-z\-]+$/', $pokemonName) ? true : false):
                            $pokemonDepo[$i]->setPaste($pokemon);
                            $pokemonDepo[$i++]->setPokemon($pokemonRepository->findOneBy(['name' => $pokemonName]));
                            break;

                        // name + genre
                        case (preg_match('/^[A-Z][0-9a-z\-]+ \([FM]\)$/', $pokemonName) ? true : false):
                            $pokemonDepo[$i]->setPaste($pokemon);
                            $pokemonDepo[$i++]->setPokemon($pokemonRepository->findOneBy(['name' => substr($pokemonName, 0, -4)]));
                            break;

                        // name + item
                        case (preg_match('/^([A-Z][a-z0-9\-]+) @ [A-Za-z0-9 \-]+$/', $pokemonName) ? true : false):
                            $pokemonDepo[$i]->setPaste($pokemon);
                            $pokemonDepo[$i]->setItem(strrev(strstr(strrev($pokemonName), ' @', true )));
                            $pokemonDepo[$i++]->setPokemon($pokemonRepository->findOneBy(['name' => strstr($pokemonName, ' @', true)]));
                            break;

                        // name + nickname
                        case (preg_match('/^.* \([A-Z][a-z0-9 \-]+\)$/', $pokemonName) ? true : false):
                            $pokemonDepo[$i]->setPaste($pokemon);
                            $pokemonDepo[$i++]->setPokemon($pokemonRepository->findOneBy(['name' => strrev(strstr(substr(strrev($pokemonName), 1), '(', true))]));
                            break;

                        // name + genre + item
                        case (preg_match('/^[0-9A-Za-z\-]+ \([FM]\) @ [A-Za-z 0-9\-]+$/', $pokemonName) ? true : false):
                            $pokemonDepo[$i]->setPaste($pokemon);
                            $pokemonDepo[$i]->setItem(strrev(strstr(strrev($pokemonName), ' @', true )));
                            $pokemonDepo[$i++]->setPokemon($pokemonRepository->findOneBy(['name' => strstr($pokemonName, ' (', true)]));
                            break;

                        // name + nickname + genre
                        case (preg_match('/^.* \([A-Za-z0-9 \-]+\) \([FM]\)$/', $pokemonName) ? true : false):
                            $pokemonDepo[$i]->setPaste($pokemon);
                            $pokemonDepo[$i++]->setPokemon($pokemonRepository->findOneBy(['name' => strrev(strstr(substr(strrev($pokemonName), 5), '(', true))]));
                            break;

                        // name + nickname + item
                        case (preg_match('/^.* \([A-Z][a-z0-9\-]+\) @ [A-Za-z0-9 \-]+$/', $pokemonName) ? true : false):
                            $pokemonDepo[$i]->setPaste($pokemon);
                            $pokemonDepo[$i]->setItem(strrev(strstr(strrev($pokemonName), ' @', true )));
                            $pokemonDepo[$i++]->setPokemon($pokemonRepository->findOneBy(['name' => substr(strrev(strstr(strstr(strrev($pokemonName), '@ )'), '(', true)), 0, -3)]));
                            break;

                        // name + nickname + item + genre
                        case (preg_match('/^.* \([A-Za-z0-9 \-]+\) \([FM]\) @ [A-Za-z 0-9\-]+$/', $pokemonName) ? true : false):
                            $pokemonDepo[$i]->setPaste($pokemon);
                            $pokemonDepo[$i]->setItem(strrev(strstr(strrev($pokemonName), ' @', true )));
                            $pokemonDepo[$i++]->setPokemon($pokemonRepository->findOneBy(['name' => strrev(strstr(substr(strstr(strrev($pokemonName), '( )'), 3), '(', true))]));
                            break;
                    }
                }
            }

            $em = $this->getDoctrine()->getManager();


            foreach ($pokemonDepo as $pokemon)
            {
                $pokemon->setTeam($newTeam);
                $em->persist($pokemon);
            }

            $newTeam->setTier($this->getDoctrine()->getRepository(Tier::class)->findOneBy(['id' => $tier]))
                ->setValidated('N')
                ->setAuthor($this->getUser())
            ;

            $em->persist($newTeam);
            $em->flush();

            $this->addFlash('success', 'Equipe envoyée avec succès !');

            return $this->redirectToRoute('index');

        }


        return $this->render('user/addTeam.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/ajouter-un-tier", name="add_tier")
     * @param Request $request
     * @return Response
     */
    public function addTier(Request $request)
    {
        $newTier = new Tier();

        $form = $this->createForm(TierType::class, $newTier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newTier);
            $em->flush();

            $this->addFlash('success', 'Tier créé avec succès !');

        }

        return $this->render('user/addTier.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route ("/profile-{id}", name="profile")
     * @param User $user
     */
    public function profile(User $user)
    {
        return $this->render('user/profile.html.twig', [
            'user' => $user
        ]);
    }
}
