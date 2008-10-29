<?php
/* Title      : DateTimepicker plugin class
 * Category   : Plugin
 * Author     : Phize
 * Author URI : http://phize.net
 * License    : GNU General Public License(http://www.gnu.org/licenses/gpl.html)
 * Version    : 1.0.0
 * Last Update: 2008-10-27
 */

class datetimepicker {
    var $base_path = '';
    var $base_uri = '';
    var $language = 'en';



    // Constructor
    function __construct($params) {
        global $modx;

        $this->base_path = isset($params['base_path']) ? $modx->config['base_path'] . $params['base_path'] :  strtr(realpath(dirname(__FILE__)), '\\', '/') . '/';
        $this->base_uri = $modx->config['base_url'] . $params['base_path'];
        $lang = isset($params['lang']) ? $params['lang'] : 'auto';
        $this->setLanguage($lang);

        $this->output();
    }



    // Constructor for PHP4
    function datetimepicker($params) {
        $this->__construct($params);
    }



    // Set language
    function setLanguage($lang = 'auto') {
        global $modx;

        if ($lang == 'auto') {
            // Auto mode works well on 0.9.6.2 or more
            // (The MODx of less than 0.9.6.2 has a bug
            //  Therefore, 'manager_lang_attribute' always returns 'en')
            $lang_code = strtolower($modx->config['manager_lang_attribute']);
        } else {
            $lang_code = $lang;
        }

        $lang_file = $this->base_path . 'js/i18n/ui.datetimepicker-' . $lang_code . '.js';

        $this->language = ($lang_code == 'en' || file_exists($lang_file)) ? $lang_code : 'en';
    }



    // Set default time
    function setDefaultTime($time = '00:00:00') {
        $this->defaultTime = preg_match('/^\d{1,2}:\d{1,2}:\d{1,2}$/', $time) ? $time : '00:00:00';
    }



    // Output the codes for replacing datetimepicker
    function output() {
        global $modx;

        $e = &$modx->Event;

        if ($this->language == 'en') {
            $js_i18n = '';
        } else {
            $js_i18n = <<<EOD
<script src="{$this->base_uri}js/i18n/ui.datetimepicker-{$this->language}.js" type="text/javascript" charset="utf-8"></script>
EOD;
        }

        $html = <<<EOD
<!-- DateTimepicker plugin: BEGIN -->
<script src="{$this->base_uri}js/jquery.js" type="text/javascript" charset="utf-8"></script>
<script src="{$this->base_uri}js/ui.datetimepicker.js" type="text/javascript" charset="utf-8"></script>
{$js_i18n}
<script type="text/javascript"  charset="utf-8">
    var modxPluginDateTimepicker = {};
    modxPluginDateTimepicker.jQuery = jQuery.noConflict(true);

    modxPluginDateTimepicker.jQuery(document).ready(function() {
        // Show datetimepicker
        function showDateTimePicker(event) {
            modxPluginDateTimepicker.jQuery(this).datetimepicker('dialog', modxPluginDateTimepicker.jQuery(event.data.field).val(), function(date) { modxPluginDateTimepicker.jQuery(event.data.field).val(date); }, {
                speed: 'fast',
                showAnim: 'fadeIn',
                dateFormat: 'dd-mm-yy',
                timeFormat: 'hh:ii:00'
            },
            [ event.pageX + 32, event.pageY - 128 ]);
            return false; 
        }

        // The array of the selectors to replace datetimepicker
        var dates = [ { field: 'input[@name="pub_date"]', icon: 'input[@name="pub_date"] ~ a[@onclick]:has(img[src*="cal.gif"])' },
                     { field: 'input[@name="unpub_date"]', icon: 'input[@name="unpub_date"] ~ a[@onclick]:has(img[src*="cal.gif"])' } ];

        // Replace datetimepickers
        for (var i = 0; i < dates.length; i ++) {
            modxPluginDateTimepicker.jQuery(dates[i].icon).bind('click', { field: dates[i].field }, showDateTimePicker);
            modxPluginDateTimepicker.jQuery(dates[i].icon).removeAttr('onclick');
        }

        // Append CSS file
        modxPluginDateTimepicker.jQuery('head').append('<link href="{$this->base_uri}css/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />');
    });
</script>
<!-- DateTimepicker plugin: END -->
EOD;

        $e->output($html);
    }
}
?>