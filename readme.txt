=== WP 3D Twitter Wall ===
Contributors: Flashapplications, Joerg Sontag
Info: http://flashapplications.de/?p=423
Tags: twitter, flash, Wall, rss, 3D, feed, plugin, widget, sidebar

Requires at least: 2.0
Stable tag: 2.0

Flash based AS3 3D Twitter Wall shows you the Tweets of an Twitter Search Result Requires php5!
FlashPlayer10

== Description ==

3D Twitter Wall to show Tweets by useing  an #Hashtag.

::: Requires php5! ::: <- Check that the save_mod is enabled for Proxy.php!!

== Installation ==

1. Make sure you're running WordPress version 2.3 or better. It won't work with older versions.
2. Download the zip file and extract the contents.
3. Upload the '3d-twitter-wall' folder to your plugins directory (wp-content/plugins/).
4. Activate the plugin through the 'plugins' page in WP.
5. See 'Options->WP 3D Twitter Wall' to adjust things like display size, etc...

= In order to actually display the WP 3D Twitter Wall, you have three options. =
1. Create a page or post and type [WP-3DWALL] anywhere in the content. This 'tag' will be replaced by the flash movie when viewing the page. See [here](http://flashapplications.de/?p=423) for more info.
2. Add the following code anywhere in your theme to display the Wall. `<?php wp_3dwall_insert(); ?>` This can be used to add WP 3D Twitter Wall to your sidebar.
3. The plugin adds a widget, so you can place it on your sidebar through 'Appearance'->'Widgets'. Open the widget to access it's own set of settings (background color,  etc).

2. 
== Frequently Asked Questions == 
= I'd like to change something in the Flash movie, will you release the .fla? =
Just Mail me : sontag(at)flashapplications.de

== Screenshots ==

1. See 'Options->WP 3D Twitter Wall to adjust things like display size, etc...
2. The Wall Cube : You can set colors that match your theme on the plugin's options page.


== Options ==

The options page allows you to change the Flash movie's , change the text color as well as the background.

= Your Wall Hash Tag  =
Insert the Hashtag you want to show!

= Color of the Cube =
Type the hexadecimal color value you'd like to use for the tags, but not the '#' that usually precedes those in HTML. Black (000000) will obviously work well with light backgrounds, white (ffffff) is recommended for use on dark backgrounds. 
= Color of the Text =
Type the hexadecimal color value you'd like to use for the tags, but not the '#' that usually precedes those in HTML. Black (000000) will obviously work well with light backgrounds, white (ffffff) is recommended for use on dark backgrounds. 
= Background color =
The hex value for the background color you'd like to use. This options has no effect when 'Use transparent mode' is selected.

= Use transparent mode =
Turn on/off background transparency. Enabling this might cause issues with some (mostly older) browsers.

= Background Picture Path =
Allows you to load an Picture.


== Changelog ==

= 1.0 =
* Initial release version.
= 1.1 =
* Fixed Proxy Bug
= 1.2 =
* Fixed loading Thumb Bug
= 1.3 =
* The Tweet Text is no better displayed
* The Links in Tweets are now active
= 2.0 =
* Insert a Fullscreen Button
* Bugfix 
* Insert a Circle RSS Preloader in the top right to show if the wall start reload rss
== Upgrade Notice ==
== Upgrade Notice ==
-