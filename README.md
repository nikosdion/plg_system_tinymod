# 🚨🚨 This repository is obsolete 🚨🚨

Joomla! 5 uses TinyMCE 6. This plugin can't work with TinyMCE 6, and I have no use case for it anymore so I am not updating it.

# TinyMCE Configuration Modifier for Joomla

A system plugin to customise TinyMCE beyond what Joomla lets you do.

**WARNING!** This plugin is meant for _expert users_. You can very easily break the TinyMCE editor or override Joomla's editor profiles if you're not careful.

## Requirements

* Joomla 4
* PHP 7.2 or later, including any PHP 8 version
* Using Joomla's built-in TinyMCE editor plugin (duh!)

## How it works

Install the plugin and enable it; it appears in the plugins manager as “System - TinyMCE Configuration Modifier”.

Edit the “System - TinyMCE Configuration Modifier”.

The only option is an editor field where you can paste a JSON document with TinyMCE configuration options. Please consult the [TinyMCE configuration reference](https://www.tiny.cloud/docs/configure/).

**IMPORTANT!** At the time of this writing, TinyMCE has published version 6 of their editor but Joomla 4 is only using TinyMCE 5. Please remember to select “TinyMCE v5” in the drop-down of the TinyMCE documentation to view the information which is relevant to the TinyMCE version Joomla is using.

## Example

You can override the styles which are available under Format, Formats in the TinyMCE menu and in the style drop-down in the editor's toolbar. Let's say you want to remove the heading levels 1 and 2.

You can do that with the following JSON document:

```json
{
    "style_formats_merge": false,
    "style_formats": [
        {
            "title": "Headings",
            "items": [
                {
                    "title": "Heading 3",
                    "format": "h3"
                },
                {
                    "title": "Heading 4",
                    "format": "h4"
                },
                {
                    "title": "Heading 5",
                    "format": "h5"
                },
                {
                    "title": "Heading 6",
                    "format": "h6"
                }
            ]
        },
        {
            "title": "Inline",
            "items": [
                {
                    "title": "Bold",
                    "format": "bold"
                },
                {
                    "title": "Italic",
                    "format": "italic"
                },
                {
                    "title": "Underline",
                    "format": "underline"
                },
                {
                    "title": "Strikethrough",
                    "format": "strikethrough"
                },
                {
                    "title": "Superscript",
                    "format": "superscript"
                },
                {
                    "title": "Subscript",
                    "format": "subscript"
                },
                {
                    "title": "Code",
                    "format": "code"
                }
            ]
        },
        {
            "title": "Blocks",
            "items": [
                {
                    "title": "Paragraph",
                    "format": "p"
                },
                {
                    "title": "Blockquote",
                    "format": "blockquote"
                },
                {
                    "title": "Div",
                    "format": "div"
                },
                {
                    "title": "Pre",
                    "format": "pre"
                }
            ]
        },
        {
            "title": "Align",
            "items": [
                {
                    "title": "Left",
                    "format": "alignleft"
                },
                {
                    "title": "Center",
                    "format": "aligncenter"
                },
                {
                    "title": "Right",
                    "format": "alignright"
                },
                {
                    "title": "Justify",
                    "format": "alignjustify"
                }
            ]
        }
    ],
	"block_formats": "Paragraph=p; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6; Preformatted=pre; Code=code"
}
```

Please note that we had to set [`style_formats_merge`](https://www.tiny.cloud/docs/configure/editor-appearance/#style_formats_merge) to `false` to make sure that our `style_formats` _replace_ the existing definitions. There is no other way to remove style formats. 

Also note that this does not remove the formats pulled in from the `editor.css` file. That's a plugin, not a hard-coded style format.

Finally, the `block_formats` determines what will be shown in the “block elements” drop-down. I removed the heading levels 1 and 2, and I added a `<code>` element which I frequently use when doing technical support of my software.
