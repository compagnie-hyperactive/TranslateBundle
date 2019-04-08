<?php

namespace LchTranslateBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class LchTranslateBundleExtension
 * @package LchTranslateBundle\Twig
 */
class LchTranslateBundleExtension extends AbstractExtension
{
    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('available_i18n_paths', [LchTranslateBundleRuntime::class, 'getAvailableI18nPaths'])
        ];
    }
}
