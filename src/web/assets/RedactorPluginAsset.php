<?php

namespace carlcs\footnote\web\assets;

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

        $this->js[] = 'footnote.js';
        $this->css[] = 'footnote.css';

        parent::init();
    }
}
