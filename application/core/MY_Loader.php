<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Loader extends CI_Loader
{
    public function __construct()
    {
        parent::__construct();
    }

	/**
	 * Database Loader
	 *
	 * @param	string	the DB credentials
	 * @param	bool	whether to return the DB object
	 * @param	bool	whether to enable active record (this allows us to override the config setting)
	 * @return	object
	 */
	public function database($params = '', $return = FALSE, $active_record = NULL)
	{
        // Do we even need to load the database class?
        if (class_exists('CI_DB') AND $return == FALSE AND $active_record == FALSE)
        {
            return FALSE;
        }

        require_once(BASEPATH.'database/DB'.EXT);

        // Load the DB class
        $db =& DB($params, $active_record);

        $my_driver = config_item('subclass_prefix').'DB_'.$db->dbdriver.'_driver';
        $my_driver_file = APPPATH.'libraries/'.$my_driver.EXT;

        if (file_exists($my_driver_file))
        {
            require_once($my_driver_file);
            $db = new $my_driver(get_object_vars($db));
        }

        if ($return === TRUE)
        {
            return $db;
        }
        // Grab the super object
        $CI =& get_instance();

        // Initialize the db variable.  Needed to prevent
        // reference errors with some configurations
        $CI->db = '';
        $CI->db = $db;
	}

}

/* End of file RS_Loader.php */
/* Location: ./application/core/RS_Loader.php */