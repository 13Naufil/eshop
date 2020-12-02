<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Login
 * @property M_blogs $m_blogs
 * @property M_cpanel $m_cpanel
 */
class Blog_posts extends CI_Controller
{
    var $table;
    var $id_field;
    var $module;
    var $module_name;
    var $module_title;

    function __construct()
    {
        parent::__construct();
        $this->m_cpanel->checkLogin();

        //TODO:: Module Name
        $this->module_name = getUri(2);
        $this->module = 'm_' . $this->module_name;
        $this->load->model(ADMIN_DIR . $this->module);
        $this->module = $this->{$this->module};

        $this->table = $this->module->table;
        $this->id_field = $this->module->id_field;

        $this->module_route = $this->router->class;
        $this->module_title = getModuleDetail()->module_title;


    }

    public function index()
    {
        $where = '';

        $data['title'] = $this->module_title;
        $data['query'] = "SELECT `id`,
          -- `featured_image`,
          `title`,
          `status`,
          `datetime`
           FROM " . $this->table . " WHERE 1 " . $where;
        $data['query'] .= getFindQuery($data['query']);


        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));

        $this->admin_template->load($this->module_name . '/grid', $data);
    }

    public function blog_tags()
    {
        $term = getVar('term');
        $SQL = "SELECT id, tags as label, slug as value FROM blog_tags WHERE tags LIKE '%" . $term . "%'";
        $ROWS = $this->db->query($SQL)->result();
        echo json_encode($ROWS);
    }


    public function form()
    {
        $id = (getUri(4));

        if (!empty($id)) {
            $SQL = "SELECT * FROM " . $this->table . " WHERE " . $this->id_field . "='" . $id . "'";
            $RS = $this->db->query($SQL);
            if ($RS->num_rows() == 0) {
                $this->admin_template->not_found();
            }
            $data['row'] = $RS->row();

            $SQL = "SELECT bc.id FROM blog_posts AS bp INNER JOIN blog_relations AS br ON (bp.id = br.post_id) INNER JOIN blog_categories AS bc ON (br.id = bc.id) WHERE bp.id='" . $id . "' AND br.rel_type='categories'";
            $data['selected_cats'] = singleColArray($SQL, 'id');


            $SQL = "SELECT bt.slug , bt.tags FROM blog_posts AS bp INNER JOIN blog_relations AS br ON (bp.id = br.post_id) INNER JOIN blog_tags AS bt ON (br.id = bt.id) WHERE bp.id='" . $id . "'  AND br.rel_type='tags'";
            $data['selected_tags'] = join(',', singleColArray($SQL, 'tags'));

        }

        $this->breadcrumb->add_item($this->module_title, admin_url($this->module_route));
        $this->breadcrumb->add_item(($id > 0) ? 'Edit' : 'Add New');

        $this->admin_template->load($this->module_name . '/form', $data);
    }

    public function view()
    {
        $id = (getUri(4));

        if (!empty($id)) {
            $SQL = "SELECT * FROM " . $this->table . " WHERE " . $this->id_field . "='{$id}'";
            $data['row'] = $this->db->query($SQL)->row();
        }

        $data['title'] = $this->module_title;
        $this->admin_template->load($this->module_name . '/form', $data);
    }


    function status()
    {

        $id = (getUri(4));
        $status = (getUri(5));

        $where = $this->id_field . "='" . $id . "'";
        save($this->table, array('result' => $result), $where);
        redirect(ADMIN_DIR . $this->module_name);
    }

    public function add()
    {


        if (!$this->module->validate()) {
            $data['row'] = array2object($this->input->post());

            $this->admin_template->load($this->module_name . '/form', $data);
        } else {
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];
            $DBdata['content'] = addslashes(getVar('content', 0, 0));
            $DBdata['author'] = $this->session->userdata('tgm_user_id');
            $DBdata['slug'] = url_title(getVar('title', 1, 0));

            if (!empty($_FILES['featured_image']['name'])) {
                $fileData = $this->module->do_upload('featured_image');
                $DBdata['featured_image'] = $fileData['file_name'];
            }

            $id = save($this->table, $DBdata);
            /*------------------------------------------------*/
            $categories = getVar('categories', true, false);

            if (count($categories) > 0) {
                foreach ($categories as $cat) {
                    $DBdata_rel = array(
                        'rel_type' => 'categories',
                        'post_id' => $id,
                        'id' => $cat,
                    );
                    save('blog_relations', $DBdata_rel);
                }
            }
            /*------------------------------------------------*/
            $tags = explode(',', getVar('tags', 1, 0));
            if (count($tags) > 0) {
                foreach ($tags as $tag) {
                    $tag_id = getVal('blog_tags', 'id', " WHERE slug='" . dbEscape($tag) . "'");
                    if ($tag_id <= 0 || empty($tag_id)) {
                        $tag_id = save('blog_tags', array('tags' => $tag, 'slug' => $tag));
                    }
                    $DBdata_rel = array(
                        'rel_type' => 'tags',
                        'post_id' => $id,
                        'id' => $tag_id,
                    );
                    save('blog_relations', $DBdata_rel);
                }
            }


            redirect(ADMIN_DIR . $this->module_name . '/?msg=Record has been inserted..');
        }
    }


    public function update()
    {
        $id = intval(getVar('id'));

        if (!$this->module->validate()) {
            $data['row'] = array2object($this->input->post());
            $this->admin_template->load($this->module_name . '/form', $data);
        } else {
            $DbArray = getDbArray($this->table);
            $DBdata = $DbArray['dbdata'];
            $DBdata['content'] = addslashes(getVar('content', 0, 0));
            $DBdata['slug'] = url_title(getVar('title', 1, 0));

            if (!empty($_FILES['featured_image']['name'])) {
                $fileData = $this->module->do_upload('featured_image');
                $DBdata['featured_image'] = $fileData['file_name'];
            }

            $where = $DbArray['where'];
            save($this->table, $DBdata, $where);

            /*------------------------------------------------*/
            $this->db->query("DELETE FROM blog_relations WHERE post_id = '" . $id . "'");

            $categories = getVar('categories', 1, 0);
            if (count($categories) > 0) {
                foreach ($categories as $cat) {
                    $DBdata_rel = array(
                        'rel_type' => 'categories',
                        'post_id' => $id,
                        'id' => $cat,
                    );
                    save('blog_relations', $DBdata_rel);
                }
            }
            /*------------------------------------------------*/
            $tags = explode(',', getVar('tags', 1, 0));
            if (count($tags) > 0) {
                foreach ($tags as $tag) {
                    $tag_id = getVal('blog_tags', 'id', " WHERE slug='" . dbEscape($tag) . "'");
                    if ($tag_id <= 0 || empty($tag_id)) {
                        $tag_id = save('blog_tags', array('tags' => $tag, 'slug' => $tag));
                    }
                    $DBdata_rel = array(
                        'rel_type' => 'tags',
                        'post_id' => $id,
                        'id' => $tag_id,
                    );
                    save('blog_relations', $DBdata_rel);
                }
            }

            redirect(ADMIN_DIR . $this->module_name . '/?msg=Record has been updated..');

        }
    }


    public function delete()
    {
        $id = intval(getUri(4));
        if (empty($id)) {
            $id = dbEscape(join(',', getVar('ids')));
        }
        $SQL = "DELETE FROM " . $this->table . " WHERE `" . $this->id_field . "` IN(" . $id . ")";
        $this->db->query($SQL);
        redirect(ADMIN_DIR . $this->module_name . '/?msg=Record has been Deleted..');
    }



}

/* End of file pages.php */
/* Location: ./application/controllers/admin/pages.php */