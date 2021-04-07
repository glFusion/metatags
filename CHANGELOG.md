# Metatags plugin for glFusion - Changelog

## Ver 1.1.0 (October 6, 2017)

- Implement plugin_autotag function, support all content types
- Set tags via outputHandler class with priority
- Remove PHP in Staticpage option, no longer needed
- Remove default description and keywords to avoid duplicate tags
- Add user-defined array of global default name->content values.
- Set global default values, if any, with plugin_getheadercode function.
- Refactor upgrade function in separate file
- Add option to set article author if not set by a meta tag
