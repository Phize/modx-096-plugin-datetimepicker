Title      : Datepicker plugin
Category   : Plugin
Author     : Phize
Author URI : http://phize.net
License    : GNU General Public License(http://www.gnu.org/licenses/gpl.html)
Version    : 1.0.0
Last Update: 2008-10-27



Introduction
------------

Datepicker plugin is the plugin replaces default datepicker.

In 'Edit document' page,
when you click calendar icon as usual, new datepicker is shown.

Now, you can pick up a date without opening new window/tab.



Install
-------

1.Copy datepicker/ folder to /assets/plugins/

2.Create new plugin named 'Datepicker'.

3.Copy&Paste the following code to 'Plugin configuration'.
   &language=Language;string;auto &defaultTime=Default Time(hh:mm:ss);string;00:00:00

4.Check 'OnDocFormPrerender' event, and save the plugin.



Parameters
----------

language   : The language of datepicker.
             You can check language code in /assets/plugins/datepicker/js/i18n/ folder.
             ('**' in 'ui.datepicker-**.js' is the language code.)

             When 'auto' is set,
               the language code will be the same as 'Manager HTML and XML Language Attribute'
                                                                           in 'Configuration'.
             However, auto mode works well on 0.9.6.2 or more.
             (The MODx of less than 0.9.6.2 has a bug.
              Therefore, the language code will be always 'en' even if you set 'auto'.)

defaultTime: The default time.
             The time format is 'hh:mm:ss'.
