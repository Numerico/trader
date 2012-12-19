<?php
/*
  * Holds the BBcode
  * @package WP-Trader
  */
function textbbcode($form,$name,$content="") {
	
?>
<script src="<?php echo WP_TRADER_PLUGIN_URL . '/includes/js/bbcode_smilies.js'; ?>" type="text/javascript"></script>
<?php
	smilies();
?>
	<table>
		<tr>
			<td id="showbbcode">Show WYSIWYG Editor&nbsp;&nbsp;</td>
			<td id="hidebbcode">Hide WYSIWYG Editor&nbsp;&nbsp;</td>
			<td id="showsmilies">Show Smilies&nbsp;&nbsp;</td>
			<td id="hidesmilies">Hide Smilies&nbsp;&nbsp;</td>
		</tr>
	</table>
	<table id="bbcode">
		<tbody>
		<tr>
			<td>
				<table>
					<tr>
						<td align="left"><a href="javascript: BBTag('[b]','bold','<?php echo $name; ?>','<?php echo $form; ?>')"><img src="<?php echo WP_TRADER_PLUGIN_URL . '/css/images/editor_buttons/32x32/bold.png'; ?>" border="0" alt="Bold" name="bold" width="16" height="16"></a></td>
						<td align="left"><a href="javascript: BBTag('[i]','italic','<?php echo $name; ?>','<?php echo $form; ?>')"><img src="<?php echo WP_TRADER_PLUGIN_URL . '/css/images/editor_buttons/16x16/italic.png'; ?>" border="0" alt="Italic" name="italic" width="16" height="16"></a></td>
						<td align="left"><a href="javascript: BBTag('[u]','underline','<?php echo $name; ?>','<?php echo $form; ?>')"><img src="<?php echo WP_TRADER_PLUGIN_URL . '/css/images/editor_buttons/16x16/underline.png'; ?>" border="0" alt="Underline" name="underline" width="16" height="16"></a></td>
						<td align="left"><a href="javascript: BBTag('[*]','li','<?php echo $name; ?>','<?php echo $form; ?>')"><img src="<?php echo WP_TRADER_PLUGIN_URL . '/css/images/editor_buttons/16x16/bulleted_list.png'; ?>" border="0" alt="List" name="li" width="16" height="16"></a></td>
						<td align="left"><a href="javascript: BBTag('[hr]','hr','<?php echo $name; ?>','<?php echo $form; ?>')"><img src="<?php echo WP_TRADER_PLUGIN_URL . '/css/images/editor_buttons/16x16/hr.png'; ?>" border="0" alt="Horizontal Line" name="horizontal" width="16" height="16"></a></td>
						<td align="left"><a href="javascript: BBTag('[justify]','justify','<?php echo $name; ?>','<?php echo $form; ?>')"><img src="<?php echo WP_TRADER_PLUGIN_URL . '/css/images/editor_buttons/16x16/align_justify.png'; ?>" border="0" alt="Justify" name="justify" width="16" height="16"></a></td>
						<td align="left"><a href="javascript: BBTag('[left]','left','<?php echo $name; ?>','<?php echo $form; ?>')"><img src="<?php echo WP_TRADER_PLUGIN_URL . '/css/images/editor_buttons/16x16/align_left.png'; ?>" border="0" alt="Left" name="left" width="16" height="16"></a></td>
						<td align="left"><a href="javascript: BBTag('[center]','center','<?php echo $name; ?>','<?php echo $form; ?>')"><img src="<?php echo WP_TRADER_PLUGIN_URL . '/css/images/editor_buttons/16x16/align_center.png'; ?>" border="0" alt="Center" name="center" width="16" height="16"></a></td>						
						<td align="left"><a href="javascript: BBTag('[right]','right','<?php echo $name; ?>','<?php echo $form; ?>')"><img src="<?php echo WP_TRADER_PLUGIN_URL . '/css/images/editor_buttons/16x16/align_right.png'; ?>" border="0" alt="Right" name="right" width="16" height="16"></a></td>
						<td align="left"><a href="javascript: BBTag('[quote]','quote','<?php echo $name; ?>','<?php echo $form; ?>')"><img src="<?php echo WP_TRADER_PLUGIN_URL . '/css/images/editor_buttons/16x16/blockquote.png'; ?>" border="0" alt="Quote" name="quote" width="16" height="16"></a></td>
						<td align="left"><a href="javascript: BBTag('[url]','url','<?php echo $name; ?>','<?php echo $form; ?>')"><img src="<?php echo WP_TRADER_PLUGIN_URL . '/css/images/editor_buttons/16x16/insert_link.png'; ?>" border="0" alt="Link" name="url" width="16" height="16"></a></td>
						<td align="left"><a href="javascript: BBTag('[img]','img','<?php echo $name; ?>','<?php echo $form; ?>')"><img src="<?php echo WP_TRADER_PLUGIN_URL . '/css/images/editor_buttons/16x16/image.png'; ?>" border="0" alt="Image" name="img" width="16" height="16"></a></td>
						<td align="left"><a href="javascript: BBTag('[spoiler]','spoiler','<?php echo $name; ?>','<?php echo $form; ?>')"><img src="<?php echo WP_TRADER_PLUGIN_URL . '/css/images/editor_buttons/16x16/spoiler.png'; ?>" border="0" alt="Spoiler" name="spoiler" width="16" height="16"></a></td>
						<td align="left"><a href="javascript: BBTag('[code]','code','<?php echo $name; ?>','<?php echo $form; ?>')"><img src="<?php echo WP_TRADER_PLUGIN_URL . '/css/images/editor_buttons/16x16/subscript.png'; ?>" border="0" alt="Code" name="code" width="16" height="16"></a></td>
						<td align="left"><a href="javascript: BBTag('[swf]','swf','<?php echo $name; ?>','<?php echo $form; ?>')"><img src="<?php echo WP_TRADER_PLUGIN_URL . '/css/images/editor_buttons/16x16/swf.png'; ?>" border="0" alt="SWF" name="swf" width="16" height="16"></a></td>
					</tr>
				</table>
				<table>
					<tr>
						<td>
							<select name="size" size="0.5" onChange="javascript: BBTag('[size]','size','<?php echo $name; ?>','<?php echo $form; ?>')">
								<option selected="selected">Size</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
							</select>
						</td>
						<td>
							<select name="font" size='0.5' onChange="javascript: BBTag('[font]','font','<?php echo $name; ?>','<?php echo $form; ?>')">
								<option selected="selected">FONT</option>
								<option value="arial">Arial</option>
								<option value="comic sans ms">Comic</option>
								<option value="courier new">Courier New</option>
								<option value="tahoma">Tahoma</option>
								<option value="times new roman">Times New Roman</option>
								<option value="verdana">Verdana</option>
							</select>
						</td>
						<td>
							<select name="color" size="0.5" onChange="javascript: BBTag('[color]','font','<?php echo $name; ?>','<?php echo $form; ?>')">
								<option selected="selected">COLOR</option>
								<option value="skyblue" style="color:skyblue">sky blue</option>
								<option value="royalblue" style="color:royalblue">royal blue</option>
								<option value="blue" style="color:blue">blue</option>
								<option value="darkblue" style="color:darkblue">dark-blue</option>
								<option value="orange" style="color:orange">orange</option>
								<option value="orangered" style="color:orangered">orange-red</option>
								<option value="crimson" style="color:crimson">crimson</option>
								<option value="red" style="color:red">red</option>
								<option value="firebrick" style="color:firebrick">firebrick</option>
								<option value="darkred" style="color:darkred">dark red</option>
								<option value="green" style="color:green">green</option>
								<option value="limegreen" style="color:limegreen">limegreen</option>
								<option value="seagreen" style="color:seagreen">sea-green</option>
								<option value="deeppink" style="color:deeppink">deeppink</option>
								<option value="tomato" style="color:tomato">tomato</option>
								<option value="coral" style="color:coral">coral</option>
								<option value="purple" style="color:purple">purple</option>
								<option value="indigo" style="color:indigo">indigo</option>
								<option value="burlywood" style="color:burlywood">burlywood</option>
								<option value="sandybrown" style="color:sandybrown">sandy brown</option>
								<option value="sienna" style="color:sienna">sienna</option>
								<option value="chocolate" style="color:chocolate">chocolate</option>
								<option value="teal" "style=color:teal">teal</option>
								<option value="silver" style="color:silver">silver</option>
							</select>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		</tbody>
	</table>
	<?php
	echo "<table id='smilies'><tbody><tr>";
	$i = 0;
	global $smilies;
	foreach ($smilies as $code => $url) {
		$test = "<td><a href=\"javascript:SmileIT('".$code."', '".htmlspecialchars($form)."', '".htmlspecialchars($name)."')\"><img src=\"".WP_TRADER_PLUGIN_URL . 'css/images/smilies/'.$url.''."\" alt=\"$code\" title=\"$code\" border=\"0\"></a></td>";
		print(($i % 10 == 0) ? "</tr>$test" : $test);
		$i++;
	}
	echo "</tbody></table>";
	?>
	<table>
		<tbody>
			<tr>
				<td valign="top">
					<textarea name="<?php echo $name; ?>" rows="10" cols="55"><?php echo $content; ?></textarea>
				</td>    
			</tr>
		</tbody>
   </table>
<?php
}
?>
