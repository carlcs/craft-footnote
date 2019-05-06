<?php

namespace carlcs\footnotes\web\assets;

use craft\redactor\assets\redactor\RedactorAsset;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class RedactorPluginAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = __DIR__.'/dist';

        $this->depends = [
            CpAsset::class,
            RedactorAsset::class,
        ];

        $this->js[] = 'footnotes.js';
        $this->css[] = 'footnotes.css';

        parent::init();
    }
}
