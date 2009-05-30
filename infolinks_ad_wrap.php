<?php
/*
Plugin Name: Infolinks Ad Wrap
Plugin URI: http://rubayathasan.com/wordpress/plugin/infolinks-ad-wrap-wordpress-plugin/
Description: Simple plugin to add infolinks ad to a wordpress web site.
Version: 1.0.2
Author: Rubayat Hasan
Author URI: http://rubayathasan.com/


Copyright 2009  Rubayat Hasan (Contact: http://rubayathasan.com/contact/ )

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
// set default values on install
function infolinks_ad_wrap_install() {
	if(get_option('infolinks_wrap_content')=="") {
    	update_option('infolinks_wrap_content', "Yes"); // wrap content by default
		update_option('infolinks_wrap_comment', "No");
  	}
}

add_action("activate_infolinks_ad_wrap/infolinks_ad_wrap.php", "infolinks_ad_wrap_install");

//add infolinks menu to the wordpress options menu
function infolinks_add_options(){
  if(function_exists('add_options_page')){
    add_options_page('Infolinks Ad Wrap', 'Infolinks Ad Wrap', 9, basename(__FILE__), 'infolinks_options_subpanel');
  }
}

//validate options
switch($_POST['infolinks_action']){
	case 'Save':
	 	if($_POST['infolinks_wrap_content'] == "on") update_option('infolinks_wrap_content', "Yes");
	  	else update_option('infolinks_wrap_content', "No");
	  	if($_POST['infolinks_wrap_comment'] == "on") update_option('infolinks_wrap_comment', "Yes");
	  	else update_option('infolinks_wrap_comment', "No");
	  	
	  	if($_POST['infolinks_script'] != "") {
            update_option('infolinks_script', stripslashes($_POST['infolinks_script']));
        }
	  	//else update_option('infolinks_wrap_comment', "No");
	  	break;
}

//option panel
function infolinks_options_subpanel(){
?>
<div class="wrap"> 
  	<h2>Infolinks Ad Wrap Options</h2> 
  	<form name="form1" method="post">
		<fieldset class="options">
			<legend>Options</legend>
			<INPUT TYPE=CHECKBOX NAME="infolinks_wrap_content" <?php if(get_option('infolinks_wrap_content')=="Yes") echo "CHECKED=on"; ?>>Wrap Content<BR><BR>
			<INPUT TYPE=CHECKBOX NAME="infolinks_wrap_comment" <?php if(get_option('infolinks_wrap_comment')=="Yes") echo "CHECKED=on"; ?>>Wrap Comment<BR><br>
			
			Add the infolinks lines below along with any customization.<br>
			<textarea style="width: 650px; height: 200px;" name="infolinks_script"><?php echo htmlspecialchars(get_option('infolinks_script')) ?></textarea>
			<br>
		</fieldset>
		<br />
		<input type="submit" name="infolinks_action" value="Save" />
	</form>
</div>

<?php
}


add_action('admin_menu', 'infolinks_add_options');

// main functionality
function infolinks_ad_wrap ($text)
{
	return '<!--INFOLINKS_ON-->'.$text.'<!--INFOLINKS_OFF-->';
}

// main functionality
function infolinks_ad_script ($text)
{
	print get_option('infolinks_script');
}

if(get_option('infolinks_wrap_content') == "Yes")
	add_filter ('the_content', 'infolinks_ad_wrap');

if(get_option('infolinks_wrap_comment') == "Yes")
	add_filter ('comment_text', 'infolinks_ad_wrap');
	
add_action('wp_footer', 'infolinks_ad_script');
	
	
?>