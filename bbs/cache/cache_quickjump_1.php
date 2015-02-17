<?php

if (!defined('PUN')) exit;
define('PUN_QJ_LOADED', 1);
$forum_id = isset($forum_id) ? $forum_id : 0;

?>				<form id="qjump" method="get" action="viewforum.php">
					<div><label><span><?php echo $lang_common['Jump to'] ?><br /></span>
					<select name="id" onchange="window.location=('viewforum.php?id='+this.options[this.selectedIndex].value)">
						<optgroup label="站务板块">
							<option value="3"<?php echo ($forum_id == 3) ? ' selected="selected"' : '' ?>>站务</option>
						</optgroup>
						<optgroup label="时间系统讨论板块">
							<option value="4"<?php echo ($forum_id == 4) ? ' selected="selected"' : '' ?>>使用说明及版本发布</option>
							<option value="5"<?php echo ($forum_id == 5) ? ' selected="selected"' : '' ?>>需求建议</option>
							<option value="6"<?php echo ($forum_id == 6) ? ' selected="selected"' : '' ?>>问题报告</option>
							<option value="8"<?php echo ($forum_id == 8) ? ' selected="selected"' : '' ?>>组建小组</option>
						</optgroup>
						<optgroup label="谈天说地板块">
							<option value="9"<?php echo ($forum_id == 9) ? ' selected="selected"' : '' ?>>头头是道</option>
							<option value="7"<?php echo ($forum_id == 7) ? ' selected="selected"' : '' ?>>谈天说地</option>
						</optgroup>
					</select></label>
					<input type="submit" value="<?php echo $lang_common['Go'] ?>" accesskey="g" />
					</div>
				</form>
