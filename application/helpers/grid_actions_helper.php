<?php
/**
 * Developed by Naufil khan.
 * Email: pisces_adnan@hotmail.com
 * Autour: Naufil khan
 * Date: 5/26/12
 * Time: 12:16 PM
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('get_grid_actions')) {
    /**
     * @param $rows
     * @param $id_field
     * @param array $buttons = array('view' => array('id'), 'edit' => array('id'), 'status' => array('id'), 'delete' => array('id'))
     * @param string $form_name
     * @return string
     */
    function get_grid_actions($rows, $id_field, $buttons, $module_uri = "", $file_path = array(),$action_privilege = 'private', $site_url = '')
    {

        $CI = & get_instance();
        //$user_actions = $CI->session->userdata('actions');
        $module = getUri($module_uri);
        $user_actions = $CI->db->query("SELECT um.actions FROM users AS u INNER JOIN user_type_module_rel AS um ON (u.user_type_id = um.user_type_id) INNER JOIN modules AS m ON (m.id = um.module_id) WHERE um.user_type_id = '" . intval($CI->session->userdata('user_type')) . "' AND m.`module`='" . addslashes($module) . "'")->row()->actions;

        $user_actions = array_unique(explode('|', str_replace(array('update'), array('edit'), $user_actions))); //$user_actions[$module]

        $actions = array();
        $qstring = array();

        foreach ($buttons as $key => $button) {

            if (is_array($button)) {
                array_push($actions, $key);
                $i = -1;
                foreach ($button as $field => $fields) {
                    if (!is_int($field)) {
                        $qsval = $rows[$fields];
                        $fields = $field;
                    } else {
                        $qsval = ($rows[$fields]);
                    }

                    $i++;
                    $qstring[$key] .= (($i == 0) ? "?" : "&") . $fields . "=" . $qsval;
                }

            } else {
                array_push($actions, $button);
            }

        }

        if ($action_privilege != 'private') {
            $user_actions = $actions;
        }


        $CI =& get_instance();

        if (empty($site_url)) {
            $site_url = $CI->router->class;
            if (getUri(1) == str_replace('/', '', ADMIN_DIR)) {
                $site_url = site_url(ADMIN_DIR . $CI->router->class);
            }
        }

        if (in_array('edit', $actions)) {
            $edit = '<a
                        action="edit"
                        href="' . ($site_url . '/form/' . $rows[$id_field] . '/' . $qstring['edit']) . '"
                        class="btn btn-link btn-icon btn-xs tip"" data-original-title="Edit"><i class="icon-pencil3"></i>
                     </a>';
        }

        if (in_array('edit_account', $actions)) {
            $edit_account = '<a
                        action="edit_account"
                        href="' . ($site_url . '/account/' . $rows['user_id'] . '/' . $rows[$id_field]. '/' . $qstring['edit_account']) . '"
                        class="btn btn-link btn-icon btn-xs tip"" data-original-title="Edit Account"><i class="icon-pencil"></i>
                     </a>';
        }

        if (in_array('delete', $actions)) {
            $delete = '<a
                        action="delete"
                        href="' . ($site_url . '/delete/' . $rows[$id_field] . '/' . $qstring['delete']) . '"
                        class="btn btn-link btn-icon btn-xs tip" data-original-title="Delete"><i class="icon-remove4"></i>
                     </a>';
        }


        if (in_array('duplicate', $actions)) {
            $duplicate = '<a
                        action="duplicate"
                        href="' . ($site_url . '/duplicate/' . $rows[$id_field] . '/' . $qstring['duplicate']) . '"
                        class="btn btn-link btn-icon btn-xs tip" data-original-title="Duplicate"><i class="icon-copy"></i>
                     </a>';
        }

        if (in_array('courier_options', $actions)) {
            $courier_options = '<a
                        action="courier_options"
                        href="' . ($site_url . '/courier_options/' . $rows[$id_field] . '/' . $qstring['courier_options']) . '"
                        class="btn btn-link btn-icon btn-xs tip" data-original-title="Courier Options"><i class="icon-target2"></i>
                     </a>';
        }

        if (in_array('show_catalog', $actions)) {
            $show_catalog = '<a
                        action="show_catalog"
                        href="' . ($site_url . '/show_catalog/' . $rows[$id_field] . '/' . $qstring['show_catalog']) . '"
                        class="btn btn-link btn-icon btn-xs tip" data-original-title="Show Catalog"><i class="icon-picture"></i>
                     </a>';
        }

        if (in_array('judges_book', $actions)) {
            $judges_book = '<a
                        action="judges_book"
                        href="' . ($site_url . '/judges_book/' . $rows[$id_field] . '/' . $qstring['judges_book']) . '"
                        class="btn btn-link btn-icon btn-xs tip" data-original-title="Judges Book"><i class="icon-book"></i>
                     </a>';
        }

        if (in_array('show_certificate', $actions)) {
            $show_certificate = '<a
                        action="show_certificate"
                        href="' . ($site_url . '/show_certificate/' . $rows[$id_field] . '/' . $qstring['show_certificate']) . '"
                        class="btn btn-link btn-icon btn-xs tip" data-original-title="Show Certificate"><i class="icon-trophy"></i>
                     </a>';
        }

        if (in_array('attend_show', $actions)) {
            $attend_show = '<a
                        action="attend_show"
                        href="' . ($site_url . '/attend_show/' . $rows[$id_field] . '/' . $qstring['attend_show']) . '"
                        class="btn btn-link btn-icon btn-xs tip" data-original-title="Attend Show"><i class="icon-list-ol"></i>
                     </a>';
        }

        if (in_array('banned_user', $actions)) {
            $banned_user = '<a
                        action="banned_user"
                        href="' . ($site_url . '/banned_user/' . $rows[$id_field] . '/' . $qstring['banned_user']) . '"
                        class="btn btn-link btn-icon btn-xs tip" data-original-title="Ban user"><i class="icon-remove-sign"></i>
                     </a>';
        }

        if (in_array('status', $actions)) {
            $status = '
                        <a
                            action="status"
                            href="' . ($site_url . '/status/' . $rows[$id_field] . '/' . $qstring['status']) . '"
                            class="btn btn-link btn-icon btn-xs tip color-'.((in_array($rows['status'], array(1, 'Active', 'Approved'))) ? 'check': 'off').'" data-original-title="Status"><i class="icon-'.(in_array($rows['status'], array(1, 'Active', 'Approved')) ? 'checkmark-circle': 'minus-circle').'"></i>
                        </a>';
        }


        if (in_array('view', $actions)) {
            $view = '<a
                            action="view"
                            href="' . ($site_url . '/view/' . $rows[$id_field] . '/' . $qstring['view']) . '"
                            class="btn btn-link btn-icon btn-xs tip" data-original-title="View"><i class="icon-eye7"></i>
                         </a>';
        }


        if (in_array('bids', $actions)) {
            $bids = '<a
                            action="bids"
                            href="' . ($site_url . '/bids/' . $rows[$id_field] . '/' . $qstring['bids']) . '"
                            class="btn btn-link btn-icon btn-xs tip" data-original-title="View Bids"><i class="icon-github"></i>
                         </a>';
        }


        if (in_array('litter_registration', $actions)) {
            $litter_registration = '<a
                            action="litter_registration"
                            href="' . admin_url('litters/form/' . $qstring['litter_registration']) . '"
                            class="btn btn-link btn-icon btn-xs tip" data-original-title="Goto Litter Registration"><i class="icon-share-alt"></i>
                         </a>';
        }

        if (in_array('assign_microchips', $actions)) {
            $assign_microchips = '<a
                            action="assign_microchips"
                            href="' . ($site_url . '/assign_microchips/' . $rows[$id_field] . '/' . $qstring['assign_microchips']) . '"
                            class="btn btn-link btn-icon btn-xs tip" data-original-title="Assign Microchips"><i class="ico-tags"></i>
                         </a>';
        }

        if (in_array('approved_puppies', $actions)) {
            $approved_puppies = '<a
                            action="approved_puppies"
                            href="' . ($site_url . '/approved_puppies/' . $rows[$id_field] . '/' . $qstring['approved_puppies']) . '"
                            class="btn btn-link btn-icon btn-xs tip" data-original-title="Approved Puppies"><i class="icon-bell"></i>
                         </a>';
        }


        if (in_array('view_pedigree', $actions)) {
            $view_pedigree = '<a
                            action="view_pedigree"
                            href="' . ($site_url . '/view_pedigree/' . $rows[$id_field] . '/' . $qstring['view_pedigree']) . '"
                            class="btn btn-link btn-icon btn-xs tip" data-original-title="View Pedigree"><i class="icon-bar-chart"></i>
                         </a>';
        }


        if (in_array('files', $actions)) {
            $files = '<a
                            action="files"
                            href="' . ($site_url . '/files/' . $rows[$id_field] . '/' . $qstring['files']) . '"
                            class="btn btn-link btn-icon btn-xs tip" data-original-title="Member Files"><i class="icon-copy"></i>
                         </a>';
        }

        if (in_array('account', $actions)) {
            $account = '<a
                            action="account"
                            href="' . ($site_url . '/account/' . $rows[$id_field] . '/' . $qstring['files']) . '"
                            class="btn btn-link btn-icon btn-xs tip" data-original-title="Member Account"><i class="icon-money"></i>
                         </a>';
        }



        if (in_array('download', $actions)) {

            $download = '
                    <a title="Download" class="grid_button ui_dialog" action="check_status" href="' . $file_path['download'] . '">
                         <img src="' . base_url() . 'images/pictos/download.png" alt="" width="16" height="16">
                    </a>
                ';
        }
        if (in_array('delete_file', $actions)) {

            $delete_file = '
                    <a title="Delete File" class="grid_button ui_dialog" action="check_status" href="' . $file_path['delete_file'] . '">
                         <img src="' . base_url() . 'images/pictos/delete_file.png" alt="" width="16" height="16">
                    </a>
                ';
        }
        if (in_array('view_calls', $actions)) {

            $view_calls = '<a
                                action="view_calls"
                                href="' . ($site_url . '/view_calls/' . $rows[$id_field] . '/' . $qstring['view']) . '"
                                class="btn btn-link btn-icon btn-xs tip" show_popup" data-original-title="View Calls"><i class="icon-tasks"></i>
                          </a>';
        }
        if (in_array('galleries', $actions)) {

            $galleries = '<a
                            action="galleries"
                            href="' . ($site_url . '/galleries/' . $rows[$id_field] . '/' . $qstring['galleries']) . '"
                            class="btn btn-link btn-icon btn-xs tip" data-original-title="Galleries"><i class="icon-images"></i>
                      </a>';
        }
        if (in_array('pages', $actions)) {

            $pages = '<a
                        action="pages"
                        href="' . ($site_url . '/pages/' . $rows[$id_field] . '/' . $qstring['pages']) . '"
                        class="btn btn-link btn-icon btn-xs tip" data-original-title="Pages"><i class="icon-file-plus"></i>
                  </a>';
        }
        if (in_array('testimonials', $actions)) {

            $testimonials = '<a
                        action="testimonials"
                        href="' . ($site_url . '/testimonials/' . $rows[$id_field] . '/' . $qstring['testimonials']) . '"
                        class="btn btn-link btn-icon btn-xs tip" data-original-title="Testimonials"><i class="icon-bubble-quote"></i>
                  </a>';
        }

        /*---------------------------------------------------------------------------------------------*/
        //$user_actions = array('new', 'edit', 'delete', 'print');
        $form_btn = '';
        foreach ($buttons as $key => $button) {
            if (is_array($button)) {
                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                # @start Modules action Conditions
                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                if ($rows['status'] == 'shipped' && $module == 'sales_orders') {
                    unset($user_actions[array_search('edit', $user_actions)]);
                }
                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                # @End Modules action Conditions
                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                if (in_array($key, $user_actions)) {
                    $form_btn .= ${$key};
                }
            } else {
                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                # @start Modules action Conditions   //continue
                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                if ($rows['user_type'] == 'Admin' && $button == 'account') {
                    continue;
                }

                if (!in_array($rows['type'], array('Advertiser')) && $module == 'customers') {
                    if(array_search('testimonials', $user_actions) !== false) unset($user_actions[array_search('testimonials', $user_actions)]);
                    if(array_search('pages', $user_actions) !== false) unset($user_actions[array_search('pages', $user_actions)]);
                    if(array_search('galleries', $user_actions) !== false) unset($user_actions[array_search('galleries', $user_actions)]);
                }

                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                # @End Modules action Conditions
                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                //echo '<pre>';print_r($user_actions);echo '</pre>';
                //var_dump($button);


                if (in_array($button, $user_actions)) {
                    $form_btn .= ${$button};
                }
            }
        }

        return $action_btn = '<div class="table-controls">' . $form_btn . '</div>';
    }
}