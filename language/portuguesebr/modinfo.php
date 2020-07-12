<?php
// $Id: modinfo.php,v 1.2 2003/10/14 13:18:04 wellwine Exp $
// $Id: modinfo.php,v 1.3 2006 Nazar Exp $
// $Id: modinfo.php,v 1.4 2006 GibaPhp Exp $
// Module Info

// The name directory module
//define('_MI_POLLS_DIRNAME',"smartpoll"); // warning, name of directory for install module.
define('_MI_POLLS_DIRNAME',"xicpoll"); // warning, name of directory for install module.

// The name of this module
define('_MI_POLLS_NAME',"Votações");

// A brief description of this module
define('_MI_POLLS_DESC',"Exibe bloco de Enquete/Votação");

// A Brief description of Extra Blocks. GibaPhp
define('_MI_POLLS_BDESC_02',"02-Bloco de Enquete");
define('_MI_POLLS_BDESC_03',"03-Bloco de Enquete");
define('_MI_POLLS_BDESC_04',"04-Bloco de Enquete");


// Names of blocks for this module (Not all module has blocks)
define('_MI_POLLS_BNAME1',"Votação");

// Extra blocks - GibaPhp
define('_MI_POLLS_BNAME_02',"Votação bloco 02");
define('_MI_POLLS_BNAME_03',"Votação bloco 03");
define('_MI_POLLS_BNAME_04',"Votação bloco 04");

// Names of admin menu items
define('_MI_POLLS_ADMENU1',"Listar Votações");
define('_MI_POLLS_ADMENU2',"Incluir votação");

// Module properties - wellwine
define('_MI_POLLS_LOOKUPHOST',"Mostrar hostname de acesso do endereço IP");
define('_MI_POLLS_LOOKUPHOSTDESC',"Lista o nome do host e endereço IP durante a visualização do log da enquete. Since nslookup is used, isto poderá gerar um retardo grande para mostrar os nomes.");

//Module properties - Nazar
define("_MI_POLL_LIMITBYIP","Restringir voto a partir do mesmo IP");
define("_MI_POLL_LIMITBYIPD","Restringe o voto que porventura venha do mesmo IP. Cuidado quando usar em intranets.");
define("_MI_POLL_LIMITBYUID","Restringir voto a partir do mesmo Usuario");
define("_MI_POLL_LIMITBYUIDD","Restringe o voto realizado pelo mesmo usuário.");

?>
