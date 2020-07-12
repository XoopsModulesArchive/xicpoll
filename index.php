<?php
### =============================================================
### Xoopers - Atendendo a todos os sabores de Xoops
### =============================================================
### P�gina Principal do M�dulo
### =============================================================
### Developer: Gilberto G. de Oliviera Aka GibaPhp
### Info: Este m�dulo � baseado no XoopsPoll de OnoKazu
### =============================================================
### WebSite: www.xoopers.org
### =============================================================
### $Id: index.php,v 1.0 2008/01/03 19:00:00 GibaPhp Exp $
### =============================================================

// $Id: index.php,v 1.12 2004/12/26 19:12:13 onokazu Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
include "../../mainfile.php";

$mydirname = basename( dirname(  __FILE__ ) ) ; // diret�rio raiz do m�dulo. Directory root module.

include XOOPS_ROOT_PATH."/modules/".$mydirname."/include/constants.php";
include_once XOOPS_ROOT_PATH."/modules/".$mydirname."/class/xicpoll.php";
include_once XOOPS_ROOT_PATH."/modules/".$mydirname."/class/xicpolloption.php";
include_once XOOPS_ROOT_PATH."/modules/".$mydirname."/class/xicpolllog.php";
include_once XOOPS_ROOT_PATH."/modules/".$mydirname."/class/xicpollrenderer.php";

if ( !empty($_POST['poll_id']) ) {
	$poll_id = intval($_POST['poll_id']);
} elseif (!empty($_GET['poll_id'])) {
	$poll_id = intval($_GET['poll_id']);
}

if ( empty($poll_id) ) {
	$xoopsOption['template_main'] = 'xicpoll_index.html';
	include XOOPS_ROOT_PATH."/header.php";
	$limit = (!empty($_GET['limit'])) ? intval($_GET['limit']) : 50;
	$start = (!empty($_GET['start'])) ? intval($_GET['start']) : 0;
    $xoopsTpl->assign('lang_pollslist', _PL_POLLSLIST);
    $xoopsTpl->assign('lang_pollquestion' , _PL_POLLQUESTION);
    $xoopsTpl->assign('lang_pollvoters', _PL_VOTERS);
    $xoopsTpl->assign('lang_votes', _PL_VOTES);
    $xoopsTpl->assign('lang_expiration', _PL_EXPIRATION);
    $xoopsTpl->assign('lang_results', _PL_RESULTS);
	$xoopsTpl->assign('folder_module', $mydirname); //add name diretory module. GibaPhp
	// add 1 to $limit to know whether there are more polls
	$polls_arr =& xicpoll::getAll(array(), true, "weight ASC, end_time DESC", $limit+1, $start);
	$polls_count = count($polls_arr);
	$max = ( $polls_count > $limit ) ? $limit : $polls_count;
	for ( $i = 0; $i < $max; $i++ ) {
	$polls = array();
    $polls['pollId'] = $polls_arr[$i]->getVar("poll_id");
		if ( $polls_arr[$i]->getVar("end_time") > time() ) {
            $polls['pollEnd'] = formatTimestamp($polls_arr[$i]->getVar("end_time"),"m");
			$polls['pollQuestion'] = "<a href='index.php?poll_id=".$polls_arr[$i]->getVar("poll_id")."'>".$polls_arr[$i]->getVar("question")."</a>";
		} else {
			$polls['pollEnd'] = "<span style='color:#ff0000;'>"._PL_EXPIRED."</span>";
			$polls['pollQuestion'] = $polls_arr[$i]->getVar("question");
		}
	$polls['pollVoters'] = $polls_arr[$i]->getVar("voters");
    $polls['pollVotes'] = $polls_arr[$i]->getVar("votes");
	$xoopsTpl->append('polls', $polls);
	unset($polls);
	}
	include XOOPS_ROOT_PATH."/footer.php";
} elseif ( !empty($_POST['option_id']) ) {
	$voted_polls = (!empty($_COOKIE['voted_polls'])) ? $_COOKIE['voted_polls'] : array();
	$mail_author = false;
	$poll = new xicpoll($poll_id);
	if ( !$poll->hasExpired() ) {
		if ( empty($voted_polls[$poll_id]) ) {
			if ( $xoopsUser ) {
				if ( xicpollLog::hasVoted($poll_id, xoops_getenv('REMOTE_ADDR'), $xoopsUser->getVar("uid")) ) {
					setcookie("voted_polls[$poll_id]", 1, 0);
					$msg = _PL_ALREADYVOTED;
				} else {
					$poll->vote($_POST['option_id'], xoops_getenv('REMOTE_ADDR'), $xoopsUser->getVar("uid"));
					$poll->updateCount();
					setcookie("voted_polls[$poll_id]", 1, 0);
					$msg = _PL_THANKSFORVOTE;
				}
			} else {
				if ( xicpollLog::hasVoted($poll_id, xoops_getenv('REMOTE_ADDR')) ) {
					setcookie("voted_polls[$poll_id]", 1, 0);
					$msg = _PL_ALREADYVOTED;
				} else {
					$poll->vote($_POST['option_id'], xoops_getenv('REMOTE_ADDR'));
					$poll->updateCount();
					setcookie("voted_polls[$poll_id]", 1, 0);
					$msg = _PL_THANKSFORVOTE;
				}
			}
		} else {
			$msg = _PL_ALREADYVOTED;
		}
	} else {
		$msg = _PL_SORRYEXPIRED;
		if ( $poll->getVar("mail_status") != POLL_MAILED ) {
			$xoopsMailer =& getMailer();
			$xoopsMailer->useMail();
            $mydirname = basename( dirname(  __FILE__ ) ) ; // diret�rio raiz do m�dulo. Directory root module.
			$xoopsMailer->setTemplateDir(XOOPS_ROOT_PATH."/modules/".$mydirname."/language/".$xoopsConfig['language']."/mail_template/");
			$xoopsMailer->setTemplate("mail_results.tpl");
			$author = new XoopsUser($poll->getVar("user_id"));
			$xoopsMailer->setToUsers($author);
			$xoopsMailer->assign("POLL_QUESTION", $poll->getVar("question"));
			$xoopsMailer->assign("POLL_START", formatTimestamp($poll->getVar("start_time"), "l", $author->timezone()));
			$xoopsMailer->assign("POLL_END", formatTimestamp($poll->getVar("end_time"), "l", $author->timezone()));
			$xoopsMailer->assign("POLL_VOTES", $poll->getVar("votes"));
			$xoopsMailer->assign("POLL_VOTERS", $poll->getVar("voters"));
			$xoopsMailer->assign("POLL_ID", $poll->getVar("poll_id"));
			$xoopsMailer->assign("SITENAME", $xoopsConfig['sitename']);
			$xoopsMailer->assign("ADMINMAIL", $xoopsConfig['adminmail']);
			$xoopsMailer->assign("SITEURL", $xoopsConfig['xoops_url']."/");

			$xoopsMailer->assign("FOLDER_MODULE", $mydirname); //add name diretory module. GibaPhp

			$xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
			$xoopsMailer->setFromName($xoopsConfig['sitename']);
			$xoopsMailer->setSubject(sprintf(_PL_YOURPOLLAT,$author->uname(),$xoopsConfig['sitename']));
			if ( $xoopsMailer->send() != false ) {
				$poll->setVar("mail_status", POLL_MAILED);
				$poll->store();
			}
		}
	}
	$mydirname = basename( dirname(  __FILE__ ) ) ; // diret�rio raiz do m�dulo. Directory root module.
    redirect_header(XOOPS_URL."/modules/".$mydirname."/pollresults.php?poll_id=$poll_id", 1, $msg);
	exit();
} elseif ( !empty($poll_id) ) {
	$xoopsOption['template_main'] = 'xicpoll_view.html';
	include XOOPS_ROOT_PATH."/header.php";
	$poll = new xicpoll($poll_id);
	$renderer = new xicpollRenderer($poll);
    $renderer->assignForm($xoopsTpl);
    $xoopsTpl->assign('lang_vote' , _PL_VOTE);
    $xoopsTpl->assign('lang_results' , _PL_RESULTS);
    $mydirname = basename( dirname(  __FILE__ ) ) ; // diret�rio raiz do m�dulo. Directory root module.
	$xoopsTpl->assign('folder_module', $mydirname); //add name diretory module. GibaPhp
	include XOOPS_ROOT_PATH."/footer.php";
}
?>