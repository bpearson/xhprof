<?php

$XHPROF_ROOT = dirname(__FILE__);
include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";

$profileRun = array();
$dataDir    = $XHPROF_ROOT."/data/";
$profileDir = $dataDir."/profile";
$dataFiles  = glob($dataDir."/*.data");
$profileUrl = "xhprof_html/index.php";
$prefix     = "profile";
foreach ($dataFiles as $dataFile) {
    $xhprof_data  = file_get_contents($dataFile);
    $xhprof_data  = @unserialize($xhprof_data);
    $xhprof_runs  = new XHProfRuns_Default($profileDir);
    $xhprof_runs->save_run($xhprof_data, $prefix);
    unlink($dataFile);
}

?>
<html>
    <head>
        <title>Profiling Runs</title>
    </head>
    <body>
        <div class="header">Profile Runs</div>
<?php
    $profileRun = glob($profileDir."/*");
    foreach ($profileRun as $filename) {
        $runId   = str_replace(".".$prefix.".xhprof", "", basename($filename));
        $baseUrl = $profileUrl."?run=".$runId."&source=".$prefix;
        echo "<div class=\"profileRun\">";
        echo "<a href=\"".$baseUrl."\">";
        echo "Run: ".$runId;
        echo "</a>";
        echo "</div>";
    }
?>
    </body>
</html>
