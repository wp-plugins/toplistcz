<?php
/*
Plugin Name: TopList.cz
Plugin URI: http://www.honza.info/category/wordpress/
Description: Widget for easy integration of TopList.cz, popular Czech website visit statistics server.
Version: 3.0
Author: Honza Skýpala
Author URI: http://www.honza.info
*/

/*  
	Copyright 2009  Honza Skýpala  (email : honza@live.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

class TopList_CZ_Widget extends WP_Widget {
	function TopList_CZ_Widget() {
		$widget_ops = array('classname' => 'widget_toplist_cz',
												'description' => __('Integrates TopList.cz statistics into your blog', 'toplistcz') );
		$control_ops = array('width' => 380, 'height' => 500);
		parent::WP_Widget('toplist_cz', 'TopList.cz', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance){
		extract($args);
		
		$toplist_server     = empty($instance['server'])     ? 'toplist.cz' : $instance['server'];
		$toplist_link       = empty($instance['link'])       ? 'homepage'   : $instance['link'];
		$toplist_logo       = empty($instance['logo'])       ? ''           : $instance['logo'];
		$toplist_id         = empty($instance['id'])         ? '1'          : $instance['id'];
		$toplist_referrer   = empty($instance['referrer'])   ? ''           : $instance['referrer'];
		$toplist_resolution = empty($instance['resolution']) ? ''           : $instance['resolution'];
		$toplist_depth      = empty($instance['depth'])      ? ''           : $instance['depth'];
		$toplist_pagetitle  = empty($instance['pagetitle'])  ? ''           : $instance['pagetitle'];

    $title='';
    echo $before_widget.$before_title.$title.$after_title;

    if ($toplist_logo=='text') {
    	echo '<ilayer left=1 top=1 src="http://'.$toplist_server.'/count.asp?id='.$toplist_id.'&logo=text" width="88" heigth="31"><iframe src="http://'.$toplist_server.'/count.asp?id='.$toplist_id.'&logo=text" scrolling=no style="width: 88px;height: 31px;"></iframe></ilayer>';
    } else {
	  	$width = "88";
	  	$height = "31";
	    switch ($toplist_logo) {
	    case 'mc':
	    	$height = "60";
	    	break;
	    case 'bc':
	    	$height = "120";
	    	break;
	    case 'btn':
		   	$width = "80";
	    	$height = "15";
	    	break;
	    case 's':
		   	$width = "14";
	    	$height = "14";
	    	break;
	    }
	    switch ($toplist_logo) {
	    case '1':
	    case '2':
	    case '3':
	    case 'counter':
	    case 'mc':
	    case 'bc':
	    case 'btn':
	    case 's':
	    	$imgsrc="http://".$toplist_server."/count.asp?logo=".$toplist_logo."&";
	    	break;
	    case 'blank':
	    	$imgsrc="http://".$toplist_server."/dot.asp?";
	    	$width = "1";
	    	$height = "1";
	    	break;
	    default:
	    	$imgsrc="http://".$toplist_server."/count.asp?";
	    	break;
	  	}	
	  	if ($toplist_link == 'stats') {
	  		$link = 'http://www.'.$toplist_server.'/stat/'.$toplist_id;
	  	} else {
	  		$link = 'http://www.'.$toplist_server.'/';
	  	}
	  	$as = '<a href="'.$link.'" target="_top">';
	  	$ae = '</a>';
	  	$imgurl = $imgsrc.'id='.$toplist_id;
  		$imgs = '<img src="'.$imgurl;
  		$imge = '" alt="TOPlist" border="0" width="'.$width.'" height="'.$height.'" />';
	  	$img = $imgs.$imge;
	  	$js = $nse = '';
	  	if ($toplist_referrer!='' || $toplist_resolution!='' || $toplist_depth!='' || $toplist_pagetitle!='') {
	  		$jss = '<script language="JavaScript" type="text/javascript">'."\n<!--\ndocument.write('";
	  		$jse = "');\n//--></script><noscript>";
	  		$nse = '</noscript>';
	  		$jsimg = $imgs;
		  	if ($toplist_referrer   != '') $jsimg .= '&http=\'+escape(document.referrer)+\'';
		  	if ($toplist_resolution != '') $jsimg .= '&wi=\'+escape(window.screen.width)+\'&he=\'+escape(window.screen.height)+\'';
		  	if ($toplist_depth      != '') $jsimg .= '&cd=\'+escape(window.screen.colorDepth)+\'';
		  	if ($toplist_pagetitle  != '') $jsimg .= '&t=\'+escape(document.title)+\'';
		  	$js = $jss.$jsimg.$imge.$jse;
	  	}
	  	echo $as;
	  	echo $js;
	  	echo $img;
	  	echo $nse;
	  	echo $ae;
  	}
    echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
    $instance = $old_instance;
    $instance['server']     = strip_tags(stripslashes($new_instance['server']));
    $instance['link']       = strip_tags(stripslashes($new_instance['link']));
    $instance['logo']       = strip_tags(stripslashes($new_instance['logo']));
    $instance['id']         = strip_tags(stripslashes($new_instance['title']));
    $instance['title']      = strip_tags(stripslashes($new_instance['title']));
    $instance['referrer']   = strip_tags(stripslashes($new_instance['referrer']));
    $instance['resolution'] = strip_tags(stripslashes($new_instance['resolution']));
    $instance['depth']      = strip_tags(stripslashes($new_instance['depth']));
    $instance['pagetitle']  = strip_tags(stripslashes($new_instance['pagetitle']));

  	return $instance;
	}
	
	function form($instance){
    //Defaults
    $instance = wp_parse_args( (array) $instance, array('server'=>'toplist.cz', 
                                                        'link'=>'homepage',
                                                        'logo'=>'',
                                                        'id'=>'',
                                                        'title'=>'',
                                                        'referrer'=>'',
                                                        'resolution'=>'',
                                                        'depth'=>'',
                                                        'pagetitle'=>'') );

    $toplist_server     = htmlspecialchars($instance['server']);
    $toplist_link       = htmlspecialchars($instance['link']);
    $toplist_logo       = htmlspecialchars($instance['logo']);
    $toplist_id         = htmlspecialchars($instance['title']);
    $toplist_title      = htmlspecialchars($instance['title']);
    $toplist_referrer   = htmlspecialchars($instance['referrer']);
    $toplist_resolution = htmlspecialchars($instance['resolution']);
    $toplist_depth      = htmlspecialchars($instance['depth']);
    $toplist_pagetitle  = htmlspecialchars($instance['pagetitle']);

		// server choice input
		echo '<table><tr><td><label for="' . $this->get_field_name('server') . '">';
		_e('Server', 'toplistcz');
		echo ': </label></td>';
		echo '<td><input id="' . $this->get_field_id('server') . '" name="' . $this->get_field_name('server') . '" type="radio" value="toplist.cz"'.($toplist_server=='toplist.cz'?' checked':'').'>toplist.cz</input></td>';
		echo '</tr><tr>';
		echo '<td></td>';
		echo '<td><input id="' . $this->get_field_id('server') . '" name="' . $this->get_field_name('server') . '" type="radio" value="toplist.sk"'.($toplist_server=='toplist.sk'?' checked':'').'>toplist.sk</input></td>';
		echo '</tr></table><hr />';

		// toplist ID input
		echo '<p><label for="' . $this->get_field_name('title') . '">'.str_replace('toplist', 'TopList', $toplist_server).' ID: </label><input id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="'.intval($toplist_id).'" size="7" /></p>'."\n";
		echo '<p><em>'.str_replace('%server%', $toplist_server, __('Your ID on <a href="http://www.%server%" target="_blank">www.%server%</a> server. If you don\'t have one yet, please <a href="http://www.%server%/edit/?a=e" target="_blank">register</a>.', 'toplistcz')).'</em></p><hr />';
		
		// logo selection
		echo '<table><tr>';
		echo '<td><label for="' . $this->get_field_name('logo') . '">';
		_e('Logo', 'toplistcz');
		echo ':&nbsp;</label></td>';
		echo '<td><input id="' . $this->get_field_id('logo') . '" name="' . $this->get_field_name('logo') . '" type="radio" value=""'.($toplist_logo==''?' checked':'').' /></td><td><img src="http://i.toplist.cz/img/logo.gif" width="88" height="31" /></td>';
		echo '<td>&nbsp;</td>';
		echo '<td><input id="' . $this->get_field_id('logo') . '" name="' . $this->get_field_name('logo') . '" type="radio" value="1"'.($toplist_logo=='1'?' checked':'').' /></td><td style="background-color: black;"><img src="http://i.toplist.cz/img/logo1.gif" width="88" height="31" /></td>';
		echo '<td>&nbsp;</td>';
		echo '<td><input id="' . $this->get_field_id('logo') . '" name="' . $this->get_field_name('logo') . '" type="radio" value="2"'.($toplist_logo=='2'?' checked':'').' /></td><td><img src="http://i.toplist.cz/img/logo2.gif" width="88" height="31" /></td>';
		echo "</tr><tr><td></td>";
		echo '<td><input id="' . $this->get_field_id('logo') . '" name="' . $this->get_field_name('logo') . '" type="radio" value="3"'.($toplist_logo=='3'?' checked':'').' /></td><td><img src="http://i.toplist.cz/img/logo3.gif" width="88" height="31" /></td>';
		echo '<td>&nbsp;</td>';
		echo '<td><input id="' . $this->get_field_id('logo') . '" name="' . $this->get_field_name('logo') . '" type="radio" value="blank"'.($toplist_logo=='blank'?' checked':'').' /></td><td style="text-align: center">'.__('nothing', 'toplistcz').'</td>';
		echo '<td>&nbsp;</td>';
		echo '<td><input id="' . $this->get_field_id('logo') . '" name="' . $this->get_field_name('logo') . ' "type="radio" value="text"'.($toplist_logo=='text'?' checked':'').' /></td><td style="text-align: center"><font size ="2"><b>867314</b><br /><font size="1"><a href="http://www.'.$toplist_server.'" target="_top"><b>www.'.$toplist_server.'<b></a></font></td>';
		echo "</tr><tr><td></td>";
		echo '<td><input id="' . $this->get_field_id('logo') . '" name="' . $this->get_field_name('logo') . '" type="radio" value="counter"'.($toplist_logo=='counter'?' checked':'').' /></td><td><img src="http://www.'.$toplist_server.'/images/counter.asp?s=904182" width="88" height="31" /></td>';
		echo '<td>&nbsp;</td>';
		echo '<td><input id="' . $this->get_field_id('logo') . '" name="' . $this->get_field_name('logo') . '" type="radio" value="btn"'.($toplist_logo=='btn'?' checked':'').' /></td><td style="text-align: center"><img src="http://www.'.$toplist_server.'/images/counter.asp?a=btn&amp;s=722890" width="80" height="15" /></td>';
		echo '<td>&nbsp;</td>';
		echo '<td><input id="' . $this->get_field_id('logo') . '" name="' . $this->get_field_name('logo') . '" type="radio" value="s"'.($toplist_logo=='s'?' checked':'').' /></td><td style="text-align: center"><img src="http://i.'.$toplist_server.'/img/sqr.gif" width="14" height="14" /></td>';
		echo "</tr><tr><td></td>";
		echo '<td><input id="' . $this->get_field_id('logo') . '" name="' . $this->get_field_name('logo') . '" type="radio" value="mc"'.($toplist_logo=='mc'?' checked':'').' /></td><td><img src="http://www.'.$toplist_server.'/images/counter.asp?a=mc&amp;ID=1" width="88" height="60" /></td>';
		echo '<td>&nbsp;</td>';
		echo '<td><input id="' . $this->get_field_id('logo') . '" name="' . $this->get_field_name('logo') . '" type="radio" value="bc"'.($toplist_logo=='bc'?' checked':'').' /></td><td><img src="http://www.'.$toplist_server.'/images/counter.asp?a=bc&amp;ID=1" width="88" height="120" /></td>';
		echo '</tr></table><hr />';
		
		// monitoring details settings
		echo '<p><input id="' . $this->get_field_id('referrer') . '" name="' . $this->get_field_name('referrer') . '" type="checkbox" '.($toplist_referrer!=''?'checked ':'').' />';
		echo ' <label for="' . $this->get_field_name('referrer') . '">';
		_e('Monitor where visitors came from', 'toplistcz');
		echo '</label><br />';
		echo '<input id="' . $this->get_field_id('resolution') . '" name="' . $this->get_field_name('resolution') . '" type="checkbox" '.($toplist_resolution!=''?'checked ':'').' />';
		echo ' <label for="' . $this->get_field_name('resolution') . '">';
		_e('Monitor browser graphical resolution', 'toplistcz');
		echo '</label><br />';
		echo '<input id="' . $this->get_field_id('depth') . '" name="' . $this->get_field_name('depth') . '" type="checkbox" '.($toplist_depth!=''?'checked ':'').' />';
		echo ' <label for="' . $this->get_field_name('depth') . '">';
		_e('Monitor color depth', 'toplistcz');
		echo '</label><br />';
		echo '<input id="' . $this->get_field_id('pagetitle') . '" name="' . $this->get_field_name('pagetitle') . '" type="checkbox" '.($toplist_pagetitle!=''?'checked ':'').' />';
		echo ' <label for="' . $this->get_field_name('pagetitle') . '">';
		_e('Record webpage title', 'toplistcz');
		echo '</label></p>';
		echo '<hr />';
		
		// hyperlink settings
		echo '<table><tr><td><label for="' . $this->get_field_name('link') . '">';
		_e('Link', 'toplistcz');
		echo ': </label></td>';
		echo '<td><input id="' . $this->get_field_id('link') . '" name="' . $this->get_field_name('link') . '" type="radio" value="homepage"'.($toplist_link=='homepage'?' checked':'').'>'.$toplist_server.'</input></td>';
		echo '</tr><tr>';
		echo '<td></td>';
		echo '<td><input id="' . $this->get_field_id('link') . '" name="' . $this->get_field_name('link') . '" type="radio" type="radio" value="stats"'.($toplist_link=='stats'?' checked':'').'>'.__('Detailed statistics', 'toplistcz').'</input></td>';
		echo '</tr></table>';
	}
}

function toplist_cz_init() {
	register_widget('TopList_CZ_Widget');
}
function toplist_cz_textdomain() {
	$plugin_dir = basename(dirname(__FILE__));
	load_plugin_textdomain('toplistcz', false, $plugin_dir);
}

add_action('widgets_init', 'toplist_cz_init');
add_action('init', 'toplist_cz_textdomain');
?>