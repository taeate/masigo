<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('member/Login_model');
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
    } 
    public function index() {
        if ($this->input->post()) {
        
            $user_id = $this->input->post('user_id');
            $password = $this->input->post('password');
    
            // 사용자 인증 시도
            $user = $this->Login_model->authenticate($user_id, $password);
            if ($user) {
                // 세션 데이터 설정
                $session_data = array(
                    'user_id'     => $user->user_id,
                    'username'    => $user->username,
                    'email'       => $user->email,
                    'is_logged_in'=> TRUE
                );
                $this->session->set_userdata($session_data);
    
                // 로그인 성공 시 
                // redirect('posts'); 
                $this->load->view('member/login_view');
            } else {
                // 로그인 실패 시 오류 메시지 설정
                $this->session->set_flashdata('error', '잘못된 아이디 또는 비밀번호입니다.');
                // redirect('login');
                
            }
        } else {
            // GET 요청 시 로그인 뷰 로드
            $this->load->view('member/login_view');
        }
    }

    // 로그아웃 기능
    public function logout() {
        $this->session->unset_userdata('is_logged_in');
        $this->session->unset_userdata('user_id');
        redirect('login');
    }


	
}
?>
