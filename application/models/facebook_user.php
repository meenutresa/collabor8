<?php
class Facebook_user extends CI_Model{

	function __construct()
    	{
       	parent::__construct();
		$fb_config = array(
            	'appId'  => '334799646648478',
            	'secret' => '0933fb8afdfc25ccaa1d8e774dcd52d7',
		'fileUpload' => true,
		);
		$this->load->library('facebook', $fb_config);
		$this->load->database();
    	}

	function check_user_logged_in()			//returns TRUE if user is logged into facebook and app 
	{
		$flag = FALSE;
		$user_id = $this->facebook->getUser();
		if($user_id) 
		{

      		      try {
				$user_profile = $this->facebook->api('/me','GET');
       			$flag = TRUE;
	      		    } catch(FacebookApiException $e) {
        			error_log($e->getType());
        			error_log($e->getMessage());
      			}   
    		} 
		else 
		{ 
			$flag = FALSE; 
		}
		return $flag;
	}
	
	function check_user_exists() 			//if user has registered returns username and email as array else returns FALSE
	{
		$user_id = $this->facebook->getUser();
		//$this->db->select('username, email');
		$query = $this->db->get_where('users',array( 'password' => $user_id ));
		if($query->num_rows() == 0)
		{
			return FALSE;
		}
		else
		{
			return $query->row_array();
		}
	}
	
	function get_login_url()     			//returns facebook login url
	{
		$permissions = array ('scope' => 'emails, user_photos');//, user_birthday, publish_stream, user_location, user_about_me');
		return $this->facebook->getLoginUrl($permissions);
	}

	function get_logout_url()   			//returns facebook logout url (logout from both facebook and app)
	{
		return $this->facebook->getLogoutUrl();
	}
	
	function get_user_profile($username) 		 //returns info of user from profiles as array if user exists else FALSE
	{
		$query = $this->db->get_where('profiles',array( 'username' => $username ));
		if($query->num_rows() == 0)
		{
			return FALSE;
		}
		else 
		{
			return	$query->row_array();
		}
	}
	
	function add_user()  				//adds information obtained from facebook to facebook_users and profiles 
	{
		$info = $this->facebook->api('/me','GET');
		
		$username = $info['name'];
		$this->db->select('username');
		$query = $this->db->get_where('users',array( 'username' => $username ));
		if(!$query->num_rows() == 0)
		{
			$username = $username.rand(0,9);
		}	

		$data = array(	
					'password'	=> $info['id'],
					'username' 	=> $username,
					'email'         => $info['email'],
                                        'profile_pic'   => $this->get_profile_pic_url()
				);
		$this->db->insert('users',$data);
		
	}

	
	function get_friends()				//returns friend list as array
	{
		
		$friends_list = $this->facebook->api('/me/friends','GET');
		return $friends_list;

	}

	function get_likes()					//returns users likes as array
	{
		$likes_list = $this->facebook->api('/me/likes', 'GET');
		return $likes_list;
	}

	function get_posts()					//returns users posts as array
	{
		$posts_list = $this->facebook->api('/me/posts', 'GET');
		return $posts_list;
	}

	function get_profile_pic_url()			//returns user's profile pic url
	{
		$user_id = $this->facebook->getUser();
		return "http://graph.facebook.com/".$user_id."/picture";	
	}

	function publish_story($message, $title, $caption, $description, $link, $picture_url)	//publishes a story to users timeline "user shared a $link via app" $message $title $caption $description 
	{
		$user = $this->facebook->getUser();
		$params = array(
                  'message'       =>  $message,
                  'name'          =>  $title,
                  'caption'       =>  $caption,
                  'description'   =>  $description,
                  'link'          =>  $link,
		    'picture'	      =>  $picture
              );
		$post = $this->facebook->api("/".$user."/feed","POST",$params);
	}

	
	public function logout_fb()				//logout of app, not facebook
	{
		$this->facebook->destroySession();
	}
}
?>
