<?php
	if(isset($_POST["textarea__adsense-tag"])) {
		$adsenseTag = $_POST["textarea__adsense-tag"];
		update_option('adsense_tag', $adsenseTag);
		$overType = $_POST["radio__over-type"];
		update_option('over_type', $overType);
		echo '<p style="color: #0000ff;"><strong>変更が完了しました</strong></p>';
	}
	if(isset($_POST["textarea__adsense-tag"]) && !get_option('adsense_tag')) {
		echo '<p style="color: #ff0000;"><strong>広告タグを入力してください</strong></p>';
	}
?>

<div class="settings-wrapper">
	<h2>Over Adsense管理画面</h2>
	
	<div class="form-wrapper">
		<form class="settings-form" action="" method="POST">
			<div class="group">
				<p>広告タグを入力</p>
				<textarea class="textarea__adsense-tag" name="textarea__adsense-tag"><?php echo wp_kses(get_option('adsense_tag'), wp_kses_allowed_html('post')); ?></textarea>
			</div>
			<div class="group">
				<p>スマホ版のみ表示</p>
				<input class="radio__sp" type="radio" name="radio__over-type" value="sp" <?php get_option('over_type') == 'sp' ? print 'checked="checked"' : print ''; ?>>
			</div>

			<div class="group">
				<p>スマホ版とデスクトップ版の両方に表示</p>
				<?php 
					if(!get_option('over_type')){
						echo '<input class="radio__both" type="radio" name="radio__over-type" value="both" checked="checked">';
					}
					if(get_option('over_type') == 'both') {
						echo '<input class="radio__both" type="radio" name="radio__over-type" value="both" checked="checked">';
					}
					if(get_option('over_type') == 'sp') {
						echo '<input class="radio__both" type="radio" name="radio__over-type" value="both">';
					}
				?>
			</div>
			<?php submit_button();?>
		</form>
	</div>
	<!-- end form-wrapper -->
</div>
<!-- end settings-wrapper -->