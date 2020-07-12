<?php
// Traducción por debianus (http://es.impresscms.org)
// $Id: modinfo.php,v 1.2 2003/10/14 13:18:04 wellwine Exp $
// $Id: modinfo.php,v 1.3 2006 Nazar Exp $
// $Id: modinfo.php,v 1.4 2006 GibaPhp Exp $
// Module Info

// The name directory module
define('_MI_POLLS_DIRNAME',"xicpoll"); // warning, name of directory for install module.

// The name of this module
define("_MI_POLLS_NAME","Votaciones");

// A brief description of this module
define('_MI_POLLS_DESC',"Gestión de votaciones");

// A Brief description of Extra Blocks. GibaPhp
define('_MI_POLLS_BDESC_02',"Votaciones-bloque02");
define('_MI_POLLS_BDESC_03',"Votaciones-bloque03");
define('_MI_POLLS_BDESC_04',"Votaciones-bloque04");

// Names of blocks for this module (Not all module has blocks)
define('_MI_POLLS_BNAME1',"Votaciones");

// Extra blocks - GibaPhp
define('_MI_POLLS_BNAME_02',"Votaciones-bloque 02");
define('_MI_POLLS_BNAME_03',"Votaciones-bloque 03");
define('_MI_POLLS_BNAME_04',"Votaciones-bloque 04");

// Names of admin menu items
define("_MI_POLLS_ADMENU1","Listar las votaciones");
define("_MI_POLLS_ADMENU2","Agregar una votacion");
// Module properties - wellwine
define('_MI_POLLS_LOOKUPHOST',"Mostrar el nombre del 'host' en lugar de la dirección IP");
define('_MI_POLLS_LOOKUPHOSTDESC',"Relaciona los nombres de los 'hosts' en lugar de las direcciones IP en los registros de las votaciones. Dado que se usa 'nslookup', puede llevar cierto tiempo el mostrar los nombres.");

//Module properties - Nazar
define('_MI_POLL_LIMITBYIP',"Restringir los votos procedentes de la misma IP");
define('_MI_POLL_LIMITBYIPD',"Restringe los votos que tengan su origen en la misma IP. Tenga cuidado en caso de usar esta opción si hay votantes en una misma intranet.");
define('_MI_POLL_LIMITBYUID',"Evitar que un mismo usuario vote más de una vez");
define('_MI_POLL_LIMITBYUIDD',"Impide que el mismo usuario pueda votar dos o más veces.");
?>
