<?php
/**
 * Logga
 *
 * Simple logger for PHP stuff. Add as a composer package and go nuts.
 * Includes support to log to error_log, via email, and webhook.
 *
 * @package Logga
 * @author  Marco Hyyryläinen <marco@wheresmar.co>
 */

namespace WM;

class Logga {

	/**
	 * Log an messages to PHP error_log
	 *
	 * @since    1.0.0
	 *
	 * @param anything $stuff The thing you want to log.
	 */
	public function text( $stuff = null ) {
		static $pageload;

		// Call $this->text() on each argument.
		if ( func_num_args() > 1 ) :
			foreach ( func_get_args() as $arg ) :
				$this->text( $arg );
			endforeach;

			return $stuff;
		endif;

		if ( ! isset( $pageload ) ) :

			$pageload = substr( md5( mt_rand() ), 0, 4 );

			if ( ! empty( $_SERVER['argv'] ) ) :
				$hint = implode( ' ', $_SERVER['argv'] );
			elseif ( isset( $_SERVER['HTTP_HOST'] ) && isset( $_SERVER['REQUEST_URI'] ) ) :
				$hint = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			else :
				$hint = php_sapi_name();
				error_log( sprintf( '[%s-%s => %s]', $pageload, getmypid(), $hint ) );
			endif;

		endif;

		$pid = $pageload . '-' . getmypid();

		if ( is_null( $stuff ) ) :

			// Log the file and line number.
			$backtrace = debug_backtrace( false );
			while ( isset( $backtrace[1]['function'] ) && __FUNCTION__ === $backtrace[1]['function'] ) :
				array_shift( $backtrace );
			endwhile;

			$log = sprintf( '%s line %d', $backtrace[0]['file'], $backtrace[0]['line'] );

		elseif ( is_bool( $stuff ) ) :
			$log = $stuff ? 'TRUE' : 'FALSE';
		elseif ( is_scalar( $stuff ) ) :
			$log = $stuff; // Strings and numbers can be logged exactly.
		else :
			// Are we in an output buffer handler?
			// If so, print_r($stuff, true) is fatal so we must avoid that.
			// This is not as slow as it looks: <1ms when !$in_ob_handler.
			// Using json_encode_pretty() all the time is much slower.
			do {
				$in_ob_handler = false;
				$ob_status = ob_get_status( true );
				if ( ! $ob_status ) :
					break;
				endif;

				foreach ( $ob_status as $ob ) :
					$obs[] = $ob['name'];
				endforeach;

				// This is not perfect: anonymous handlers appear as default.
				if ( array( 'default output handler' ) === $obs ) :
					break;
				endif;

				$backtrace = debug_backtrace( false );

				foreach ( $backtrace as $level ) :
					$caller = '';

					if ( isset( $level['class'] ) ) :
						$caller = $level['class'] . '::';
					endif;

					$caller .= $level['function'];
					$bts[]   = $caller;
				endforeach;

				if ( array_intersect( $obs, $bts ) ) :
					$in_ob_handler = true;
				endif;
			} while ( false );

			if ( $in_ob_handler ) :
				$log = l_json_encode_pretty( $stuff );
			else :
				$log = print_r( $stuff, true );
			endif;
		endif;

		error_log( sprintf( '[%s] %s', $pid, $log ) );

		return $stuff;
	}

	/**
	 * Send a log message as an email
	 *
	 * @since    1.0.0
	 */
	public function mail() {
		return 'test';
	}

	/**
	 * Call a webhook with the message
	 *
	 * @since    1.0.0
	 */
	public function hook() {
		return 'test';
	}

}
