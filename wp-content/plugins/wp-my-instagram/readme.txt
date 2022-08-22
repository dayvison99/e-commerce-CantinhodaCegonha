=== WP Instant Feeds ===
Contributors: mnmlthms
Donate link: http://mnmlthms.com/
Tags: instagram, widget
Requires at least: 3.9
Tested up to: 5.5.1
Stable tag: 1.3.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple, easy to add feeds from Instagram to your site. Period.

== Description ==

Embedding your feed from your Instagram easily with **WP Instant Feeds**. 

### What's hot?

* No Access tokens needed! How cool!
* You can set number of items row
* Ability to Preload/Reload cache

This is a better version of `wp-instagram-widget`. Thanks to *Scott Evans*

### How to use?

**1. Using shortcode** `[wp_my_instagram]`:

You can place above shortcode into your posts/pages or widget (make sure shortcode is enabled in widget)

* `username` - Your Instagram username.
* `limit` - Number of images.
* `layout` - Items per row. `default`, `2`, `3`, `4`, `5`, `6`, `8`, `10`.
* `size` - `thumbnail`, 'small', `large`, `original`.
* `target` - items link target. `_blank`, '_self'.
* `link` - account url

for example:

`[wp_my_instagram username="wordpress" limit="12" layout="3" size="large" link=""]`

**Using widget in Appearance -> Widget and look for **WP Instant Feeds** widget.**

== Frequently Asked Questions ==

= Does it work with private accounts? =

Hell naw!!! public accounts only.

= How can i place WP Instant Feeds in my theme? ? =

You can place these PHP functions any where you want:

`if( function_exists( 'wp_my_instagram') ) wp_my_instagram( array( 'username' => 'my_username', 'limit' => 12, layout => '3' ) );`

or shortcode:

`echo do_shortcode( '[wp_my_instagram username="my_username" limit="12" layout="3"]');`

== Screenshots ==

1. Widget Settings
2. Result

== Changelog ==

= 1.3.4 - Sep 2 2020 =
* New Bug fix for new API

= 1.3.3 - Apr 29 2020 =
* Bug fix

= 1.3.2 - Apr 12 2020 =
* improvements

= 1.3.1 - Mar 27 2020 =
* Bug Fixes

= 1.3.0 - Mar 26 2020 =
* Better feed getter ;)

= 1.2.0 - SEP 8 2019 =
* BUGFIXES ;)

= 1.1.9 - Aug 8 2019 =
* bugfixes & improvements

= 1.1.8 - June 15 2019 =
* bugfixes & improvements

= 1.1.7 - June 18 2019 =
* bugfixes & improvements
* Removed Instagram trademark

= 1.1.6 - Apr 14 2019 =
* bugfixes & improvements

= 1.1.5 - Feb 25 2018 =
* bugfixes & improvements

= 1.1.4 - Feb 23 2018 =
* bugfixes & improvements
* Tested Up to WP 5.x.x

= 1.1.3 - Dec 24 2018 =
* minor bugfixes
* Tested Up to WP 5.x.x

= 1.1.2 - Mar 17 2018 =
* minor bugfixes
* Fix api issue for retrieving with username.
* Work with the latest json
* Tested Up to WP 4.9.x

= 1.1.1 - Jan 12 2018 =
* minor bugfixes
* Fix api issue for retrieving with tag.

= 1.1.0 - Jul 17 2017 =
* minor bugfixes
* Add support for listing feed by tag

= 1.0.3.1 - Jul 11 2017 =
* minor bugfixes

= 1.0.3 =
* Ajaxurl bugfix

= 1.0.2 =
* Fix Minor bugs
* Add ajax cache refresher, no delay on loading when cache is expired

= 1.0.1 =
* Fix Minor bugs
* Tested Up to WP 4.8

= 1.0.0 =
* Initial Release

== Upgrade Notice ==

= 1.0 =