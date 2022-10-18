<?php

namespace ChihYuLin66\HiskioExamClimbStair;

class ClimbStair
{
    /**
     * 爬！
     * 
     * @param int $n: 總階梯數量
     */
    public function climb($n): array
    {
        $data = [];

        // 階梯數不得小於0
        if ($n <= 0) {
            return [
                'status' => false,
                'message' => '階梯數不得小於0',
                'data' => []
            ];
        }

        $max = floor($n/2);
    
        for ($i=$max; $i >= 0 ; $i--) { 
            $data[] = [
                'two' => $i,
                'one' => $n - $i * 2,
            ];
        }
    
        return [
            'status' => true,
            'message' => 'success!',
            'data' => [
                'all' => $data,
                'count' => count($data)
            ]
        ];
    }
}
