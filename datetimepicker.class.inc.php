<?php
/* Title      : DateTimepicker plugin class
 * Category   : Plugin
 * Author     : Phize
 * Author URI : http://phize.net
 * License    : GNU General Public License(http://www.gnu.org/licenses/gpl.html)
 * Version    : 1.1.0 beta
 * Last Update: 2008-10-30
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



    // Output the codes for replacing datetimepicker
    function output() {
        global $modx;

        $e = &$modx->Event;

        if ($this->language == 'en') {
            $script = <<<EOD
<script src="{$this->base_uri}js/ui.datetimepicker.js" type="text/javascript" charset="utf-8"></script>
EOD;
        } else {
            $script = <<<EOD
<script src="{$this->base_uri}js/ui.datetimepicker.js" type="text/javascript" charset="utf-8"></script>
<script src="{$this->base_uri}js/i18n/ui.datetimepicker-{$this->language}.js" type="text/javascript" charset="utf-8"></script>
EOD;
        }

        $code = <<<EOD
        // Show datetimepicker
        function showDateTimePicker(event) {
            modxPluginDateTimepicker.jQuery(this).datetimepicker('dialog', modxPluginDateTimepicker.jQuery(event.data.field).val(), function(date) { modxPluginDateTimepicker.jQuery(event.data.field).val(date); }, {
                duration: 'fast',
                showAnim: 'fadeIn',
                dateFormat: 'dd-mm-yy',
                timeFormat: 'hh:ii:ss'
            },
            [ event.pageX + 32, event.pageY - 128 ]);
            return false; 
        }

        // Bind datetimepicker event
        for (var i = 0; i < dates.length; i ++) {
            modxPluginDateTimepicker.jQuery('.plugin-datetimepicker-trigger-' + (i + 1)).bind('click', { field: '.plugin-datetimepicker-field-' + (i + 1) }, showDateTimePicker);
        }
EOD;

        $html = <<<EOD
<!-- DateTimepicker plugin: BEGIN -->
<script src="{$this->base_uri}js/jquery.js" type="text/javascript" charset="utf-8"></script>
{$script}
<script type="text/javascript"  charset="utf-8">
    // Avoid conflict with other script
    var modxPluginDateTimepicker = {};
    modxPluginDateTimepicker.jQuery = jQuery.noConflict(true);

    modxPluginDateTimepicker.jQuery(document).ready(function() {
        // The array of the selectors to replace datetimepicker
        var dates = [ { field: 'input[@name="pub_date"]', trigger: 'input[@name="pub_date"] ~ a[@onclick]:has(img[src*="cal.gif"])' },
                     { field: 'input[@name="unpub_date"]', trigger: 'input[@name="unpub_date"] ~ a[@onclick]:has(img[src*="cal.gif"])' } ];

        // Set class name and remove onclick attribute
        for (var i = 0; i < dates.length; i ++) {
            modxPluginDateTimepicker.jQuery(dates[i].field).attr({ class: 'plugin-datetimepicker-field-' + (i + 1) });
            modxPluginDateTimepicker.jQuery(dates[i].trigger).attr({ class: 'plugin-datetimepicker-trigger-' + (i + 1)});
            modxPluginDateTimepicker.jQuery(dates[i].trigger).removeAttr('onclick');
        }

        // Replace datetimepickers
{$code}

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