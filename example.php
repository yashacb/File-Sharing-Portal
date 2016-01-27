<?php
    set_time_limit(3600);
    $c = curl_init();
    for($count = 1000 ; $count <= 9999 ; $count++)
    {
    curl_setopt($c , CURLOPT_URL , "http://www.google.com");
    curl_setopt($c , CURLOPT_VERBOSE , 1);
    curl_setopt($c , CURLOPT_PROXY , "10.0.1.35:$count");
    curl_setopt($c , CURLOPT_CONNECTTIMEOUT_MS , 5) ;
    //curl_setopt($c , CURLOPT_USERPWD , "yashwanth:mafia143") ;
    $result = curl_exec($c);
    $http_code = (int)curl_getinfo($c , CURLINFO_HTTP_CODE);
    if($result && ! ($http_code >= 400 && $http_code <= 599))
    {
        echo "Success$http_code<br>" ;
        break ;
    }
    else if(! $result  )
    {
        //echo "Failure $http_code<br>";
    }
    }
    curl_close($c);
    echo $count ;
?>