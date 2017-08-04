<?php

namespace AppBundle\Serializer\Denormalizer\Gitlab;

use AppBundle\Entity\Gitlab\Build;
use AppBundle\Entity\Gitlab\Commit;
use AppBundle\Entity\Gitlab\Runner;
use AppBundle\Entity\Gitlab\User;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class BuildDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        $user = (new User())
            ->setId((int)$data['user']['id'])
            ->setName($data['user']['name'])
            ->setUsername($data['user']['username'])
            ->setState($data['user']['state'])
            ->setAvatarUrl($data['user']['avatar_url'])
            ->setWebUrl($data['user']['web_url'])
            ->setCreatedAt(new \DateTime($data['user']['created_at']))
            ->setIsAdmin($data['user']['is_admin'])
            ->setBio($data['user']['bio'])
            ->setLocation($data['user']['location'])
            ->setSkype($data['user']['skype'])
            ->setLinkedin($data['user']['linkedin'])
            ->setTwitter($data['user']['twitter'])
            ->setWebsiteUrl($data['user']['website_url']);

        $commit = (new Commit())
            ->setId((int)$data['commit']['id'])
            ->setShortId($data['commit']['short_id'])
            ->setTitle($data['commit']['title'])
            ->setAuthorName($data['commit']['author_name'])
            ->setAuthorEmail($data['commit']['author_email'])
            ->setCreatedAt(new \DateTime($data['commit']['created_at']))
            ->setMessage($data['commit']['message']);

        $runner = (new Runner())
            ->setId((int)$data['runner']['id'])
            ->setDescription($data['runner']['description'])
            ->setActive($data['runner']['active'])
            ->setIsShared($data['runner']['is_shared'])
            ->setName($data['runner']['name']);

        return (new Build())
            ->setId((int)$data['id'])
            ->setStatus($data['status'])
            ->setStage($data['stage'])
            ->setName($data['name'])
            ->setRef($data['ref'])
            ->setTag($data['tag'])
            ->setCoverage($data['coverage'])
            ->setCreatedAt(new \DateTime($data['created_at']))
            ->setStartedAt(new \DateTime($data['started_at']))
            ->setFinishedAt(new \DateTime($data['finished_at']))
            ->setUser($user)
            ->setCommit($commit)
            ->setRunner($runner);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null, array $context = [])
    {
        return $type === Build::class && JsonEncoder::FORMAT === $format;
    }

}
