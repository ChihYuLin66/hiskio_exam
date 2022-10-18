<?php

require 'vendor/autoload.php';

use ChihYuLin66\HiskioExamClimbStair\ClimbStair;

function dump(...$data)
{
    $data = is_array($data) ? $data : [$data];
    echo '<xmp>';
    foreach($data as $item) {
        print_r($item);
    }
    echo '
    </xmp>';
}

$climbStair = new ClimbStair();

dump(
    $climbStair->climb(-1),
    $climbStair->climb(1),
    $climbStair->climb(10),
    $climbStair->climb(11),
);
