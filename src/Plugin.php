<?php

namespace carlcs\footnote;

use carlcs\footnote\models\Settings;
use carlcs\footnote\services\Footnotes;
use carlcs\footnote\web\assets\ckeditor\CkeditorAsset;
use carlcs\footnote\web\twig\Extension;
use Craft;
use craft\base\Model;
use craft\ckeditor\Plugin as CkeditorPlugin;
use craft\redactor\events\RegisterPluginPathsEvent;
use craft\redactor\Field as RedactorField;
use craft\redactor\Plugin as RedactorPlugin;
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

    public function init()
    {
        parent::init();

        $this->set('footnotes', Footnotes::class);

        $view = Craft::$app->getView();
        $view->registerTwigExtension(new Extension());

        if (Craft::$app->getRequest()->getIsCpRequest()) {
            $view->registerTranslations('footnote', ['Footnote']);

            if (class_exists(RedactorPlugin::class)) {
                $this->_registerRedactorPackage();
            }

            if (class_exists(CkeditorPlugin::class)) {
                CkeditorPlugin::registerCkeditorPackage(CkeditorAsset::class);
            }
        }
    }

    public function getFootnotes(): Footnotes
    {
        return $this->get('footnotes');
    }

    // Protected Methods
    // =========================================================================

    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }

    // Private Methods
    // =========================================================================

    private function _registerRedactorPackage()
    {
        Event::on(RedactorField::class, RedactorField::EVENT_REGISTER_PLUGIN_PATHS, function (RegisterPluginPathsEvent $event) {
            $event->paths[] = Craft::getAlias('@carlcs/footnote/web/redactor-plugins');
        });

        $icon = file_get_contents(Craft::getAlias('@carlcs/footnote/icon-mask.svg'));
        Craft::$app->getView()->registerJsWithVars(fn ($variables) => "Craft.Footnote = $variables", [compact('icon')]);
    }
}
