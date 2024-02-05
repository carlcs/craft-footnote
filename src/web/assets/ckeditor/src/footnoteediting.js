import AttributeCommand from "@ckeditor/ckeditor5-basic-styles/src/attributecommand.js";
import { Plugin } from "ckeditor5/src/core.js";
import { TwoStepCaretMovement, inlineHighlight } from "ckeditor5/src/typing.js";

export default class FootnoteEditing extends Plugin {
  static get pluginName() {
    return "FootnoteEditing";
  }

  static get requires() {
    return [TwoStepCaretMovement];
  }

  init() {
    const editor = this.editor;

    editor.model.schema.extend("$text", { allowAttributes: "footnote" });

    editor.conversion.attributeToElement({
      model: "footnote",
      view: {
        name: "span",
        classes: "fn-marker",
      },
    });

    editor.commands.add("footnote", new AttributeCommand(editor, "footnote"));

    editor.plugins.get(TwoStepCaretMovement).registerAttribute("footnote");
    inlineHighlight(editor, "footnote", "span", "fn-marker_selected");
  }
}
