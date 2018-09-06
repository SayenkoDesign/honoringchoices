<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Controls Stack.
 *
 * A base abstract class that provides the needed properties and methods to
 * manage and handle controls in the editor panel to inheriting classes.
 *
 * @since 1.4.0
 * @abstract
 */
abstract class Controls_Stack {

	/**
	 * Generic ID.
	 *
	 * Holds the unique ID.
	 *
	 * @access private
	 *
	 * @var string
	 */
	private $_id;

	/**
	 * Parsed Settings.
	 *
	 * Holds the settings, which is the data entered by the user
	 *
	 * @access private
	 *
	 * @var null|array
	 */
	private $_settings;

	/**
	 * Raw Data.
	 *
	 * Holds all the raw data including the element type, the child elements,
	 * the user data.
	 *
	 * @access private
	 *
	 * @var null|array
	 */
	private $_data;
    
    
    /**
	 * Feilds.
	 *
	 * Holds all the fields for the element
	 *
	 * @access private
	 *
	 * @var null|array
	 */
	private $_fields;

	/**
	 * Get element name.
	 *
	 * Retrieve the element name.
	 *
	 * @since 1.4.0
	 * @access public
	 * @abstract
	 *
	 * @return string The name.
	 */
	abstract public function get_name();

	/**
	 * Get unique name.
	 *
	 * Some classes need to use unique names, this method allows you to create
	 * them. By default it retrieves the regular name.
	 *
	 * @since 1.6.0
	 * @access public
	 *
	 * @return string Unique name.
	 */
	public function get_unique_name() {
		return $this->get_name();
	}

	/**
	 * Get element ID.
	 *
	 * Retrieve the element generic ID.
	 *
	 * @since 1.4.0
	 * @access public
	 *
	 * @return string The ID.
	 */
	public function get_id() {
		return $this->_id;
	}

	/**
	 * Get element ID.
	 *
	 * Retrieve the element generic ID as integer.
	 *
	 * @since 1.8.0
	 * @access public
	 *
	 * @return string The converted ID.
	 */
	public function get_id_int() {
		return hexdec( $this->_id );
	}

	/**
	 * Get the type.
	 *
	 * Retrieve the type, e.g. 'stack', 'element', 'widget' etc.
	 *
	 * @since 1.4.0
	 * @access public
	 * @static
	 *
	 * @return string The type.
	 */
	public static function get_type() {
		return 'stack';
	}

	/**
	 * Get items.
	 *
	 * Utility method that receives an array with a needle and returns all the
	 * items that match the needle. If needle is not defined the entire haystack
	 * will be returned.
	 *
	 * @since 1.4.0
	 * @access private
	 * @static
	 *
	 * @param array  $haystack An array of items.
	 * @param string $needle   Optional. Needle. Default is null.
	 *
	 * @return mixed The whole haystack or the needle from the haystack when requested.
	 */
	protected static function _get_items( array $haystack, $needle = null ) {
		if ( $needle ) {
			return isset( $haystack[ $needle ] ) ? $haystack[ $needle ] : null;
		}

		return $haystack;
	}

	/**
	 * Get the raw data.
	 *
	 * Retrieve all the items or, when requested, a specific item.
 	 *
	 * @since 1.4.0
	 * @access public
	 *
	 * @param string $item Optional. The requested item. Default is null.
	 *
	 * @return mixed The raw data.
	 */
	public function get_data( $item = null ) {
		return self::_get_items( $this->_data, $item );
	}

	/**
	 * Get the settings.
	 *
	 * Retrieve all the settings or, when requested, a specific setting.
 	 *
	 * @since 1.4.0
	 * @access public
	 *
	 * @param string $setting Optional. The requested setting. Default is null.
	 *
	 * @return mixed The settings.
	 */
	public function get_settings( $setting = null ) {
		return self::_get_items( $this->_settings, $setting );
	}

	/**
	 * Set settings.
	 *
	 * Change or add new settings to an existing control in the stack.
	 *
	 * @since 1.4.0
	 * @access public
	 *
	 * @param string|array $key   Setting name, or an array of key/value.
	 * @param string|null  $value Optional. Setting value. Optional field if
	 *                            `$key` is an array. Default is null.
	 */
	final public function set_settings( $key, $value = null ) {
		// strict check if override all settings.
		if ( is_array( $key ) ) {
			$this->_settings = $key;
		} else {
			$this->_settings[ $key ] = $value;
		}
	}
    
    /**
	 * Get the fields.
	 *
	 * Retrieve all the fields or, when requested, a specific field.
 	 *
	 * @since 1.4.0
	 * @access public
	 *
	 * @param string $fields Optional. The requested fields. Default is null.
	 *
	 * @return mixed The fields.
	 */
	public function get_fields( $field = null ) {
		return self::_get_items( $this->_fields, $field );
	}

	/**
	 * Set fields.
	 *
	 * Change or add new fields to an existing control in the stack.
	 *
	 * @since 1.4.0
	 * @access public
	 *
	 * @param string|array $key   Fields name, or an array of key/value.
	 * @param string|null  $value Optional. Fields value. Optional field if
	 *                            `$key` is an array. Default is null.
	 */
	final public function set_fields( $key, $value = null ) {
		// strict check if override all fields.
		if ( is_array( $key ) ) {
			$this->_fields = $key;
		} else {
			$this->_fields[ $key ] = $value;
		}
	}


	/**
	 * Get default data.
	 *
	 * Retrieve the default data. Used to reset the data on initialization.
	 *
	 * @since 1.4.0
	 * @access protected
	 *
	 * @return array Default data.
	 */
	protected function get_default_data() {
		return [
			'id' => 0,
            'fields' => [],
			'settings' => [],
		];
	}

	/**
	 * Get parsed settings.
	 *
	 * Retrieve the parsed settings for all the controls that represent them.
	 * The parser set default values and process the settings.
	 *
	 * Classes that extend `Controls_Stack` can add new process to the settings
	 * parser.
	 *
	 * @since 1.4.0
	 * @access protected
	 *
	 * @return array Parsed settings.
	 */
	protected function _get_parsed_settings() {
		$settings = $this->_data['settings'];
        		
		return $settings;
	}
    
    
    /**
	 * Get parsed fields.
	 *
	 * Retrieve the parsed fields for all the controls that represent them.
	 * The parser set default values and process the fields.
	 *
	 * Classes that extend `Controls_Stack` can add new process to the fields
	 * parser.
	 *
	 * @since 1.4.0
	 * @access protected
	 *
	 * @return array Parsed fields.
	 */
	protected function _get_parsed_fields() {
		$fields = $this->_data['fields'];
        		
		return $fields;
	}

	/**
	 * Render element.
	 *
	 * Generates the final HTML on the frontend.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {}

	/**
	 * Initialize the class.
	 *
	 * Set the raw data, the ID and the parsed settings.
	 *
	 * @since 1.4.0
	 * @access protected
	 *
	 * @param array $data Initial data.
	 */
	protected function _init( $data ) {
		$this->_data = array_merge( $this->get_default_data(), $data );
        
		$this->_id = $this->_data['id'];
        
		$this->_settings = $this->_get_parsed_settings();
        
        $this->_fields = $this->_get_parsed_fields();
	}

	/**
	 * Controls stack constructor.
	 *
	 * Initializing the control stack class using `$data`. The `$data` is required
	 * for a normal instance. It is optional only for internal `type instance`.
	 *
	 * @since 1.4.0
	 * @access public
	 *
	 * @param array $data Optional. Control stack data. Default is an empty array.
	 */
	public function __construct( array $data = [] ) {
		$this->_init( $data );
	}
}
