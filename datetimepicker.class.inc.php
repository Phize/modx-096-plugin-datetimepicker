<?php
/* Title      : DateTimePicker plugin class
 * Category   : Plugin
 * Author     : Phize
 * Author URI : http://phize.net
 * License    : GNU General Public License(http://www.gnu.org/licenses/gpl.html)
 * Version    : 1.1.0
 * Last Update: 2008-12-31
 */

class datetimepicker {
    var $base_path = '';
    var $base_uri = '';
    var $language = 'en';



    // Constructor
    function __construct($params) {
        global $modx;

        if (isset($params['base_path'])) {
            $this->setBasePath($modx->config['base_path'] . $params['base_path']);
        } else {
            $this->setBasePath(strtr(realpath(dirname(__FILE__)), '\\', '/') . '/');
        }

        $this->setBaseUri($modx->config['base_url'] . $params['base_path']);

        $lang = isset($params['lang']) ? $params['lang'] : 'auto';
        $this->setLanguage($lang);

        $this->output();
    }



    // Constructor for PHP4
    function datetimepicker($params) {
        $this->__construct($params);
    }



    // Setter and Getter
    function getBasePath() { return $this->base_path; }
    function getBaseUri() { return $this->base_uri; }
    function getLanguage() { return $this->language; }
    function setBasePath($base_path) { $this->base_path = $base_path; }
    function setBaseUri($base_uri) { $this->base_uri = $base_uri; }
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

        $lang_file = $this->getBasePath() . 'js/i18n/ui.datetimepicker-' . $lang_code . '.js';

        $this->language = ($lang_code == 'en' || file_exists($lang_file)) ? $lang_code : 'en';
    }



    // Get Template Variables names
    function getTvNames() {
        global $modx;

        // Get table names
        $table_tv = $modx->getFullTableName('site_tmplvars');
        $table_relation = $modx->getFullTableName('site_tmplvar_templates');

        // Build SQL
        $sql = 'SELECT DISTINCT name FROM ' . $table_tv . ' tv'
             . ' LEFT JOIN ' . $table_relation . ' rel'
             . ' ON rel.tmplvarid = tv.id'
             . " WHERE type IN ('date')";
//             . ' WHERE rel.templateid = ' . $id
//             . " AND type IN ('date')";

        // Execute SQL query
        $result = $modx->db->query($sql);

        if (!$result) return false;

        // Make TV names array
        $tvs = array();
        $rows = $modx->db->getRecordCount($result);
        for ($i = 0; $i < $rows; $i ++) {
            $row = $modx->db->getRow($result);
            $tvs[] = $row['name'];
        }

        return $tvs;
    }



    // Get CSS file names
    function getCssFileNames() {
        return array('jquery.datetimepicker.css');
    }



    // Get JavaScript file names
    function getJsFileNames() {
        $lang = $this->getLanguage();

        if ($lang == 'en') {
            return array('ui.datetimepicker.js');
        } else {
            return array('ui.datetimepicker.js',
                         'i18n/ui.datetimepicker-' . $lang . '.js');
        }
    }



    // Get JavaScript to append picker
    function getPickerJs() {
        $script = <<<EOD
        // Show datetimepicker
        function showDateTimePicker(event) {
            modxPluginDateTimepicker.jQuery(this).datetimepicker('dialog', modxPluginDateTimepicker.jQuery(event.data.field).val(), function(date) { modxPluginDateTimepicker.jQuery(event.data.field).val(date); modxPluginDateTimepicker.jQuery(event.data.show).text(date); }, {
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
            modxPluginDateTimepicker.jQuery('.plugin-datetimepicker-trigger-' + (i + 1)).bind('click', { field: '.plugin-datetimepicker-field-' + (i + 1), show: '.plugin-datetimepicker-show-' + (i + 1) }, showDateTimePicker);
        }

EOD;

        return $script;
    }



    // Get script elements to append JavaScript libraries
    function buildLibraryScript($jses = array()) {
        $js_uri = $this->getBaseUri() . 'js/';

        $script = '';

        if (is_array($jses)) {
            if (count($jses) > 0) {
                foreach ($jses as $js) {
                    $script .= <<<EOD
<script src="{$js_uri}{$js}" type="text/javascript" charset="utf-8"></script>

EOD;
                }
            }
        } else {
            if (trim($jses) != '') {
                $script = <<<EOD
<script src="{$js_uri}{$jses}" type="text/javascript" charset="utf-8"></script>

EOD;
            }
        }

        return $script;
    }



    // Get JavaScript to append CSSes
    function buildCssScript($csses = array()) {
        $css_uri = $this->getBaseUri() . 'css/';

        $script = '';

        if (is_array($csses)) {
            if (count($csses) > 0) {
                foreach ($csses as $css) {
                    $script .= <<<EOD

        // Append CSS file

        modxPluginDateTimepicker.jQuery('head').append('<link href="{$css_uri}{$css}" rel="stylesheet" type="text/css" />');

EOD;
                }
            }
        } else {
            if (trim($csses) != '') {
                $script .= <<<EOD

        // Append CSS file

        modxPluginDateTimepicker.jQuery('head').append('<link href="{$css_uri}{$csses}" rel="stylesheet" type="text/css" />');

EOD;
            }
        }

        return $script;
    }




    // Build object literal for date type TVs
    function buildTvObjectLiterals($tvs = array()) {
//        $symbols = array('-' => '%2D', '.' => '%2E', '_' => '%5F');
        $literal = '';
        if (is_array($tvs) && count($tvs) > 0) {
            foreach ($tvs as $tv) {
//                $tv = str_replace($symbols_str, $symbols_replace, $tv);
                $literal .= ", { field: 'input#tv" . $tv . "', trigger: 'td:has(span#tv" . $tv . "_show)+td>a:has(img[src*=\"cal.gif\"])', show: 'span#tv" . $tv . "_show' }";
            }
        }

        return $literal;
    }



    // Output the codes for replacing datetimepicker
    function output() {
        global $modx;

        $e = &$modx->Event;

        $base_uri = $this->getBaseUri();

        $tv_dates = $this->buildTvObjectLiterals($this->getTvNames());

        // Output JavaScript
        $html = <<<EOD
<!-- DateTimepicker plugin: BEGIN -->
<script src="{$base_uri}js/jquery.js" type="text/javascript" charset="utf-8"></script>

EOD;
        $html .= $this->buildLibraryScript($this->getJsFileNames());
        $html .= <<<EOD
<script type="text/javascript">
    // Avoid conflict with other script
    var modxPluginDateTimepicker = {};
    modxPluginDateTimepicker.jQuery = jQuery.noConflict(true);

    modxPluginDateTimepicker.jQuery(document).ready(function() {
        // The array of the selectors to replace datetimepicker
        var dates = [ { field: 'input[@name="pub_date"]', trigger: 'input[@name="pub_date"] ~ a[@onclick]:has(img[src*="cal.gif"])' },
                     { field: 'input[@name="unpub_date"]', trigger: 'input[@name="unpub_date"] ~ a[@onclick]:has(img[src*="cal.gif"])' }{$tv_dates} ];

        // Set class name and remove onclick attribute
        for (var i = 0; i < dates.length; i ++) {
            modxPluginDateTimepicker.jQuery(dates[i].field).attr({ class: 'plugin-datetimepicker-field-' + (i + 1) });
            modxPluginDateTimepicker.jQuery(dates[i].trigger).attr({ class: 'plugin-datetimepicker-trigger-' + (i + 1)});
            if ('show' in dates[i]) {
                modxPluginDateTimepicker.jQuery(dates[i].show).attr({ class: 'plugin-datetimepicker-show-' + (i + 1)});
            }
            modxPluginDateTimepicker.jQuery(dates[i].trigger).removeAttr('onclick');
        }

        // Replace datetimepickers


EOD;
        $html .= $this->getPickerJs();
        $html .= $this->buildCssScript($this->getCssFileNames());
        $html .= <<<EOD
    });
</script>
<!-- DateTimepicker plugin: END -->

EOD;

        $e->output($html);
    }
}
?>