<?php

namespace Lch\TranslateBundle\Twig;

use Lch\TranslateBundle\Utils\LangSwitchHelper;
use Twig\Extension\RuntimeExtensionInterface;

/**
 * Class LchTranslateBundleRuntime
 * @package Lch\TranslateBundle\Twig
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

    /**
     * @param string $route
     * @param array $parameters
     *
     * @return string
     */
    public function getTranslatedPath(string $route, array $parameters): string
    {
        return $this->langSwitchHelper->getTranslatedPath($route, $parameters);
    }
}
