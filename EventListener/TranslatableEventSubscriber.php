<?php

namespace Lch\TranslateBundle\EventListener;

use Lch\TranslateBundle\Utils\TranslationsHelper;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;

/**
 * Todo: Validation LifeCycleCallback
 *
 * Class TranslatableEventSubscriber
 * @package Lch\TranslateBundle\EventListener
 */
class TranslatableEventSubscriber implements EventSubscriber
{
    /** @var TranslationsHelper $translationsHelper */
    protected $translationsHelper;

    /**
     * TranslatableEntityEventSubscriber constructor.
     * @param TranslationsHelper $translationsHelper
     */
    public function __construct(TranslationsHelper $translationsHelper)
    {
        $this->translationsHelper = $translationsHelper;
    }

    /**
     * @inheritdoc
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::loadClassMetadata
        ];
    }

    /**
     * @param LoadClassMetadataEventArgs $args
     *
     * @return void
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $args): void
    {
        $metadata = $args->getClassMetadata();
        $class = $metadata->getName();
        if (!$this->translationsHelper->isEntityTranslatable($class)) {
            return;
        }

        $metadata->mapManyToOne([
            'fieldName'    => 'translatedParent',
            'targetEntity' => $class,
            'inversedBy'   => 'translatedChildren'
        ]);

        $metadata->mapOneToMany([
            'fieldName'    => 'translatedChildren',
            'targetEntity' => $class,
            'mappedBy'     => 'translatedParent'
        ]);
    }
}
