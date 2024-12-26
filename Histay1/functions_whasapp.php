<?php
function send_whatsapp($number,$message)
{
    $handle = curl_init();
     
    $url = "https://whatsapp.myappstores.com/api/sendText?token=602219c37209b82a207fb4fc&phone=91$number&message=$message";
     
    // Set the url
    curl_setopt($handle, CURLOPT_URL, $url);
    // Set the result output to be a string.
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
     
    $output = curl_exec($handle);
     
    curl_close($handle);
     
    echo $output;
}
?>