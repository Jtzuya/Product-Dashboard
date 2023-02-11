<?php
class User extends CI_Model {
    public function get_user_by_email($email) {
        $query = "SELECT * FROM users WHERE email=?";
        return $this->db->query($query, $this->security->xss_clean($email))->result_array();
    }

    public function create_user($user_data) {
        $check_users_table = $this->db->query("SELECT * FROM users")->result_array();
        $user_level = 0;
        
        if(count($check_users_table) < 1 || $check_users_table === NULL) {
            $user_level = 9;
        }

        $col = "user_level, first_name, last_name, email, password, created_at";
        $query = "INSERT INTO users ($col) VALUES (?,?,?,?,?,?)";
        $values = array(
            $user_level,
            $this->security->xss_clean($user_data['first_name']),
            $this->security->xss_clean($user_data['last_name']),
            $this->security->xss_clean($user_data['email']),
            $this->security->xss_clean($user_data['password']),
            date('Y-m-d H:i:s')
        );
        return $this->db->query($query, $values);
    }

    public function validate_registration($email) {
        $this->form_validation->set_error_delimiters('<div>','</div>');
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');        
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        if(!$this->form_validation->run()) {
            return validation_errors();
        } else if($this->get_user_by_email($email)) {
            return "Email already taken.";
        }
    }

    /**
     * This function validates all form fields if certain areas 
     * are filled or not
     * Owner: Jake
     * Credits: Karen (Original code owner)
     */
    public function validate_login($login_details) {
        $this->form_validation->set_error_delimiters('<div>', '</div>');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        /**
         * form_validation->run() method checks if the rules we
         * set above via **set_rules()** are/is filled or not
         * 
         * This method returns a boolean value TRUE or FALSE whether it meets
         * the certain criteria.
         * 
         * if both email and password are filled, then it will return TRUE
         * if either one of the email/password is filled, then it will return FALSE
         * if both email and password are not filled, then it will return FALSE
         * 
         * 
         * validation_errors() method will auto generate a error string that based
         * on certain criteria.
         * Example:
         * If the email is blank, it will generate a string that states
         * "The Email field is required"
         * 
         * 🛑NOTE: The auto generating error of string is made form_validation->run()
         * runs.Because it will just generate and empty string without it running
         * that methid(test it out.)
         */
        
        if(!$this->form_validation->run()) {
            return validation_errors();
        } else {
            return "success";
        }
    }

    public function validate_pass_match($user, $pass) {
        if($user[0] && $user[0]['password'] == $this->security->xss_clean($pass)) {
            return "success";
        } else {
            return "Incorrect password was inputted for " . $user[0]['email'];
        }
    }

    public function update_user_details_by_id($user_id, $user_details) {
        $data = array();

        foreach($user_details as $key => $detail) {
            if($detail !== '') {
                $data[$key] = $this->security->xss_clean($detail);
            }
        }

        if(count($data) > 0) {
            $this->db->where('id', $this->security->xss_clean($user_id));
            $data['updated_at'] = date('Y-m-d, H:i:s');
            return $this->db->update('users', $data);
        } else {
            return 'There\'s nothing to update';
        }
    }

    public function validate_old_pass($user_id, $old_pass) {
        $query = "SELECT password FROM users WHERE id=?";
        $pass = $this->security->xss_clean($old_pass);
        if($pass !== '') {
            $result = $this->db->query($query, $this->security->xss_clean($user_id))->result_array()[0];
            if($result['password'] == $pass) {
                return 'matched';
            } else {
                return 'does not match';
            }
        } else {
            return 'empty';
        }
    }

    public function confirm_new_pass() {
        $this->form_validation->set_error_delimiters('<div>', '</div>');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[5]');
        $this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'required|matches[new_password]');


        if(!$this->form_validation->run()) {
            return validation_errors();
        } else {
            return 'success';
        }

    }
}