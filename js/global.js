jQuery(document).ready(function ($) {
var validation = {
is_email : function($email)
{
	 var re = /\S+@\S+\.\S+/;
        return re.test($email);
},
is_phone : function($phone)
{
	if ($phone.length > 9)
    	{
    	return true;	
    	}else{
    	return false;	
    	}	
	
}	
}

})
