<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Index
 * @property Cms $cms
 * @property Template $template
 * @property Catalog $catalog
 * @property M_orders $m_orders
 * @property M_coupons $m_coupons
 */
class Cart extends CI_Controller
{

    var $table = 'orders';
    var $id_field = 'id';
    var $session_order = 'customer_order_id';
    var $session_user = 'customer_user_id';

    var $order_suffix = 'SO-';
    var $order_no_limit = 12;

    function __construct()
    {
        parent::__construct();
        $this->load->helper('frontend');
        $this->load->model('cms');
        $this->load->model(ADMIN_DIR . 'm_customers');
        $this->load->model(ADMIN_DIR . 'm_orders');
        $this->load->model(ADMIN_DIR . 'm_coupons');


        $this->load->helper('string');
        //load_fb();

    }


    function index()
    {

        $user_id = getSession($this->session_user);
        $order_id = getSession($this->session_order);

        if ($order_id > 0) {
            $data['order'] = $this->db->get_where('orders', array('id' => $order_id), 1)->row();
            if($data['order']->coupon_id) {
                $data['coupon'] = $this->db->get_where('coupons', array('id' => $data['order']->coupon_id), 1)->row();
            }
            $data['products'] = $this->catalog->cart_detail($order_id);

            $data['shipping_dtl'] = unserialize(get_option('shipping'));
            $rule = $this->m_coupons->validate_rules($order_id);
            $data['shipping_amount'] = (($rule->free_shipping) ? 0 : $data['shipping_dtl']['amount']);
            $data['discount'] = ($rule->discount + $data['order']->discount);

        }
        $this->template->load('cart/cart', $data);
    }


    function addcart()
    {

        $id = intval(getVar('id'));
        $cart_type = getVar('cart_type');

        $user_id = getSession($this->session_user);
        $order_id = getSession($this->session_order);
        $order_id = $this->db->get_where('orders', array('id' => $order_id), 1)->row()->id;

        if (!$order_id) {
            $order_number = $this->order_suffix . random_string('alnum', $this->order_no_limit);
            if (empty($user_id)) {
                $user_id = intval(substr(abs(intval((random_string('numeric', 8) + random_string('numeric', 8)) * random_string('numeric', 8))), 0, 10));
                getSession($this->session_user, $user_id);
            }

            $orders_db = array(
                //'order_number' => $order_number,
                'customer_id' => $user_id,
                'status' => 'Pending',
                'created' => date('Y-m-d H:i:s')
            );

            $order_id = save($this->table, $orders_db);
            save($this->table, array('order_number' => str_pad($order_id, 10, '0', STR_PAD_LEFT)), "id='{$order_id}'");
            getSession($this->session_order, $order_id);
        }

        if ($id > 0) {

            $qty = intval(getVar('qty') == 0 ? 1 : getVar('qty'));

            $chk_product = $this->catalog->get_product_price($id);
            $this->catalog->stock_validation($chk_product, $qty);
            $price = $chk_product->amount;

            $product_exists = getValues('order_details', 'id,qty', "WHERE product_id='{$id}' AND order_id='{$order_id}'");
            $order_dtl_id = $product_exists->id;
            $product_qty_exists = $product_exists->qty;
            if ($product_qty_exists > 0 && UPDATE_CART) {
                $qty = ($product_qty_exists + $qty);
                $order_details = array(
                    'qty' => $qty
                );
                save('order_details', $order_details, "order_id='{$order_id}' AND product_id='{$id}'");
            } else {
                $order_details = array(
                    'order_id' => $order_id,
                    'product_id' => $id,
                    'qty' => $qty,
                    'price' => $price,
                );

                $order_dtl_id = save('order_details', $order_details);

            }
            # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            # order_attr
            $order_attr = getVar('order_attr', true, false);
            if (count($order_attr) > 0) {
                foreach ($order_attr as $attr_id => $attr_value) {
                    $_db_order_attr = array(
                        'order_detail_id' => $order_dtl_id,
                        'order_id' => $order_id,
                        'product_id' => $id,
                        'attr_id' => $attr_id,
                        'attr_value' => $attr_value,
                    );
                    save('order_attributes', $_db_order_attr);
                }
            }
            # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            # order_options
            $options = getVar('options', true, false);
            $option_qty = getVar('option_qty', true, false);
            if (count($options) > 0) {
                foreach ($options as $k => $option_id) {
                    $ex_opt = $this->db->get_where('product_options', array('id' => $option_id), 1)->row();
                    $opt = $this->db->get_where('product_options', array('id' => $option_id), 1)->row();
                    $_db_order_attr = array(
                        'order_detail_id' => $order_dtl_id,
                        'order_id' => $order_id,
                        'product_id' => $id,
                        'option_id' => $option_id,
                        'qty' => $option_qty[$k],
                        'price' => $opt->price,
                    );
                    save('order_options', $_db_order_attr);
                }
            }
            # ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++#


            # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            # Update stock
            $this->catalog->update_stock($id, $qty);

            if ($cart_type == 'Quick Checkout') {
                $this->_quick_checkout();
            }
        }
        if ($this->input->is_ajax_request()) {
            $JSON['status'] = true;
            $JSON['html'] = $this->load->view(get_template_directory(true) . 'order_list', array(), true);
            echo json_encode($JSON);
            exit;
        } else {
            redirect('cart');
            //redirectBack();
        }
    }

    function update_cart()
    {
        $order_id = getSession($this->session_order);
        $customer_id = getSession($this->session_user);

        $order = $this->db->query("SELECT orders.*
        FROM order_details
        INNER JOIN orders ON (order_details.order_id = orders.id)
        WHERE orders.id='{$order_id}' AND orders.customer_id='{$customer_id}' AND status='Pending'")->row();

        $order_id = $order->id;

        $qtys = getVar('qty');

        if (count($qtys) > 0 && $order_id > 0) {

            foreach ($qtys as $product_id => $_did) {
                if ($product_id > 0) {

                    $chk_product = $this->catalog->get_product_price($product_id);
                    foreach ($_did as $did => $qty) {
                        $where = array('order_id' => $order_id, 'product_id' => $product_id);
                        if(!UPDATE_CART) {
                            $where['id'] = $did;
                        }
                        $ord_dtl = $this->db->get_where('order_details', $where, 1)->row();

                        $new_qty = ($qty > $ord_dtl->qty ? ($qty - $ord_dtl->qty) : -($ord_dtl->qty - $qty));

                        $this->catalog->stock_validation($chk_product, $qty);
                        # ++++++++++++++++++++++++++++++++++++++++++++++++++
                        # Update stock

                        $this->catalog->update_stock($product_id, $new_qty);

                        $order_details = array('qty' => $qty);

                        $dtl_where = "order_id=" . $order_id . " AND product_id=" . $product_id;
                        if(!UPDATE_CART) {
                            $dtl_where .= " AND id=" . $did;
                        }
                        save('order_details', $order_details, $dtl_where);
                    }

                }
            }
        }

        redirect('cart');
    }

    function delete_cart()
    {

        $order_id = getSession($this->session_order);
        //$customer_id = getSession($this->session_user);
        $did = intval(getVar('did'));

        $order = $this->db->query("SELECT orders.*
        FROM order_details
        INNER JOIN orders ON (order_details.order_id = orders.id)
        WHERE order_details.id='{$did}' AND orders.id='{$order_id}' AND orders.status='Pending'")->row();

        $order_id = $order->id;

        $qty = getVar('qty');


        if (is_array($qty) && $order_id > 0) {
            foreach ($qty as $product_id => $q) {
                if ($product_id > 0) {
                    # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                    # Update stock
                    $this->catalog->update_stock($product_id, $q, 'return');
                    # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                    # Delete order Product
                    delete_rows('order_details', "product_id='{$product_id}' AND order_id='{$order_id}'");
                }
            }
        } else if ($did > 0 && $order_id > 0) {

            # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            # Update stock
            $ord_dtl = $this->db->get_where('order_details', array('order_id' => $order_id, 'id' => $did), 1)->row();
            $this->catalog->update_stock($ord_dtl->product_id, $ord_dtl->qty, 'return');
            # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            # Delete order Product
            delete_rows('order_details', "id='{$did}' AND order_id='{$order_id}'");
        }

        redirect('cart');
    }


    function checkout($data = array())
    {
        
        $user_id = getSession($this->session_user);
        $order_id = getSession($this->session_order);
        $customer_login = $data['customer_login'] = getSession('customer_login');

        if ($order_id > 0) {
            $data['products'] = $this->catalog->cart_detail($order_id);

            if (count($data['products']) == 0) {
                redirect('');
            }

            $data['shipping_dtl'] = unserialize(get_option('shipping'));
            $data['payment_dtl'] = unserialize(get_option('payment'));
            $total_r = $this->catalog->total($order_id, true);

            $rule = $this->m_coupons->validate_rules($order_id);
            $data['shipping_amount'] = (($rule->free_shipping) ? 0 : $data['shipping_dtl']['amount']);
            $data['discount'] = ($rule->discount + $total_r->discount);

            $data['checkout_tabs'] = array();
            if (!$customer_login) {
                $data['checkout_tabs']['billing_info'] = 'Customer Information';
            } else if ($user_id > 0) {
                $data['customer'] = $this->m_customers->customer($user_id);
                $customer_address = $this->m_customers->customer_address($user_id);
                //$data['billing'] = $customer_address['billing'];
                $data['billing'] = $data['customer'];
                $data['shipping'] = $customer_address['shipping'];

                $data['checkout_tabs']['checkout_method'] = 'Customer Account <small class="strik">' . $data['customer']->email . '</small>';
                $data['checkout_tabs']['shipping_info'] = 'Shipping Information';
            }
            if(SHIPPING_BILLING_ADD) {
                $data['checkout_tabs'] += array(
                    //'shipping_method'  =>  'Shipping Method',
                    'shipping_info'  =>  'Shipping Information',
                );
            }
            $data['checkout_tabs'] += array(
                //'payment_information'  =>  'Payment Information',
                'order_review' => 'Order Review',
            );

            $this->template->load('cart/checkout_tabs', $data);
        } else {
            redirect('');
        }
    }

    private function _quick_checkout()
    {

        $order_id = getSession($this->session_order);

        $customer_id = getSession($this->session_user);
        $customer_login = getSession('customer_login');

        if ($order_id > 0) {
            # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            # Customer Validation
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');//|callback_email_check
            $this->form_validation->set_rules('phone', 'Phone', 'required');
            $this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('city', 'City', 'required');
            $this->form_validation->set_rules('qty', 'Quantity', 'required');

            if ($this->form_validation->run() === false) {
                $this->m_orders->_delete($order_id);
                getFlash('error', validation_errors());
                getSession('row', array2object($this->input->post()));
                redirectBack();
            } else {
                $billing_ar = getDbArray('customers');
                $billing_ar = $billing_ar['dbdata'];
                $billing_ar['customer_type'] = 'guest';
                $billing_ar['first_name'] = getVar('name');
                $customer_id = save('customers', $billing_ar);
                /*getSession($this->session_user, $customer_id);
                getSession('customer_login', true);*/
                $order_up_data['customer_id'] = $customer_id;
            }

            $order = $this->db->get_where('orders', array('id' => $order_id), 1)->row();
            //$this->catalog->cart_detail($order_id);

            $total_r = $this->catalog->total($order_id, true);
            $total_amount = ($total_r->amount + $total_r->shipping_amount - $total_r->discount);
            $order_up_data['discount'] = ($total_r->discount);
            $order_up_data['shipping_amount'] = ($total_r->shipping_amount);
            $order_up_data['total_amount'] = ($total_amount);
            $order_up_data['status'] = 'Pending';
            # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            # Update Order
            save('orders', $order_up_data, "id=" . $order_id);
            activity_log('Create Order', 'orders', $order_id, $customer_id);
            # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            # order_email
            # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            $customer = $this->m_customers->customer($customer_id);
            $order_email_tags = $this->m_orders->order_email_tags($order_id);

            $email_tags = array_merge((array)$customer, (array)$order_email_tags);
            $msg = get_email_template($email_tags, 'New Order');

            $flash_msg = array();
            if ($msg->status == 'Active') {
                $emaildata = array(
                    'to' => $customer->email,
                    'cc' => get_option('recipient_email'),
                    'subject' => $msg->subject,
                    'message' => $msg->message
                );
                if (!send_mail($emaildata)) {
                    $flash_msg['error'][] = 'Email sending faild.';
                } else {
                    $flash_msg['success'][] = 'Please check your email for order invoice!';
                }
            }
            if ($msg->sms_status == 'Active') {

                $sms = get_email_template($email_tags, '', $msg->sms_message);
                if (!send_sms($sms, $customer->phone)) {
                    $flash_msg['error'][] = 'SMS sending faild.';
                }/*else{
                    $flash_msg['success'][] = ('Please check your email for order invoice!');
                }*/
            }
            if (count($flash_msg['success']) > 0) {
                $this->session->set_flashdata('success', join('<br>', $flash_msg['success']));
            }
            if (count($flash_msg['error']) > 0) {
                $this->session->set_flashdata('error', join('<br>', $flash_msg['error']));
            }

            getFlash($this->session_order, $order_id);
            $this->session->unset_userdata(array(
                $this->session_order => '',
                $this->session_user => '',
                'customer_login' => '',
                'row' => '',
            ));

            redirect('cart/success');
        }
    }


    function confirm()
    {

        $order_id = getSession($this->session_order);

        $customer_id = getSession($this->session_user);
        $customer_login = getSession('customer_login');

        if ($order_id > 0) {
 
            $billing = getVar('billing', true, false);
            $shipping = getVar('shipping', true, false);
            $use_for_shipping = getVar('use_for_shipping', true, false);
            $checkout_method = getVar('checkout_method', true, false);
            $payment_method = getVar('payment_method', true, false);
            if (empty($payment_method)) {
                $payment_method = 'CASH ON DELIVERY';
            }
            $order_up_data['payment_method'] = $payment_method;

            if (!$customer_login) {
         
                $shipping = $billing;
                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                # billing Validation
                $this->form_validation->set_rules('billing[first_name]', 'Full Name', 'required');
                //$this->form_validation->set_rules('billing[last_name]', 'Last Name', 'required');

                if ($checkout_method == 'customer') {
                    $this->form_validation->set_rules('billing[email]', 'Email', 'required|valid_email|callback_email_check');
                    $this->form_validation->set_rules('billing[password]', 'Password', 'required|min_length[6]|max_length[12]');
                    //$this->form_validation->set_rules('billing[confirm_password]', 'Billing Password Confirmation', 'required|matches[billing[confirm_password]]');
                } else {
                    $this->form_validation->set_rules('billing[email]', 'Email', 'required|valid_email');
                }
                $this->form_validation->set_rules('billing[phone]', 'Phone', 'required');
                $this->form_validation->set_rules('billing[address]', 'Address', 'required');
                // $this->form_validation->set_rules('billing[city]', 'City', 'required');
                //$this->form_validation->set_rules('billing[country]', 'Country', 'required');

                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                # Shipping Validation
                /*$this->form_validation->set_rules('shipping[first_name]', 'Shipping First Name', 'required');
                $this->form_validation->set_rules('shipping[last_name]', 'Shipping Last Name', 'required');
                $this->form_validation->set_rules('shipping[address]', 'Shipping Address', 'required');
                $this->form_validation->set_rules('shipping[city]', 'Shipping City', 'required');
                $this->form_validation->set_rules('shipping[country]', 'Shipping Country', 'required');
                $this->form_validation->set_rules('shipping[phone]', 'Shipping Phone', 'required');*/
            } else {
                
                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                # Shipping Validation
                 $this->form_validation->set_rules('shipping[first_name]', 'Full Name', 'required');
                $this->form_validation->set_rules('shipping[last_name]', 'Last Name', 'required');
                $this->form_validation->set_rules('shipping[phone]', 'Phone', 'required');
                $this->form_validation->set_rules('shipping[address]', 'Shipping Address', 'required');
                 $this->form_validation->set_rules('shipping[city]', 'City', 'required');
                  echo "error";
            }
             
            if ($this->form_validation->run() === false && !$customer_login) {

                // $this->checkout($this->input->post());
                
                //redirectBack();
                getFlash('error', validation_errors());
                getSession('row', array2object($this->input->post()));
                redirectBack();
             
            } else {

                if (!$customer_login) {
                    # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                    # Registration
                    $billing_ar = getDbArray('customers', array(), $billing);
                    $billing_ar = $billing_ar['dbdata'];
                    $password = $billing_ar['password'];
                    $billing_ar['customer_type'] = $checkout_method;
                    $billing_ar['password'] = md5($password);
                    $customer_id = save('customers', $billing_ar);
                    if ($checkout_method == 'customer') {
                        getSession($this->session_user, $customer_id);
                        getSession('customer_login', true);
                    } else {
                        $this->session->unset_userdata(array(
                            $this->session_user => '',
                            'customer_login' => ''
                        ));
                    }
                    $order_up_data['customer_id'] = $customer_id;

                    # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                    # registration_email
                    $customer = $this->m_customers->customer($customer_id);
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


                    $customer_addresses = $billing;
                    $customer_addresses['customer_id'] = $customer_id;
                    $customer_addresses['default_billing'] = 1;
                    $customer_addresses_ar = getDbArray('customer_addresses', array(), $customer_addresses);
                    $customer_addresses_ar = $customer_addresses_ar['dbdata'];
                    $default_billing_id = save('customer_addresses', $customer_addresses_ar);

                    $order_up_data['billing_add_id'] = $default_billing_id;

                    if ($use_for_shipping) {
                        unset($customer_addresses);
                        $customer_addresses = $billing_ar;
                        $customer_addresses['customer_id'] = $customer_id;
                        $customer_addresses['default_shipping'] = 1;
                        $customer_addresses_ar = getDbArray('customer_addresses', array(), $customer_addresses);
                        $customer_addresses_ar = $customer_addresses_ar['dbdata'];
                        $default_shipping_id = save('customer_addresses', $customer_addresses_ar);
                        $order_up_data['shipment_add_id'] = $default_shipping_id;
                    } else {
                        $customer_addresses = $shipping;
                        $customer_addresses['customer_id'] = $customer_id;
                        $customer_addresses['default_shipping'] = 1;
                        $customer_addresses_ar = getDbArray('customer_addresses', array(), $customer_addresses);
                        $customer_addresses_ar = $customer_addresses_ar['dbdata'];
                        $default_shipping_id = save('customer_addresses', $customer_addresses_ar);
                        $order_up_data['shipment_add_id'] = $default_shipping_id;
                    }
                } else {
                    $billing = $this->m_customers->customer_address($customer_id);
                    $order_up_data['billing_add_id'] = $billing[0]->id;

                    $customer_addresses = $shipping;
                    $customer_addresses['customer_id'] = $customer_id;
                    $customer_addresses['default_shipping'] = 1;
                    $customer_addresses_ar = getDbArray('customer_addresses', array(), $customer_addresses);
                    $customer_addresses_ar = $customer_addresses_ar['dbdata'];

                    $default_shipping_id = save('customer_addresses', $customer_addresses_ar);
                    $order_up_data['shipment_add_id'] = $default_shipping_id;
                }

                $order = $this->db->get_where('orders', array('id' => $order_id), 1)->row();
                //$this->catalog->cart_detail($order_id);

                $total_r = $this->catalog->total($order_id, true);
                $total_amount = ($total_r->amount + $total_r->shipping_amount - $total_r->discount);
                $order_up_data['discount'] = ($total_r->discount);
                $order_up_data['shipping_amount'] = ($total_r->shipping_amount);
                $order_up_data['total_amount'] = ($total_amount);
                $order_up_data['status'] = 'Pending';

                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                # Update Order
                save('orders', $order_up_data, "id=" . $order_id);

                activity_log('Create Order', 'orders', $order_id, $customer_id);
                getFlash($this->session_order, $order_id);
                $order = $this->db->get_where('orders', array('id' => $order_id), 1)->row();;

                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                # order_email
                $customer = $this->m_customers->customer($customer_id);
                $customer->password = $password;
                $order_email_tags = $this->m_orders->order_email_tags($order_id);

                $email_tags = array_merge((array)$customer, (array)$order_email_tags);
                $msg = get_email_template($email_tags, 'New Order');

                $flash_msg = array();
                if ($msg->status == 'Active') {
                    $emails = explode(',', get_option('recipient_email'));
                    array_push($emails, $customer->email);
                    $emails = join(',', $emails);
                    $emaildata = array(
                        'to' => $emails,
                        'subject' => $msg->subject,
                        'message' => $msg->message
                    );
                    if (!send_mail($emaildata)) {
                        $flash_msg['error'][] = 'Email sending faild.';
                    } else {
                        $flash_msg['success'][] = 'Please check your email for order invoice!';
                    }
                }
                if ($msg->sms_status == 'Active') {

                    $sms = get_email_template($email_tags, '', $msg->sms_message);
                    if (!send_sms($sms, $customer->phone)) {
                        $flash_msg['error'][] = 'SMS sending faild.';
                    }/*else{
                        $flash_msg['success'][] = ('Please check your email for order invoice!');
                    }*/
                }
                if (count($flash_msg['success']) > 0) {
                    $this->session->set_flashdata('success', join('<br>', $flash_msg['success']));
                }
                if (count($flash_msg['error']) > 0) {
                    $this->session->set_flashdata('error', join('<br>', $flash_msg['error']));
                }


                if ($payment_method == 'Paypal') {
                    $data['order'] = $order;
                    $data['customer'] = $customer;
                    $data['invoice'] = str_pad($order_id, 6, '0', STR_PAD_LEFT);

                    $this->template->load('cart/paypal_checkout', $data);
                } else {

                    getFlash($this->session_order, $order_id);
                    $this->session->unset_userdata(array(
                        $this->session_order => ''
                    ));
                    redirect('cart/success');
                }
            }
        } else {
             
            redirect('');
        }
    }

    public function email_check($email)
    {
        $customer_id = intval(getSession($this->session_user));
        $email_exists = $this->db->get_where('customers', array('email' => $email, 'id <>' => $customer_id, 'customer_type <>' => 'guest'))->num_rows() > 0 ? true : false;
        if ($email_exists) {
            $this->form_validation->set_message('email_check', 'This email is already exists');
            return FALSE;
        }
    }


    function notify_url()
    {
        $payer_email = getVar('payer_email');
        $payer_status = getVar('payer_status');
        $payment_status = getVar('payment_status');

        $invoice = getVar('invoice');
        $mc_gross = getVar('mc_gross');

        $ord_id = getVar('ord_id');
        if (!$ord_id) {
            $ord_id = ltrim($invoice, '0');
        }
        $order_detail = getValues('orders', '*', "WHERE id='" . intval($ord_id) . "'");

        $user_id = $order_detail->user_id;
        $user_detail = getValues('customers', '*', "WHERE id='" . intval($user_id) . "'");

        if (strtolower($payment_status) == 'completed' && strtolower($payer_status) == 'verified' && $payer_email == $user_detail->email) {

            $order_amount = $order_detail->order_amount;
            if ($mc_gross >= $order_amount) {
                save('orders', array('status' => 'Success'), "id='" . dbEscape($ord_id) . "'");
            } else {
                save('orders', array('status' => 'Payment Error'), "id='" . dbEscape($ord_id) . "'");
            }

            ob_start();
            echo '<pre>';
            echo $order_amount . ' - ' . $mc_gross;
            echo '<br />';
            print_r($_REQUEST);
            echo '</pre>';
            $msg = ob_get_clean();

            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            @mail('developer.systech@gmail.com', 'Paypal ' . get_option('site_title'), $msg, $headers);

        }
    }

    function remove_coupon()
    {
        $user_id = getSession($this->session_user);
        if ($user_id == 0) {
            redirect('customer/login');
        }

        $order_id = getSession($this->session_order);
        save('orders', array('coupon_id' => 0, 'discount' => 0), "id='{$order_id}'");
        set_notification('Coupon code remove successfully', 'success');

        redirectBack();
    }

    function apply_coupon()
    {

        $user_id = getSession($this->session_user);
        if ($user_id == 0) {
            redirect('customer/login');
        }

        $order_id = getSession($this->session_order);

        $coupon = getVar('coupon_code');

        $order = $this->db->get_where('orders', array('id' => $order_id), 1)->row();
        $total_r = $this->catalog->total($order_id, true);
        //$total_amount = ($total_r->amount + $total_r->shipping_amount - $total_r->discount);
        $total_amount = ($total_r->amount + $total_r->shipping_amount);

        $row = $this->db->get_where('coupons', array('coupon_code' => $coupon, 'coupon_type' => 'Coupon', 'end_date >=' => date('Y-m-d'), 'status' => 'Active'), 1)->row();

        if ($order->coupon_id > 0) {
            set_notification('Coupon code already applied', 'danger');
        } elseif ($row->id > 0) {

            $discount = $row->discount;
            if($row->discount_type == 'Percentage'){
                $discount = ($total_amount / 100 * $discount);
            }

            if ($row->usage_policy == 'Limited') {
                if ($row->no_used < $row->usage_limit && $total_r->amount >= $row->total_amount) {
                    save('orders', array('coupon_id' => $row->id, 'discount' => $discount), "id='{$order_id}'");

                    save('coupons', array('no_used' => (intval($row->no_used) + 1)), "id='{$row->id}'");
                    set_notification($coupon . ' - Coupon code applied successfully', 'success');
                }
            } else if ($total_r->amount >= $row->total_amount) {

                save('orders', array('coupon_id' => $row->id, 'discount' => $discount), "id='{$order_id}'");
                save('coupons', array('no_used' => (intval($row->no_used) + 1)), "id='{$row->id}'");

                set_notification($coupon . ' - Coupon code applied successfully', 'success');
            }else{
                set_notification($coupon . ' - Coupon apply on maximum "' . CURRENCY . ' ' . number_format($row->total_amount, CURRENCY_DECIMALS) . '"', 'danger');
            }
        } else {
            save('orders', array('coupon_id' => 0, 'discount' => 0), "id='{$order_id}'");
            set_notification('Invalid or expire this coupon', 'danger');
        }
        redirectBack();
        //redirect($this->input->server('HTTP_REFERER'));
    }

    function success()
    {
        $this->session->unset_userdata(array(
            $this->session_order => '',
            /*$this->session_user => '',
            'customer_login' => ''*/
        ));

        $data = array();
        $order_id = getFlash($this->session_order);
        //$order_id = 34073;
        if ($order_id == 0) {
            redirect('cart');
        }
        $block = $this->cms->get_block('success_order', true);
        $content = get_email_template($this->m_orders->order_email_tags($order_id), '', $block->content);

        $data['page']->title = $block->block_title;
        $data['page']->content = stripslashes(str_ireplace('[order_id]', $order_id, $content));
        $this->template->load('page', $data);
    }


}


/* End of file cart.php */
/* Location: ./application/controllers/cart.php */