<?php
/**
 * Developed by Naufil khan.
 * Email: pisces_adnan@hotmail.com
 * Autour: Naufil khan
 * Date: 5/26/12
 * Time: 10:35 AM
 */
/**
 * Class Login
 * @property M_Modules $m_modules
 * @property M_cpanel $m_cpanel
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('cookie');
        $this->load->model(ADMIN_DIR . 'm_login');

    }

    public function index()
    {
        if ($this->session->userdata('cct_user_id')) {
            redirect(ADMIN_DIR . 'dashboard');
        }

        $cookie = explode('|', $this->input->cookie('logged_in'));
        if (count($cookie) > 0) {
            $data['user_name'] = stripslashes($cookie[0]);
            $data['password'] = $cookie[1];
            $data['remember'] = $cookie[2];

            $data['remember_data'] = $this->db->select('first_name, last_name, photo')->from('users')->where(array('username' => $data['user_name'], 'password' => encryptPassword($data['password'])))->get()->row();
        }
        //Load Login
        $this->load->view(ADMIN_DIR . 'login', $data);
    }


    public function forgot()
    {
        if ($this->session->userdata('cct_user_id')) {
            redirect(ADMIN_DIR . 'dashboard');
        }
        $data = array();

        if (isset($_POST['recover'])) {
            $email = $this->input->post('email');

            if (!empty($email)) {
                $user = getValues('users', 'id,status', "WHERE email='" . $email . "'");

                if ($user->id !== false) {
                    if ($user->status == 'Active') {
                        $this->load->helper('string');
                        $token_num = md5(random_string());
                        save('users', array('token_num' => $token_num), "id='" . $user->id . "'");

                        $reset_pass_url = admin_url('login/reset?uid=' . $user->id . '&token=' . $token_num);
                        $site_url = site_url();

                        $email_content = '<p>Someone requested that the password be reset for the following account:</p>';
                        $email_content .= '<p><a href="' . $site_url . '">' . $site_url . '</a></p>';
                        $email_content .= '<p>If this was a mistake, just ignore this email and nothing will happen.</p>';
                        $email_content .= '<p>To reset your password, visit the following address:</p>';
                        $email_content .= '<p>&lt;<a href="' . $reset_pass_url . '">' . $reset_pass_url . '</a>&gt;</p>';

                        $this->load->library('email');
                        $this->email->initialize(array('mailtype' => 'html'));
                        $this->email->to($email)->subject('Password Recovery');
                        $this->email->message($email_content);
                        $this->email->from('info@' . $this->input->server('SERVER_NAME'));
                        $this->email->send();


                        if ($this->email->send())
                            $data['success'] = "Email sent successfully.";
                        else
                            $data['error'] = "Email sending faild.";
                    } else {
                        $data['error'] = "Your account is blocked.";
                    }
                } else {
                    $data['error'] = "Incorrect email address.";
                }
            } else {
                $data['error'] = "Please enter your email address.";
            }
        }
        $_POST += $data;
        $this->load->view(ADMIN_DIR . 'forgot', $data);

    }

    public function do_login()
    {
        if (!$this->m_login->validate()) {
            $this->index();
            exit;
        } else {
            
            $user_name = getVar('user_name');
            $password = encryptPassword(getVar('password'));
            $remember = getVar('remember');

            $result = $this->m_login->chklogin($user_name, $password);

            $logged_in_string = $user_name . '|' . getVar('password') . '|' . $remember;
            if ($remember) set_cookie('logged_in', $logged_in_string, time() + 60 * 60 * 24 * 30);
            else { set_cookie('logged_in', '', -70 + time());}

            if ($result) {
                $this->session->set_userdata(array(
                    'cct_user_id' => $result->id,
                    'username' => $result->username,
                    'email' => $result->email,
                    'user_type' => $result->user_type_id,
                    'user_info' => $result,
                ));

                $REFERER = $this->session->userdata('REFERER');
                $this->session->unset_userdata(array('REFERER' => ''));
                if (!empty($REFERER)) {
                    redirect($REFERER);
                }

                redirect(ADMIN_DIR . 'dashboard');
                //redirect(ADMIN_DIR . 'reports');
            } else {
                $this->session->set_flashdata('error', 'Incorrect User Name or Password!');
                redirect(ADMIN_DIR . 'login');
            }
        }
    }

    public function logout()
    {
        $this->session->unset_userdata(array(
            'cct_user_id' => '',
            'username' => '',
            'email' => '',
            'user_type' => '',
            'user_info' => '',
        ));
        redirect(ADMIN_DIR);
    }

    public function update_pass()
    {
        $user_id = $this->session->userdata('cct_user_id');
        $old_password = md5(getVar('old_password'));
        $password = md5(trim(getVar('password')));
        $sql = "SELECT * FROM users WHERE user_id={$user_id} AND `password`='{$old_password}'";
        $rs = $this->db->query($sql);
        if ($rs->num_rows() > 0) {
            $update_sql = "UPDATE users SET `password` = '{$password}' WHERE user_id = '{$user_id}'";
            $this->db->query($update_sql);
            echo 'Successfully Changed New Password';
        } else {
            echo 'Your old password is wrong...';
        }
    }


    /**
     * -----------------------------------------------------------------------------------------------------------------
     * Password Reset
     * -----------------------------------------------------------------------------------------------------------------
     */

    public function reset()
    {
        if ($this->session->userdata('cct_user_id')) {
            redirect(ADMIN_DIR . 'dashboard');
        }

        $user_id = intval(getVar('uid'));
        $token_num = getVar('token');

        if (!$user_id || !$token_num) {
            $this->session->set_flashdata('error_msg', 'Password reset link is broken.');
            redirect(ADMIN_DIR . '/login');
        }

        $user = getValues('users', '*', "WHERE id='" . $user_id . "' AND token_num='" . $token_num . "' AND status='Active'");

        if (count($user) == 0) {
            $this->session->set_flashdata('error_msg', 'Password reset link is invalid or already used.');
            redirect(ADMIN_DIR . '/login');
        }

        if ($this->input->post('reset')) {
            $data = array();

            $newpass = $this->input->post('newpass');
            $confpass = $this->input->post('confpass');

            if (!empty($newpass)) {
                if (!empty($confpass)) {
                    if($newpass == $confpass){
                        if (strlen($newpass) >= 6 && strlen($newpass) <= 12) {

                            save('users', array('password' => encryptPassword($newpass),'token_num' => ''), "id='" . $user_id . "'");
                            $this->session->set_flashdata('success', 'Your password has been reset successfully.');
                            redirect(ADMIN_DIR . '/login');
                        } else {
                            $data['error'] = "Password should be 6 to 12 characters long.";
                        }
                    }else{
                        $data['error'] = "Passwords do not match.";
                    }
                } else {
                    $data['error'] = "Please confirm your new password.";
                }
            } else {
                $data['error'] = "Please enter your new password.";
            }
            $_POST += $data;
        }

        $this->load->view(ADMIN_DIR . '/reset_login', $data);
    }


}