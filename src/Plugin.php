<?php

namespace carlcs\footnotes;

use carlcs\footnotes\models\Settings;
use carlcs\footnotes\web\twig\Extension;
use carlcs\footnotes\web\assets\RedactorPluginAsset;
use Craft;
use craft\helpers\Json;
use craft\redactor\events\RegisterPluginPathsEvent;
use craft\redactor\Field as RedactorField;
use yii\base\Event;

/**
 * @property Footnotes $footnotes
 * @property Settings $settings
 * @method Settings getSettings()
 * @method static Plugin getInstance()
 */
class Plugin extends \craft\base\Plugin
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->set('footnotes', Footnotes::class);

        $request = Craft::$app->getRequest();

        if ($request->getIsSiteRequest() || $request->getIsCpRequest()) {
            Craft::$app->getView()->registerTwigExtension(new Extension());
        }

        if ($request->getIsCpRequest()) {
            Event::on(RedactorField::class, RedactorField::EVENT_REGISTER_PLUGIN_PATHS, [$this, 'registerRedactorPlugin']);
        }
    }

    /**
     * Registers the Redactor plugin and its assets.
     *
     * @param RegisterPluginPathsEvent $event
     */
    public function registerRedactorPlugin(RegisterPluginPathsEvent $event)
    {
        $event->paths[] = Craft::getAlias('@carlcs/footnotes/web/assets/_redactorplugin');

        $view = Craft::$app->getView();
        $view->registerAssetBundle(RedactorPluginAsset::class);

        $icon = file_get_contents(Craft::getAlias('@carlcs/footnotes/icon-mask.svg'));
        $view->registerJs('Craft.Footnotes = '.Json::encode(compact('icon')).';');
    }

    /**
     * Returns the footnotes service.
     *
     * @return Footnotes
     */
    public function getFootnotes(): Footnotes
    {
        return $this->get('footnotes');
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel(): Settings
    {
        return new Settings();
    }
}
