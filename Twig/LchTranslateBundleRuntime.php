<?php

namespace LchTranslateBundle\Twig;

use LchTranslateBundle\Utils\LangSwitchHelper;
use Twig\Extension\RuntimeExtensionInterface;

/**
 * Class LchTranslateBundleRuntime
 * @package LchTranslateBundle\Twig
 */
class LchTranslateBundleRuntime implements RuntimeExtensionInterface
{
    /** @var LangSwitchHelper $langSwitchHelper */
    protected $langSwitchHelper;

    /**
     * LchTranslateBundleRuntime constructor.
     * @param LangSwitchHelper $langSwitchHelper
     */
    public function __construct(LangSwitchHelper $langSwitchHelper)
    {
        $this->langSwitchHelper = $langSwitchHelper;
    }

    /**
     * @param object|null $translatableEntity
     *
     * @return array
     */
    public function getAvailableI18nPaths(object $translatableEntity = null): array
    {
        return $this->langSwitchHelper->getAvailableI18nPaths($translatableEntity);
    }
}