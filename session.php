<?php 

class session
{
		function session()
		{
			session_start();
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