=== Covid-19 Live Tracker ===
Created: 04/20/2020
Contributors: ianaleck
Email: ianaleckm@gmail.com
Donate link: https://www.buymeacoffee.com/ianaleck
Tags: Covid-19, Coronavirus, Corona-virus, Live Tracker, Statistics, Coronavirus Live Map
Requires at least: 3.0.1
Tested up to: 5.4 
Stable tag: 3.30
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Requires PHP: 5.2.4

Corona Virus / Covid-19 Live Tracker plugin to get Live data for table and or map.

== Description ==


Coronavirus disease (COVID-19) is an infectious disease caused by a newly discovered coronavirus.
The plugin displays the Coronavirus ( Covid19 ) data of the whole world and country you call through a shortcode [ia_covid19] in your WordPress post or page. You can use the shortcode with some attributes also. For example: [ia_covid19 type=table area=us theme=light].

The plugin dependent on data from a 3rd party service [Novel COVID API](https://corona.lmao.ninja/) to provide Live covid-19 statistics via an API and the plugin calls this service as soon the shortcode [ia_covid19] is available on a page or post. 
[Novel COVID API Documentation](https://corona.lmao.ninja/docs/) https://corona.lmao.ninja/docs/.
Novel Covid Api's  [License](https://github.com/NovelCOVID/API/blob/master/LICENSE) is found on https://github.com/NovelCOVID/API/blob/master/LICENSE. 
Novel Covid [Privacy Policy](https://github.com/NovelCOVID/API/blob/master/privacy.md) https://github.com/NovelCOVID/API/blob/master/privacy.md

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

1. Live Dark Mode Table
2. Live Map
3. Mobile Responsive and Select custom countries
4. Generate Widget/Shortcode
5. Live Light Mode Table with transparent background
6. Generate Widget/Shortcode


== Changelog ==

= 1.0.0 =
* 04/23/2020
* Initial commit

== Upgrade Notice ==

Nothing at the moment
