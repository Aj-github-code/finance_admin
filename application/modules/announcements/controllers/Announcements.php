<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Announcements extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('announcements_model', 'announcements');
        }

        function index()
        {
            $data['meta_title']             = "Announcements";
            $data['meta_description']       = "Announcements";
            $data['meta_keywords']          = "Announcements";
            $data['page_title']             = "Announcements";
            $data['module']                 = "Announcements";
            $data['menu']                   = "announcements";
            $data['submenu']                = "list";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->push(1, 'Announcements', announcements_constants::announcements_url);
            $this->breadcrumbs->unshift(2, 'List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "announcements/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function ajax_list()
        {
            $condition          = ['a.status !' => '-1'];
            $list               = $this->announcements->get_data($condition, '', '', '');
            $tabledata          = [];
            $no                 = isset($_GET['offset']) ? $_GET['offset'] : 0;

            foreach ($list as $key => $value) {
                if(isset($value->created_on) && !empty($value->created_on) && $value->created_on !== '0000-00-00 00:00:00')
                {
                    $created_on = date($this->config->item('default_date_time_format'), strtotime($value->created_on));
                }
                else
                {
                    $created_on = 'NA';
                }

                $status         = '';
                if($value->status == 1)
                {
                    $status     = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$value->id.', 0, this);" data-type="announcement" data-function="'.base_url().announcements_constants::change_announcement_status_url.'"><span class="badge badge-success">Active</span></a>';
                }
                else if($value->status == 0)
                {
                    $status     = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$value->id.', 1, this);" data-type="announcement" data-function="'.base_url().announcements_constants::change_announcement_status_url.'"><span class="badge badge-danger">In-Active</span></a>';
                }

                $action = '
                            <span class="dropdown action-dropdown d-flex justify-content-center">
                                <button id="btnSearchDrop'.$key.'" type="button" class="btn btn-sm btn-icon btn-pure font-medium-2" data-toggle="dropdown" aria-haspopup="true"
                                 aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <span aria-labelledby="btnSearchDrop'.$key.'" class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" title="Edit" href="'.base_url().announcements_constants::edit_announcement_url.'/'.$value->id.'">Edit</a>
                                    <a class="dropdown-item" title="Delete" href="javascript:void(0);" onclick="change_status('.$value->id.', -1, this);" data-type="announcement" data-function="'.base_url().announcements_constants::change_announcement_status_url.'">Delete</a>
                                </span>
                            </span>
                        ';

                $view   = '<a class="" href="'.base_url().announcements_constants::edit_announcement_url.'/'.$value->id.'" title="Edit '.$value->title.'">'.$value->title.'</a>';

                $no++;
                $row                                            = [];
                $row['sr_no']                                   = $no;
                $row['id']                                      = $value->id;
                $row['title']                                   = $view;
                $row['description']                             = $value->description;
                $row['status']                                  = $status;
                $row['created_on']                              = $created_on;
                $row['action']                                  = $action;
            
                $tabledata[]                                    = $row;
            }

            $output             = array(
                                        "total"      => $this->announcements->get_data($condition, '', '', 'allcount'),
                                        "rows"       => $tabledata,
                                    );

            echo json_encode($output);
        }

        private function form_validation_rules($data=[])
        {
            $this->form_validation->set_rules('title', 'Title', 'required|max_length[100]|trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('description', 'Description', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('status', 'Status', 'required');
        }

        function add()
        {
            $data['meta_title']             = "Add Announcement";
            $data['meta_description']       = "Add Announcement";
            $data['meta_keywords']          = "Add Announcement";
            $data['page_title']             = "Add Announcement";
            $data['module']                 = "Announcements";
            $data['menu']                   = "announcements";
            $data['submenu']                = "add";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";
            $data['id']                     = "";
            $data['post_data']              = [];
            $data['post_data']['status']    = 1;

            $this->form_validation_rules($data);

            if($this->input->post())
            {
                $data['post_data']          = $this->input->post();
            }

            if($this->form_validation->run($this) === TRUE)
            {
                if($this->input->post())
                {
                    $response               = $this->announcements->save('', $this->security->xss_clean($this->input->post()));
                    $this->session->set_flashdata('status', $response);
                    redirect(base_url().announcements_constants::announcements_url);
                }
            }

            $this->breadcrumbs->push(1, 'Announcements', announcements_constants::announcements_url);
            $this->breadcrumbs->unshift(2, 'Add', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "announcements/form";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function edit($id='')
        {
            $response = ['error' => 1, 'message' => 'Invalid request'];
            if(!empty($id))
            {
                $data['meta_title']         = "Edit Announcement";
                $data['meta_description']   = "Edit Announcement";
                $data['meta_keywords']      = "Edit Announcement";
                $data['page_title']         = "Edit Announcement";
                $data['module']             = "Announcements";
                $data['menu']               = "announcements";
                $data['submenu']            = "list";
                $data['childmenu']          = "";
                $data['loggedin']           = "yes";
                $data['id']                 = $id;
                $data['post_data']          = [];

                $this->form_validation_rules($data);

                if($this->form_validation->run($this) === TRUE)
                {
                    if($this->input->post())
                    {
                        $response           = $this->announcements->save($id, $this->security->xss_clean($this->input->post()));
                        $this->session->set_flashdata('status', $response);
                        redirect(base_url().announcements_constants::announcements_url);
                    }
                }

                if($this->input->post())
                {
                    $data['post_data']      = $this->input->post();
                }
                else
                {
                    $data['post_data']      = $this->announcements->get_details($id);

                    if(empty($data['post_data']))
                    {
                        $this->session->set_flashdata('status', ['error' => 1, 'message' => 'Announcement not found']);
                        redirect(base_url().announcements_constants::announcements_url);
                    }
                }

                $this->breadcrumbs->push(1, 'Announcements', announcements_constants::announcements_url);
                $this->breadcrumbs->unshift(2, 'Edit', '#');
                $data['breadcrumb']          = $this->breadcrumbs->show();

                $data['content']            = "announcements/form";
                echo Modules::run("templates/".$this->config->item('theme'), $data);
            }
            else
            {
                $this->session->set_flashdata('status', $response);
                redirect(base_url().announcements_constants::announcements_url);
            }
        }

        function change()
        {
            $response       = ['error' => 1, 'message' => 'Access denied'];

            if(isset($_POST) && !empty($_POST))
            {
                $id         = isset($_POST['id']) ? $_POST['id'] : '';
                $type       = isset($_POST['type']) ? $_POST['type'] : '';
                $status     = isset($_POST['status']) ? $_POST['status'] : '';

                $details    = $this->announcements->get_details($id);

                if(!empty($details))
                {
                    if($status == '-1')
                    {
                        $message = 'deleted';
                    }
                    else if($status == 1)
                    {
                        $message = 'activated';
                    }
                    else if($status == 0)
                    {
                        $message = 'in-activated';
                    }

                    if($this->announcements->change($id, $status))
                    {
                        $response   = ['error' => 0, 'message' => ucfirst($type).' successfully '.$message];
                    }
                    else
                    {
                        $response   = ['error' => 1, 'message' => 'Unable to perform this action'];
                    }
                }
                else
                {
                    $response   = ['error' => 1, 'message' => 'No '.$type.' found'];
                }
            }
            echo json_encode($response);
        }
    }