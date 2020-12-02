<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Index
 * @property Cms $cms
 * @property M_customers $m_customers
 */
class Customer extends CI_Controller
{

    function __construct()
    {
        session_start();
        parent::__construct();
        $this->load->helper('frontend');
        $this->load->model('cms');
        $this->load->model(ADMIN_DIR . 'm_customers');
        $this->load->model(ADMIN_DIR . 'm_orders');

    }

    /**
     * void account
     */
    function account()
    {

        $customer_login = getSession('customer_login');
        if (!$customer_login) {
            redirect('customer/login');
        }
        $customer_id = getSession('customer_user_id');

        $data['customer'] = $this->m_customers->customer($customer_id);

        $edit = getUri(3);
        if ($edit == 'edit') {
            $data['edit'] = true;
            $data['row'] = $data['customer'];
            $this->template->load('customer/edit_profile', $data);
        } else {
            $this->template->load('customer/dashboard', $data);
        }
    }

    /**
     * void account
     */
    function order()
    {
        $customer_login = getSession('customer_login');
        if (!$customer_login) {
            redirect('customer/login');
        }
        $customer_id = getSession('customer_user_id');

        $action = getUri(3);
        switch ($action) {
            case 'view':
                $id = intval(getVar('id'));
                if ($id > 0) {
                    $query = "SELECT * FROM orders WHERE id='{$id}' AND customer_id='{$customer_id}' AND status !='Process'";
                    $data['order'] = $this->db->query($query)->row();
                    if ($data['order']->id == $id) {

                        $data['customer'] = $this->m_customers->customer($data['order']->customer_id);
                        if(!SHIPPING_BILLING_ADD) {
                            $data['billing'] = $data['customer'];
                            $data['shipping'] = $data['customer'];
                        }else {
                            $billing = $this->m_customers->customer_address($data['order']->customer_id, '', $data['order']->billing_add_id);
                            $shipping = $this->m_customers->customer_address($data['order']->customer_id, '', $data['order']->shipment_add_id);
                            $data['billing'] = $billing[0];
                            $data['shipping'] = $shipping[0];
                        }

                        $data['order_detail'] = $this->catalog->order_detail($id);

                        /*$total_r = $this->catalog->total($id, true);
                        $total_amount = ($total_r->amount + $total_r->shipping_amount - $total_r->discount);
                        $data['shipping_amount'] = ($total_r->shipping_amount);
                        $data['discount'] = ($total_r->discount);
                        $data['total_amount'] = ($total_amount);*/

                        $this->template->load('customer/order_view', $data);
                        return;
                    }
                }
                show_404();
                break;
        }


    }

    /**
     * void wishlist
     */
    function wishlist()
    {
        $customer_login = getSession('customer_login');
        if (!$customer_login) {
            redirect('customer/login');
        }
        $customer_id = getSession('customer_user_id');

        $data['customer'] = $this->m_customers->customer($customer_id);

        $data['products'] = $this->m_customers->wishlist($customer_id);

        $this->template->load('customer/wishlist', $data);
    }

    /**
     * void wishlist
     */
    function add_wishlist()
    {

        $customer_login = getSession('customer_login');
        if (!$customer_login) {
            redirect('customer/login');
        }
        $DBdata['customer_id'] = getSession('customer_user_id');
        $DBdata['product_id'] = $this->uri->segment(3);
        $DBdata['created'] = date('Y-m-d H:i:s');

        print_r($DBdata);
        save('customer_wishlist',$DBdata);
        redirect('customer/wishlist');
    }

    /**
     * void wishlist
     */
    function orders()
    {

        $customer_login = getSession('customer_login');
        if (!$customer_login) {
            redirect('customer/login');
        }
        $customer_id = getSession('customer_user_id');

        $data['customer'] = $this->m_customers->customer($customer_id);

        $data['orders'] = $this->m_customers->orders($customer_id);

        $this->template->load('customer/orders', $data);
    }

    /**
     * void login
     */
    function login()
    {
        $checkout = getVar('checkout');

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() !== FALSE) {
                $email = getVar('email');
                $password = getVar('password');

                $login_sql = "SELECT  * FROM `customers` WHERE `email` = '" . $email . "' AND `password` = '" . md5($password) . "' AND status='Active' AND customer_type != 'guest'";
                $user_detail = $this->db->query($login_sql);

                if ($user_detail->num_rows() > 0) {
                    $user_detail = $user_detail->row();
                    $user_id = $user_detail->id;

                    $this->update_customer_orders($user_id);

                    activity_log('Customer Login', 'customers', $user_id, $user_id);

                    $this->session->set_userdata('customer_login', true);
                    $this->session->set_userdata('customer_user_id', $user_id);

                    if ($checkout) {
                        redirect('cart/checkout');
                    } else if (getVar('redirect') != '') {
                        redirect(getVar('redirect'));
                    } else {
                        redirect('cart');
                    }
                } else {
                    $data['login_error'] = 'Invalid email or password!';
                }
            }
        }

        $data['checkout'] = $checkout;
        $this->template->load('customer/login', $data);
    }


    /**
     * void registration
     */
    function registration()
    {
        $checkout = getVar('checkout');
        $edit = getVar('edit');
        $change_pass = getVar('change_pass');

        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $chk_where = '';
            if ($edit) {
                $customer_id = getSession('customer_user_id');
                if (!$customer_id) {
                    redirect('customer/login');
                }
                //$customer = $this->m_customers->customer($customer_id);
                $chk_where .= " AND id !='{$customer_id}'";
            }
            # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            # Validation
            //$email_exist = $this->db->query("SELECT * FROM `customers` WHERE `email`='" . getVar('email') . "'" . $chk_where);
            if ($change_pass == 1) {
                //$chk_pass = $this->db->query("SELECT id FROM `customers` WHERE 1 AND password='" . md5(getVar('current_password')) . "'" . $chk_where);
            }
            /*if (empty($_SESSION['captcha']) || trim(strtolower($_REQUEST['captcha'])) != $_SESSION['captcha']) {
                $captcha_error = "Invalid captcha";
                $data['captcha_error'] = $captcha_error;
                //$this->session->set_flashdata('error', $captcha_error);
            } else */
            /*if ($email_exist->num_rows() > 0) {
                $this->session->set_flashdata('error', 'Email address already exist.');
            } else */{

                $this->form_validation->set_rules('first_name', 'First Name', 'required');
                $this->form_validation->set_rules('last_name', 'Last Name', 'required');
                if (!$customer_id) {
                    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
                    $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[12]');
                }

                if ($change_pass == 1 && $customer_id) {
                    $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[12]|matches[confirm_password]');
                    $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required');
                }

                $this->form_validation->set_rules('address', 'Address', 'required');
                $this->form_validation->set_rules('city', 'City', 'required');
                //$this->form_validation->set_rules('state', 'State/Province', 'required');
                //$this->form_validation->set_rules('country', 'Country', 'required');
                $this->form_validation->set_rules('phone', 'Phone', 'required');

                if ($this->form_validation->run() !== FALSE) {

                    # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                    # Customer Data
                    $DbArray = getDbArray('customers');
                    $DBdata = $DbArray['dbdata'];
                    $password = $DBdata['password'];
                    $DBdata['password'] = md5($password);
                    $DBdata['customer_type'] = 'customer';
                    $DBdata['modified'] = date('Y-m-d H:i:s');
                    $DBdata['created'] = date('Y-m-d H:i:s');
                    if ($customer_id) {
                        unset($DBdata['email'],$DBdata['customer_type'],$DBdata['created']);
                    }
                    if ($customer_id && $change_pass != 1) {
                        unset($DBdata['password']);
                    }

                    if ($customer_id) {
                        save('customers', $DBdata, "id='{$customer_id}'");
                    } else {

                        $user_id = save('customers', $DBdata);
                        $this->update_customer_orders($user_id);

                        # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                        # registration_email
                        $customer = $this->m_customers->customer($user_id);
                        $customer->password = $password;
                        $msg = get_email_template($customer, 'New Account');
                        if ($msg->status == 'Active') {
                            $emaildata = array(
                                'to' => $customer->email,
                                'subject' => $msg->subject,
                                'message' => $msg->message
                            );
                            if (!send_mail($emaildata)) {
                                $this->session->set_flashdata('error', 'Email sending faild.');
                            } else {
                                $this->session->set_flashdata('success', 'Please check your email for username & password!');
                            }
                        }

                        # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                        # customer_addresses
                        $DbArray = getDbArray('customer_addresses', array(), $DBdata);
                        $DbArray['dbdata']['customer_id'] = $user_id;
                        $DbArray['dbdata']['default_billing'] = 1;
                        $DbArray['dbdata']['default_shipping'] = 1;
                        save('customer_addresses', $DbArray['dbdata']);


                        # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                        # Set Session
                        $this->session->set_userdata('customer_login', true);
                        $this->session->set_userdata('customer_user_id', $user_id);
                    }
                    activity_log('Customer Registration', 'customers', $user_id, $user_id);
                    # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                    # redirect
                    if ($checkout) {
                        redirect('cart/checkout');
                    } else if (getVar('redirect') != '') {
                        redirect(getVar('redirect'));
                    } else {
                        redirect('');
                    }
                }
            }
        }
        $data['row'] = array2object($this->input->post());
        $data['checkout'] = $checkout;

        $this->template->load('customer/registration', $data);

    }

    /**
     * @param $email
     * @return bool
     */
    public function email_check($email)
    {
        $customer_id = intval(getSession($this->session_user));
        $email_exists = $this->db->get_where('customers', array('email' => $email, 'id <>' => $customer_id, 'customer_type <>' => 'guest'))->num_rows() > 0 ? true : false;
        if ($email_exists) {
            $this->form_validation->set_message('email_check', 'This email is already exists');
            return FALSE;
        }
    }


    /**
     * @param $customer_user_id
     */
    function update_customer_orders($customer_user_id)
    {
        $order_id = getSession('customer_order_id');
        $user_id = getSession('customer_user_id');

        if ($order_id > 0) {
            save('orders', array('customer_id' => $customer_user_id), "id=" . $order_id);// . " AND customer_id=" . $user_id

            if (CHK_MAX_QTY) {
                $products = $this->db->select('products.id,products.name,products.max_sale_qty, order_details.id as did, order_details.qty')->join('products', 'products.id=order_details.product_id')->get_where('order_details', array('order_id' => $order_id))->result();
                if (count($products) > 0) {
                    foreach ($products as $product) {
                        $total_qty = $this->catalog->validate_max_qty($customer_user_id, $product->id, $product->max_sale_qty);

                        if ($total_qty > $product->max_sale_qty) {
                            $purchased_qty = ($total_qty - $product->qty);
                            $cart_qty = $product->qty;
                            $max_sale_qty = $product->max_sale_qty;
                            $qty = ($product->max_sale_qty - ($total_qty - $product->qty));
                            /*echo '<pre>';print_r($purchased_qty);echo '</pre>';
                            echo '<pre>';print_r($cart_qty);echo '</pre>';
                            echo '<pre>';print_r($qty);echo '</pre>';
                            die('Call');*/
                            if($qty <= 0){
                                delete_rows('order_details', "id='{$product->did}'");
                            }else{
                                save('order_details', array('qty' => $qty), "id='{$product->did}'");
                            }
                            getFlash('error', '<strong>' . $product->name . '</strong> you have already purchased '.($purchased_qty).' qty of ' . $max_sale_qty . ($remaining > 0 ? ' remaining : '. $remaining : ''));
                        }
                    }
                }
            }
        }

    }


    /**
     * void forget
     */
    public function forget()
    {
        $checkout = getVar('checkout');

        $email_exist = $this->db->query("SELECT * FROM `customers` WHERE `email`='" . getVar('email') . "'");
        if ($email_exist->num_rows() > 0) {
            $customer = $email_exist->row();

            $this->load->helper('string');
            $tocken_num = random_string('alnum', 12);
            save('customers', array('token_num' => ($tocken_num)), "id=" . $customer->id);


            # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            # Email notification
            $member = $this->m_customers->customer($customer->id);
            unset($member->password);

            $msg = get_email_template($member, 'Forgot Password');

            if ($msg->status == 'Active') {
                $emaildata = array(
                    'to' => $member->email,
                    //'cc' => get_option('contact_email'),
                    'subject' => $msg->subject,
                    'message' => $msg->message
                );
                if (!send_mail($emaildata)) {
                    getFlash('error', 'Email sending failed.');
                } else {
                    getFlash('success', 'Please check your email.');
                }
            }
        } else {
            $this->session->set_flashdata('error', 'Email address is not exist');
        }

        redirectBack();
    }

    /**
     * void reset Password
     */
    public function reset()
    {
        $user_id = intval(getVar('uid'));
        $token_num = getVar('token');

        if (!$user_id || !$token_num) {
            $this->session->set_flashdata('error_msg', 'Password reset link is broken.');
            redirect('customer/login');
        }
        $customer = $this->m_customers->customer($user_id, "AND token_num='{$token_num}' AND status='Active'");

        if ($customer->id <= 0) {
            $this->session->set_flashdata('error_msg', 'Password reset link is invalid or already used.');
            redirect('customer/login');
        }

        if ($this->input->post('reset')) {
            $data = array();

            $newpass = $this->input->post('newpass');
            $confpass = $this->input->post('confpass');

            if (!empty($newpass)) {
                if (!empty($confpass)) {
                    if ($newpass == $confpass) {
                        if (strlen($newpass) >= 6 && strlen($newpass) <= 12) {

                            save('customers', array('password' => md5($newpass), 'token_num' => ''), "id='" . $user_id . "'");
                            $this->session->set_flashdata('success', 'Your password has been reset successfully.');
                            redirect('customer/login');
                        } else {
                            $data['error'] = "Password should be 6 to 12 characters long.";
                        }
                    } else {
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

        $this->template->load('customer/reset', $data);
    }


    /**
     * void logout
     */
    public function logout()
    {
        $customer_id = getSession('customer_user_id');
        $order_id = getSession('customer_order_id');
        activity_log('Customer Logout', 'customers', $customer_id, $customer_id);
        $this->m_orders->_delete($order_id);
        $this->session->unset_userdata(array(
            'customer_order_id' => '',
            'customer_user_id' => '',
            'customer_login' => ''
        ));

        redirect();
    }

    function subscribe(){
        $email = getVar('email', true, false);
        $db_data = array(
            'email' => $email,
            'created' => date('Y-m-d H:i:s'),
            'status' => 'Subscribe');
        $customer_id = getSession('customer_user_id');
        if($customer_id > 0){
            $db_data['customer_id'] = $customer_id;
        }
        $id = save('subscribers', $db_data);

        activity_log('Subscribe', 'subscribers', $id, $customer_id);

        $msg = get_email_template($this->input->post(), 'New Subscriber');
        if ($msg->status == 'Active') {
            $emaildata = array(
                'to' => $email,
                'subject' => $msg->subject,
                'message' => $msg->message
            );
            if (!send_mail($emaildata)) {
                getFlash('error', 'Email sending failed.');
            } else {
                getFlash('success', 'Please check your email.');
            }
        }
        redirectBack();
    }

    function unsubscribe(){
        $email = getVar('email', true, false);

        $id = save('subscribers', array(), "email='{$email}'");

        activity_log('Unsubscribe', 'subscribers', $id);

        $msg = get_email_template($this->input->post(), 'Unsubscribe');
        if ($msg->status == 'Active') {
            $emaildata = array(
                'to' => $email,
                'subject' => $msg->subject,
                'message' => $msg->message
            );
            if (!send_mail($emaildata)) {
                getFlash('error', 'Email sending failed.');
            } else {
                getFlash('success', 'Please check your email.');
            }
        }
        redirectBack();
    }

}


/* End of file cart.php */
/* Location: ./application/controllers/cart.php */