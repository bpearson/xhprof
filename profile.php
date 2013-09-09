<?php

$GLOBALS['XHPROF_LIB_ROOT']  = dirname(__FILE__)."/xhprof_lib";
$GLOBALS['XHPROF_HTML_ROOT'] = dirname(__FILE__)."/xhprof_html";
$GLOBALS['base_path']        = rtrim(dirname($_SERVER['SCRIPT_NAME']), "/")."/xhprof_html";

require_once $GLOBALS['XHPROF_LIB_ROOT'].'/display/xhprof.php';

// param name, its type, and default value
$params = array('run'        => array(XHPROF_STRING_PARAM, ''),
                'wts'        => array(XHPROF_STRING_PARAM, ''),
                'symbol'     => array(XHPROF_STRING_PARAM, ''),
                'sort'       => array(XHPROF_STRING_PARAM, 'wt'), // wall time
                'run1'       => array(XHPROF_STRING_PARAM, ''),
                'run2'       => array(XHPROF_STRING_PARAM, ''),
                'source'     => array(XHPROF_STRING_PARAM, 'xhprof'),
                'all'        => array(XHPROF_UINT_PARAM, 0),
                );

// pull values of these params, and create named globals for each param
xhprof_param_init($params);

/* reset params to be a array of variable names to values
   by the end of this page, param should only contain values that need
   to be preserved for the next page. unset all unwanted keys in $params.
 */
foreach ($params as $k => $v) {
  $params[$k] = $$k;

  // unset key from params that are using default values. So URLs aren't
  // ridiculously long.
  if ($params[$k] == $v[1]) {
    unset($params[$k]);
  }
}

echo "<html>";

echo "<head><title>XHProf: Hierarchical Profiler Report</title>";
xhprof_include_js_css($GLOBALS['XHPROF_HTML_ROOT']);
echo "</head>";

echo "<body>";

$vbar    = ' class="vbar"';
$vwbar   = ' class="vwbar"';
$vwlbar  = ' class="vwlbar"';
$vbbar   = ' class="vbbar"';
$vrbar   = ' class="vrbar"';
$vgbar   = ' class="vgbar"';
$dataDir = dirname(__FILE__)."/data/profile/";

$xhprof_runs_impl = new XHProfRuns_Default($dataDir);

displayXHProfReport($xhprof_runs_impl, $params, $source, $run, $wts,
                    $symbol, $sort, $run1, $run2);


echo "</body>";
echo "</html>";
