<?php
/*
Plugin Name: Click to Call or Chat Buttons
Plugin URI: https://www.digitalblue.ro/click-to-call-or-chat-buttons/
Description: Mobile visitors will see a call or chat button in your website 
Version: 1.5.0
Author: DIGITALBLUE
Author URI: https://www.digitalblue.ro
License: GPL2
*/
/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2020 DIGITALBLUE
*/
?>
<?php


define('CTCOCB_VERSION','1.5.0');
define('CTCOCB_BASENAME', plugin_basename( __FILE__ ) );
define('CTCOCB_BASEFOLDER', plugin_basename( dirname( __FILE__ ) ) );
define('CTCOCB_FILENAME', str_replace(CTCOCB_BASEFOLDER.'/', '', CTCOCB_BASENAME ) );
require_once("ctcocb-svg.php");
add_action('wp_enqueue_scripts', 'ctcocb_front_styling' );
add_action('admin_menu', 'register_ctcocb_page');
add_action('admin_init', 'ctcocb_options_init');
add_filter( 'plugin_row_meta', 'ctcocb_plugin_row_meta', 10, 2 );
add_filter( 'plugin_action_links_'. CTCOCB_BASENAME, 'ctcocb_plugin_add_settings_link' );
if(isset($_GET['page']) && strpos($_GET['page'], 'ctcocb') !== false) {
	add_action( 'admin_enqueue_scripts', 'ctcocb_enqueue_color_picker' );
}
$ctcocb_options = ctcocb_get_options();
$ctcocb_plugin_title = apply_filters( 'ctcocb_plugin_title',  'Click to Call or Chat Buttons');
function ctcocb_settings_page() { 
	global $ctcocb_options;
	?>

	<div class="wrap">	
		<h1><?php __("Click to Call or Chat Buttons");?><span class="version">v<?php echo CTCOCB_VERSION;?></span></h1>
		<?php 
		if($ctcocb_options['activePlugin']==0) {
			echo '<div class="notice-error notice"><p>The Click to Call or Chat Button is currently <b>inactive</b>.</p></div>';
		}
		?>

	<form method="post" action="options.php" class="ctcocb-container">
		<?php settings_fields('ctcocb_options'); ?>
		<table class="form-table">
			<tr>
				<th>
					<h3>General</h3>
				</th>
			</tr>
			<tr>
				<th>Buttons status:</th>
				<td>
					<input name="ctcocb[activePlugin]" type="checkbox" value="1" <?php checked('1', $ctcocb_options['activePlugin']); ?> /> <label title="Enable" for="activated">Active</label> 
				</td>
			</tr>
			<tr>
				<th>Phone number to call:</th>
				<td><input type="text" name="ctcocb[numberPhone]" value="<?php echo $ctcocb_options['numberPhone']; ?>" /></td>
			</tr>
			<tr>
				<th>Phone number(or text) to display:</th>
				<td>
					<input type="text" name="ctcocb[textPhone]" value="<?php echo $ctcocb_options['textPhone']; ?>" maxlength="30" />
				</td>
			</tr>
			
			<tr>
				<th>WhatsApp number to call or chat:</th>
				<td><input type="text" name="ctcocb[numberWapp]" value="<?php echo $ctcocb_options['numberWapp']; ?>" /></td>
			</tr>
			<tr>
				<th>WhatsApp number(or text) to display:</th>
				<td>
					<input  type="text" name="ctcocb[textWapp]" value="<?php echo $ctcocb_options['textWapp']; ?>" maxlength="30" />
				</td>
			</tr>
			<tr>
			<th>Custom text:</th>
				<td><input type="text" name="ctcocb[text]" value="<?php echo $ctcocb_options['text']; ?>" /></td>
			</tr>
		</table>

		<div id="settings">
			<table class="form-table">
				<tr>
					<th>
						<h3>Colors</h3>
					</th>
				</tr>
				<tr>	
					<th>Semi-transparent container background</th>
					<td>
						<input name="ctcocb[transparentBackground]" type="checkbox" value="1" <?php checked('1', $ctcocb_options['transparentBackground']);?> /> 
						<label title="Transparent" for="activated">Semi-transparent</label>
					</td>
				</tr>
				<tr>	
					<th>Container background color</th>
					<td>
					   <input name="ctcocb[colorBackground]" type="text" value="<?php echo $ctcocb_options['colorBackground']; ?>" class="ctcocb-color-field"  />
					</td>
				</tr>
				<tr>	
					<th>Container border color</th>
					<td>
					   <input name="ctcocb[containerBorderColor]" type="text" value="<?php echo $ctcocb_options['containerBorderColor']; ?>" class="ctcocb-color-field" />
					</td>
				</tr>
				<tr>	
					<th>Phone icon color</th>
					 <td>
					   <input name="ctcocb[colorPhoneIcon]" type="text" value="<?php echo $ctcocb_options['colorPhoneIcon']; ?>" class="ctcocb-color-field"  />
					   
					</td>
				</tr>
				<tr>	
					<th>Phone border color</th>
					 <td>
					   <input name="ctcocb[colorPhoneBubble]" type="text" value="<?php echo $ctcocb_options['colorPhoneBubble']; ?>" class="ctcocb-color-field"  />
					   <i>Require Phone icon color to be set</i>
					</td>
				</tr>
					<tr>	
					<th>WhatsApp icon color</th>
					 <td>
					   <input name="ctcocb[colorWappIcon]" type="text" value="<?php echo $ctcocb_options['colorWappIcon']; ?>" class="ctcocb-color-field"  />
					</td>
				</tr>
				<tr>	
					<th>WhatsApp background color</th>
					 <td>
					   <input name="ctcocb[colorWappBubble]" type="text" value="<?php echo $ctcocb_options['colorWappBubble']; ?>" class="ctcocb-color-field"  />
					   
					</td>
				</tr>
				<tr>	
					<th>Phone and WhatsApp text color</th>
					<td>
					   <input name="ctcocb[colorText]" type="text" value="<?php echo $ctcocb_options['colorText']; ?>" class="ctcocb-color-field"  />
					   
					</td>
				</tr>
				<tr>	
					 <th>Custom text color</th>
					 <td>
					   <input name="ctcocb[colorCustomText]" type="text" value="<?php echo $ctcocb_options['colorCustomText']; ?>" class="ctcocb-color-field" />
					   
					</td>
				</tr>
				
				<tr>
						<th>
							<h3>Topography</h3>
						</th>
				</tr>
				<tr>
					<th>Display Buttons:</th>
					<td>
						
						<div>
						<input id="displayPhone" name="ctcocb[displayPhone]" type="checkbox" value="1" <?php checked('1', $ctcocb_options['displayPhone']); ?> />
						<label>Phone</label>  
						</div>
						<div>
						<input id="displayWapp" name="ctcocb[displayWapp]" type="checkbox" value="1" <?php checked('1', $ctcocb_options['displayWapp']); ?> />
						<label>WhatsApp</label>  
						</div>
						<div>
						<input id="displayText" name="ctcocb[displayText]" type="checkbox" value="1" <?php checked('1', $ctcocb_options['displayText']); ?> />
						<label>Custom Text</label>  
						</div>
					</td>	    	    
				</tr>
				<tr>
					<th>
						Button position
					</th>
					<td class="appearance">
						<div class="appearance-options">
							<div>
								<input type="radio"  name="ctcocb[appearancePosition]" value="1" <?php checked('1', $ctcocb_options['appearancePosition']); ?>>
								<label>Top - full width</label>
							</div>
							<div>
								<input type="radio"  name="ctcocb[appearancePosition]" value="2" <?php checked('2', $ctcocb_options['appearancePosition']); ?>>
								<label>Bottom - full width</label>
							</div>
							<div>
								<input type="radio" name="ctcocb[appearancePosition]" value="3" <?php checked('3', $ctcocb_options['appearancePosition']); ?>>
								<label>Left bottom - auto width</label>
							</div>
							<div>
								<input type="radio"  name="ctcocb[appearancePosition]" value="4" <?php checked('4', $ctcocb_options['appearancePosition']); ?>>
								<label>Right bottom - auto width</label>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<th>
						Items order
					</th>
					<td>
						<div>
							<div>
								<input type="radio"  name="ctcocb[appearanceOrder]" value="1" <?php checked('1', $ctcocb_options['appearanceOrder']); ?>>
								<label>Phone | Custom Text | WhatsApp</label>
							</div>
							<div>
								<input type="radio"  name="ctcocb[appearanceOrder]" value="2" <?php checked('2', $ctcocb_options['appearanceOrder']); ?>>
								<label>WhatsApp | Custom Text | Phone</label>
							</div>
							<div>
								<input type="radio" name="ctcocb[appearanceOrder]" value="3" <?php checked('3', $ctcocb_options['appearanceOrder']); ?>>
								<label>Phone | WhatsApp | Custom Text</label>
							</div>
							<div>
								<input type="radio"  name="ctcocb[appearanceOrder]" value="4" <?php checked('4', $ctcocb_options['appearanceOrder']); ?>>
								<label>Custom Text | Phone | WhatsApp</label>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<th>Restrict appearance:</th>
					<td>					 
						
						<div>
							<input type="radio" name="ctcocb[pagesDisplay]" value="0" <?php checked(0, $ctcocb_options['pagesDisplay']);?> />
							<label>Display buttons on all pages and posts.</label>
						</div>
						<div>
							<input type="radio" name="ctcocb[pagesDisplay]" value="1" <?php checked(1, $ctcocb_options['pagesDisplay']);?> />
							<label>Limit to these posts and pages.</label>
						</div>
						<div>
							<input type="radio" name="ctcocb[pagesDisplay]" value="2" <?php checked(2, $ctcocb_options['pagesDisplay']);?> />
							<label>Exclude these posts and pages.</label>
						</div>
						<input type="text" name="ctcocb[pageIds]" value="<?php echo $ctcocb_options['pageIds']; ?>" />
						<p>Pages or post IDs included or excluded. (Enter IDs of the posts and pages, separated by commas.)</p>
					</td>
				</tr>
				<tr  class="db_slider">
					<th>Maximum screen width (<span class="slider_preview"><?php echo $ctcocb_options['screenWidth']; ?></span>px):</th>
					<td>
						<label>Smaller</label> <input type="range" min="300" max="3000" name="ctcocb[screenWidth]" value="<?php echo $ctcocb_options['screenWidth']; ?>" step="20">
						<label>Bigger</label>				
						<p>Call buttons will be displayed only on screens with width above this value. Optimal value is around 780px).</p>
					</td>
				</tr>
				<tr  class="db_slider">
					<th>Container margin (<span class="slider_preview"><?php echo $ctcocb_options['containerMargin']; ?></span>px):</th>
					<td>
						<label>Smaller</label> <input type="range" min="0" max="40" name="ctcocb[containerMargin]" value="<?php echo $ctcocb_options['containerMargin']; ?>" step="1">
						<label>Bigger</label>				
					</td>
				</tr>
					<tr  class="db_slider">
				<th>Container padding (<span class="slider_preview"><?php echo $ctcocb_options['containerPadding']; ?></span>px):</th>
					<td>
						<label>Smaller</label> <input type="range" min="0" max="40" name="ctcocb[containerPadding]" value="<?php echo $ctcocb_options['containerPadding']; ?>" step="1">
						<label>Bigger</label>				
					</td>
				</tr>
				<tr  class="db_slider">
					<th>Container border size (<span class="slider_preview"><?php echo $ctcocb_options['containerBorderSize']; ?></span>px):</th>
					<td>
						<label>Smaller</label> <input type="range" min="0" max="40" name="ctcocb[containerBorderSize]" value="<?php echo $ctcocb_options['containerBorderSize']; ?>" step="1"> <label>Bigger</label>				
					</td>
				</tr>
				<tr  class="db_slider">
					<th>Container border radius (<span class="slider_preview"><?php echo $ctcocb_options['containerBorderRadius']; ?></span>px):</th>
					<td>
						<label>Smaller</label> <input type="range" min="0" max="40" name="ctcocb[containerBorderRadius]" value="<?php echo $ctcocb_options['containerBorderRadius']; ?>" step="1"> <label>Bigger</label>				
					</td>
				</tr>			
				
				
				<tr  class="db_slider">
					<th>Icons padding (<span class="slider_preview"><?php echo $ctcocb_options['padding']; ?></span>)px:</th>
					<td>
						<label>Smaller</label> <input type="range" min="0" max="20" name="ctcocb[padding]" value="<?php echo $ctcocb_options['padding']; ?>"  step="1"> <label>Bigger</label>				
					</td>
				</tr>

				<tr  class="db_slider">
					<th>Icons size (<span class="slider_preview"><?php echo $ctcocb_options['buttonSize']; ?></span>px):</th>
					<td>
						<label>Smaller</label> <input type="range" min="10" max="100" name="ctcocb[buttonSize]" value="<?php echo $ctcocb_options['buttonSize']; ?>" step="1"> <label>Bigger</label>				
					</td>
				</tr>
				<tr  class="db_slider">
					<th>Font size (<span class="slider_preview"><?php echo $ctcocb_options['fontSize']; ?></span>px):</th>
					<td>
						<label>Smaller</label> <input type="range" min="10" max="40" name="ctcocb[fontSize]" value="<?php echo $ctcocb_options['fontSize']; ?>"  step="1"> <label>Bigger</label>				
					</td>
				</tr>

				<tr  class="db_slider">
					<th>Layer order (<span class="slider_preview"><?php echo $ctcocb_options['zIndex']; ?></span>):</th>
					<td>
						<label>Back</label> <input type="range" min="1" max="10" name="ctcocb[zIndex]" value="<?php echo $ctcocb_options['zIndex']; ?>" step="1"> <label>Front</label>
						<p class="description">Place Click to Call or Chat Buttons in front or in background of other elements.</p>
					</td>
				</tr>
				<tr  class="db_slider">
					<th>Page margin (<span class="slider_preview"><?php echo $ctcocb_options['pagePadding']; ?></span>px):</th>
					<td>
						<label>Smaller</label> <input type="range" min="0" max="100" name="ctcocb[pagePadding]" value="<?php echo $ctcocb_options['pagePadding']; ?>" step="1"> <label>Bigger</label>
						<p class="description">Add bottom or top padding to page.</p>
					</td>
				</tr>
				<tr>
					<th>
						<h3>Google Analytics event tracking</h3>
					</th>
				</tr>
				<tr>
					<th>Select type of tracking:</th>
					<td> 
						<div>
							<input  type="radio" name="ctcocb[trackingType]" value="0" <?php checked('0', $ctcocb_options['trackingType']); ?> /> 
							<label>Disabled</label>
						</div>
						 <div>
							<input  type="radio" name="ctcocb[trackingType]" value="1" <?php checked('1', $ctcocb_options['trackingType']); ?> /> 
							<label>Classic Google Analytics (ga.js)</label>
						</div>
						<div>
							<input type="radio" name="ctcocb[trackingType]" value="2" <?php checked('2', $ctcocb_options['trackingType']); ?> /> 
							<label>Google Universal Analytics (analytics.js)</label>
						</div>
						<div>
							<input type="radio" name="ctcocb[trackingType]" value="3" <?php checked('3', $ctcocb_options['trackingType']); ?> /> 
							<label>Latest Google Analytics (recommended),(gtag.js)</label>
						</div>
					</td>
				</tr>		
			</table>
			<p>Aditional information <a target="_blank" href="https://www.digitalblue.ro/click-to-call-or-chat-buttons/">Click to Call or Chat Buttons</a></p>
			<p>Check the <a target="_blank" href="https://www.digitalblue.ro/click-to-call-or-chat-buttons-pro/">Click to Call or Chat Buttons Pro version</a></p>
		</div>
		<input type="hidden" name="ctcocb[version]" value="<?php echo CTCOCB_VERSION; ?>" />
		<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
		
	</form>
	</div>
<?php 
}


if(!is_admin()) 
{
	global $ctcocb_options;
	if($ctcocb_options['activePlugin'] == '1') {
		function ctcocb_head() {
			if(ctcocb_ckeck_page()) {
				global $ctcocb_options;
				$body_css="";
				if($ctcocb_options['appearancePosition']==1){if($ctcocb_options['pagePadding']>0)$body_css="padding-top:".$ctcocb_options['pagePadding']."px;";$ctcocb_css="top:".$ctcocb_options['containerMargin']."px;left:".$ctcocb_options['containerMargin']."px;right:".$ctcocb_options['containerMargin']."px;";}
				if($ctcocb_options['appearancePosition']==2){if($ctcocb_options['pagePadding']>0)$body_css="padding-bottom:".$ctcocb_options['pagePadding']."px;";$ctcocb_css="bottom:".$ctcocb_options['containerMargin']."px;left:".$ctcocb_options['containerMargin']."px;right:".$ctcocb_options['containerMargin']."px;";}
				if($ctcocb_options['appearancePosition']==3){if($ctcocb_options['pagePadding']>0)$body_css="padding-bottom:".$ctcocb_options['pagePadding']."px;";$ctcocb_css="bottom:".$ctcocb_options['containerMargin']."px;left:".$ctcocb_options['containerMargin']."px;";}
				if($ctcocb_options['appearancePosition']==4){if($ctcocb_options['pagePadding']>0)$body_css="padding-bottom:".$ctcocb_options['pagePadding']."px;";$ctcocb_css="bottom:".$ctcocb_options['containerMargin']."px;right:".$ctcocb_options['containerMargin']."px;";}
				$styling = "\n<!-- Call or Chat Button ".CTCOCB_VERSION." by DIGITALBLUE (digitalblue.ro/wordpress-plugin/ctcocb) -->\n";
				$styling .= "<style>";
				$styling .= "@media screen and (max-width: ".$ctcocb_options['screenWidth']."px){.ctcocb {display: block;}
				body{".$body_css.";}
				}";
				$styling .= ".ctcocb {";
				$styling .= $ctcocb_css.";";
				if(isset($ctcocb_options['containerPadding']))$styling .= "padding:".$ctcocb_options['containerPadding']."px;";
				$styling .= "z-index:".ctcocb_set_zindex($ctcocb_options['zIndex']).";";
				$alphaBackground="";
				if($ctcocb_options['transparentBackground']==1)$alphaBackground='bb';
					
					
				if($ctcocb_options['colorBackground']!="")$styling .= "background:".$ctcocb_options['colorBackground'].$alphaBackground.";";	
				$styling .= "border: ".$ctcocb_options['containerBorderSize']."px solid ".$ctcocb_options['containerBorderColor'].$alphaBackground.";  border-radius: ".$ctcocb_options['containerBorderRadius']."px;";
				$styling .= "}";
				
			
				$styling .= ".ctcocb-text{color:".$ctcocb_options['colorCustomText'].";}";
				$styling .= ".ctcocb a,.ctcocb a:visited{color:".$ctcocb_options['colorText'].";}";
				$styling .= ".ctcocb a,.ctcocb a:visited{color:".$ctcocb_options['colorText'].";}";
				
				$styling .= "
					 .ctcocb img {width:". $ctcocb_options['buttonSize']."px!important;}
					
					 .ctcocb div {font-size:". $ctcocb_options['fontSize']."px;}
					 .ctcocb img,.ctcocb .ctcocb-text{margin-left:". $ctcocb_options['padding']."px;margin-right:". $ctcocb_options['padding']."px;}
					
					 ";
				$styling .= "</style>\n";
		
				echo $styling;
			}
		}
		
		
		function ctcocb_footer() {
			if(ctcocb_ckeck_page()) {
				global $ctcocb_options;
				if($ctcocb_options['trackingType'] == '1') { // ga.js
					$trackingcode_Phone =         "onclick=\"_gaq.push(['_trackEvent', 'Click to Call or Chat Buttons', 'Click to Call or Chat Buttons - Phone', 'Phone Button']);\""; 
				} elseif($ctcocb_options['trackingType'] == '2') { // analytics.js
					$trackingcode_Phone =         "onclick=\"ga('send', 'event', 'Click to Call or Chat Buttons', 'Click to Call or Chat Buttons - Phone', 'Phone Button');\""; 
				} elseif($ctcocb_options['trackingType'] == '3') { // gtag.js
					$trackingcode_Phone =         "onclick=\"gtag('event', 'Click to Call or Chat Buttons',  {event_category: 'Click to Call or Chat Buttons - Phone', event_label: 'Phone Button'});\"";
				} else {
					$trackingcode_Phone = "";
				}
				
				if($ctcocb_options['trackingType'] == '1') { // ga.js
					$trackingcode_WApp =    "onclick=\"_gaq.push(['_trackEvent', 'Click to Call or Chat Buttons', 'Click to Call or Chat Buttons - WApp', 'WApp Button']);\""; 
				} elseif($ctcocb_options['trackingType'] == '2') { // analytics.js
					$trackingcode_WApp =    "onclick=\"ga('send', 'event', 'Click to Call or Chat Buttons', 'Click to Call or Chat Buttons - WApp', 'WApp Button');\""; 
				} elseif($ctcocb_options['trackingType'] == '3') { // gtag.js
					$trackingcode_WApp =    "onclick=\"gtag('event', 'Click to Call or Chat Buttons', {event_category: 'Click to Call or Chat Buttons - WApp', event_label: 'WApp Button'});\"";
				} else {
					$trackingcode_WApp = "";
				}
				$colorsp[1]=$ctcocb_options['colorPhoneBubble'];
				$colorsp[2]=$ctcocb_options['colorPhoneIcon'];
				
				$colorsw[1]=$ctcocb_options['colorWappBubble'];
				$colorsw[2]=$ctcocb_options['colorWappIcon'];
				$col=0;
				if($ctcocb_options['displayPhone'])$col++;
				if($ctcocb_options['displayText'])$col++;
				if($ctcocb_options['displayWapp'])$col++;
				$ctcocb_cols=1;
				if($col==2){$ctcocb_cols=2;}
				if($col==3){$ctcocb_cols=3;}	
				if($ctcocb_options['appearancePosition']>2)$ctcocb_cols="";
				$ButtonPhone=$ButtonText=$ButtonWapp='';
				$ctcocb_textPhone=$ctcocb_textWapp=$ctcocb_text='';				
				if($ctcocb_options['textPhone']!='')$ctcocb_textPhone='<div class="ctcocb-phone">'.$ctcocb_options['textPhone'].'</div>';
				if($ctcocb_options['text']!='')$ctcocb_text='<div class="ctcocb-text">'.$ctcocb_options['text'].'</div>';
				if($ctcocb_options['textWapp']!='')$ctcocb_textWapp='<div class="ctcocb-wapp">'.$ctcocb_options['textWapp'].'</div>';
				if($ctcocb_options['displayPhone'])	$ButtonPhone=	'<div class="ctcocb-cols-'.$ctcocb_cols.'"><a  href="tel:'.$ctcocb_options['numberPhone'].'" '.$trackingcode_Phone.'><div class="ctcocb-img" ><img alt="Phone icon"  src="data:image/svg+xml;base64,'.ctcocb_get_svg('iconPhone',$colorsp,100).'"/></div>'.$ctcocb_textPhone.'</a></div>';
				if($ctcocb_options['displayText'])	$ButtonText=	'<div class="ctcocb-cols-'.$ctcocb_cols.'">'.$ctcocb_text.'</div>';
				if($ctcocb_options['displayWapp'])	$ButtonWapp=	'<div class="ctcocb-cols-'.$ctcocb_cols.'"><a  href="https://wa.me/'.$ctcocb_options['numberWapp'].'" '.$trackingcode_WApp.'><div class="ctcocb-img" ><img alt="WhatsApp icon" src="data:image/svg+xml;base64,'.ctcocb_get_svg('iconWapp',$colorsw,100).'"/></div>'.$ctcocb_textWapp.'</a></div>';
				$Button=$ButtonPhone.$ButtonText.$ButtonWapp;
				if($ctcocb_options['appearanceOrder']==1)$Button=$ButtonPhone.$ButtonText.$ButtonWapp;
				if($ctcocb_options['appearanceOrder']==2)$Button=$ButtonWapp.$ButtonText.$ButtonPhone;
				if($ctcocb_options['appearanceOrder']==3)$Button=$ButtonPhone.$ButtonWapp.$ButtonText;		
				if($ctcocb_options['appearanceOrder']==4)$Button=$ButtonText.$ButtonPhone.$ButtonWapp;	            
				echo $Button='<div class="ctcocb">'.$Button.'</div>';
			}
		}
		add_action('wp_head', 'ctcocb_head');
		add_action('wp_footer', 'ctcocb_footer');
		
	}
	function ctcocb_ckeck_page(){
		global $ctcocb_options;
		if(isset($ctcocb_options['pageIds']) && $ctcocb_options['pageIds'] != "") {
					$pageIds = explode(',', str_replace(' ', '' ,$ctcocb_options['pageIds']));
				}	
		if($ctcocb_options['pagesDisplay'] == '0'||
			($ctcocb_options['pagesDisplay'] == '1'&&isset($pageIds)&&(is_page($pageIds)||is_single($pageIds)))||
			($ctcocb_options['pagesDisplay'] == '2'&&isset($pageIds)&&!(is_page($pageIds)||is_single($pageIds)))){	
				return true;
			}
	return false;			
	}
}	

function ctcocb_get_options() { 
	if(!get_option('ctcocb')) { 
		$default_options = array(
			'activePlugin' => 0,
			'numberPhone' => '+10987654321',
			'numberWapp' => '+10987654321',
			'textPhone' => '0987.654.321',
			'textWapp' => '0987.654.321',
			'text' => 'Contact us!', 
			'transparentBackground' => 0,
			'colorBackground' => '#25d366',
			'colorPhoneIcon' => '#ffffff',
			'colorPhoneBubble' => '',
			'colorWappIcon' => '#ffffff',
			'colorWappBubble' => '#25d366',
			'colorText' => '#ffffff',
			'colorCustomText' => '#ffffff',
			'appearanceOrder' => 1,
			'appearancePosition' => 2,
			'displayText' => 1,
			'displayPhone' => 1,
			'displayWapp' => 1,
			'trackingType' => 0,
			'pageIds' => '',
			'pagesDisplay' => 0,
			'containerBorderSize' => 1,
			'containerBorderColor' => '#ffffff',
			'containerBorderRadius' => 0,
			'screenWidth' => 780,
			'containerMargin' => 0,
			'containerPadding' => 5,
			'buttonSize' => 20,
			'fontSize' => 14,
			'padding' => 5,
			'zIndex' => 6,
			'pagePadding' => 0,
			'version' => CTCOCB_VERSION
			);
		add_option('ctcocb',$default_options);
	} 
	
	$ctcocb_options = get_option('ctcocb');
	$ctcocb_options['activePlugin'] = isset($ctcocb_options['activePlugin']) ? $ctcocb_options['activePlugin'] : 0;
	$ctcocb_options['appearanceOrder'] = isset($ctcocb_options['appearanceOrder']) ? $ctcocb_options['appearanceOrder']  : 1;
	$ctcocb_options['transparentBackground'] = isset($ctcocb_options['transparentBackground']) ? $ctcocb_options['transparentBackground'] : 0;
	$ctcocb_options['displayPhone'] = isset($ctcocb_options['displayPhone']) ? $ctcocb_options['displayPhone'] : 0;
	$ctcocb_options['displayWapp'] = isset($ctcocb_options['displayWapp']) ? $ctcocb_options['displayWapp'] : 0;
	$ctcocb_options['displayText'] = isset($ctcocb_options['displayText']) ? $ctcocb_options['displayText'] : 0;
	$ctcocb_options['pagesDisplay'] = isset($ctcocb_options['pagesDisplay']) ? $ctcocb_options['pagesDisplay']  : 0;
	return $ctcocb_options;
}

function register_ctcocb_page() {
	global $ctcocb_plugin_title;
	$page = add_submenu_page('options-general.php', $ctcocb_plugin_title, $ctcocb_plugin_title, 'manage_options', 'ctcocb', 'ctcocb_settings_page');
	add_action( 'admin_print_styles-' . $page , 'ctcocb_admin_styling' );
}
function ctcocb_enqueue_color_picker( $hook_suffix ) {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'ctcocb-script-handle', plugins_url('js/ctcocb.js', __FILE__ ), array( 'wp-color-picker' ), CTCOCB_VERSION, true );

}
function ctcocb_admin_styling() {
	wp_enqueue_style( 'ctcocb_styling' );
}
function ctcocb_front_styling() {
    wp_enqueue_style( 'ctcocb-front-styling', plugins_url('ctcocb-front.css', __FILE__)); 
}
function ctcocb_plugin_row_meta($meta, $name) {
	if ( $name == CTCOCB_BASENAME ) {
		
			$meta[]='<a href="options-general.php?page='.CTCOCB_FILENAME.'">'.__('Settings').'</a>';
			$meta[]='<a href="https://www.digitalblue.ro/click-to-call-or-chat-buttons/">Support</a>';
	}	
	return $meta;
}
function ctcocb_plugin_add_settings_link( $links ) {
    array_unshift( $links, sprintf( '<a href="options-general.php?page=%s">%s</a>', CTCOCB_FILENAME, __('Settings') ) );
  	return $links;
}
function ctcocb_options_init() {
	register_setting(
	    'ctcocb_options',
	    'ctcocb',        
        'ctcocb_sanitize' 
    );
}

function ctcocb_sanitize($input) {
        foreach ($input as $key=>$value) {
            $input[$key]= esc_html(sanitize_text_field($value));
        }
    return $input;
}

function ctcocb_set_zindex($z) {
	$z_index = array(
		10 =>1000000001,
		9 => 100000001,
		8 => 10000001,
		7 => 1000001,
		6 => 100001,
		5 => 10001,
		4 => 1001,
		3 => 101,
		2 => 11,
		1 => 1
	);
	return $z_index[$z];
}


?>
