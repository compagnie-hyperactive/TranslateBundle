<?php


namespace Lch\TranslateBundle\Event;


use Symfony\Component\EventDispatcher\Event;

class AfterFindingEntityTranslationsEvent extends Event
{
    /** @var object $originalEntity */
    protected $originalEntity;

    /** @var array $translationsFound */
    protected $translationsFound;


    /**
     * AfterFindingEntityTranslationsEvent constructor.
     *
     * @param object $originalEntity
     * @param array $translationsFound
     */
    public function __construct(object $originalEntity, array $translationsFound)
    {
        $this->originalEntity    = $originalEntity;
        $this->translationsFound = $translationsFound;
    }

    /**
     * @return object
     */
    public function getOriginalEntity(): object
    {
        return $this->originalEntity;
    }

    /**
     * @return array
     */
    public function getTranslationsFound(): array
    {
        return $this->translationsFound;
    }

    /**
     * @param array $translationsFound
     *
     * @return AfterFindingEntityTranslationsEvent
     */
    public function setTranslationsFound(array $translationsFound): AfterFindingEntityTranslationsEvent
    {
        $this->translationsFound = $translationsFound;

        return $this;
    }
}