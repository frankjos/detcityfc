<?php

	/**
	 * Required Variables
	 * Get variables info from theme options panel
	 */

	$atp_searchformtxt = get_option('atp_searchformtxt');
?>
<div class="search-box">
	<form method="get" action="<?php echo home_url(); ?>/">
		<input type="text" size="15" class="search-field" name="s" id="s" value="<?php echo $atp_searchformtxt; ?>.." onfocus="if(this.value == '<?php echo $atp_searchformtxt; ?>..') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo $atp_searchformtxt; ?>..';}"/>
		<button type="submit" value="<?php echo $atp_searchformtxt; ?>" class="button small gray" /><span><?php echo $atp_searchformtxt; ?></span></button>
	</form>
</div>