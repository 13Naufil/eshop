<?php
/**
 * Developed by Naufil khan.
 * Email: pisces_adnan@hotmail.com
 * Autour: Naufil khan
 * Date: 5/30/12
 * Time: 12:56 AM
 */


if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_DB_mysql_driver extends CI_DB_mysql_driver
{

    function __construct($params)
    {
        parent::__construct($params);
        if(MYSQL_TIME_ZONE != ''){
            $this->query('SET time_zone = "' . MYSQL_TIME_ZONE . '"');
        }
        log_message('debug', 'Extended DB driver class instantiated!');
    }

    public function found_rows()
    {
        return $this->query("SELECT FOUND_ROWS() as total")->row()->total;
    }
}

