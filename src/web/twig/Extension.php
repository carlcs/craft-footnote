<?php

namespace carlcs\footnotes\web\twig;

use carlcs\footnotes\Plugin;

class Extension extends \Twig_Extension
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'Footnotes';
    }

    /**
     * @inheritdoc
     */
    public function getFunctions(): array
    {
        return [
            new \Twig_SimpleFunction('setFootnoteDefinitions', [Plugin::getInstance()->getFootnotes(), 'setDefinitions']),
            new \Twig_SimpleFunction('parseFootnoteDefinitions', [Plugin::getInstance()->getFootnotes(), 'parseDefinitions']),
            new \Twig_SimpleFunction('parseFootnoteMarkers', [Plugin::getInstance()->getFootnotes(), 'parseMarkers'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('getFootnotes', [Plugin::getInstance()->getFootnotes(), 'getFootnotes']),
            new \Twig_SimpleFunction('getFootnotesHtml', [Plugin::getInstance()->getFootnotes(), 'getFootnotesHtml'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getFilters(): array
    {
        return [
            new \Twig_SimpleFilter('parseFootnoteMarkers', [Plugin::getInstance()->getFootnotes(), 'parseMarkers'], ['is_safe' => ['html']]),
        ];
    }
}
