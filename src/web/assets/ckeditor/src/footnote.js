import { Plugin } from "ckeditor5/src/core.js";
import FootnoteEditing from "./footnoteediting.js";
import FootnoteUI from "./footnoteui.js";

import "../theme/footnote.css";

export default class Footnote extends Plugin {
  static get pluginName() {
    return "Footnote";
  }

  static get requires() {
    return [FootnoteEditing, FootnoteUI];
  }
}
