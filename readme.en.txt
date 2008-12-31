Title      : DateTimePicker plugin
Category   : Plugin
Author     : Phize
Author URI : http://phize.net
License    : GNU General Public License(http://www.gnu.org/licenses/gpl.html)
Version    : 1.1.0
Last Update: 2008-12-31



Introduction
------------

DateTimePicker plugin is the plugin replaces default datetimepicker.

In 'Edit document' page,
when you click calendar icon as usual, new datetimepicker is shown.

Now, you can pick up a date and a time without opening new window/tab.

If there are date type TVs have TV name which are included '-' or '.', '_', 
DateTimePicker plugin would not run correctly.



Install
-------

1.Copy datetimepicker/ folder to /assets/plugins/

2.Create new plugin named 'DateTimePicker'.

3.Copy&Paste the content of datetimepicker.plugin.tpl.php into 'Plugin code'.

4.Copy&Paste the following code into 'Plugin configuration'.
   &language=Language;string;auto

5.Check 'OnDocFormPrerender' event, and save the plugin.



Parameters
----------

language   : The language of datetimepicker.
             You can check language code in /assets/plugins/datetimepicker/js/i18n/ folder.
             ('**' in 'ui.datetimepicker-**.js' is the language code.)

             When 'auto' is set,
               the language code will be the same as 'Manager HTML and XML Language Attribute'
                                                                           in 'Configuration'.
             However, auto mode works well on 0.9.6.2 or more.
             (The MODx of less than 0.9.6.2 has a bug.
              Therefore, the language code will be always 'en' even if you set 'auto'.)
