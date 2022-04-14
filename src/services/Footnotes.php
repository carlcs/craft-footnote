<?php

namespace carlcs\footnote\services;

use carlcs\footnote\Plugin;
use Craft;
use craft\base\Component;
use craft\helpers\StringHelper;
use craft\web\View;
use yii\base\InvalidArgumentException;

class Footnotes extends Component
{
    // Properties
    // =========================================================================

    private ?array $_footnotes = null;

    // Public Methods
    // =========================================================================

    /**
     * Stores an array of footnote definitions.
     */
    public function setDefinitions(array $definitions, string $articleId = '')
    {
        $setDefinitionsKeyPrefix = Plugin::getInstance()->getSettings()->setDefinitionsKeyPrefix;

        foreach ($definitions as $name => $text) {
            $name = StringHelper::removeLeft($name, $setDefinitionsKeyPrefix);

            $this->_footnotes[$articleId][$name] = [
                'articleId' => $articleId,
                'noteText' => $text,
                'noteId' => null,
                'markerCount' => null,
            ];
        }
    }

    /**
     * Parses a string for footnote definitions, stores names and texts.
     */
    public function parseDefinitions(string $str, string $articleId = '', ?string $definitionSyntax = null): string
    {
        $settings = Plugin::getInstance()->getSettings();
        $definitionSyntax = $definitionSyntax ?: $settings->definitionSyntax;

        if (($pattern = $settings->definitionSyntaxes[$definitionSyntax] ?? false) === false) {
            throw new InvalidArgumentException('Unsupported definition syntax: '.$definitionSyntax);
        }

        $callback = function($matches) use ($articleId) {
            $this->_footnotes[$articleId][$matches['name']] = [
                'articleId' => $articleId,
                'noteText' => trim($matches['text']),
                'noteId' => null,
                'markerCount' => null,
            ];
        };

        return preg_replace_callback($pattern, $callback, $str);
    }

    /**
     * Parses a string for footnotes markers and replaces them with links to the
     * corresponding footnote if one is found, otherwise removes the marker.
     */
    public function parseMarkers(string $str, string $template = null, string $articleId = '', ?string $markerSyntax = null): string
    {
        $settings = Plugin::getInstance()->getSettings();
        $markerSyntax = $markerSyntax ?: $settings->markerSyntax;

        if (($pattern = $settings->markerSyntaxes[$markerSyntax] ?? false) === false) {
            throw new InvalidArgumentException('Unsupported definition syntax: '.$markerSyntax);
        }

        static $fnCount = [];

        $callback = function($matches) use ($settings, $articleId, $template, &$fnCount) {

            // Prepare the marker names
            if ($settings->allowMarkersArray === true) {
                $names = explode(',', $matches['name']);
                $names = array_map('trim', $names);
            } else {
                $names = [$matches['name']];
            }

            $html = '';

            foreach ($names as $position => $name) {
                // Check if a matching footnote definition exists for this marker.
                $noDefinitionMatch = !isset($this->_footnotes[$articleId][$name]);

                // Check if this could be an inline footnote
                $validInlineFootnote = $settings->inlineFootnoteMinLength !== null &&
                    strlen($name) >= $settings->inlineFootnoteMinLength;

                if ($noDefinitionMatch && !$validInlineFootnote) {
                    if ($settings->removeUnmatchedMarkers === true) {
                        return '';
                    }

                    return $matches[0];
                }

                // Initialize a counter for each article.
                if (!isset($fnCount[$articleId])) {
                    $fnCount[$articleId] = 0;
                }

                // If it’s an inline footnote we need to store it now
                if ($noDefinitionMatch) {
                    $noteText = $name;
                    $name = md5($name);

                    if (!isset($this->_footnotes[$articleId][$name])) {
                        $this->_footnotes[$articleId][$name] = [
                            'articleId' => $articleId,
                            'noteText' => trim($noteText),
                            'noteId' => null,
                            'markerCount' => null,
                        ];
                    }
                }

                $fn = &$this->_footnotes[$articleId][$name];

                // Is this the first marker for this footnote?
                if (!isset($fn['noteId'])) {
                    $fn['noteId'] = ++$fnCount[$articleId];
                    $fn['markerCount'] = 0;
                } else {
                    $fn['markerCount'] ++;
                }

                $variables = [
                    'articleId' => $fn['articleId'],
                    'noteId' => $fn['noteId'],
                    'markerId' => $fn['markerCount'],
                    'markerPosition' => $position,
                ];

                $html .= $this->renderMarkerTemplate($template, $variables);
            }

            return $html;
        };

        return preg_replace_callback($pattern, $callback, $str);
    }

    /**
     * Returns an array of footnotes which were matched to markers.
     */
    public function getFootnotes(string $articleId = '', bool $includeUnmatched = false): array
    {
        // No footnote definitions stored at all?
        if (($footnotes = $this->_footnotes[$articleId] ?? false) === false) {
            return [];
        }

        uasort($footnotes, function($fnA, $fnB) {
            return $fnA['noteId'] - $fnB['noteId'];
        });

        if ($includeUnmatched !== true) {
            $footnotes = array_filter($footnotes, function($fn) {
                return isset($fn['noteId']);
            });
        }

        // No markers matched with footnote definitions?
        if (empty($footnotes)) {
            return [];
        }

        return $footnotes;
    }

    /**
     * Returns the HTML for footnotes which were matched to markers.
     */
    public function getFootnotesHtml(string $template = null, string $articleId = ''): string
    {
        $footnotes = $this->getFootnotes($articleId);

        if (!$footnotes) {
            return '';
        }

        $variables = [
            'footnotes' => $footnotes,
        ];

        return $this->renderListTemplate($template, $variables);
    }

    // Protected Methods
    // =========================================================================

    protected function renderMarkerTemplate($customTemplate, $variables): string
    {
        return $this->_handleTemplateRender('marker', $customTemplate, $variables);
    }

    protected function renderListTemplate($customTemplate, $variables): string
    {
        return $this->_handleTemplateRender('list', $customTemplate, $variables);
    }

    // Private Methods
    // =========================================================================

    /**
     * Renders footnotes list and marker templates.
     */
    private function _handleTemplateRender(string $context, ?string $customTemplate, array $variables): string
    {
        $view = Craft::$app->getView();

        // Custom template
        if ($customTemplate) {
            return $view->renderTemplate($customTemplate, $variables);
        }

        // User defined default template
        $setting = $context.'Template';
        $defaultTemplate = Plugin::getInstance()->getSettings()->{$setting};

        if ($defaultTemplate !== null) {
            return $view->renderTemplate($defaultTemplate, $variables);
        }

        return $view->renderTemplate('footnote/footnote/'.$context, $variables, View::TEMPLATE_MODE_CP);
    }
}
