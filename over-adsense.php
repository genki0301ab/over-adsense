<?php 
/*
	Plugin Name: Over Adsense
	Plugin URI: 
	Description: 詳細ページ全体に広告を表示させるプラグイン
	Author: Genki Okada
	Version: 1.0.0
	Author URI: https://github.com/genki0301ab
	License: GPL2
*/

/*
	Copyright 2018 Genki Okada (email : genki0301ab@gmail.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class OverAdsense {
	//initialize
	function __construct() {
		if(!get_option('adsense_tag')) {
			$this -> settingAdd();
		}
		$this -> overType();
		add_action('admin_menu', array($this, 'menuOption'));
		add_action('wp_footer', array($this, 'overlay'));
		register_uninstall_hook(__FILE__, 'OverAdsense::settingRemove');
	}
	//property
	public $pc = 1;
	public $sp = 1;
	//method
	public function menuOption() { //menuOption
		add_menu_page('Over Adsense', 'Over Adsense', 'manage_options', 'over-adsense-settings', array($this, 'menuUI'));
	}
	public function menuUI() { //menuUI
		include_once('views/settings.php');
		wp_enqueue_style('settings', plugins_url('css/settings.css', __FILE__));
	}
	public function settingAdd() { //settingAdd
		add_option('addsense_tag', '');
		add_option('over_type', '');
	}
	public function settingRemove() { //settingRemove
		delete_option('adsense_tag');
		delete_option('over_type');
	}
	public function overType() { //overType
		switch(get_option('over_type')) {
			case 'sp' :
				$this -> pc = 0;
				$this -> sp = 1;
			break;
			case 'both' :
				$this -> pc = 1;
				$this -> sp = 1;
			break;
			default :
				$this -> pc = 1;
				$this -> sp = 1;
			break;
		}
	}
	public function overlay() { //overlay
		if(is_single() == true && get_option('adsense_tag') == true) {
			wp_enqueue_style('over-adsense-css', plugins_url('css/over-adsense.css', __FILE__));
			wp_enqueue_script('over-adsense-js', plugins_url('js/over-adsense.js', __FILE__));
			echo '<div class="over-adsense-wrapper">';
				echo '<div class="over-adsense">';
					echo wp_kses(get_option('adsense_tag'), wp_kses_allowed_html('post'));
					echo '<div class="close-button"></div>';
				echo '</div>';
			echo '</div>';
			echo '<script>';
				echo '$(function() {';
					echo 'var overAdsese = OverAdsense({pc: ' . $this -> pc . ', sp: ' . $this -> sp . '});';
				echo '});';
			echo '</script>';
		}
	}
}

$overAdsense = new OverAdsense;