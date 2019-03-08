<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function cal(Request $request) {
        $input = $request->all();
        $number = $input['number'];
        $selectNumber= $input['numberlist'];
        //$result = strrev($this->convert($number));
        $result = $this->convertBalan($number);
        dd($result);

        return redirect()->back()->with('result', $result);
    }

    public function convert($num) {
        $str = "";
        while($num >= 1) {

            $str .= $num%2;
            $num = $num/2;
        }

        return $str;
    }
    public function convertBalan($str) {
        $result = "";
        for($i = 0; $i< strlen($str); $i++) {
            if($this->isOperator($str[$i]) == 0) {
                $result.= $str[$i];
            }
            if($this->isOperator($str[$i]) == 1) {
                if($str[$i] == '(')
                    $this->push($str[$i]);
                else if($str[$i] == ')') {
                    $tmp = $this->pop();
                    while($tmp != '(') {
                        $result .= $tmp;
                        $tmp = $this->pop();
                    }
                }
               // dd($this->stack);
            }
            else {
                while(!$this->isEmpty() && $this->getPriority($this->top()) >= $this->getPriority($str[$i])) {
                    //dd($this->top());
                    $result .= $this->pop();
                }
                $this->push($str[$i]);
            }
        }
//        dd($result);
        return $result;
    }

    public function getPriority($str) {
        if($str == "*" || $str == "/") return 2;
        else if($str == "+" || $str == "-") return 1;
        return 0;
    }

    public function isOperator($str) {
        if($this->getPriority($str) == 0) {
//            dd(strcmp($str, "("));
            if(strcmp($str, "(") != 0  && strcmp($str, ")") != 0 ) return 0;
            else return 1;
        }
        return 2;
    }


    protected $stack;
    protected $limit;

    public function __construct($limit = 10, $initial = array()) {
        // initialize the stack
        $this->stack = $initial;
        // stack can only contain this many items
        $this->limit = $limit;
    }

    public function push($item) {
        // trap for stack overflow
        if (count($this->stack) < $this->limit) {
            // prepend item to the start of the array
            array_unshift($this->stack, $item);
        } else {
            throw new RunTimeException('Stack is full!');
        }
    }

    public function pop() {
        if ($this->isEmpty()) {
            // trap for stack underflow
            throw new RunTimeException('Stack is empty!');
        } else {
            // pop item from the start of the array
            return array_shift($this->stack);
        }
    }

    public function top() {
        return current($this->stack);
    }

    public function isEmpty() {
        return empty($this->stack);
    }
}

