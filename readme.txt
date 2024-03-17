=== One Tap Google Sign in ===
Contributors: surendhar153
Donate link: https://www.buymeacoffee.com/surendhar153
Tags: google, one tap, social login, login, signup
Requires at least: 5.1
Tested up to: 6.5
Requires PHP: 7.4
Stable tag: 1.4.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 
Allows users to add Google One Tap Sign-in Or Sign-up to wordpress website.
 
== Description ==

Allows users to add Google One Tap Sign-in Or Sign-up to wordpress website.


== Installation ==

1. Install the plugin via Wordpress repository or by uploading the plugin
2. Activate the plugin through the 'Plugins' menu in WordPress
4. In the Google Cloud Console create a project and create a oauth app
5. And create credentials for "OAuth client ID" and choose web application and add your homepage to 'Authorized JavaScript origins' and you can leave 'Authorized redirect URIs' empty.
5. Get the 'Client ID' from your credentials
6. Enter your 'Client ID' of you oauth login credentials in the 'Google One Tap Login' menu in the wordpress

== Dependencies ==

1. Wordpress v5.1 and later
2. PHP v7.4 and later

== Frequently Asked Questions ==
 
= How does login works? =
 
When google sends user information, if the user email is already registered it will login the user and if the user email is not registered it will create a user account and it will login the user. And after logging in the user will be redirected to the same page.
 
= How to select user role of registering user? =

New user registration user role is defined in the 'New User Default Role' field in the Settings -> General in the admin menu.

= How to enable Automatic sign-in in one tap login? =

Automatic sign-in is currently not enabled. You can look for this feature in the upcoming release

== Screenshots ==

1. Plugin Settings Page
2. WP-Login Page
 
== Changelog ==

= 1.4.1 =
* Updated Google APIs Client Library for PHP Dependencies
* Tested with latest wordpress 6.5
* Reduced no of plugin tags to 5
* Added cache busting on the login redirection

= 1.4.0 =
* Disbale auto login option in the admin settings
* Tested with latest wordpress 6.4.3

= 1.3.1 =
* Revert google library

= 1.3 =
* Something Awesome
* Updated google/apiclient to 2.12.6

= 1.1.2 =
* Updating User Firstname Lastname and getting profile picture for future use
* Added security fixes sanitize input and output

= 1.1 =
* Updating User Firstname Lastname and getting profile picture for future use
* Added security fixes sanitize input and output

= 1.0 =
* Added Lisence and added guidlines for wordpress plugin repository
 
= 0.0.1 =
* Google One Tap Sign-in added for wordpress
