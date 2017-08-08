<?php

namespace AppBundle\Controller;

use AppBundle\Domain\MezzoInterface;
use AppBundle\Service\Orchestrator;
use AppBundle\Service\TeamFlow;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

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

    /**
     * @Route("/metrics/{metricName}", name="metrics")
     */
    public function metricAction(Request $request, string $metricName)
    {
        $timeline = $this->get('app.service.history_manager')->getHistory();
        $project = $this->teamFlow->getProject();

        // replace this example code with whatever you need
        return $this->render("default/$metricName.html.twig", [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
            'apps' => MezzoInterface::APPS,
            'project' => $project,
            'json' => $this->get('serializer')->serialize($timeline, JsonEncoder::FORMAT),
        ]);
    }
}
