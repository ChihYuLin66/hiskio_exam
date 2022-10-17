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
        $n = 10;
        $climbStair = new ClimbStair(); 
        $data = $climbStair->climb($n);
        
        foreach ($data['all'] as $item) { 
            $this->assertEquals($n, $item['two'] * 2 + $item['one']);
        }
    }
}