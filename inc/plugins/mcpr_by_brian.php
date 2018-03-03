<?php
/********************************************************************************
 *
 *  ModCP Rules
 *  Author: Brian.
 * 
 *  Allows you to add general rules box to all moderators visible in ModCP.
 *
 ********************************************************************************/


if(!defined("IN_MYBB"))
	die("This file cannot be accessed directly.");

function mcpr_by_brian_info()
{
	return array(
		"name"			=> "ModCP Rules",
		"description"	=> "Allows you to add general rules box to all moderators visible in ModCP. Like my plugins? Please donate to brianleek2016@gmail.com on PayPal.",
		"website"		=> "https://community.mybb.com/user-115119.html",
		"author"		=> "Brian.",
		"authorsite"	=> "https://community.mybb.com/user-115119.html",
		"version"		=> "1.0",
		"compatibility"	=> "18*"
	);
}


function mcpr_by_brian_activate()
{
	global $db, $lang;
      require MYBB_ROOT."/inc/adminfunctions_templates.php";
	$main = array(
		'name' => 'mcpr', 
		'title' => 'ModCP Rules', 
		'description' => "Settings for ModCP Rules", 
		'disporder' => 1, 
		'isdefault' => 0
	);
	$gid = $db->insert_query("settinggroups", $main);

	$mcprules = array(
		"sid"			=> NULL,
		"name"			=> "mcp_rules",
		"title"			=> "Rules",
		"description"	=> "Enter general rules for moderator below.",
		"optionscode"	=> "textarea",
		"value"			=> "1. Rule #1<br />2. Rule #2.",
		"disporder"		=> 1,
		"gid"			=> intval($gid)
	);

	$db->insert_query("settings", $mcprules);
	rebuild_settings();

    require_once MYBB_ROOT."/inc/adminfunctions_templates.php";
    find_replace_templatesets("modcp", "#".preg_quote("<td valign=\"top\">")."#i", "<td valign=\"top\">{\$mcprd}");

}

function mcpr_by_brian_deactivate()
{
    global $db, $mybb;
    $db->delete_query("settinggroups", "name='mcpr'");
    $db->delete_query('settings', 'name IN ( \'mcp_rules\')');

	
require_once MYBB_ROOT."/inc/adminfunctions_templates.php";
find_replace_templatesets("modcp", "#".preg_quote('{$mcprd}')."#i", '', 0);


	rebuild_settings();

}

$plugins->add_hook("global_start", "mcprd");
function mcprd()
{
    global $mybb, $templates,  $mcprd;

$mcprd = "<table class=\"tborder\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\">
<tr>
<td class=\"thead\"><strong>General Rules & Guidelines to Moderators</strong></td>
</tr>
<tr>
<td class=\"tcat\" width=\"23%\"><span class=\"smalltext\">These are general notices & rules to all moderators</span></td>
</td>
</tr>
<td class=\"trow1\"><span class=\"smalltext\">{$mybb->settings['mcp_rules']}</span></td></table><br />";

}
?>
