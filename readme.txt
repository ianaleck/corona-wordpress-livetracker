=== Simple Custom CSS and JS ===
Created: 04/20/2020
Contributors: ianaleck
Email: ianaleckm@gmail.com
Donate link: https://www.buymeacoffee.com/ianaleck
Tags: Covid-19, Coronavirus, Corona-virus, Tracker, Statistics
Requires at least: 3.0.1
Tested up to: 5.4 
Stable tag: 3.30
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Requires PHP: 5.2.4

Corona Virus / Covid-19 Live Tracker plugin to get Live data for table and or map.

== Description ==

Corona Virus / Covid-19 Live Tracker plugin to get Live data for table and or map.
The plugin dependent on data from [Novel COVID API](https://corona.lmao.ninja/) as a 3rd party service to provide Live covid-19 statistics and the plugin calls this service as soon as tag is submitted on to the site. A link to there documentation is here [Novel COVID API Documentation](https://corona.lmao.ninja/docs/) https://corona.lmao.ninja/docs/. Novel Covid Api's  [License](https://github.com/NovelCOVID/API/blob/master/LICENSE) is found on https://github.com/NovelCOVID/API/blob/master/LICENSE. 

= Features =
* **List All Countries Statistics in Summary**
* **List Single Countries Statistics in Summary**
* **Show MAP of world with confirmed cases**

== Installation ==

* From the WP admin panel, click "Plugins" -> "Add new".
* In the browser input box, type "Covid-19 Live Tracker".
* Select the "Covid-19 Live Tracker" plugin and click "Install".
* Activate the plugin.

OR...

* Download the plugin from this page.
* Save the .zip file to a location on your computer.
* Open the WP admin panel, and click "Plugins" -> "Add new".
* Click "upload".. then browse to the .zip file downloaded from this page.
* Click "Install".. and then "Activate plugin".

OR...

* Download the plugin from this page.
* Extract the .zip file to a location on your computer.
* Use either FTP or your hosts cPanel to gain access to your website file directories.
* Browse to the `wp-content/plugins` directory.
* Upload the extracted `corona_virus_tracker` folder to this directory location.
* Open the WP admin panel.. click the "Plugins" page.. and click "Activate" under the newly added "Covid-19 Live Tracker" plugin.

== Frequently Asked Questions ==

= What if I want to add multiple live trackers? =
If you want to add multiple live trackers with different look and feel, you can generate shortcodes from them from the plugin Admin page and insert the shortcode on where you want the widget to appear.

= Will this plugin affect the loading time? =
When you click the `Save` button the codes will be cached in files and there is no database queries at all :).

= Does the plugin modify the code I write in the editor? =
No, the code is printed exactly as in the editor. It is not modified/checked/validated in any way. You take the full responsability for what is written in there.

= My code doesn't show on the website =
Try one of the following:
1. If you are using any caching plugin (like "W3 Total Cache" or "WP Fastest Cache"), then don't forget to delete the cache before seing the code printed on the website.
2. Make sure the code is in **Published** state (not **Draft** or **in Trash**).

= Does it work with a Multisite Network? =
Yes.

= What if I change the theme? =
The plugin is independent of the theme and they will persist through a theme change. This is particularly useful. 

= Can I update the style of the widget? =
Yes.


== Screenshots ==

1. Generate Widget/Shortcode


== Changelog ==

= 1.0 =
* 06/12/2015
* Initial commit

== Upgrade Notice ==

Nothing at the moment
