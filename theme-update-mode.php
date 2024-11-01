<?php
/*
Plugin Name: Theme Update Mode
Plugin URI: 
Description: If caused the error in the theme editing, management screen allows viewing.
Author: 8suzuran8
Author URI: https://profiles.wordpress.org/8suzuran8/
Version: 1.0.1
Text Domain: theme_update_mode
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

if ( is_admin() ) {
	function theme_update_mode_directory( $dir ) {
		if ( get_user_meta( get_current_user_id(), 'use_theme_update_mode', true ) != 1 ) {
			return $dir;
		}

		return dirname( __FILE__ );
	}

	add_filter( 'stylesheet_directory', 'theme_update_mode_directory' );
	add_filter( 'template_directory', 'theme_update_mode_directory' );

    function theme_update_mode_profile_update( $user_id, $old_user_data ) {
        update_user_meta( $user_id, 'use_theme_update_mode', $_POST[ 'use_theme_update_mode' ] );
    }

    add_action( 'profile_update', 'theme_update_mode_profile_update', 10, 2 );

    function theme_update_mode_user_profile($user) {
        $html = '';
        $html .= '<table class="form-table"><tr><th>';
        $html .= '<label for="use_theme_update_mode">' . __( 'テーマ編集モード', 'theme_update_mode' ) . '</label>';
        $html .= '</th><td>';
        $html .= '<input type="checkbox" name="use_theme_update_mode" id="use_theme_update_mode" value="1" ' . checked( $user->use_theme_update_mode, 1, false) . '/>';
        $html .= __( '使用する', 'theme_update_mode' );
        $html .= '<p class="description">' . __( '管理画面ではテーマが動かなくなります。それにより、テーマでエラーを起こしても管理画面が表示できなくなることを防ぎます。', 'theme_update_mode' ) . '</p>';
        $html .= '</td></tr></table>';
        $html .= '';

        echo $html;
    }

    add_action( 'show_user_profile', 'theme_update_mode_user_profile' );
    add_action( 'edit_user_profile', 'theme_update_mode_user_profile' );
}