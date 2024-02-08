(()=>{var e={0:(e,t,n)=>{"use strict";n.d(t,{c:()=>i});var o=n(312),r=n.n(o)()((function(e){return e[1]}));r.push([e.id,".ck-content .fn-marker{background-color:var(--gray-100);border-radius:var(--medium-border-radius);display:inline-block;font-size:.8em;line-height:1;margin-inline:.2em;padding-block:.1em .2em;padding-inline:.4em;vertical-align:35%}.ck.ck-editor__editable .fn-marker_selected{outline:2px solid var(--dark-focus-color)}",""]);const i=r},312:e=>{"use strict";e.exports=function(e){var t=[];return t.toString=function(){return this.map((function(t){var n=e(t);return t[2]?"@media ".concat(t[2]," {").concat(n,"}"):n})).join("")},t.i=function(e,n,o){"string"==typeof e&&(e=[[null,e,""]]);var r={};if(o)for(var i=0;i<this.length;i++){var a=this[i][0];null!=a&&(r[a]=!0)}for(var s=0;s<e.length;s++){var c=[].concat(e[s]);o&&r[c[0]]||(n&&(c[2]?c[2]="".concat(n," and ").concat(c[2]):c[2]=n),t.push(c))}},t}},596:(e,t,n)=>{"use strict";var o,r=function(){return void 0===o&&(o=Boolean(window&&document&&document.all&&!window.atob)),o},i=function(){var e={};return function(t){if(void 0===e[t]){var n=document.querySelector(t);if(window.HTMLIFrameElement&&n instanceof window.HTMLIFrameElement)try{n=n.contentDocument.head}catch(e){n=null}e[t]=n}return e[t]}}(),a=[];function s(e){for(var t=-1,n=0;n<a.length;n++)if(a[n].identifier===e){t=n;break}return t}function c(e,t){for(var n={},o=[],r=0;r<e.length;r++){var i=e[r],c=t.base?i[0]+t.base:i[0],l=n[c]||0,u="".concat(c," ").concat(l);n[c]=l+1;var d=s(u),f={css:i[1],media:i[2],sourceMap:i[3]};-1!==d?(a[d].references++,a[d].updater(f)):a.push({identifier:u,updater:p(f,t),references:1}),o.push(u)}return o}function l(e){var t=document.createElement("style"),o=e.attributes||{};if(void 0===o.nonce){var r=n.nc;r&&(o.nonce=r)}if(Object.keys(o).forEach((function(e){t.setAttribute(e,o[e])})),"function"==typeof e.insert)e.insert(t);else{var a=i(e.insert||"head");if(!a)throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");a.appendChild(t)}return t}var u,d=(u=[],function(e,t){return u[e]=t,u.filter(Boolean).join("\n")});function f(e,t,n,o){var r=n?"":o.media?"@media ".concat(o.media," {").concat(o.css,"}"):o.css;if(e.styleSheet)e.styleSheet.cssText=d(t,r);else{var i=document.createTextNode(r),a=e.childNodes;a[t]&&e.removeChild(a[t]),a.length?e.insertBefore(i,a[t]):e.appendChild(i)}}function m(e,t,n){var o=n.css,r=n.media,i=n.sourceMap;if(r?e.setAttribute("media",r):e.removeAttribute("media"),i&&"undefined"!=typeof btoa&&(o+="\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(i))))," */")),e.styleSheet)e.styleSheet.cssText=o;else{for(;e.firstChild;)e.removeChild(e.firstChild);e.appendChild(document.createTextNode(o))}}var h=null,v=0;function p(e,t){var n,o,r;if(t.singleton){var i=v++;n=h||(h=l(t)),o=f.bind(null,n,i,!1),r=f.bind(null,n,i,!0)}else n=l(t),o=m.bind(null,n,t),r=function(){!function(e){if(null===e.parentNode)return!1;e.parentNode.removeChild(e)}(n)};return o(e),function(t){if(t){if(t.css===e.css&&t.media===e.media&&t.sourceMap===e.sourceMap)return;o(e=t)}else r()}}e.exports=function(e,t){(t=t||{}).singleton||"boolean"==typeof t.singleton||(t.singleton=r());var n=c(e=e||[],t);return function(e){if(e=e||[],"[object Array]"===Object.prototype.toString.call(e)){for(var o=0;o<n.length;o++){var r=s(n[o]);a[r].references--}for(var i=c(e,t),l=0;l<n.length;l++){var u=s(n[l]);0===a[u].references&&(a[u].updater(),a.splice(u,1))}n=i}}}},968:(e,t,n)=>{e.exports=n(672)("./src/core.js")},500:(e,t,n)=>{e.exports=n(672)("./src/typing.js")},348:(e,t,n)=>{e.exports=n(672)("./src/ui.js")},672:e=>{"use strict";e.exports=CKEditor5.dll}},t={};function n(o){var r=t[o];if(void 0!==r)return r.exports;var i=t[o]={id:o,exports:{}};return e[o](i,i.exports,n),i.exports}n.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e;return n.d(t,{a:t}),t},n.d=(e,t)=>{for(var o in t)n.o(t,o)&&!n.o(e,o)&&Object.defineProperty(e,o,{enumerable:!0,get:t[o]})},n.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),n.r=e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.nc=void 0;var o={};(()=>{"use strict";n.r(o),n.d(o,{Footnote:()=>f});var e=n(968);
/**
 * @license Copyright (c) 2003-2024, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */
class t extends e.Command{constructor(e,t){super(e),this.attributeKey=t}refresh(){const e=this.editor.model,t=e.document;this.value=this._getValueFromFirstAllowedNode(),this.isEnabled=e.schema.checkAttributeInSelection(t.selection,this.attributeKey)}execute(e={}){const t=this.editor.model,n=t.document.selection,o=void 0===e.forceValue?!this.value:e.forceValue;t.change((e=>{if(n.isCollapsed)o?e.setSelectionAttribute(this.attributeKey,!0):e.removeSelectionAttribute(this.attributeKey);else{const r=t.schema.getValidRanges(n.getRanges(),this.attributeKey);for(const t of r)o?e.setAttribute(this.attributeKey,o,t):e.removeAttribute(this.attributeKey,t)}}))}_getValueFromFirstAllowedNode(){const e=this.editor.model,t=e.schema,n=e.document.selection;if(n.isCollapsed)return n.hasAttribute(this.attributeKey);for(const e of n.getRanges())for(const n of e.getItems())if(t.checkAttribute(n,this.attributeKey))return n.hasAttribute(this.attributeKey);return!1}}var r=n(500);class i extends e.Plugin{static get pluginName(){return"FootnoteEditing"}static get requires(){return[r.TwoStepCaretMovement]}init(){const e=this.editor;e.model.schema.extend("$text",{allowAttributes:"footnote"}),e.conversion.attributeToElement({model:"footnote",view:{name:"span",classes:"fn-marker"}}),e.commands.add("footnote",new t(e,"footnote")),e.plugins.get(r.TwoStepCaretMovement).registerAttribute("footnote"),(0,r.inlineHighlight)(e,"footnote","span","fn-marker_selected")}}var a=n(348);class s extends e.Plugin{static get pluginName(){return"FootnoteUI"}init(){const e=this.editor;e.ui.componentFactory.add("footnote",(t=>{const n=e.commands.get("footnote"),o=new a.ButtonView(t);return o.set({label:Craft.t("footnote","Footnote"),icon:'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">\n    <path\n        d="M14.154 5.748c.287 0 .533-.084.739-.253.208-.168.313-.41.313-.724a.857.857 0 0 0-.248-.617c-.165-.174-.388-.261-.668-.261-.19 0-.348.026-.472.079a.76.76 0 0 0-.29.21c-.072.087-.14.2-.206.337-.062.137-.12.266-.172.388a.328.328 0 0 1-.169.154.662.662 0 0 1-.28.056.496.496 0 0 1-.346-.15.55.55 0 0 1-.154-.406c0-.162.048-.332.145-.51.1-.18.243-.352.43-.514.19-.162.425-.29.705-.387.28-.1.594-.15.94-.15.302 0 .577.042.827.126.249.081.465.2.65.355a1.544 1.544 0 0 1 .555 1.206c0 .311-.068.58-.205.804a2.678 2.678 0 0 1-.58.65c.243.13.447.28.612.448a1.7 1.7 0 0 1 .379.56 1.7 1.7 0 0 1 .126.66c0 .283-.058.557-.173.822a2.092 2.092 0 0 1-.5.71 2.441 2.441 0 0 1-.79.486 2.798 2.798 0 0 1-1.004.173 2.41 2.41 0 0 1-1.739-.7 2.391 2.391 0 0 1-.434-.627C12.048 8.458 12 8.28 12 8.14a.57.57 0 0 1 .173-.434.614.614 0 0 1 .44-.169c.086 0 .17.027.252.08.08.05.133.11.158.182.162.433.335.756.52.967.186.21.448.313.784.313a1.16 1.16 0 0 0 1-.565c.119-.187.178-.403.178-.65 0-.364-.1-.649-.3-.855-.199-.208-.476-.313-.831-.313-.063 0-.159.006-.29.019-.13.012-.215.019-.252.019-.172 0-.304-.042-.397-.127a.468.468 0 0 1-.14-.36c0-.149.056-.269.168-.36.112-.093.278-.14.5-.14h.191ZM5.818 17c-.287 0-.509-.078-.665-.235-.157-.156-.235-.385-.235-.685V8.703H3.744c-.235 0-.418-.059-.548-.176A.688.688 0 0 1 3 8.018c0-.222.065-.391.196-.509.13-.117.313-.176.548-.176h1.663l-.49.47v-.724c0-1.266.307-2.224.92-2.877.627-.665 1.54-1.05 2.74-1.154l.607-.04c.195-.025.352.007.47.099a.561.561 0 0 1 .234.313c.04.13.04.267 0 .41a.751.751 0 0 1-.176.353.512.512 0 0 1-.352.176l-.43.02c-.784.065-1.351.3-1.703.704-.352.391-.529.978-.529 1.761v.783l-.254-.294h2.25c.248 0 .437.059.568.176.13.118.196.287.196.51a.688.688 0 0 1-.196.508c-.13.117-.32.176-.568.176H6.698v7.377c0 .613-.293.92-.88.92Z"\n    />\n</svg>\n',tooltip:!0,isToggleable:!0}),o.bind("isOn","isEnabled").to(n,"value","isEnabled"),this.listenTo(o,"execute",(()=>{e.execute("footnote"),e.editing.view.focus()})),o}))}}var c=n(596),l=n.n(c),u=n(0),d={injectType:"singletonStyleTag",attributes:{"data-cke":!0},insert:"head",singleton:!0};l()(u.c,d);u.c.locals;class f extends e.Plugin{static get pluginName(){return"Footnote"}static get requires(){return[i,s]}}})(),(window.CKEditor5=window.CKEditor5||{}).footnote=o})();