<?php 

class session
{
		function session()
		{	
			ini_set(‘session.gc_maxlifetime’,86400);
			session_start();
			//start_session(0);
		}	
		
		function register_value($name,$value)
		{	
			$_SESSION[$name]=$value;
			return true;
		}
		
		function get_value($name)
		{	
			
			if(isset($_SESSION[$name]))
				return $_SESSION[$name];
			else
				return false;
			
		
		}
		function destroy()
		{
			session_destroy();
		}
		
		function id()
		{
		
			return session_id();
		}



}
		

?>
