<?php 

//Warning, notification etc. messages

if(isset($_SESSION['notify']))
{
    $x = $_SESSION['notify'];
    
    if      ($x == 'profile')       {$y = $lang["please_login_profile"];} 
    elseif  ($x == 'create')        {$y = $lang["please_login_create"];} 
    elseif  ($x == 'update')        {$y = $lang["please_login_update"];}
    elseif  ($x == 'delete')        {$y = $lang["please_login_delete"];}
    elseif  ($x == 'error_general') {$y = $lang["error_general"];} 
    elseif  ($x == 'delete')        {$y = $lang["please_login_delete"];}
    elseif  ($x == 'not_found')     {$y = $lang["not_found"];}
    elseif  ($x == 'my_services')   {$y = $lang["please_login_my_services"];}

    $_SESSION['actual_message'] = $y;
    unset($_SESSION['notify']);
}

?>