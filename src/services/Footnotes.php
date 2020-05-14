<?php

namespace carlcs\footnote\services;

use carlcs\footnote\Plugin;
use Craft;
use craft\base\Component;
use craft\helpers\StringHelper;
use yii\base\InvalidArgumentException;

class Footnotes extends Component
{
    // Properties
    // =========================================================================

    /**
     * @var array|null
     */
    private $_footnotes;

    // Public Methods
    // =========================================================================

    /**
     * Stores an array of footnote definitions.
     *
     * @param array $definitions An array of footnote definition name-text pairs
     * @param string $articleId The ID to identify the article the footnotes belong to
     */
    public function setDefinitions($definitions, $articleId = '')
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
     *
     * @param string $str The string to be parsed
     * @param string $articleId The ID to identify the article the footnotes belong to
     * @param string|null $definitionSyntax Sets the syntax the parser is expecting
     * @return string
     */
    public function parseDefinitions($str, $articleId = '', $definitionSyntax = null): string
    {
        $settings = Plugin::getInstance()->getSettings();
        $definitionSyntax = $definitionSyntax ?: $settings->definitionSyntax;

        if (($pattern = $settings->definitionSyntaxes[$definitionSyntax] ?? false) === false) {
            throw new InvalidArgumentException('Unsupported definition syntax: '.$definitionSyntax);
        }

        $callback = function ($matches) use ($articleId) {
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
     *
     * @param string $str The string to be parsed for markers
     * @param string|null $template The path to the template to render for a matched marker
     * @param string $articleId Identifies the article the footnotes belong to
     * @param string|null $markerSyntax Sets the syntax the parser is expecting
     * @return string
     */
    public function parseMarkers($str, $template = null, $articleId = '', $markerSyntax = null): string
    {
        $settings = Plugin::getInstance()->getSettings();
        $markerSyntax = $markerSyntax ?: $settings->markerSyntax;

        if (($pattern = $settings->markerSyntaxes[$markerSyntax] ?? false) === false) {
            throw new InvalidArgumentException('Unsupported definition syntax: '.$markerSyntax);
        }

        static $fnCount = [];

        $callback = function ($matches) use ($settings, $articleId, $template, &$fnCount) {

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
     *
     * @param string $articleId The ID to identify the article the footnotes belong to
     * @param bool $raw
     * @return array
     */
    public function getFootnotes($articleId = '', $raw = false): array
    {
        // No footnote definitions stored at all?
        if (($footnotes = $this->_footnotes[$articleId] ?? false) === false) {
            return [];
        }

        if ($raw === true) {
            return $footnotes;
        }

        uasort($footnotes, function ($fnA, $fnB) {
            return $fnA['noteId'] - $fnB['noteId'];
        });

        $footnotes = array_filter($footnotes, function ($fn) {
            return isset($fn['noteId']);
        });

        // No markers matched with footnote definitions?
        if (empty($footnotes)) {
            return [];
        }

        return $footnotes;
    }

    /**
     * Returns the HTML for footnotes which were matched to markers.
     *
     * @param string $articleId The ID to identify the article the footnotes belong to
     * @param string|null $template The path to the template
     * @return string
     */
    public function getFootnotesHtml($template = null, $articleId = ''): string
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
     *
     * @param string $context Is this a footnotes list or a marker?
     * @param string|null $customTemplate The path to the template
     * @param array $variables The variables passed to the template
     * @return string
     */
    private function _handleTemplateRender($context, $customTemplate, $variables): string
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

        // Plugin's default template
        $oldTemplateMode = $view->getTemplateMode();

        $view->setTemplateMode($view::TEMPLATE_MODE_CP);
        $html = $view->renderTemplate('footnote/footnote/'.$context, $variables);

        $view->setTemplateMode($oldTemplateMode);

        return $html;
    }
}
