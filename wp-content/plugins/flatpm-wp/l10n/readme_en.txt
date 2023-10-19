# Flat PM #
* Contributors: FlatBoy
* Donate link: https://mehanoid.pro/flat-pm/
* Tags: ads, ad injection, ads plugin, ad rotation, ad manager, adsense, advertising, custom code, banner, rotator, ad blocking detection, header code, footer code, banners, adverts, sticky fixed widgets, flatpm, flat pm, flat profit maker
* Requires at least: 4.4
* Tested up to: 5.9.3
* Stable tag: 2.664
* Requires PHP: 5.6
* License: GPLv3
* License URI: https://www.gnu.org/licenses/gpl.html

## Description ##
Плагин вывода рекламы с огромным количеством функционала.
**Flat PM** – это плагин для вывода рекламы и интерактивного контента. Увеличивает конверсию, поведенческие факторы и выхлоп с сайтов!
> Основная цель плагина – упростить контроль по выводу рекламных блоков.

### Targeting options ###
* Whether the user is using ADblock
* Output ad units in the right place
* Advertising target by content
* Targeting by country and city
* A/B testing
* Screen resolution targeting
* Targeting by get-parameter in url, referer, cookie, ip, operating system, browser, time and date
* Output any number of ad units

### Output options ###
* By js/css selectors
* One-time withdrawal or withdrawal with repetition
* There are more than 56 prepared places for withdrawal
* Popups
* Pop-outs on the bottom, top, right, left of the screen
* Timers for closing popups and leaving blocks

### Additional features ###
* There is a simple code output in the header and footer of your theme
* Delayed display of advertising
* Customization of the design of the closing cross of the outgoing and pop-up blocks
* A lot of shortcodes are integrated into the plugin to display information about the article, category or the user himself
* There is a functionality of sticky blocks in the content
* There is a sticky block functionality for the sidebar
* Output video prerolls
* Delayed loading of ad units
* Lazy loading of metrics and analytics
* Automatic cache cleaning on the site
* Cool code syntax highlighting

### Экспорт / импорт всех настроек ###
* Вы можете экспортировать настройки плагина на другой сайт
* Если вы хотите внести массовые изменения в блоки перед импортом, можете воспользоваться [микросервисом по дешифровке настроек](https://mehanoid.pro/deshifrator-shifrator-nastroek-plaginov/)

## Installation ##
Install like any other plugin or:
* Upload the files to the `/wp-content/plugins/flatpm-wp` directory, or install the plugin via the WordPress plugin installation screen in the admin panel.
* Activate the plugin through the list of all plugins on your site.


## Screenshots ##
1. List of all ads
2. Adding a new ad unit
3. Output settings
4. Features of the PRO version
5. Inserting code in the header and footer
6. Video prerolls
7. Plugin Options
8. Export and import


## Frequently Asked Questions ##

### How to create an A/B test? ###
Create two or more sub-blocks within the same ad unit. Select a group for rotation for subblocks.
The group must be the same for the subblocks you want to rotate in the A/B test.

### How to use selectors? ###
I wrote a short [article] about selectors (https://mehanoid.pro/css-selektory-kotorye-vy-dolzhny-znat/), it has a guide and examples.

### How to display a block in the sidebar? ###
Go to widgets, create a widget with HTML,
Inside the widget write: `<div class="flat_side_1"></div>`
In the block settings, specify "Search the entire document" and the selector: `.flat_side_1`

### How to make a sticky block in the content? ###
You need to wrap your code in this construct:

`<div class="flatPM_sticky" data-height="500" data-top="74">
Your advertising code
</div>
data-height is the height of the scroll box in pixels, the default value is 350.
data-top is the padding from the top of the screen in pixels, default value is 0`

### How to make a sticky block for a sidebar? ###
You need to wrap your code in this construct:

`<div class="flatPM_sidebar" data-top="76">
your code number 1
</div>
<div class="flatPM_sidebar" data-top="76">
your code number 2
</div>
<div class="flatPM_sidebar" data-top="76">
your code number 3
</div>
data-top is the padding from the top of the screen in pixels, default value is 0`

The number of blocks can be anything from 1 to infinity.
If there is only one block, then it will be fixed and replace the functionality of the Q2W3 Fixed Widget plugin.
If there is more than one block, then they will replace each other at equal intervals when the page is scrolled down.


## Changelog ##

### 2.661 ###
* Fixed potential bug with adsense output.
* Fixed a potential bug with user GEO checking.

### 2.658 ###
* Fixed ssl signature verification bug when checking a license.

### 2.657 ###
* Fixed 2 vulnerabilities in the plugin. Nothing critical, but still.
* Fixed a bug, it was related to the incorrect calculation of the "minimum spacing" in characters.
* Fixed "in N characters" output bug, it was related to hidden tags, pictures, "img, ins, script, style, noscript" ads.
* Fixed bug with displaying advertising code for video pre-rolls, the bug was related to the processing of double quotes.
* In the new version, the license check address has been changed from wp-pro.online to mehanoid.pro. The old address is still supported, but no later than 3 months later it will be completely deleted and become unavailable. We recommend updating the plugin.
* Many more minor code tweaks to set the stage for a major update.
* Visual edits in the admin panel.
* [Full changelog up to 2.654](https://mehanoid.pro/flat-pm/shangelog-flat-pm/)

### 2.655 ###
* Fixed vulnerability in plugin.
* [Full changelog up to 2.654](https://mehanoid.pro/flat-pm/shangelog-flat-pm/)

### 2.654 ###
* Fixed vulnerability in plugin.
* Fixed conflict with WPRocket plugin, with its deferred scripting feature.
* [Full changelog up to 2.654](https://mehanoid.pro/flat-pm/shangelog-flat-pm/)

### 2.653 ###
* Fixed bug with saving/outputting selectors.
* [Full changelog up to 2.653](https://mehanoid.pro/flat-pm/shangelog-flat-pm/)

### 2.651 ###
* Added display of blocks on pages with 404 errors - is_404().
* [Full changelog up to 2.651](https://mehanoid.pro/flat-pm/shangelog-flat-pm/)

### 2.650 ###
* The block serial number is now saved more intuitively, and an alert has been added for greater clarity.
* Full release of the plugin in the WordPress repository.
* [Full changelog up to 2.650](https://mehanoid.pro/flat-pm/shangelog-flat-pm/)

### 2.644 ###
* Fixed a bug with the functionality of defining cookies and get-parameters.
The plugin incorrectly determined the values if there were more than one of them
* Added settings for displaying code inside elements.
For “Once” and “Every N”, namely “Add to beginning”, “Add to end”.
In total, all 4 main types of content insertion are implemented: before, after, append, prepend.
* An option has been added to the plugin settings that allows you to give access to the plugin management for editors.
* An algorithm for cleaning all data that is written to the database has been introduced into the plugin.
* [Full changelog up to 2.644](https://mehanoid.pro/flat-pm/shangelog-flat-pm/)

### 2.623 ###
* first version in repository
* [All changes before 2.623](https://mehanoid.pro/flat-pm/shangelog-flat-pm/)


## Upgrade Notice ##
Bugfix release.