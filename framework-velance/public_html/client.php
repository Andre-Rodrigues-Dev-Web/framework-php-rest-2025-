<?php

    $url = 'http://localhost/PROJS/VIDEO_AULAS/SERIE/03_APIREST2021/public_html/api';

    $class = '/user';
    $param = '';

    $response = file_get_contents($url.$class.$param);