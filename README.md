# MetaTags Plugin for glFusion
## Version: 1.0.7

For the latest documentation, please see

	http://www.glfusion.org/wiki/doku.php?id=metatags:start

## LICENSE

This program is free software; you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation; either version 2 of the License, or (at your option) any later
version.

## OVERVIEW

The Metatags plugin allows you to set metatags in the  meta tags in HTML
&lt;head&gt; section according to the page content. Metatags are implemented
using autotags and support any content type;

```
<meta name="keywords" content="some,key,words">
<meta name="descrition" content="Some description">
```

##USAGE

The Metatags plugin uses glFusion's autolink feature. If you have disabled it,
please enable the feature in Configuration UI (Miscellaneous - Miscellaneous -
Disable Autolinks).

In an article or a staticpage, if you write [meta:key comma_separated_keywords]
as an autotag, this tag will be converted into
```
  <meta name="keywords" content="comma_separated_keywords">.
```
For example, to have the following keywords shown in the header:
```
  [meta:key glfusion,cms,content management system]
```
Would produce:
```
  <meta name="keywords" content="glfusion,cms,content management system">.
```
Likewise, if you write `[meta:desc description of the current page]`, the tag
will be converted into `<meta name="description" content="description of the
current page">`. In both cases, autotags themselves are not visible in the
content except for the editor(s).

For example, to place a meta description in a story, use:
```
  [meta:desc This is a description of this story]
```
Would produce
```
  <meta name="description" content="This is a description of this story">
```
Caution: Your keywords and description MUST NOT contain a right square
bracket(']').

Recommendation: Put your metatag autotags in the &quot;bodytext&quot; section
of your articles to prevent them from being used on the home page and in topic
lists. If more than one of the same tag type, e.g. &quot;meta:desc&quot; is
found, the first one encountered will be used.

##CONFIGURATION

Once you have installed the Metatags plugin, it works well without manual
configuration. However, if you would like to change the name of autotag
(default value is 'meta') or keys translated into meta tag keys (default
values are 'key' and 'desc'), you can set up the plugin through
Configuration UI (http://yoursite/admin/configuration.php).

#### Autotag name
This is the name glFusion recognizes as an autotag (meta in the
above USAGE)

#### Replace
Keys (the label left to an textarea) will be converted into meta tag keys
(the string in an textarea). For example:

    key      => keyword
    desc     => description
    au       => author

`[meta:au Mark R. Evans]` translates to:
`<meta name="author" content="Mark R. Evans">`

#### Show tags to Editors?
By default, the meta auto tag is hidden in the rendered content. If this is
set to true, then story editors will see the actual meta data when vieing
the content.

#### Add Author
To automatically add the author&apos;s name to article pages, select
&quot;true&quot; here.

#### Defaults
You can create default tags that will appear on *every* page. Add an element
with the desired tag name and value. Use the actuall meta name value here,
not the replacement key from above.

##INSTALLATION

The MetaTags Plugin uses the glFusion automated plugin installer.
Simply upload the distribtuion using the glFusion plugin installer located in
the Plugin Administration page.

##UPGRADING

The upgrade process is identical to the installation process, simply upload
the distribution from the Plugin Administration page.
