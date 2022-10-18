<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use ChihYuLin66\HiskioExamClimbStair\ClimbStair;

class ClimbStairTest extends TestCase
{
    /**
     * 試爬
     */
    public function testClimb() 
    {
        $n = 5;
        $climbStair = new ClimbStair(); 
        $response = $climbStair->climb($n);

        $this->assertTrue($response['status']);
        foreach ($response['data']['all'] as $item) { 
            $this->assertEquals($n, $item['two'] * 2 + $item['one']);
        }
    }

    /**
     * n < 0
     */
    public function testClimbNLessThanZero() 
    {
        $n = -1;
        $climbStair = new ClimbStair(); 
        $response = $climbStair->climb($n);
        
        $this->assertEquals($response['status'], false);
    }
}