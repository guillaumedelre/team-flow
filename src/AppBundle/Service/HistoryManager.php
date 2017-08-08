<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 04/08/17
 * Time: 21:55
 */

namespace AppBundle\Service;

use AppBundle\Entity\Artifact\PhpunitClover;
use AppBundle\Entity\Project;
use AppBundle\Entity\Service;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class HistoryManager
{
    const BUILD_STATUS_SUCCESS = 'success';
    const BUILD_STATUS_FAILED = 'failed';

    const BUILD_STAGE_BUILD = 'buid';
    const BUILD_STAGE_PACKAGE = 'package';
    const BUILD_STAGE_DEPLOY = 'deploy';

    const BUILD_SUCCESS = 0b001;
    const BUILD_WARNING = 0b010;
    const BUILD_ERROR = 0b000;

    /**
     * @var string
     */
    private $historyPath;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * History constructor.
     *
     * @param string $historyPath
     * @param Filesystem $filesystem
     * @param SerializerInterface $serializer
     */
    public function __construct(
        string $historyPath,
        Filesystem $filesystem,
        SerializerInterface $serializer
    ) {
        $this->historyPath = $historyPath;
        $this->filesystem = $filesystem;
        $this->serializer = $serializer;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function hasHistory(): bool
    {
        if (!$this->filesystem->exists($this->historyPath)) {
            $message = sprintf('Path not found `%s`.', $this->historyPath);
            throw new \Exception($message);
        }

        $finder = new Finder();

        $finder->files()->in($this->historyPath)->name('*.json')->sortByModifiedTime();
        if (0 === $finder->count()) {
            return false;
        }

        return true;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getHistory(): array
    {
        $finder = new Finder();
        $finder->files()->in($this->historyPath)->name('*.json')->sortByModifiedTime();
        $files = \iterator_to_array($finder);

        $lastMonthFiles = $this->filterOnLastMonth($files);

        $return = [];
        foreach ($lastMonthFiles as $day => $file) {
            /** @var Project $project */
            $project = $this->serializer->deserialize(
                $file->getContents(),
                Project::class,
                JsonEncoder::FORMAT
            );
            $dt = date_create_from_format('Ymd', $day);
            $services = $this->buildServiceFromArray($dt, $project->getServices()->toArray());
            $project->setServices($services);
            $return[] = $project->getServices();
        }

        return $return;
    }

    /**
     * @param array $files
     *
     * @return array
     */
    public function filterOnLastMonth(array $files = [])
    {
        $month = [];

        $lastMonth = (new \DateTime())->modify('-1 month');

        /** @var SplFileInfo $file */
        foreach ($files as $file) {

            list($timestamp, $extension) = explode('.', $file->getRelativePathname());

            $date = (new \DateTime())->setTimestamp($timestamp);
            if ($lastMonth->getTimestamp() < $date->getTimestamp()) {

                $month[$date->format('Ymd')] = $file;

            }
        }

        return $month;
    }

    /**
     * @param array $services
     *
     * @return array
     */
    private function buildServiceFromArray(\DateTime $createdAt, array $services): array
    {
        $return = [];
        foreach ($services as $service) {
            $return[] = (new Service())
                ->setCreatedAt($createdAt)
                ->setName($service['name'])
                ->setPhpunitClover(
                    (new PhpunitClover())
                        ->setFiles($service['phpunitClover']['files'])
                        ->setLoc($service['phpunitClover']['loc'])
                        ->setNcloc($service['phpunitClover']['ncloc'])
                        ->setClasses($service['phpunitClover']['classes'])
                        ->setMethods($service['phpunitClover']['methods'])
                        ->setCoveredmethods($service['phpunitClover']['coveredmethods'])
                        ->setConditionals($service['phpunitClover']['conditionals'])
                        ->setCoveredconditionals($service['phpunitClover']['coveredconditionals'])
                        ->setStatements($service['phpunitClover']['statements'])
                        ->setCoveredstatements($service['phpunitClover']['coveredstatements'])
                        ->setElements($service['phpunitClover']['elements'])
                        ->setCoveredelements($service['phpunitClover']['coveredelements'])
                );
        }

        return $return;
    }

    /**
     * @param Project $project
     */
    public function statify(Project $project)
    {
        $content = $this->serializer->serialize($project, JsonEncoder::FORMAT);
        $this->filesystem->dumpFile($this->historyPath . '/' . time() . '.json', $content);
    }
}
