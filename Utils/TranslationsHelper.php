<?php

namespace LchTranslateBundle\Utils;

use LchTranslateBundle\Model\Behavior\Translatable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * Class TranslationsHelper
 * @package LchTranslateBundle\Utils
 */
class TranslationsHelper
{
    /** @var ParameterBagInterface $params */
    protected $params;

    /** @var EntityManagerInterface $em */
    protected $em;

    /** @var array $availableLanguages */
    protected $availableLanguages;

    /**
     * TranslationsHelper constructor.
     * @param ParameterBagInterface $params
     * @param EntityManagerInterface $em
     */
    public function __construct(ParameterBagInterface $params,
                                EntityManagerInterface $em
    ) {
        $this->params = $params;
        $this->em = $em;
    }

    /**
     * Available languages as defined in application parameters.
     *
     * @return array
     */
    public function getAvailableLanguages(): array
    {
        if (!$this->availableLanguages) {
            $this->availableLanguages = $this->params->get('available_languages');
        }

        return $this->availableLanguages;
    }

    /**
     * Checks if given object or class uses Translatable trait.
     *
     * @param object|string object
     *
     * @return bool
     *
     * @throws UnexpectedValueException
     */
    public function isEntityTranslatable($object): bool
    {
        $class = is_object($object) ? get_class($object) : $object;

        if (!is_string($class)) {
            throw new UnexpectedValueException($class, 'string');
        }

        return in_array(
            Translatable::class,
            class_uses($class),
            true
        );
    }
}
