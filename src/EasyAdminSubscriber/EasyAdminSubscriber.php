<?php

namespace App\EasyAdminSubscriber;

use App\Entity\Category;
use App\Entity\TvShow;
use DateTimeImmutable;
use Symfony\Component\String\Slugger\SluggerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    // public function __construct(private SluggerInterface $slugger)
    // {
        
    // }

    public function getSubscribedEvents()
    {
        // return [
        //     BeforeEntityPersistedEvent::class => ['setTvShowSlug']
        // ];
    }

    public function setTvShowSlug(BeforeEntityPersistedEvent $event) 
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof TvShow)) {
            return;
        }

        // $slug = $this->slugger->slug($entity->getTitle());
        // $entity->setSlug($slug);

        // $now = new DateTimeImmutable('now');
        // $entity->setCreatedAt($now);
        // $entity->setUpdatedAt($now);
    }
}