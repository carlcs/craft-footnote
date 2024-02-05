import { Plugin } from "ckeditor5/src/core.js";
import { ButtonView } from "ckeditor5/src/ui.js";

import footnoteIcon from "../theme/footnote.svg";

export default class FootnoteUI extends Plugin {
  static get pluginName() {
    return "FootnoteUI";
  }

  init() {
    const editor = this.editor;

    editor.ui.componentFactory.add("footnote", (locale) => {
      const command = editor.commands.get("footnote");
      const view = new ButtonView(locale);

      view.set({
        label: Craft.t("footnote", "Footnote"),
        icon: footnoteIcon,
        tooltip: true,
        isToggleable: true,
      });

      view.bind("isOn", "isEnabled").to(command, "value", "isEnabled");

      this.listenTo(view, "execute", () => {
        editor.execute("footnote");
        editor.editing.view.focus();
      });

      return view;
    });
  }
}
