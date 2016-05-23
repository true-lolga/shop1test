<?php
if(!class_exists('login_widget_admin_security')){
	class login_widget_admin_security {
		
	function __construct(){
		$captcha_on_admin_login = (get_option('captcha_on_admin_login') == 'Yes'?true:false);
		if($captcha_on_admin_login and in_array( $GLOBALS['pagenow'], array( 'wp-login.php' ) )){
			add_action( 'login_form', array( $this, 'security_add' ) );
		}
		
		$login_afo_forgot_pass_link = get_option('login_afo_forgot_pass_link');
		if($login_afo_forgot_pass_link and !in_array( $GLOBALS['pagenow'], array( 'wp-login.php' ) ) ){	
			add_filter( 'lostpassword_url', array( $this, 'afo_lost_password_url_filter'), 10, 2 );
		}
		
		add_action ( 'afo_login_log_front', array( $this, 'afo_login_log_front_action'), 1, 1 );
		add_filter( 'authenticate', array( $this, 'myplugin_auth_signon'), 30, 3 );
	
		$captcha_on_user_login = (get_option('captcha_on_user_login') == 'Yes'?true:false);
		if($captcha_on_user_login){
			add_action( 'login_afo_form', array( $this, 'security_add_user' ) );
		}
		
		if( in_array( $GLOBALS['pagenow'], array( 'wp-login.php' ) ) ){
			add_filter('wp_login', array ( $this, 'check_afo_login_success' ) );
			add_filter('login_errors', array( $this, 'check_afo_login_failed' ) );
		}
	}
	
	function afo_lost_password_url_filter( $lostpassword_url, $redirect ) {
		$login_afo_forgot_pass_link = get_option('login_afo_forgot_pass_link');
		return esc_url( get_permalink($login_afo_forgot_pass_link) );
	}

	function check_afo_login_success(){
		$lla = new login_log_adds;
		$lla->log_add($_SERVER['REMOTE_ADDR'], 'Login success', date("Y-m-d H:i:s"), 'success');
	}
	
	function check_afo_login_failed( $error ){	
		global $errors;
		$lla = new login_log_adds;
		$err_codes = $errors->get_error_codes();
		
		if ( in_array( 'invalid_username', $err_codes ) or in_array( 'incorrect_password', $err_codes ) ) {
			$lla->log_add($_SERVER['REMOTE_ADDR'], 'Error in login', date("Y-m-d H:i:s"), 'failed');
		}
		
		return $error;
	}
	
	function afo_login_log_front_action( $error ){
		$lla = new login_log_adds;
		$err_codes = $error->get_error_codes();
		if ( in_array( 'invalid_username', $err_codes ) or in_array( 'incorrect_password', $err_codes ) ) {
			$lla->log_add($_SERVER['REMOTE_ADDR'], 'Error in login', date("Y-m-d H:i:s"), 'failed');
		}
		
	}
		
		function security_add(){
			echo '<p><img src="'.plugin_dir_url( __FILE__ ).'captcha/captcha.php" class="captcha" alt="code"></p>
			<p>
				<label for="captcha">'.__('Captcha','login-sidebar-widget').'<br>
				<input type="text" name="admin_captcha" id="admin_captcha" class="input" value="" size="20" autocomplete="off"></label>
			</p>';
		}
	
		function myplugin_auth_signon( $user, $username, $password ) {
			if(!session_id()){
				@session_start();
			}
			
			$lla = new login_log_adds;
			
			$captcha_on_admin_login = (get_option('captcha_on_admin_login') == 'Yes'?true:false);
			if($captcha_on_admin_login){
				if( isset($_POST['admin_captcha']) and sanitize_text_field($_POST['admin_captcha']) != $_SESSION['captcha_code'] ){
					$lla->log_add($_SERVER['REMOTE_ADDR'], 'Security code do not match', date("Y-m-d H:i:s"), 'failed');
					return new WP_Error( 'error_security_code', __( "Security code do not match.", "flp" ) );
				}
			}
			
			$captcha_on_user_login = (get_option('captcha_on_user_login') == 'Yes'?true:false);
			if( $captcha_on_user_login and (isset($_POST['user_captcha']) and sanitize_text_field($_POST['user_captcha']) != $_SESSION['captcha_code']) ){
				$lla->log_add($_SERVER['REMOTE_ADDR'], 'Security code do not match', date("Y-m-d H:i:s"), 'failed');
				return new WP_Error( 'error_security_code', __( "Security code do not match.", "flp" ) );
			} 
			
			return $user;
		}
		
		
		function security_add_user(){
			
		echo '<div class="form-group">
			<label for="captcha">'.__('Captcha','login-sidebar-widget').' </label>
			<img src="'.plugin_dir_url( __FILE__ ).'captcha/captcha.php" alt="code" class="captcha">
			<input type="text" name="user_captcha" id="user_captcha" autocomplete="off"/>
		</div>';
		}
	}
}

if(!function_exists('security_init')){
	function security_init(){
		new login_widget_admin_security;
	}
}

security_init();

class login_log_adds{
	function log_add( $ip = '', $msg = '', $l_added = '', $l_status = '' ){
		global $wpdb;
		if($ip == ''){
			return;
		}
		
		$log_data = array( 'ip' => $ip, 'msg' => $msg,  'l_added' => $l_added, 'l_status' => $l_status, 'l_type' => 'new' );
		$log_data_format = array( '%s', '%s', '%s', '%s', '%s' );
		$wpdb->insert( $wpdb->prefix."login_log", $log_data, $log_data_format );
		
	}
}