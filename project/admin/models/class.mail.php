<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once('../../postageapp_class.inc');	

class userCakeMail {
	//UserCake uses a text based system with hooks to replace various strs in txt email templates
	public $contents = NULL;
	
	//Function used for replacing hooks in our templates
	public function newTemplateMsg($template,$additionalHooks)
	{
		global $mail_templates_dir,$debug_mode;
		
		$this->contents = file_get_contents($mail_templates_dir.$template);
		
		//Check to see we can access the file / it has some contents
		if(!$this->contents || empty($this->contents))
		{
			return false;
		}
		else
		{
			//Replace default hooks
			$this->contents = replaceDefaultHook($this->contents);
			
			//Replace defined / custom hooks
			$this->contents = str_replace($additionalHooks["searchStrs"],$additionalHooks["subjectStrs"],$this->contents);
			
			return true;
		}
	}
	
	public function sendMail($email,$subject,$msg = NULL)
	{
		global $websiteName,$emailAddress;
		
		$header = array(
      'From'      => 'INNOVAPATH <' . $emailAddress . '>\r\n',
      'Reply-to'  => 'INNOVAPATH <' . $emailAddress . '>\r\n'
    );
		
		//Check to see if we sending a template email.
		if($msg == NULL)
			$msg = $this->contents; 
		
		$message = $msg;
		
		$message = wordwrap($message, 70);
		
    $mail_body = array(
      'text/html' => $message 
    );

		return PostageApp::mail($email, $subject, $mail_body, $header);

	}
}

?>
