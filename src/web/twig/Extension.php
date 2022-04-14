<?php

namespace carlcs\footnote\web\twig;

use carlcs\footnote\Plugin;
use Twig\TwigFilter;
use Twig\TwigFunction;

class Extension extends \Twig\Extension\AbstractExtension
{
    public function getName(): string
    {
        return 'Footnote';
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('setFootnoteDefinitions', [Plugin::getInstance()->getFootnotes(), 'setDefinitions']),
            new TwigFunction('parseFootnoteDefinitions', [Plugin::getInstance()->getFootnotes(), 'parseDefinitions']),
            new TwigFunction('parseFootnoteMarkers', [Plugin::getInstance()->getFootnotes(), 'parseMarkers'], ['is_safe' => ['html']]),
            new TwigFunction('getFootnotes', [Plugin::getInstance()->getFootnotes(), 'getFootnotes']),
            new TwigFunction('getFootnotesHtml', [Plugin::getInstance()->getFootnotes(), 'getFootnotesHtml'], ['is_safe' => ['html']]),
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('parseFootnoteMarkers', [Plugin::getInstance()->getFootnotes(), 'parseMarkers'], ['is_safe' => ['html']]),
        ];
    }
}
