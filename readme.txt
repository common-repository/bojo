=== Bojo ===
Contributors:
Donate: 
Tags: 
Requires at least: 2.1
Tested up to: 2.5
Stable tag: trunk

== Description ==

Allows you to display short messages of what you're up to.  It's supposed to be similar to Twitter.

== Installation ==

1. Put the bojo directory in wp-content/plugins
1. Activate the theme
1. Go into Options > Bojo in the Dashboard to set your display preferences
1. Go into Admin > Categories and create the category you want to use with the plugin
1. Use the function `bojo()` wherever in your theme you want the latest posts displayed, or use widgets to add it to your sidebar
1. Start writing posts with whatever category you chose

== Frequently Asked Questions ==

= How do you subscribe with an RSS reader? =

It depends on how the blogger's blog is configured.  It could be something like:
http://www.example.com/blog/categories/bojo/feed

Just copy the address of the category (listed in most themes) and then add */feed*.

== Screenshots ==

== Uninstallation ==

1. Remove the widget from your sidebar
1. Go into the settings area and delete the settings
1. Deactivate the plugin
1. Remove the category you chose to be used with Bojo (if desired)
1. Remove the directory *bojo*

== TODO ==

* Automatically create the Bojo category if it doesn't already exist
* Allow references to other bojanoj (users of Bojo)
* Better customization of what information you want outputted from bojo()
