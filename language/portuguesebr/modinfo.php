<?php
// $Id: modinfo.php,v 1.2 2003/10/14 13:18:04 wellwine Exp $
// $Id: modinfo.php,v 1.3 2006 Nazar Exp $
// $Id: modinfo.php,v 1.4 2006 GibaPhp Exp $
// Module Info

// The name directory module
//define('_MI_POLLS_DIRNAME',"smartpoll"); // warning, name of directory for install module.
define('_MI_POLLS_DIRNAME',"xicpoll"); // warning, name of directory for install module.

// The name of this module
define('_MI_POLLS_NAME',"Vota��es");

// A brief description of this module
define('_MI_POLLS_DESC',"Exibe bloco de Enquete/Vota��o");

// A Brief description of Extra Blocks. GibaPhp
define('_MI_POLLS_BDESC_02',"02-Bloco de Enquete");
define('_MI_POLLS_BDESC_03',"03-Bloco de Enquete");
define('_MI_POLLS_BDESC_04',"04-Bloco de Enquete");


// Names of blocks for this module (Not all module has blocks)
define('_MI_POLLS_BNAME1',"Vota��o");

// Extra blocks - GibaPhp
define('_MI_POLLS_BNAME_02',"Vota��o bloco 02");
define('_MI_POLLS_BNAME_03',"Vota��o bloco 03");
define('_MI_POLLS_BNAME_04',"Vota��o bloco 04");

// Names of admin menu items
define('_MI_POLLS_ADMENU1',"Listar Vota��es");
define('_MI_POLLS_ADMENU2',"Incluir vota��o");

// Module properties - wellwine
define('_MI_POLLS_LOOKUPHOST',"Mostrar hostname de acesso do endere�o IP");
define('_MI_POLLS_LOOKUPHOSTDESC',"Lista o nome do host e endere�o IP durante a visualiza��o do log da enquete. Since nslookup is used, isto poder� gerar um retardo grande para mostrar os nomes.");

//Module properties - Nazar
define("_MI_POLL_LIMITBYIP","Restringir voto a partir do mesmo IP");
define("_MI_POLL_LIMITBYIPD","Restringe o voto que porventura venha do mesmo IP. Cuidado quando usar em intranets.");
define("_MI_POLL_LIMITBYUID","Restringir voto a partir do mesmo Usuario");
define("_MI_POLL_LIMITBYUIDD","Restringe o voto realizado pelo mesmo usu�rio.");

?>
