<?php

namespace AppBundle\Controller;

use AppBundle\Service\Orchestrator;
use AppBundle\Service\TeamFlow;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @var TeamFlow
     */
    private $teamFlow;

    /**
     * DefaultController constructor.
     *
     * @param TeamFlow $teamFlow
     */
    public function __construct(TeamFlow $teamFlow)
    {
        $this->teamFlow = $teamFlow;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $project = $this->teamFlow->getProject();

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
            'project' => $project,
        ]);
    }
}
