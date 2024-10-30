<?php
/*
Plugin Name: Bojo
Plugin URI: http://kechjo.cogia.net/blogo/2008/03/02/introducing-bojo/
Description: Lets you post short messages of what you're up to.
Version: 0.2.1
Author: Keith Bowes
Author URI: http://kechjo.cogia.net/
 */

/*  Copyright 2008  Bojo

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

$bojo = array();

function bojo_plenigi_agordojn(&$agordoj)
{
	if ( !is_array($agordoj) )
		$agordoj = array('nomo' => 'Bojo', 'nombro' => 5, 'titolo' => 'Recent Bojos');
}

function bojo_komenci()
{

	global $bojo;
	$bojo['nonids'] = array();
	$ind = 0;

	$agordoj = get_option('bojo');
	bojo_plenigi_agordojn($agordoj);
	
	load_plugin_textdomain('bojo', 'wp-content/plugins/bojo');

	$categories = get_categories();
	foreach ( $categories as $category )
	{
		if ( $category->name == $agordoj['nomo'] )
		{
			$bojo['id'] = $category->term_id;
			$bojo['nomo'] = $category->name;
		}
		else
		{
			$bojo['nonids'][$ind] = $category->term_id;
			$ind++;
		}
	}

	if ( is_home() )
		// Hack, because query_posts('cat=-' . $bojo['id']); doesn't work
		query_posts('cat=' . join($bojo['nonids'], ','));
}

function bojo()
{
	global $bojo;
	$ind = 0;

	if ( !$bojo['id'] ) return;

	$agordoj = get_option('bojo');
	bojo_plenigi_agordojn($agordoj);

	query_posts('cat=' . $bojo['id'] . '&showposts=' . $agordoj['nombro']);
	echo '<ul class="bojo">';
	while ( have_posts() ):
		the_post();

		$ind++;
?>
	<li class="bojero" id="bojero-<?php echo $ind; ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>: <?php echo strip_tags(get_the_excerpt()); ?></li>
<?php endwhile;

echo '</ul>';

}

function bojo_agordoj($umaĵo = false)
{
	$agordoj = get_option('bojo');
	bojo_plenigi_agordojn($agordoj);

	if ( $_POST['submit'] )
	{

		$agordoj['nomo'] = $_POST['nomo'];
		$agordoj['nombro'] = $_POST['nombro'];
		$agordoj['titolo'] = $_POST['titolo'];

		update_option('bojo', $agordoj);
	}

	if ( $_POST['submit-del'] )
	{
		delete_option('bojo');
	}
?>
<div class="wrap">
	<h2><?php if ( !$umaĵo ) _e('Bojo Options', 'bojo'); ?></h2>
	<form action="<?php echo $_SERVER['PHP_SELF'] . '?page=' . basename(__FILE__); ?>&updated=true" method="post">
		<table class="niceblue form-table">
			<tr>
				<td>
					<label for="nomo"><?php _e('Name of category: ', 'bojo') ?></label>
				</td>
				<td>
					<input type="text" name="nomo" id="nomo" value="<?php echo $agordoj['nomo']; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<label for="nombro"><?php _e('Number of messages: ', 'bojo'); ?></label>
				</td>
				<td>
					<input type="text" name="nombro" id="nombro" value="<?php echo $agordoj['nombro']; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<label for="titolo"><?php _e('Bojo Title: ', 'bojo'); ?></label>
				</td>
				<td>	
					<input type="text" name="titolo" id="titolo" value="<?php _e($agordoj['titolo'], 'bojo'); ?>" />
				</td>
			</tr>
		</table>
<?php if ( !$umaĵo ): ?>
		<div class="submit">
			<input type="submit" name="submit" value="<?php _e('Update Options') ?> &raquo;" />
		</div>
<? else: ?>
	<input type="hidden" name="submit" value="1" />
<? endif; ?>
	</form>

<?php if ( !$umaĵo ): ?>
	<form action="<?php echo $_SERVER['PHP_SELF'] . '?page=' . basename(__FILE__); ?>" method="post" style="text-align: center">
	<input  type="submit" name="submit-del" value="<?php _e('Delete Settings'); ?>" />
	</form>
<?php endif; ?>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="text-align: right">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
</form>

</div>

<?php

}

function bojo_aldoni_al_administrilo()
{
	
	add_options_page(__('Bojo Options', 'bojo'), __('Bojo', 'bojo'), publish_posts, basename(__FILE__), 'bojo_agordoj');
}

function widget_bojo_init()
{
	if ( !function_exists('register_sidebar_widget') )
		return;

	function widget_bojo($args)
	{
		extract($args);

		$agordoj = get_option('bojo');
		bojo_plenigi_agordojn($agordoj);

		echo $before_widget . $before_title . __($agordoj['titolo'], 'bojo') . $after_title;

		bojo();

		echo $after_widget;
	}

	function widget_bojo_control()
	{
		bojo_agordoj(true);
	}

	register_sidebar_widget('Bojo', 'widget_bojo');
	register_widget_control('Bojo', 'widget_bojo_control');
}

add_action('admin_menu', 'bojo_aldoni_al_administrilo');
add_action('widgets_init', 'widget_bojo_init');
add_action('wp_head', 'bojo_komenci');

?>
