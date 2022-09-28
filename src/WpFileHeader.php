<?php

namespace Pronamic\WpFileHeader;

class WpFileHeader {
	/**
	 * Get value of the specified key from file.
	 * 
	 * @param string $file Filename.
	 * @param string $key  Key.
	 * @return string
	 */
	public static function get_value( $file, $key ) {
		$file_data = \file_get_contents( $file, false, null, 0, 8 * 1024 );

		if ( false === $file_data ) {
			throw new \Exception( \sprintf( 'Could not read file: %s', $file ) );
		}

		/**
		 * Pattern.
		 * 
		 * @link https://github.com/wp-cli/i18n-command/blob/v2.4.0/src/FileDataExtractor.php#L39-L57
		 * @link https://github.com/WordPress/wordpress-develop/blob/6.0.2/src/wp-includes/functions.php#L6631-L6669
		 */
		$pattern = self::get_regex( $key );

		$result = \preg_match( $pattern, $file_data, $matches );

		if ( false === $result ) {
			throw new \Exception( \sprintf( 'Failed to match `%s` in file `%s`', $key, $file ) );
		}

		if ( 0 === $result ) {
			throw new \Exception( \sprintf( 'Could not find match for `%s` in file `%s`.', $key, $file ) );
		}

		if ( \array_key_exists( 'value', $matches ) ) {
			$value = $matches['value'];

			return $value;
		}

		return '';
	}

	/**
	 * Set value of the specified key in file.
	 * 
	 * @param string $file Filename.
	 * @param string $key  Key.
	 * @return string
	 */
	public static function set_value( $file, $key, $value ) {
		$file_data = \file_get_contents( $file, false );

		if ( false === $file_data ) {
			throw new \Exception( \sprintf( 'Could not read file: %s', $file ) );
		}

		$pattern = self::get_regex( $key );

		$replacement = '${1}' . $value;

		$file_data = \preg_replace( $pattern, $replacement, $file_data );

		$result = \file_put_contents( $file, $file_data );

		if ( false === $result ) {
			throw new \Exception( \sprintf( 'Could not write data to file: %s.', $file ) );
		}
	}

	/**
	 * Get regular expression to match and replace header value.
	 *
	 * @link https://github.com/WordPress/WordPress/blob/6.0/wp-includes/shortcodes.php#L236-L300
	 * @link https://github.com/wp-cli/i18n-command/blob/v2.4.0/src/MakePotCommand.php#L122-L166
	 * @link https://github.com/WordPress/WordPress/blob/6.0/wp-includes/kses.php#L1491-L1512
	 * @link https://php.watch/articles/php-regex-readability
	 * @link https://github.com/wp-cli/i18n-command/blob/v2.4.0/src/FileDataExtractor.php#L39-L57
	 * @link https://github.com/WordPress/wordpress-develop/blob/6.0.2/src/wp-includes/functions.php#L6631-L6669
	 */
	private static function get_regex( $key ) {
		$pattern = '';

		/**
		 * Delimter.
		 * 
		 * @link https://www.php.net/manual/en/regexp.reference.delimiters.php
		 */
		$delimter = '/';

		/**
		 * Starting delimter.
		 */
		$pattern .= $delimter;

		/**
		 * Start of line.
		 * 
		 * @link https://www.php.net/manual/en/regexp.reference.meta.php#regexp.reference.meta
		 */
		$pattern .= '^';

		/**
		 * Start group all charachters before the actual header value.
		 */
		$pattern .= '(?P<prefix>';

		/**
		 * Spacing / comments characters.
		 * - space
		 * - tab
		 * - slash /
		 * - asterisk *
		 * - number sign #
		 * - at sign @
		 */
		$pattern .= '[ \t\/*#@]*';

		/**
		 * File header key.
		 * 
		 * @link https://www.php.net/preg_quote
		 */
		$pattern .= preg_quote( $key, $delimter );

		/**
		 * Colon that separate key and value.
		 */
		$pattern .= ':';

		/**
		 * Spacing after colon.
		 */
		$pattern .= '[ \t]*';

		/**
		 * End group all charachters before the actual header value.
		 */
		$pattern .= ')';

		/**
		 * File header value.
		 * 
		 * @link https://www.php.net/manual/en/regexp.reference.subpatterns.php
		 */
		$pattern .= '(?P<value>.*)';

		/**
		 * Ending delimter.
		 */
		$pattern .= $delimter;

		/**
		 * Multiline modifier.
		 * 
		 * @link https://www.php.net/manual/en/reference.pcre.pattern.modifiers.php
		 */
		$pattern .= 'm';

		/**
		 * Caseless modifier.
		 * 
		 * @link https://www.php.net/manual/en/reference.pcre.pattern.modifiers.php
		 */
		$pattern .= 'i';

		return $pattern;
	}
}
