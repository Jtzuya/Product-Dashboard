<?php
class Products extends CI_Controller {
    public function index() 
    {
        // products/new default page
        $user_level = $this->session->userdata('user_level');
        if($user_level == 9) {
            $this->load->view('partials/initialize');
            $this->load->view('products/index');
            $this->load->view('partials/disconnect');
        } else {
            redirect('dashboard');
        }
    }

    public function create() 
    {
        $user_level = $this->session->userdata('user_level');
        if($user_level == 9) {
            $product_data = $this->input->post();
            $result = $this->product->create_product($product_data);
    
            if($result == TRUE) {
                $this->session->set_flashdata('success', 'product successfully added..');
                redirect('products/new');
            } else {
                redirect('products/new');
            }
        } else {
            redirect('dashboard');
        }
    }

    public function edit($product_id) 
    {
        $product_data = array();
        $user_level = $this->session->userdata('user_level');
        if($user_level == 9) {
            $product_data['id'] = $product_id;
            $this->load->view('partials/initialize');
            $this->load->view('products/edit', $product_data);
            $this->load->view('partials/disconnect');
        } else {
            redirect('dashboard');
        }
    }

    public function updating_product($product_id) 
    {
        $user_level = $this->session->userdata('user_level');
        if($user_level == 9) {
            $product_details = $this->input->post();
            $result = $this->product->update_product_by_id($product_id, $product_details);
            
            if($result == TRUE) {
                $this->session->set_flashdata('success', "Product with ID $product_id successfully updated");
                redirect("products/edit/$product_id");
            } else {
                redirect("products/edit/$product_id");
            }
        } else {
            redirect('dashboard');
        }
    }

    public function show_product($product_id) 
    {
        $product_data = array();
        $user_id = $this->session->userdata('user_id');
        // if not user id, refrain them to access the posting of method

        $product = $this->product->get_product_by_id($product_id);

        $product['custom_date'] = custom_date($product['created_at']); // goes first because we pushed this inside the $product variable (array)
        $product_data['id'] = $product_id;
        $product_data['product'] = $product;
        $product_data['active_user'] = $this->session->userdata('user_id');
        $product_data['reviews'] = $this->show_reviews($product_id); // check if we have reviews and and render them
        $product_data['replies'] = $this->show_replies($product_id);
        
        $this->load->view('partials/initialize');
        $this->load->view('products/show', $product_data);
        $this->load->view('partials/disconnect');
    }

    public function delete_product($product_id) 
    {
        $user_level = $this->session->userdata('user_level');
        if($user_level == 9) {
            $id = $this->security->xss_clean($product_id);
            $result = $this->product->delete_product_by_id($id);

            if($result == TRUE) {
                $this->session->set_flashdata('success', "Successfully deleted product id $product_id");
                redirect('dashboard/admin');
            } else {
                $this->session->set_flashdata('input_errors', "Did not successfully deleted the product with id $product_id");
                redirect('dashboard/admin');
            }
        } else {
            redirect('/');
        }
    }

    public function create_review($product_id) 
    {
        // echo 'saving review to db';
        // dump($this->input->post());
        $review_data = array();
        $review_data['user_id'] = $this->session->userdata('user_id');
        $review_data['product_id'] = $product_id;
        $review_data['message'] = $this->input->post('review');
        $path = "products/show/$product_id";

        if($review_data['user_id'] !== NULL) {
            $result = $this->product->post_review($review_data);
            
            if($result !== TRUE) {
                $this->session->set_flashdata('input_errors', 'Nothing was submitted.. probably your didn\'t wrote any message at all🥴');
                redirect($path);
            } else {
                $this->session->set_flashdata('success', 'Successfully posted a review');
                redirect($path);
            }
        } else {
            redirect($path);
        }
    }

    public function show_reviews($product_id) 
    {
        $result = $this->product->get_reviews_by($product_id);
        if(count($result) > 0) {
            foreach($result as $key => $reviews) {
                if($reviews['created_at']) {
                    // added custom date in the existing result array 
                    $result[$key]['custom_date'] = custom_date($reviews['created_at']);
                }
            }
            return $result;
        } else {
            return; // just simply return or do nothing...
        }
    }

    public function create_reply($product_id, $review_id) 
    {
        // why review id? because we will use this as our foreign key to locate data inside db
        // why product id? so that after submission we can use that id to traverse back to that product's page
        $reply_data = array();
        $reply_data['user_id'] = $this->session->userdata('user_id');
        $reply_data['review_id'] = $review_id;
        $reply_data['message'] = $this->input->post('reply');
        $path = "products/show/$product_id";
        
        if($reply_data['user_id'] !== NULL) {
            $result = $this->product->post_reply($reply_data);
            if($result !== TRUE) {
                $this->session->set_flashdata('input_errors', "Nothing was submitted.. probably your didn\'t wrote any reply at all🥴");
                redirect($path);
            } else {
                $this->session->set_flashdata('success', 'Successfully replied');
                redirect($path);
            }
        } else {
            $this->session->set_flashdata('input_errors', "You are submitting a reply without signing in which should be bakana...");
            redirect($path);
        }
    }

    public function show_replies($product_id)
    {
        $result = $this->product->get_replies($product_id);
        if($result !== NULL) {
            return $result;
        } else {
            return;
        }
    }
}