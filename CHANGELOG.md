# Metatags plugin for glFusion - Changelog

## Ver 1.1.0
Release TBD
- Implement plugin_autotag function.
  - Supports all content types
- Set tags via outputHandler class with priority
  - Requires an update to outputHandler class
- Remove PHP in Staticpage option, no longer needed
- Remove default description and keywords
- Add user-defined array of global default name->content values.
- Set global default values, if any, with plugin_getheadercode function.
- Refactor upgrade function in separate file
- Add option to set default author if not set by a meta tag
