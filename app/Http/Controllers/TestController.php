<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 19.04.15
 * Time: 16:49
 */

namespace App\Http\Controllers;
use App\Test;
use App\Theme;
use Illuminate\Http\Request;
use App\Question;
use App\Codificator;
use PDOStatement;
use  PDO;
use Illuminate\Routing\Controller;

class TestController extends Controller{
    private $test;

    function __construct(Test $test){
        $this->test=$test;
    }

    public function index(){
        return view('tests.index');
    }

    public function prepareTest(Question $question){
        $array = [];
        $query=$question->where('code', '=', '1.5.1')->orWhere('code', '=', '1.5.2')->get();
        foreach ($query as $id){
             array_push($array,$id->id_question);
        }
        return $array;
    }
        $index = rand(0,count($array)-1);
        $choisen = $array[$index];
        $array[$index]=$array[count($array)-1];
        $array[count($array)-1] = $choisen;
        array_pop($array);
        $q->show($choisen, $num, $codificator, $tema);
   }
} 