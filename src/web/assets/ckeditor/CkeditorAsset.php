<?php

namespace carlcs\footnote\web\assets\ckeditor;

use craft\ckeditor\web\assets\BaseCkeditorPackageAsset;

class CkeditorAsset extends BaseCkeditorPackageAsset
{
    public $sourcePath = __DIR__ . '/build';

    public $js = [
        'footnote.js',
    ];

    public array $pluginNames = [
        'Footnote',
    ];

    public array $toolbarItems = [
        'footnote',
    ];
}
