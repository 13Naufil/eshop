<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model
{
    private $user_data;
    private $user_access;
    public  $logged_in;
    public  $error;

    /**
     * -----------------------------------------------------------------------------------------------------------------
     * User Init
     * -----------------------------------------------------------------------------------------------------------------
     */

    public function __construct()
    {
        parent::__construct();

        $this->user_data = array();
        $this->logged_in = false;

        $logged_in = $this->session->userdata('logged_in');
        if ($logged_in === false) {
            $logged_in = get_cookie('logged_in');
            if ($logged_in !== false) {
                $this->session->set_userdata('logged_in', $logged_in);
            }
        }

        if ($logged_in !== false) {
            $logged_in = explode('|', $logged_in);
            $this->login($logged_in[1], $logged_in[0], false, 'id');
        }
    }

    /**
     * -----------------------------------------------------------------------------------------------------------------
     * Get User Properties
     * -----------------------------------------------------------------------------------------------------------------
     */

    public function __get($column)
    {
        if (isset($this->user_data[$column])) {
            return $this->user_data[$column];
        } else {
            return parent::__get($column);
        }
    }

    /**
     * -----------------------------------------------------------------------------------------------------------------
     * Set User Properties
     * -----------------------------------------------------------------------------------------------------------------
     */

    public function __set($column, $value)
    {
        $this->user_data[$column] = $value;
    }

    /**
     * -----------------------------------------------------------------------------------------------------------------
     * User Login
     * -----------------------------------------------------------------------------------------------------------------
     */

    public function login($username, $password, $remember = false, $id_column = 'username')
    {
        $result = $this->db->get_where('users', array($id_column => $username, 'password' => $password));

        if ($result->num_rows() > 0) {
            $this->user_data = $result->row_array();

            if ($this->user_data['status'] == 'active') {
                $this->logged_in = true;

                # User Login Data
                $this->db->select('activity_datetime,user_ip')->where(array('activity_name' => 'user_login', 'user_id' => $this->user_data['id']))->order_by('id', 'desc')->limit(1, 1);
                $last_login = $this->db->get('activity_log')->row_array();
                $this->user_data['last_login'] = isset($last_login['activity_datetime']) ? strtotime($last_login['activity_datetime']) : null;
                $this->user_data['last_login_ip'] = isset($last_login['user_ip']) ? $last_login['user_ip'] : null;

                # User Access
                $user_access = $this->db->query("SELECT m.name,a.components FROM user_access AS a INNER JOIN modules AS m ON m.id = a.module_id WHERE a.user_id = ?", array($this->user_data['id']));
                foreach ($user_access->result() as $row) {
                    $this->user_access[$row->name] = $row->components;
                }

                # Create User Session
                $logged_in_string = $this->user_data['password'] . '|' . $this->user_data['id'];
                $this->session->set_userdata('logged_in', $logged_in_string);
                if ($remember) set_cookie('logged_in', $logged_in_string, time() + 60 * 60 * 24 * 30);
                return true;
            } else {
                $this->error = "Your account is blocked.";
            }
        } else {
            $this->error = "Incorrect Username or Password.";
        }

        return false;
    }

    /**
     * -----------------------------------------------------------------------------------------------------------------
     * User Update
     * -----------------------------------------------------------------------------------------------------------------
     */

    public function update($data, $user_id = null)
    {
        if (is_null($user_id)) {
            $user_id = $this->user_data['id'];
            foreach ($data as $column => $value) {
                $this->user_data[$column] = $value;
            }
        }
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
    }

    /**
     * -----------------------------------------------------------------------------------------------------------------
     * User Get
     * -----------------------------------------------------------------------------------------------------------------
     */

    public function get($fields, $where)
    {
        $user = $this->db->select($fields)->where($where)->get('users');
        if ($user->num_rows() > 0) {
            $user = $user->row_array();
            if (count($user) > 1) {
                return $user;
            } else {
                return $user[$fields];
            }
        } else {
            return false;
        }
    }

    /**
     * -----------------------------------------------------------------------------------------------------------------
     * User Can Access Module
     * -----------------------------------------------------------------------------------------------------------------
     */

    public function can_access($module_name)
    {
        if ($this->is_super_user() || array_key_exists($module_name, $this->user_access)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * -----------------------------------------------------------------------------------------------------------------
     * User Can Access Module Component
     * -----------------------------------------------------------------------------------------------------------------
     */

    public function can($component, $module_name)
    {
        if ($this->is_super_user()) return true;

        $module_components = explode('|', $this->user_access[$module_name]);
        if (in_array($component, $module_components)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * -----------------------------------------------------------------------------------------------------------------
     * Check Super User
     * -----------------------------------------------------------------------------------------------------------------
     */

    public function is_super_user()
    {
        $super_users = array('developer', 'super_admin', 'admin');
        if (in_array($this->user_data['type'], $super_users)) {
            return true;
        } else {
            return false;
        }
    }
}

/* End of file user.php */
/* Location: ./application/models/user.php */