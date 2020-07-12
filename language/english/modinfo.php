<?php
// $Id: modinfo.php,v 1.2 2003/10/14 13:18:04 wellwine Exp $
// $Id: modinfo.php,v 1.3 2006 Nazar Exp $
// $Id: modinfo.php,v 1.4 2006 GibaPhp Exp $
// Module Info

// The name directory module
define('_MI_POLLS_DIRNAME',"xicpoll"); // warning, name of directory for install module.

// The name of this module
define('_MI_POLLS_NAME',"Polls");

// A brief description of this module
define('_MI_POLLS_DESC',"Shows a poll/survey block");

// A Brief description of Extra Blocks. GibaPhp
define('_MI_POLLS_BDESC_02',"02-Block of Poll");
define('_MI_POLLS_BDESC_03',"03-Block of Poll");
define('_MI_POLLS_BDESC_04',"04-Block of Poll");

// Names of blocks for this module (Not all module has blocks)
define('_MI_POLLS_BNAME1',"Polls");

// Extra blocks - GibaPhp
define('_MI_POLLS_BNAME_02',"Vote block 02");
define('_MI_POLLS_BNAME_03',"Vote block 03");
define('_MI_POLLS_BNAME_04',"Vote block 04");

// Names of admin menu items
define('_MI_POLLS_ADMENU1',"List Polls");
define('_MI_POLLS_ADMENU2',"Add Poll");

// Module properties - wellwine
define('_MI_POLLS_LOOKUPHOST',"Show hostname instead of IP address");
define('_MI_POLLS_LOOKUPHOSTDESC',"List host names instead of IP addresses in viewing poll log. Since nslookup is used, It might take longer to show names.");

//Module properties - Nazar
define('_MI_POLL_LIMITBYIP',"Restrict voting from the same IP");
define('_MI_POLL_LIMITBYIPD',"Restrict the vote que porventura venha do mesmo IP. Warning, if use it in intranets.");
define('_MI_POLL_LIMITBYUID',"Restricting voting from the same User");
define('_MI_POLL_LIMITBYUIDD',"Restrcting the vote realizado pelo same user.");

?>