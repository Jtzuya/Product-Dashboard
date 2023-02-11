<?php
/**
 * Things to improve: 
 * - password add more security with using salt
 * 
 * Owner: Jake
 */


defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller 
{
	protected $active_user = NULL;

	// VIEWS FUNCTIONS
	public function index()
	{
		$active_user = $this->session->userdata('user_id');

		// This checks whether there's an active user via user id inside the session
		if(!$active_user) {
			// show the login page if there's NO active user
			$this->load->view('partials/initialize');
			$this->load->view('templates/login');
			$this->load->view('partials/disconnect');
		} else {
			redirect('dashboard');
		}

		// dump($this->session->userdata());
	}

	public function register() 
	{
		$active_user = $this->session->userdata('user_id');

		if(!$active_user) {
			$this->load->view('partials/initialize');
			$this->load->view('templates/registration');
			$this->load->view('partials/disconnect');
		} else {
			redirect('dashboard');
		}
	}

	public function dashboard() 
	{
		$product_details = array();
		$active_user = $this->session->userdata('user_id');
		$user_level = $this->session->userdata('user_level');
		
		if($active_user && $user_level == 0) {
			$product_details['datas'] = $this->product->get_all_products();
			$this->load->view('partials/initialize');
			$this->load->view('templates/dashboard.php', $product_details);
			$this->load->view('partials/disconnect');
		} else if ($active_user && $user_level == 9) {
			redirect('dashboard/admin');
		} else {
			// if not signed in, just redirect to the login page
			redirect('/');
		}

		// dump($this->session->userdata());
	}

	public function admin() 
	{
		$product_details = array();
		$active_user = $this->session->userdata('user_id');
		$user_level = $this->session->userdata('user_level');

		if($active_user && $user_level == 9) {
			$product_details['datas'] = $this->product->get_all_products();
			$this->load->view('partials/initialize');
			$this->load->view('templates/admin_dashboard.php', $product_details);
			$this->load->view('partials/disconnect');
		} else if($active_user && $user_level == 0) {
			redirect('dashboard');
		} else {
			// if not signed in, just redirect to the login page
			redirect('/');
		}
	}

	public function profile() {
		$user_id = $this->session->userdata('user_id');
		if($user_id) {
			$this->load->view('partials/initialize');
			$this->load->view('templates/profile');
			$this->load->view('partials/disconnect');
		} else {
			redirect('/');
		}
	}

	public function update_user() {
		$user_id = $this->session->userdata('user_id');
		if($user_id !== NULL) {
			$user_details = $this->input->post();
			$result = $this->user->update_user_details_by_id($user_id, $user_details);
			if($result !== TRUE) {
				$this->session->set_flashdata('input_errors', $result);
				redirect('users/edit');
			} else {
				$this->session->set_flashdata('success', 'Successfully updated details');
				redirect('users/edit');
			}
		} else {
			redirect('/');
		}
	}

	public function update_pass() {
		$user_id = $this->session->userdata('user_id');
		$path = 'users/edit';
		if($user_id !== NULL) {
			$result = $this->user->validate_old_pass($user_id, $this->input->post('old_password'));
			if($result == 'matched') {
				$result = $this->user->confirm_new_pass();
				if($result !== 'success') {
					$this->session->set_flashdata('input_errors', $result);
					redirect($path);
				} else {
					$user_details = array('password' => $this->input->post('new_password'));
					$result = $this->user->update_user_details_by_id($user_id, $user_details);
					if($result == TRUE) {
						$this->session->set_flashdata('success', 'successfully updated password');
						redirect($path);
					} else {
						$this->session->set_flashdata('input_errors', $result);
						redirect($path);
					}
				}

			} else {
				$this->session->set_flashdata('input_errors', $result);
				redirect($path);
			}
		} else {
			redirect($path);
		}
	}

	// OTHER FUNCTIONS
	public function process_registration() 
	{
		$email = $this->input->post('email');

		/**
		 * What this defined variable does is it goes to the user
		 * model (see we are not using $this->load->model since
		 * we are auto-loading it inside application/config/autoload.php)
		 * 
		 * then, we call this validate registration public function
		 * inside to check whether we already have this email inside our
		 * database.
		 */
		$checker = $this->user->validate_registration($email);
		if($checker !== NULL) {
			// if not null means, email already exists and let's throw an error
			$this->session->set_flashdata('input_errors', $email . ' already exists');
			redirect('register');
		} else {
			// Returns null, email doens't exist and it is safe to assume that we can create this email
			$user_data = $this->input->post();

			// create
			$this->user->create_user($user_data);

			// get and set session
			$new_user = $this->user->get_user_by_email($email);
			$this->session->set_userdata(array(
				'user_id' => $new_user[0]['id'], 
				'first_name' => $new_user[0]['first_name'],
				'user_level' => $new_user[0]['user_level']
			));

			$user_level = $this->session->userdata('user_level');
			if($user_level == 9) {
				redirect('dashboard/admin');
			} else {
				redirect('dashboard');
			}
		}
	}

	public function process_signin() 
	{
		$login_details = $this->input->post();
		$result = $this->user->validate_login($login_details);

		if($result !== 'success') {
			// if result does not return a success string then show some errors
			$this->session->set_flashdata('input_errors', $result);
			redirect('login');
		} else {
			$email = $login_details['email'];

			// checks the database for this email returns an array or null if there's no data inside the db
			$user = $this->user->get_user_by_email($email);

			if($user[0] !== NULL) {
				$result = $this->user->validate_pass_match($user, $this->input->post('password'));
				if($result !== 'success') {
					$this->session->set_flashdata('input_errors', $result);
					redirect('login');
				} else {
					$this->session->set_userdata(array(
						'user_id' => $user[0]['id'], 
						'first_name' => $user[0]['first_name'],
						'user_level' => $user[0]['user_level']
					));

					$user_level = $this->session->userdata('user_level');
					if($user_level == 9) {
						redirect('dashboard/admin');
					} else {
						redirect('dashboard');
					}
				}
			} else {
				$this->session->set_flashdata('input_errors', 'cannot find this email');
				redirect('login');
			}
		}
	}

	public function logout() 
	{
		$this->session->sess_destroy();
		redirect('login');
	}
}
