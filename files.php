<?php
include("lib/headers.php");
include("lib/settings.php");
$t = $text['files'];

// Is our dir in the list of GitHub local paths?
$isGitHubRepoDir = in_array($ICEcoder["root"],$ICEcoder['githubLocalPaths']);
?>
<!DOCTYPE html>

<html onMouseDown="top.ICEcoder.mouseDown=true" onMouseUp="top.ICEcoder.mouseDown=false; if (!top.ICEcoder.overCloseLink) {top.ICEcoder.tabDragEnd()}" onMouseMove="if(top.ICEcoder) {top.ICEcoder.getMouseXY(event,'files');top.ICEcoder.canResizeFilesW()}" onDrop="if(top.ICEcoder) {top.ICEcoder.getMouseXY(event,'files')}" onContextMenu="top.ICEcoder.selectFileFolder(event); return top.ICEcoder.showMenu(event)" onClick="top.ICEcoder.selectFileFolder(event)" onDragStart="top.ICEcoder.selectFileFolder(event);" onDragOver="event.preventDefault();event.stopPropagation()">
<head>
<title>ICEcoder v <?php echo $ICEcoder["versionNo"];?> file manager</title>
<meta name="robots" content="noindex, nofollow">
<link rel="stylesheet" type="text/css" href="lib/files.css">
<link rel="stylesheet" type="text/css" href="lib/file-types.css">
<link rel="stylesheet" type="text/css" href="lib/file-type-icons.css">
<script src="lib/ice-coder<?php if (!$ICEcoder['devMode']) {echo '.min';};?>.js" type="text/javascript"></script>
</head>

<body onFocus="top.ICEcoder.files.style.background='#444'" onBlur="top.ICEcoder.files.style.background='#383838'" onload="top.ICEcoder.showHideGithubNav(top.ICEcoder.githubDiff ? 'show' : 'hide')" onDblClick="top.ICEcoder.openFile()" onKeyDown="return top.ICEcoder.interceptKeys('files', event);" onKeyUp="top.ICEcoder.resetKeys(event);" onBlur="parent.ICEcoder.resetKeys(event);">

<div title="<?php echo $t['Lock'];?>" onClick="top.ICEcoder.lockUnlockNav()" id="fmLock" class="lock"></div>
<div title="<?php echo $t['Refresh'];?>" onClick="top.ICEcoder.refreshFileManager()" class="refresh"></div>
<div title="Plugins" onClick="top.ICEcoder.showHidePlugins(top.get('plugins').style.width != '55px' ? 'show' : 'hide')" class="plugins"></div>
<?php
$_SESSION['githubDiff'] = false;
if ($isGitHubRepoDir) {
	$classExtra = !isset($_GET["githubDiff"]) || $_GET["githubDiff"] == "false" ? "Off" : "On";
	if ($classExtra == "On") {
		$_SESSION['githubDiff'] = true;
		// Make sure we are showing the diff pane
		echo "<script>top.ICEcoder.setSplitPane('on');</script>";
	}
	echo '<div title="GitHub" onClick="top.ICEcoder.githubDiffToggle()" class="github'.$classExtra.'"></div>';
}
?>

<ul class="fileManager">
<li class="pft-directory dirOpen"><a nohref title="/" onMouseOver="top.ICEcoder.overFileFolder('folder','/')" onMouseOut="top.ICEcoder.overFileFolder('folder','')" onClick="top.ICEcoder.openCloseDir(this)" style="position: relative; left:-22px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span id="|">/ <?php
echo $iceRoot == "" ? $t['ROOT'] : trim($iceRoot,"/");
$thisPermVal = $serverType=="Linux" ? substr(sprintf('%o', fileperms($docRoot.$iceRoot)), -3) : "";
$permColors = $thisPermVal == 777 ? 'background: #800; color: #eee' : 'color: #888';
?></span> <span style="<?php echo $permColors;?>; font-size: 8px" id="|_perms"><?php echo $thisPermVal;;?></span></a></li><?php
// tree file items generated by the iFrame 'fileControl' below which loads in the items at location=| (ie, the root)
?>
</ul>

<iframe name="fileControl" src="lib/get-branch.php?location=|&csrf=<?php echo $_SESSION['csrf'];?>" style="display: none"></iframe>

<iframe name="testControl" style="display: none"></iframe>

<iframe name="processControl" style="display: none"></iframe>

</body>
	
</html>