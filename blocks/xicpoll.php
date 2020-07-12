<?php
### =============================================================
### Xoopers - Atendendo a todos os sabores de Xoops
### =============================================================
### Página Principal do Módulo
### =============================================================
### Developer: Gilberto G. de Oliviera Aka GibaPhp
### Info: Este módulo é baseado no XoopsPoll de OnoKazu
### =============================================================
### WebSite: www.xoopers.org
### =============================================================
### $Id: blocks/xicpoll.php,v 1.0 2008/01/03 19:00:00 GibaPhp Exp $
### =============================================================
// $Id: xoopspoll.php,v 1.8 2004/12/26 19:12:12 onokazu Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
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
$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;

include_once XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/class/xicpoll.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/class/xicpolllog.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/class/xicpolloption.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/language/'.$xoopsConfig['language'].'/main.php';

// GibaPhp - Compatible = Hacked by wellwine<br />(http://wellwine.net/)";
function hasVoted($poll_id) {
    global $_COOKIE;
    global $xoopsUser;
    $voted_polls = (!empty($_COOKIE['voted_polls'])) ? $_COOKIE['voted_polls'] : array();
    if ( empty($voted_polls[$poll_id]) ) {
        if (is_object($xoopsUser)) {
            $uid = $xoopsUser->getVar('uid');
        } else {
            $uid = null;
        }
        if ( xicpollLog::hasVoted($poll_id, xoops_getenv('REMOTE_ADDR'), $uid) ) {
            setcookie("voted_polls[$poll_id]", 1, 0);
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function b_xicpoll_show($optionsx)
{
    $NumPool      = $optionsx[0];    // GibaPhp - Id da enquete que deverá ser mostrada.
    $ViewResults  = $optionsx[1];    // GibaPhp - 1 = Yes , 0 = no for view results in vote.
    
    $show_result  = ($optionsx[2]==1)?true:false; // GibaPhp - Compatible = Hacked by wellwine<br />(http://wellwine.net/)";
    $show_percent = ($optionsx[3]==1)?true:false; // GibaPhp - Compatible = Hacked by wellwine<br />(http://wellwine.net/)";
    $show_bar     = ($optionsx[4]==1)?true:false; // GibaPhp - Compatible = Hacked by wellwine<br />(http://wellwine.net/)";

	$block = array();

    // GibaPhp - if $NumPool = 0 (Poll / survey normal.)
    // Else - Multi-survey / poll - blocks extra.
    if ($NumPool < 1) {
	   $polls =& xicpoll::getAll(array('display=1'), true, 'weight ASC, end_time DESC');
    } else {
	   $polls =& xicpoll::getAll(array('display=1','poll_id='.$NumPool), true, 'weight ASC, end_time DESC');
    }

	$count = count($polls);

	$block['lang_vote']         = _PL_VOTE;
	$block['lang_results']      = _PL_RESULTS;
	$block['lang_view_results'] = $ViewResults;

    // GibaPhp - Compatible = Hacked by wellwine<br />(http://wellwine.net/)";

 	$block['lang_show_result']  = $show_result;
	$block['lang_show_percent'] = $show_percent;
	$block['lang_show_bar']     = $show_bar;

    $mydirname = basename( dirname( dirname( __FILE__ ) ) ) ; // diretório raiz do módulo. Directory root module.
	$block['folder_module']     = $mydirname; //add name diretory module. GibaPhp
	

    for ($i = 0; $i < $count; $i++) {
        $options_arr =& xicpollOption::getAllByPollId($polls[$i]->getVar('poll_id'));
        $expired = $polls[$i]->hasExpired();

        if (($expired || hasVoted($polls[$i]->getVar('poll_id'))) && $show_result) {
            $total = $polls[$i]->getVar("votes");
            foreach ($options_arr as $option) {
                if ( $total > 0 ) {
                    $percent = 100 * $option->getVar("option_count") / $total;
                } else {
                    $percent = 0;
                }
                if ( intval($percent) > 0 && $show_bar) {
                    $width = intval($percent);
                    $img = "<img src='".XOOPS_URL."/modules/".$mydirname."/images/colorbars/".$option->getVar("option_color", "E")."' height='14' width='".$width."%' align='middle' alt='".intval($percent)." %' />";
                } else {
                    $img ='';
                }
                if ($show_percent) {
                    $percent = sprintf("%d%%", $percent);
                } else {
                    $percent = '';
                }
                $options[] = array(
                                   'percent' => $percent,
                                   'image'   => $img,
                                   'text'    => $option->getVar('option_text'));
            }
            $poll = array(
                          'expired'  => 1,
                          'id'       => $polls[$i]->getVar('poll_id'),
                          'question' => $polls[$i]->getVar('question'),
                          'options'  => $options);

        } else {
            $option_type = 'radio';
            $option_name = 'option_id';
            if ($polls[$i]->getVar('multiple') == 1) {
                $option_type = 'checkbox';
                $option_name .= '[]';
            }
            foreach ($options_arr as $option) {
                $options[] = array(
                                   'id'   => $option->getVar('option_id'),
                                   'text' => $option->getVar('option_text'));
            }
            $poll = array(
                          'expired' => 0,
                          'id'          => $polls[$i]->getVar('poll_id'),
                          'question'    => $polls[$i]->getVar('question'),
                          'option_type' => $option_type,
                          'option_name' => $option_name,
                          'options'     => $options);

        }

        $block['polls'][] =& $poll;

        unset($NumPool); // GibaPhp
		unset($options);
		unset($poll);
    }

    return $block;

}


function b_xicpoll_edit($options)
{
   /**
    * $options[0] = ID for poll
    * $options[1] = View result in page Poll
    * $options[2] = show result if expired or voted (1=yes)
    * $options[3] = show percent (1=yes)
    * $options[4] = show bar (1=yes)
    */
    $form .= _BL_POLLS_ID_POOLS." <input type='text' name='options[]' value='".$options[0]."' size=5 />";

    $form .= "<br />" . _BL_POLLS_VIEW_RESULT_IN_POLLS."<input type=\"radio\" name=\"options[1]\" value=\"1\"";
    if ($options[1] == 1) $form .= " checked=\"checked\"";
    $form .= " />"._YES."<input type=\"radio\" name=\"options[1]\" value=\"0\"";
    if ($options[1] == 0) $form .= " checked=\"checked\"";
    $form .= " />"._NO;

    $form .= "<br />" . _BL_POLL_EDIT_SHOWRESULTS."<input type=\"radio\" name=\"options[2]\" value=\"1\"";
    if ($options[2] == 1) $form .= " checked=\"checked\"";
    $form .= " />"._YES."<input type=\"radio\" name=\"options[2]\" value=\"0\"";
    if ($options[2] == 0) $form .= " checked=\"checked\"";
    $form .= " />"._NO;

    $form .= "<br />" . _BL_POLL_EDIT_SHOWPERCENT."<input type=\"radio\" name=\"options[3]\" value=\"1\"";
    if ($options[3] == 1) $form .= " checked=\"checked\"";
    $form .= " />"._YES."<input type=\"radio\" name=\"options[3]\" value=\"0\"";
    if ($options[3] == 0) $form .= " checked=\"checked\"";
    $form .= " />"._NO;

    $form .= "<br />" . _BL_POLL_EDIT_SHOWBAR."<input type=\"radio\" name=\"options[4]\" value=\"1\"";
    if ($options[4] == 1) $form .= " checked=\"checked\"";
    $form .= " />"._YES."<input type=\"radio\" name=\"options[4]\" value=\"0\"";
    if ($options[4] == 0) $form .= " checked=\"checked\"";
    $form .= " />"._NO;

    $form .= "<br />";
	return $form;
}


?>