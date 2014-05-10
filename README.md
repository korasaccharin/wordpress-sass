# SASS for WordPress

This plugin provides automated SASS stylesheet generation.

##  Description

SASS is a programmable approach to stylesheets which really adds some cool features. It can make a stylesheet easier to read, easier to update and also adds some powerful features like functions, variables and imports. (See http://sass-lang.com/docs/yardoc/file.SASS_REFERENCE.html for more details.)

This plugin enables any Wordpress Theme to use SASS stylesheets.  In a wordpress theme, the comments at the top of style.css are used to define the theme.  For this reason, this plugin will not allow a .sass or .scss file named 'style'.

## Installation

Install the plugin: copy it in wp-content/plugins or add it with your WordPress administration.

Create the source .sass or .scss file in your theme directory (i.e. mystyle.sass)

## Usage

The plugin has two methods:

- wpass_register_style() instead of wp_register_style()
- wpass_enqueue_style() instead of wp_enqueue_style()

The target file must be writable by WordPress.

## Example

    wpass_register_style('screen', get_template_directory_uri() . '/screen.sass'); 

Based on the plugin of Ed Burns

Requires at least: 3.0

Tested up to: 3.6.0
