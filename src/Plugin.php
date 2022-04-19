<?php

namespace carlcs\footnote;

use carlcs\footnote\models\Settings;
use carlcs\footnote\services\Footnotes;
use carlcs\footnote\web\twig\Extension;
use Craft;
use craft\base\Model;
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

    public function init()
    {
        parent::init();

        $this->set('footnotes', Footnotes::class);

        Craft::$app->getView()->registerTwigExtension(new Extension());

        if (Craft::$app->getRequest()->getIsCpRequest()) {
            Event::on(RedactorField::class, RedactorField::EVENT_REGISTER_PLUGIN_PATHS, function(RegisterPluginPathsEvent $event) {
                $event->paths[] = Craft::getAlias('@carlcs/footnote/web/redactor-plugins');
            });

            $view = Craft::$app->getView();

            $icon = file_get_contents(Craft::getAlias('@carlcs/footnote/icon-mask.svg'));
            $view->registerJsWithVars(fn($variables) => "Craft.Footnote = $variables", [compact('icon')]);
            $view->registerTranslations('footnote', ['Footnote']);
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
}
