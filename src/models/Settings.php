<?php

namespace carlcs\footnote\models;

use craft\base\Model;

class Settings extends Model
{
    // Properties
    // =========================================================================

    public string $definitionSyntax = 'redactor';
    public string $markerSyntax = 'redactor';
    public array $definitionSyntaxes = [
        // Redactor syntax: `<p>1. My footnote definition</p>`
        'redactor' => '/<p>\s*(?P<name>\S+?)[ ]?\.[ ]*\n?(?P<text>[\s\S]+?)<\/p>/',

        // Plain text syntax: `1. My footnote definition`
        'plaintext' => '/^[ ]{0,3}(?P<name>\S+?)[ ]?\.[ ]*\n?(?P<text>(.+|\n(?!\S+?[ ]?\.\s)(?!\n+[ ]{0,3}\S))*)/xm',

        // Markdown syntax: `[^1]: My footnote definition`
        'markdown' => '/^[ ]{0,3}\[\^(?P<name>.+?)\][ ]?:[ ]*\n?(?P<text>(?:.+|\n(?!\[.+?\][ ]?:\s)(?!\n+[ ]{0,3}\S))*)/xm',
    ];
    public array $markerSyntaxes = [
        // Redactor syntax: `<span class="fn-marker">1</span>`
        'redactor' => '/(<span class=\"fn-marker\">(?P<name>.+?)<\/span>)/',

        // Markdown syntax: `[^1]`
        'markdown' => '/(\[\^(?P<name>\S+?)\])/',
    ];
    public ?array $extraDefinitionSyntaxes = null;
    public ?array $extraMarkerSyntaxes = null;
    public string $setDefinitionsKeyPrefix = 'ಠvಠ';
    public bool $allowMarkersArray = true;
    public bool $removeUnmatchedMarkers = true;
    public ?string $markerTemplate = null;
    public ?string $listTemplate = null;
    public ?int $inlineFootnoteMinLength = null;

    // Public Methods
    // =========================================================================

    public function init(): void
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
