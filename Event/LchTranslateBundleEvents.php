<?php

namespace LchTranslateBundle\Event;

/**
 * Class LchTranslateBundleEvents
 * @package LchTranslateBundle\Event
 */
class LchTranslateBundleEvents
{
    public const QUERYING_TRANSLATED_PARENT = QueryingTranslatedParentEvent::NAME;
    public const GUESSING_TRANSLATED_PARENT_LABEL = GuessingTranslatedParentLabelEvent::NAME;
}
