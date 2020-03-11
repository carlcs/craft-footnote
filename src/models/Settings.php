<?php

namespace carlcs\footnote\models;

use craft\base\Model;

class Settings extends Model
{
    // Properties
    // =========================================================================

    /**
     * @var string
     */
    public $definitionSyntax = 'redactor';

    /**
     * @var string
     */
    public $markerSyntax = 'redactor';

    /**
     * @var array
     */
    public $definitionSyntaxes = [
        // Redactor syntax: `<p>1. My footnote definition</p>`
        'redactor' => '/<p>\s*(?P<name>\S+?)[ ]?\.[ ]*\n?(?P<text>[\s\S]+?)<\/p>/',

        // Plain text syntax: `1. My footnote definition`
        'plaintext' => '/^[ ]{0,3}(?P<name>\S+?)[ ]?\.[ ]*\n?(?P<text>(.+|\n(?!\S+?[ ]?\.\s)(?!\n+[ ]{0,3}\S))*)/xm',

        // Markdown syntax: `[^1]: My footnote definition`
        'markdown' => '/^[ ]{0,3}\[\^(?P<name>.+?)\][ ]?:[ ]*\n?(?P<text>(?:.+|\n(?!\[.+?\][ ]?:\s)(?!\n+[ ]{0,3}\S))*)/xm',
    ];

    /**
     * @var array
     */
    public $markerSyntaxes = [
        // Redactor syntax: `<span class="fn-marker">1</span>`
        'redactor' => '/(<span class=\"fn-marker\">(?P<name>.+?)<\/span>)/',

        // Markdown syntax: `[^1]`
        'markdown' => '/(\[\^(?P<name>\S+?)\])/',
    ];

    /**
     * @var array|null
     */
    public $extraDefinitionSyntaxes;

    /**
     * @var array|null
     */
    public $extraMarkerSyntaxes;

    /**
     * @var string
     */
    public $setDefinitionsKeyPrefix = 'ಠvಠ';

    /**
     * @var bool
     */
    public $allowMarkersArray = true;

    /**
     * @var bool
     */
    public $removeUnmatchedMarkers = true;

    /**
     * @var string|null
     */
    public $markerTemplate;

    /**
     * @var string|null
     */
    public $listTemplate;

    /**
     * @var int|null
     */
    public $inlineFootnoteMinLength;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (is_array($this->extraDefinitionSyntaxes)) {
            $this->definitionSyntaxes = array_merge($this->definitionSyntaxes, $this->extraDefinitionSyntaxes);
            $this->extraDefinitionSyntaxes = null;
        }

        if (is_array($this->extraMarkerSyntaxes)) {
            $this->markerSyntaxes = array_merge($this->markerSyntaxes, $this->extraMarkerSyntaxes);
            $this->extraMarkerSyntaxes = null;
        }
    }
}
