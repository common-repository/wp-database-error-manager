=== WP DB Error Manager ===
Contributors: suyash515
Donate link: www.codevigor.com
Tags: db, error, database, connection
Requires at least: 3.0.1
Tested up to: 4.7.4
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WP DB Error Manager allows you to properly handle and manage Database Connection errors that occur in Wordpress websites.

== Description ==

There is nothing worse than greeting your online users with a huge "Database Connection Error" on your website. This is a common problem that occurs on many websites. WP DB Error Manager allows you to properly handle and manage the errors by allowing you to perform these actions:
- Create a custom database error page so that users will not feel alarmed
- Allow users to contact you even when your website is down
- Create automated checks to notify you when your website is down

== Installation ==

1. Unzip the downloaded file
2. Copy/Paste the resulting folder in your wp-contents/plugins/ folder

== Frequently Asked Questions ==

= It is saying that it does not have permission to write =

This can usually occur if the plugin does not have the necessary permissions to write to the wp-content/ folder. The WP DB Error Manager plugin allows you to add a file manually by FTP. Simply open your FTP client, create a file called 'db-error.php' in your wp-content/ folder and paste the contents you get from the plugin settings page.

== Screenshots ==

1. screenshots-1.png : Setup Page
2. screenshots-2.png : Customise your message
3. screenshots-3.png : Sample database error page design

== Changelog ==

= 1.0 =
* Set up additional templates for generating database error pages

== Upgrade Notice ==

= 1.0 =
Allow more options and templates for custom database error pages