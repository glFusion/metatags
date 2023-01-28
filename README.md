# MetaTags Plugin for glFusion
## Version: 1.2.0

For the latest documentation, please see https://www.glfusion.org/wiki/glfusion:plugins:metatags:start

Requires glFusion 2.0.0 or higher.

## Overview

The Metatags plugin allows you to set metatags in the meta tags in HTML
&lt;head&gt; section according to the page content. Metatags are implemented
using autotags and support any content type;

```
<meta name="keywords" content="some,key,words">
<meta name="description" content="Some description">
```

## Usage

The Metatags plugin uses glFusion's autolink feature. If you have disabled it,
please enable the feature in Configuration UI (Miscellaneous - Miscellaneous -
Disable Autolinks).

In an article or a staticpage, if you write `[meta:key comma_separated_keywords]`
as an autotag, this tag will be converted into
```
  <meta name="keywords" content="comma_separated_keywords">.
```
For example, to have the following keywords shown in the header:
```
  [meta:key glfusion,cms,content management system]
```
The result:
```
  <meta name="keywords" content="glfusion,cms,content management system">.
```
Likewise, if you write `[meta:desc description of the current page]`, the tag
will be converted into `<meta name="description" content="description of the
current page">`. In both cases, autotags themselves are not visible in the
content except to the editor(s) if configured.

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

To create a meta "property" rather than a "name", use "metaprop" as the tag
name. E.g.
```
  [metaprop:og:image https://yoursite/logo.png]
```
to create
```
  <meta property="og:image" content="https://yoursite/logo.png" />
```

Recommendation: Put your metatag autotags in the &quot;bodytext&quot; section
of your articles to prevent them from being used on the home page and in topic
lists. If more than one of the same tag type and priority is
found, the first one encountered will be used.

## Configuration

Once you have installed the Metatags plugin, it works well without manual
configuration. However, if you would like to change the name of autotag
(default value is 'meta') or keys translated into meta tag keys (default
values are 'key' and 'desc'), you can set up the plugin through
Configuration UI `(http://yoursite/admin/configuration.php)`.

#### Autotag name

This is the name glFusion recognizes as an autotag (meta in the
above USAGE).

To create autotags for a meta "property", use this name as a prefix
followed by "prop", e.g. "metaprop".

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
set to true, then story editors will see the actual meta data when viewing
the content.

#### Add Author

To automatically add the author&apos;s name to article pages, select
&quot;true&quot; here. The metatag will be added at "LOW" priority so that
any `[meta:author]` tag will override the author set in the article.

#### Defaults
You can create default tags that will appear on *every* page if no autotag is
found. Add an element with the desired tag name and value. Use the actual
meta name value here, not the replacement key from above.

Use care with this option as duplicate metatags on your site can hurt rather
than help your search engine rankings.

  * Name Tags - These elements will appear as `<meta name="key" content="value" />`
  * Property Tags - These elements will appear as `<meta property="key" content="value" />`

## Installation

The MetaTags Plugin uses the glFusion automated plugin installer.
Simply upload the distribtuion using the glFusion plugin installer located in
the Plugin Administration page.

## Upgrading

The upgrade process is identical to the installation process, simply upload
the distribution from the Plugin Administration page.

## License

This program is free software; you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation; either version 2 of the License, or (at your option) any later
version.
