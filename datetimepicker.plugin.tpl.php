/* Title      : DateTimepicker plugin
 * Category   : Plugin
 * Author     : Phize
 * Author URI : http://phize.net
 * License    : GNU General Public License(http://www.gnu.org/licenses/gpl.html)
 * Version    : 1.0.0
 * Last Update: 2008-10-27
 */

$base_path = 'assets/plugins/datetimepicker/';
$class_file = $modx->config['base_path'] . $base_path . 'datetimepicker.class.inc.php';

$e = &$modx->Event;

switch ($e->name) {
    case 'OnDocFormPrerender':
        if (file_exists($class_file)) include_once($class_file); else return;
        if (!class_exists('datetimepicker')) return;

        $params = array();
        $params['base_path'] = $base_path;
        $params['lang'] = $language;
        $params['defaultTime'] = $defaultTime;

        $dp = new datetimepicker($params);
        break;
    default:
        break;
}
