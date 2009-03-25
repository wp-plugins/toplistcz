<?php
/*
Plugin Name: TopList.cz
Plugin URI: http://www.honza.info/category/pocitace/
Description: Widget for easy integration of TopList.cz, popular Czech website visit statistics server.
Version: 0.1
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

### Function: Init TopList.cz Widget
function widget_toplist_cz_init() {
	if (!function_exists('register_sidebar_widget')) {
		return;
	}

	### Function: TopList.cz Widget
	function widget_toplist_cz($args) {
		extract($args);
		$options = get_option('toplist_cz');
    $title='';
    echo $before_widget.$before_title.$title.$after_title;
    if ($options['logo']=='text') {
    	echo '<ilayer left=1 top=1 src="http://toplist.cz/count.asp?id='.$options['id'].'&logo=text" width="88" heigth="31"><iframe src="http://toplist.cz/count.asp?id='.$options['id'].'&logo=text" scrolling=no style="width: 88px;height: 31px;"></iframe></ilayer>';
    } else {
	  	$width = "88";
	  	$height = "31";
	    switch ($options['logo']) {
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
	    switch ($options['logo']) {
	    case '1':
	    case '2':
	    case '3':
	    case 'counter':
	    case 'mc':
	    case 'bc':
	    case 'btn':
	    case 's':
	    	$imgsrc = "http://toplist.cz/count.asp?logo=".$options['logo']."&";
	    	break;
	    case 'blank':
	    	$imgsrc = "http://toplist.cz/dot.asp?";
	    	$width = "1";
	    	$height = "1";
	    	break;
	    default:
	    	$imgsrc = "http://toplist.cz/count.asp?";
	    	break;
	  	}	
	  	$as = '<a href="http://www.toplist.cz/" target="_top">';
	  	$ae = '</a>';
	  	$imgurl = $imgsrc.'id='.$options['id'];
  		$imgs = '<img src="'.$imgurl;
  		$imge = '" alt="TOPlist" border="0" width="'.$width.'" height="'.$height.'" />';
	  	$img = $imgs.$imge;
	  	$js = $nse = '';
	  	if ($options['referrer']!='' || $options['resolution']!='' || $options['depth']!='' || $options['pagetitle']!='') {
	  		$jss = '<script language="JavaScript" type="text/javascript">'."\n<!--\ndocument.write('";
	  		$jse = "');\n//--></script><noscript>";
	  		$nse = '</noscript>';
	  		$jsimg = $imgs;
		  	if ($options['referrer']!='') $jsimg .= '&http=\'+escape(document.referrer)+\'';
		  	if ($options['resolution']!='') $jsimg .= '&wi=\'+escape(window.screen.width)+\'&he=\'+escape(window.screen.height)+\'';
		  	if ($options['depth']!='') $jsimg .= '&cd=\'+escape(window.screen.colorDepth)+\'';
		  	if ($options['pagetitle']!='') $jsimg .= '&t=\'+escape(document.title)+\'';
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

	### Function: TopList.cz Widget Options
	function widget_toplist_cz_options() {
		$options = get_option('toplist_cz');
		if (!is_array($options)) {
			$options = array('id' => '', 'logo' => '', 'referrer' => '', 'resolution' => '', 'depth' => '', 'pagetitle' => '');
		}
		if ($_POST['toplist_cz-submit']) {
			$options['id'] = strip_tags($_POST['toplist_cz-id']);
			$options['logo'] = strip_tags($_POST['toplist_cz-logo']);
			$options['referrer'] = strip_tags($_POST['toplist_cz-referrer']);
			$options['resolution'] = strip_tags($_POST['toplist_cz-resolution']);
			$options['depth'] = strip_tags($_POST['toplist_cz-depth']);
			$options['pagetitle'] = strip_tags($_POST['toplist_cz-pagetitle']);
			update_option('toplist_cz', $options);
		}
		echo '<p><label for="toplist_cz-id">';
		_e('TopList.cz ID', 'toplist_cz');
		echo ': </label><input type="text" id="toplist_cz-id" name="toplist_cz-id" value="'.intval($options['id']).'" size="7" /></p>'."\n";
		echo '<p><em>'.__('Your ID on <a href="http://www.toplist.cz" target="_blank">www.toplist.cz</a> server. If you don\'t have one yet, please <a href="http://www.toplist.cz/edit/?a=e" target="_blank">register</a>.', 'toplist_cz').'</em></p><hr />';
		echo '<table><tr>';
		echo '<td><label for="toplist_cz-logo">';
		_e('Logo', 'toplist_cz');
		echo ':&nbsp;</label></td>';
		echo '<td><input type="radio" name = "toplist_cz-logo" value = ""'.($options['logo']==''?' checked':'').' /></td><td><img src = "http://i.toplist.cz/img/logo.gif" width="88" height="31" /></td>';
		echo '<td>&nbsp;</td>';
		echo '<td><input type="radio" name = "toplist_cz-logo" value = "1"'.($options['logo']=='1'?' checked':'').' /></td><td style="background-color: black;"><img src = "http://i.toplist.cz/img/logo1.gif" width="88" height="31" /></td>';
		echo '<td>&nbsp;</td>';
		echo '<td><input type="radio" name = "toplist_cz-logo" value = "2"'.($options['logo']=='2'?' checked':'').' /></td><td><img src = "http://i.toplist.cz/img/logo2.gif" width="88" height="31" /></td>';
		echo "</tr><tr><td></td>";
		echo '<td><input type="radio" name = "toplist_cz-logo" value = "3"'.($options['logo']=='3'?' checked':'').' /></td><td><img src = "http://i.toplist.cz/img/logo3.gif" width="88" height="31" /></td>';
		echo '<td>&nbsp;</td>';
		echo '<td><input type="radio" name = "toplist_cz-logo" value = "blank"'.($options['logo']=='blank'?' checked':'').' /></td><td style="text-align: center">'.__('nothing', 'toplist_cz').'</td>';
		echo '<td>&nbsp;</td>';
		echo '<td><input type="radio" name = "toplist_cz-logo" value = "text"'.($options['logo']=='text'?' checked':'').' /></td><td style="text-align: center"><font size ="2"><b>867314</b><br /><font size="1"><a href="http://www.toplist.cz" target="_top"><b>www.toplist.cz<b></a></font></td>';
		echo "</tr><tr><td></td>";
		echo '<td><input type="radio" name = "toplist_cz-logo" value = "counter"'.($options['logo']=='counter'?' checked':'').' /></td><td><img src = "http://www.toplist.cz/images/counter.asp?s=904182" width="88" height="31" /></td>';
		echo '<td>&nbsp;</td>';
		echo '<td><input type="radio" name = "toplist_cz-logo" value = "btn"'.($options['logo']=='btn'?' checked':'').' /></td><td style="text-align: center"><img src = "http://www.toplist.cz/images/counter.asp?a=btn&amp;s=722890" width="80" height="15" /></td>';
		echo '<td>&nbsp;</td>';
		echo '<td><input type="radio" name = "toplist_cz-logo" value = "s"'.($options['logo']=='s'?' checked':'').' /></td><td style="text-align: center"><img src = "http://i.toplist.cz/img/sqr.gif" width="14" height="14" /></td>';
		echo "</tr><tr><td></td>";
		echo '<td><input type="radio" name = "toplist_cz-logo" value = "mc"'.($options['logo']=='mc'?' checked':'').' /></td><td><img src = "http://www.toplist.cz/images/counter.asp?a=mc&amp;ID=1" width="88" height="60" /></td>';
		echo '<td>&nbsp;</td>';
		echo '<td><input type="radio" name = "toplist_cz-logo" value = "bc"'.($options['logo']=='bc'?' checked':'').' /></td><td><img src = "http://www.toplist.cz/images/counter.asp?a=bc&amp;ID=1" width="88" height="120" /></td>';
		echo '</tr></table><hr />';
		echo '<p><input type="checkbox" id="toplist_cz-referrer" name="toplist_cz-referrer" '.($options['referrer']!=''?'checked ':'').' />';
		echo ' <label for="toplist_cz-referrer">';
		_e('Monitor where visitors came from', 'toplist_cz');
		echo '</label><br />';
		echo '<input type="checkbox" id="toplist_cz-resolution" name="toplist_cz-resolution" '.($options['resolution']!=''?'checked ':'').' />';
		echo ' <label for="toplist_cz-resolution">';
		_e('Monitor browser graphical resolution', 'toplist_cz');
		echo '</label><br />';
		echo '<input type="checkbox" id="toplist_cz-depth" name="toplist_cz-depth" '.($options['depth']!=''?'checked ':'').' />';
		echo ' <label for="toplist_cz-depth">';
		_e('Monitor color depth', 'toplist_cz');
		echo '</label><br />';
		echo '<input type="checkbox" id="toplist_cz-pagetitle" name="toplist_cz-pagetitle" '.($options['pagetitle']!=''?'checked ':'').' />';
		echo ' <label for="toplist_cz-pagetitle">';
		_e('Record webpage title', 'toplist_cz');
		echo '</label></p>';
		echo '<input type="hidden" id="toplist_cz-submit" name="toplist_cz-submit" value="1" />'."\n";
	}

	register_sidebar_widget('TopList.cz', 'widget_toplist_cz');
	register_widget_control('TopList.cz', 'widget_toplist_cz_options', 415, 500);

}

### Function: Load The WP-DownloadManager Widget
add_action('plugins_loaded', 'widget_toplist_cz_init');

### Create text domain for translations
add_action('init', 'toplist_cz_textdomain');
function toplist_cz_textdomain() {
	$plugin_dir = basename(dirname(__FILE__));
	load_plugin_textdomain('toplist_cz', false, $plugin_dir);
}
?>