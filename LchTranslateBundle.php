<?php

namespace LchTranslateBundle;

use LchTranslateBundle\DependencyInjection\LchTranslateExtension;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class LchTranslateBundle
 * @package LchTranslateBundle
 */
class LchTranslateBundle extends Bundle
{
    /**
     * @inheritdoc
     */
    public function getContainerExtension(): Extension
    {
        if (!$this->extension) {
            $this->extension = new LchTranslateExtension();
        }

        return $this->extension;
    }
}