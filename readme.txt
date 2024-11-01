=== Plugin Name ===
Contributors: hauxh
Donate link: http://excion.co/donate
Tags: key,secret,token,string,post,posts,without,password
Requires at least: 3.0.1
Tested up to: 3.5.1
Stable tag: 0.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin allows you to require a secret key that is passed via the URL: http://example.com/post-title/?key=[string]

== Description ==

This plugin allows you to require a secret key that is passed via the URL: http://example.com/post-title/?key=[string]
Specify the key in a custom value called "key" with the [string] or use the built in widget.

Stable version of the plugin are pushed to the WordPress repository, 
but the latest version of the plugin can be found at: 
https://bitbucket.org/excion/wpkeyme/

Issues/Bugs: https://bitbucket.org/excion/wpkeyme/issues

== Installation ==

The easiest way to install this plugin is by searching from within your 
WordPress plugins admin area. This plugin was developed by 
Aubrey Portwood (hauxh) and is provided to you by Excion.

Issues/Bugs: https://bitbucket.org/excion/wpkeyme/issues

== Frequently Asked Questions ==

This plugin was developed by Aubrey Portwood (hauxh) 
and is provided to you by Excion.

Issues/Bugs: https://bitbucket.org/excion/wpkeyme/issues

== Screenshots ==

== Changelog ==

= 0.2.1 =
Fixes for default permalinks.

= 0.2 =
Reworked so the key could be set using a widget in the post/page.
Also added a way to generate a random key from withing the widget.
Better die page that helps tell the user what is missing.

= 0.1 =

Initial creation of the plugin for use in one of our own projects. 
This includes the feature to specify a key in the WordPress post's custom 
field "key" and passing that key via the GET method in the URL, 
like http://example.com/?key=[string]