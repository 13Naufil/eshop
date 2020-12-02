<?php
/**
 * Naufil khan
 * Email: developer.systech@gmail.com
 */




function update_member_credit($user_id, $new_amount, $edit_amount = 0)
{
    $ci = & get_instance();
    $member = get_member($user_id);
    $credit_amount = ($member->credit_amount - $edit_amount);
    $credit_amount += $new_amount;

    save('users', array('credit_amount' => $credit_amount), "id=" . intval($user_id));
}



function add_income($income_by, $amount, $title, $head = '', $order_id = 0, $date = null)
{
    $ci = & get_instance();

    $data['income_by'] = $income_by;
    $data['title'] = $title;
    $data['income_head'] = (($head == '') ? $title : $head);
    $data['amount'] = $amount;
    if($order_id > 0){
        $data['order_id'] = $order_id;
    }
    if($date !== null){
        $data['date'] = $date;
    }else{
        $data['date'] = date('Y-m-d');
    }

    $data['created'] = date('Y-m-d H:i:s');
    if (getUri(1) == substr(ADMIN_DIR, 0, -1)) {
        $data['created_by'] = $ci->session->userdata('cct_user_id');
    } else {
        $data['created_by'] = $ci->session->userdata('frontend_user_id');
    }

    $id = save('income', $data);

    if($amount < 0){
        $account['user_id'] = $income_by;
        $account['payment_method'] = 'Credit';
        $account['date'] = date('Y-m-d');
        $account['amount'] = abs($amount);
        $account['cheque_no'] = $title;
        $account['note'] = $title;
        $account['created'] = date('Y-m-d H:i:s');
        $account['created_by'] = $ci->session->userdata('cct_user_id');

        $user_accounts_id = save('user_accounts', $account);
        activity_log('add_user_accounts', 'user_accounts', $user_accounts_id, 0, "Return $amount - " . $head);

        update_member_credit($income_by, 0, $amount);
    }else{

        update_member_credit($income_by, 0, $amount);
    }

    return $id;
}

function QR_code_generate($url){

    $url = str_replace(ROOT_DIR ,'/', $url);

    include_once dirname(__FILE__).'/../libraries/phpqrcode/qrlib.php';

    $_url = explode('/', $url);
    $file_name = str_replace(array('.html', '.php'), '', end($_url));
    $fileName = ASSETS_DIR . 'front/dogs_qr/' . $file_name . '.png';
    // outputs image directly into browser, as PNG stream
    QRcode::png($url, $fileName);

    return $fileName;
}

function barcode_generate($text, $file_name, $code = 'BCGcode39'){

    $classFile = $code . '.barcode.php';
    $className = $code;
    $baseClassFile = 'BCGBarcode1D.php';
    $codeVersion = '5.2.0';

    $_url = explode('.', $file_name);
    $full_filename = ASSETS_DIR . 'front/dogs_barcode/' . $file_name;
    @unlink($full_filename);
    $ext = end($_url);

    $barcode_data = array();
    $barcode_data['filename'] = $full_filename;
    $barcode_data['code'] = $code;
    $barcode_data['filetype'] = strtoupper($ext);
    $barcode_data['dpi'] = 150;
    $barcode_data['scale'] = isset($defaultScale) ? $defaultScale : 1;
    $barcode_data['rotation'] = 0;
    $barcode_data['font_family'] = 'Arial.ttf';
    $barcode_data['font_size'] = 9;
    //$barcode_data['thickness'] = 30;
    $barcode_data['text'] = trim($text);
    $barcode_data['a1'] = '';
    $barcode_data['a2'] = '';
    $barcode_data['a3'] = '';

    include dirname(__FILE__).'/../libraries/barcode/barcode.php';

}
