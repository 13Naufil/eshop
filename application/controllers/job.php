<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Product_catalog
 * @property Template $template
 * @property Jobs $jobs
 */
class Job extends CI_Controller
{
    function __construct(){

        parent::__construct();
        $this->load->helper('frontend');
        $this->load->model('jobs');
    }

    public function index() {

        $job_id = intval(getUri(3));
        $jobs = $this->jobs->get_jobs("id=" .$job_id);
        $data['job'] = $job = $jobs[0];

        $action = strtolower(getUri(4));
        switch($action){
            case 'apply':
                $this->apply($job);
                return;
                break;
        }

        $data['page']->title = $job->title;
        $data['page']->tagline = $job->job_category;
        $data['page']->content = $this->load->view(get_template_directory(true) . 'job_detail', $data, true);

        $this->template->set_site_title($job->title);
        $this->template->meta('keywords', $job->title);
        $this->template->meta('description', $job->title);

        $template = 'page';
        $this->template->load($template, $data);
	}


    function apply($job){
        $id = $job->id;

        if($this->input->server('REQUEST_METHOD') == 'POST'){

            $this->load->model(ADMIN_DIR . 'm_job_seekers');

            $DbArray = getDbArray('job_seekers');
            $DBdata = $DbArray['dbdata'];
            $DBdata['job_id'] = $id;

            if ($_FILES['cv']['name']) {
                $upload = $this->m_job_seekers->file_upload('cv');
                $file_name = $upload['upload_data']['file_name'];
                $DBdata['cv'] = $file_name;
            }

            if($upload['upload_data']['file_name'] !='') {
                $_POST['cv'] = '<a href="' . asset_url('admin/cv/' . $upload['upload_data']['file_name']) . '">Download CV</a>';
            }
            $msg = '<table>';
            foreach($_POST as $field => $val){
                $msg .= '<tr><td><strong>'.ucwords(str_replace('_',' ', $field)).': </strong></td><td>'.nl2br($val).'</td></tr>';
            }
            $msg .= '<table>';


            $job_seekers = save('job_seekers', $DBdata);
            activity_log('apply job', 'job_seekers', $job_seekers);

            $this->session->set_flashdata('success', 'Thanks for applying.');

            #Email

            $_emaildata = array(
                'to' => get_option('career_email'),
                'subject' => 'Career - ' . $job->title,
                'message' => $msg
            );
            send_mail($_emaildata);

            redirect($this->input->server('HTTP_REFERER'));
        }

        $data['job'] = $job;
        $data['page']->title = $job->title;
        $data['page']->tagline = $job->job_category;
        $data['page']->content = $this->load->view(get_template_directory(true) . 'job_apply_form', $data, true);

        $this->template->set_site_title($job->title);
        $this->template->meta('keywords', $job->title);
        $this->template->meta('description', $job->title);

        $template = 'page';
        $this->template->load($template, $data);
    }

}

/* End of file thumbs.php */
/* Location: ./application/controllers/thumbs.php */