<?php

namespace carlcs\footnote;

use carlcs\footnote\models\Settings;
use carlcs\footnote\services\Footnotes;
use carlcs\footnote\web\twig\Extension;
use carlcs\footnote\web\assets\RedactorPluginAsset;
use Craft;
use craft\helpers\Json;
use craft\redactor\events\RegisterPluginPathsEvent;
use craft\redactor\Field as RedactorField;
use craft\web\View;
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

            $view = Craft::$app->getView();
            $view->registerAssetBundle(RedactorPluginAsset::class);

            $icon = file_get_contents(Craft::getAlias('@carlcs/footnote/icon-mask.svg'));
            $view->registerJs('Craft.Footnote = '.Json::encode(compact('icon')).';');
        }
    }

    /**
     * Registers the Redactor plugin and its assets.
     *
     * @param RegisterPluginPathsEvent $event
     */
    public function registerRedactorPlugin(RegisterPluginPathsEvent $event)
    {
        $event->paths[] = Craft::getAlias('@carlcs/footnote/web/assets/_redactorplugin');
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
