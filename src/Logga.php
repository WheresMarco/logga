<?php
/**
 * Logga
 *
 * Simple logger for PHP stuff. Add as a composer package and go nuts.
 * Includes support to log to error_log, via email, and webhook.
 *
 * @package    Logga
 * @author     Marco Hyyryläinen <marco@wheresmar.co>
 */

namespace WM;

class Logga {

	/**
	 * Log an messages to PHP error_log
	 *
	 * @since    1.0.0
	 */
	public function txt() {
		throw new \Exception( "Not implemented" );
	}

	/**
	 * Send a log message as an email
	 *
	 * @since    1.0.0
	 */
	public function mail() {
		throw new \Exception( "Not implemented" );
	}

	/**
	 * Call a webhook with the message
	 *
	 * @since    1.0.0
	 */
	public function hook() {
		throw new \Exception( "Not implemented" );
	}

}
