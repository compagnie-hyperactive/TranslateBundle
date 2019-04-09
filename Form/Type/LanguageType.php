<?php

namespace Lch\TranslateBundle\Form\Type;

use Lch\TranslateBundle\Utils\TranslationsHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class LanguageType
 * @package Lch\TranslateBundle\Form\Type
 */
class LanguageType extends AbstractType
{
    /** @var TranslationsHelper $translationsHelper */
    protected $translationsHelper;

    /**
     * LanguageType constructor.
     * @param TranslationsHelper $translationsHelper
     */
    public function __construct(TranslationsHelper $translationsHelper)
    {
        $this->translationsHelper = $translationsHelper;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => $this->translationsHelper->getAvailableLanguages()
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}