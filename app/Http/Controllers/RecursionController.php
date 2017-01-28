<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 08.11.15
 * Time: 2:37
 */

namespace App\Http\Controllers;


use App\Recursion;
use Illuminate\Http\Request;

class RecursionController extends Controller
{

    public function get_recursion(){
        return view('recursion/recursion');
    }

    public function get_recursion_one(){
        return view('recursion/recursion_one');
    }

    public function get_recursion_two(){
        return view('recursion/recursion_two');
    }

    public function get_recursion_three(){
        return view('recursion/recursion_three');
    }

    public function calculate_one(Request $request){
		$exp = (String) $request->input('expression');
        $q = (String) $request->input('q');
        $function = (String) $request->input('function');
        $function = str_replace("-", " |-| ", $function);

        if ($q == "" || $function == "" || $exp == "") return "Заполните все пропуски!";

        $expression = $this->convertExp1Param($q, $exp);
        $cmd = "/var/www/html/timelimit.sh '";
        $cmd = $cmd . "head (" . $expression . " [0]) == (\\x ->" . $function . ") 0 \\n";
        $cmd = $cmd . "head (" . $expression . " [1]) == (\\x ->" . $function . ") 1 \\n";
        $cmd = $cmd . "head (" . $expression . " [2]) == (\\x ->" . $function . ") 2 \\n";
        $cmd = $cmd . "head (" . $expression . " [3]) == (\\x ->" . $function . ") 3 \\n";
        $cmd = $cmd . "head (" . $expression . " [10]) == (\\x ->" . $function . ") 10'";

        exec($cmd, $res);

        $countFalse = 0;
        $countTrue = 0;
        $pointsNumber = 5;
        foreach($res as $str){
            if(strstr($str,'False') !== false) $countFalse +=1;
            if(strstr($str,'True') !== false) $countTrue +=1;
        }

        if($countTrue + $countFalse != $pointsNumber) return "Ошибка в выражениях или выход за временные рамки!";
        if($countFalse == 0) return "Функции совпадают";

        return "Функции НЕ совпадают";
    }

    function convertExp1Param($q, $exp){
        $exp = strtolower($exp);
        $exp = str_replace(" ", "", $exp);
        $expression = "recursion1 " . $q . " (" . $this->depthStep($exp) . ")";
        return $expression;
    }

    public function calculate_two(Request $request){
        $second = (String) $request->input('second');
        $first = (String) $request->input('first');
        $function = (String) $request->input('function');
        $function = str_replace("-", " |-| ", $function);

        if ($first == "" || $function == "" || $second == "") return "Заполните все пропуски!";

        $expression = $this->convertExp2Param($first, $second);

        $cmd = "/var/www/html/timelimit.sh '";
        $cmd = $cmd . "head (" . $expression . " [0, 0]) == (\\x y ->" . $function . ") 0 0 \\n";
        $cmd = $cmd . "head (" . $expression . " [1, 1]) == (\\x y ->" . $function . ") 1 1 \\n";
        $cmd = $cmd . "head (" . $expression . " [2, 2]) == (\\x y ->" . $function . ") 2 2 \\n";
        $cmd = $cmd . "head (" . $expression . " [3, 3]) == (\\x y ->" . $function . ") 3 3 \\n";
        $cmd = $cmd . "head (" . $expression . " [10, 10]) == (\\x y ->" . $function . ") 10 10'";

        exec($cmd, $res);

        $countFalse = 0;
        $countTrue = 0;
        $pointsNumber = 5;
        foreach($res as $str){
            if(strstr($str,'False') !== false) $countFalse +=1;
            if(strstr($str,'True') !== false) $countTrue +=1;
        }

        if($countTrue + $countFalse != $pointsNumber) return "Ошибка в выражениях или выход за временные рамки!";
        if($countFalse == 0) return "Функции совпадают";

        return "Функции НЕ совпадают";
    }

    public function calculate_three(Request $request){
        $second = (String) $request->input('second');
        $first = (String) $request->input('first');
        $function = (String) $request->input('function');
        $function = str_replace("-", " |-| ", $function);

        if ($first == "" || $function == "" || $second == "") return "Заполните все пропуски!";

        $expression = $this->convertExp2Param($first, $second);

        $cmd = "/var/www/html/timelimit.sh '";
        $cmd = $cmd . "head (" . $expression . " [0, 0, 0]) == (\\x y z ->" . $function . ") 0 0 0 \\n";
        $cmd = $cmd . "head (" . $expression . " [1, 1, 1]) == (\\x y z ->" . $function . ") 1 1 1 \\n";
        $cmd = $cmd . "head (" . $expression . " [2, 2, 2]) == (\\x y z ->" . $function . ") 2 2 2 \\n";
        $cmd = $cmd . "head (" . $expression . " [3, 3, 3]) == (\\x y z ->" . $function . ") 3 3 3 \\n";
        $cmd = $cmd . "head (" . $expression . " [10, 10, 10]) == (\\x y z ->" . $function . ") 10 10 10'";

        exec($cmd, $res);

        $countFalse = 0;
        $countTrue = 0;
        $pointsNumber = 5;
        foreach($res as $str){
            if(strstr($str,'False') !== false) $countFalse +=1;
            if(strstr($str,'True') !== false) $countTrue +=1;
        }

        if($countTrue + $countFalse != $pointsNumber) return "Ошибка в выражениях или выход за временные рамки!";
        if($countFalse == 0) return "Функции совпадают";

        return "Функции НЕ совпадают";
    }

    function convertExp2Param($first, $second){
        $first = strtolower($first);
        $second = strtolower($second);

        $second = str_replace(" ", "", $second);
        $first = str_replace(" ", "", $first);
        $expression = "recursion (" . $this->depthStep($first) . ") (" . $this->depthStep($second) . ")";
        return $expression;
    }

    function depthStep($str){
        $args = strstr($str,'(');
        $pos = strpos($str, '(');
        $countOpen = 0;
        $countClose = 0;
        $tmpStr = "";
        if ($pos === false) {
           $fun = $str;
        } else {
            $fun = substr($str, 0, $pos);
        }
        $result = $this->matchFun($fun);
        if ($args != "") {
            $result = $result . " [";
            $exp = explode(',', substr($args, 1 , -1));
            $termCount = count($exp);
            $i = 0;
            foreach($exp as $term){
                $i += 1;
                $posOpen = strpos($term, '(');
                $closeNum = substr_count($term, ')');
                if ($posOpen === false && $closeNum == 0 && $countOpen == 0) {
                    $result = $result . $this->depthStep($term) . ",";
                } else {
                    if ($countOpen == 0 && $posOpen !== false){
                        $tmpStr = $tmpStr . $term;
                    }
                    else {
                        $tmpStr = $tmpStr . "," . $term;
                    }
                    if ($posOpen !== false){
                        $countOpen += 1;
                    }
                    if ($closeNum != 0) {
                            $countClose += $closeNum;
                    }
                    if ($countOpen == $countClose && $countOpen != 0) {
                        if ($i == $termCount) {
                            $result = $result . $this->depthStep($tmpStr);
                        } else {
                            $result = $result . $this->depthStep($tmpStr) . ",";
                        }
                        $countOpen = 0;
                        $countClose = 0;
                        $tmpStr = "";
                    }
                }
            }
            $result = $result . "]";
        }
        return str_replace(",]" , "]", $result);
    }

    function matchFun($fun){
        if (preg_match('/^sum/', $fun) != 0) return 'summ';
        if (preg_match('/^s[;0-9]+/', $fun) != 0) return 's';
        if (preg_match('/^s/', $fun) != 0) return 'sNext';
        if (preg_match('/^mul/', $fun) != 0) return 'mul';
        if (preg_match('/^[\^]/', $fun) != 0) return 'pow';
        if ($fun[0] == 'c' || $fun[0] == 'u'){
            $args = explode('.', substr($fun, 1));
            return '(' . $fun[0] . ' ' . $args[1] . ')';
        }
        return "1";
    }
}