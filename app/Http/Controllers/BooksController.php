<?php

namespace App\Http\Controllers;
use App\Ebook;
use Request;
use DateTime;
use App\Book;
use App\Testing\Lecture;
use App\Order;
use DB;
class BooksController extends Controller {
    
    
    public function index(){
        $book = Book::select();
	    $result = $book->get();
        $searchquery = ""; 
        return view("library.books", compact('result','searchquery'));
    }
    
    
    public function search(){
        $search = Request::input('search');
        $book = Book::where('title', 'like', "%$search%");
        $book->orWhere('author', 'like', "%$search%");
	    //$query = "SELECT id, coverImg, title, author, format FROM `book` WHERE UPPER(`title`) LIKE UPPER('%$search%') OR UPPER(`author`) LIKE UPPER('%$search%')";
	    $result = $book->get();
        $searchquery = $search;
        return view("library.books", compact('result','searchquery'));
    }
    
    public function getBook($id){
        $book = Book::where('id', '=', "$id");
        $row = $book->first();
        return view("library.book", compact('id','row'));
    }

    public function getvalues($arr) {
        return $arr['date'];
         }

     public function lection($id){
       $book_id = $id;
       $ordered = Order::where('book_id', '=', $book_id);
         $ordered->select('date');
         $arr = $ordered->get()->toArray();
         $arr_processed = [];
         foreach($arr as $elem){
             $arr_processed[] = $elem['date'];
         }
       $result1 = Lecture::whereNotIn('date', $arr_processed)->get();
 	   //$query1 = "SELECT Lecture.id, Lecture.date FROM `Lecture` where Lecture.date not in (SELECT date FROM `order` where order.book_id ='$book_id')";
       $success = false;
    return view("library.lection", compact('book_id','result1', 'success'));
     }

    public function ebookindex(){
        $ebook=Ebook::select();
        $results=$ebook->get();
        /*$link = mysqli_connect('localhost','root','root','libr');
        $link->query("SET CHARACTER SET utf8");*/
        //$results = array();
        for ($i = 0; $i < 5; $i++){
            //$query = "SELECT * FROM ebook WHERE section=$i";
            $query=Ebook::where('section', '=', "$i");
            $results[$i] = $query->get();
        }
        $searchquery = "";
        return view("library.ebooks", compact('results','searchquery'));
    }
    public function esearch(){
        $search = Request::input('search');
        $ebook=Ebook::where('title', 'like', "%$search%");
        $ebook->orWhere('author', 'like', "%$search%");
        //$query = "SELECT * FROM `ebook` WHERE UPPER(`title`) LIKE UPPER('%$search%') OR UPPER(`author`) LIKE UPPER('%$search%')";
        //$results = $link->query($query);
        $results= $ebook->get();
        $searchquery = $search;
        return view("library.ebooks", compact('results','searchquery'));
    }

    public function order($book_id){
        $date = Request::input('date');

        $order = new Order;
        $order->id = NULL;
        $order->book_id = "$book_id";
        $order->student_id = "vasya"; //TODO: сюда прикрутить авторизацию
        $order->date = "$date";
        $order->save();
        $ordered = Order::where('book_id', '=', $book_id);
        $ordered->select('date');
        $arr = $ordered->get()->toArray();
        $arr_processed = [];
        foreach($arr as $elem){
            $arr_processed[] = $elem['date'];
        }
        $result1 = Lecture::whereNotIn('date', $arr_processed)->get();

        $success = true;
        return view("library.Lecture", compact('book_id','result1', 'success'));
    }
    public function library_calendar(){
        $success = false;
        return view("personal_account.library_calendar", compact('success'));
    }

    public function create_date(){
        $datapicker = Request::input('data_picker');
        //fuck the ORM
        DB::delete("TRUNCATE TABLE `Lecture`");
            $date = new DateTime($datapicker);
            //$query = DB::insert("INSERT INTO `Lecture`(`id`, `date`) VALUES(NULL,'".$date->format('Y-m-d')."')");
            //$result = $link->query($query);

            for ($j=0; $j<16; $j++) {
                DB::insert("INSERT INTO `Lecture`(`id`, `date`) VALUES(NULL,'".$date->format('Y-m-d')."')");
                $date->modify('+7 day');
            }
        $success = true;
        return view("personal_account.library_calendar", compact('success'));
    }

    public function     library_order_list(){
        $result = DB::Select("SELECT `order`.`id`, `order`.`student_id`, `order`.`date`,`order`.`status`, `order`.`book_id`, `book`.`title`, `book`.`author` FROM `order` INNER JOIN `book` ON book.id=order.book_id ORDER BY date");
        $result = json_decode(json_encode($result), true);
        return view("personal_account.library_order_list", compact('result'));
    }

    public function order_list_delete(){
      //  $link = mysqli_connect('localhost','root','root','libr');
      // $link->query("SET CHARACTER SET utf8");
        $return = Request::input('return');
        if (count($return) > 0){
            foreach ($return as $id) {
                //$query = DB::delete ("DELETE FROM `order` WHERE order.id=".$id);
                $result = DB::delete ("DELETE FROM `order` WHERE order.id=".$id);
                $result = json_decode(json_encode($result), true);
               // $result = $link->query($query);
            }
        }

        $result = DB:: Select("SELECT `order`.`id`, `order`.`student_id`, `order`.`date`, `order`.`status`, `order`.`book_id`, `book`.`title`, `book`.`author` FROM `order` INNER JOIN `book` ON book.id=order.book_id  ORDER BY date");
        $result = json_decode(json_encode($result), true);
        // $result = $link->query($query);

        return view("personal_account.library_order_list", compact('result'));
    }


    public function student_lib_account(){
        //TODO: сюда нужна авторизация для пользователя
        $result = DB::Select("SELECT `order`.`id`, `order`.`student_id`, `order`.`date`, `order`.`book_id`, `book`.`title`, `book`.`author` FROM `order` INNER JOIN `book`  WHERE `order`.student_id = 'vasya' && book.id=`order`.book_id && `order`.date > CURDATE() ORDER BY date");
        $result = json_decode(json_encode($result), true);
        return view("personal_account.student_lib_account", compact('result'));
    }
    public function student_order_delete(){
        $return = Request::input('return');
        if (count($return) > 0){
            foreach ($return as $id) {

                $result = DB::delete ("DELETE FROM `order` WHERE order.id=".$id);
                $result = json_decode(json_encode($result), true);
            }
        }
//TODO: сюда тоже нужна авторизация для пользователя
        $result = DB:: Select("SELECT `order`.`id`, `order`.`student_id`, `order`.`date`, `order`.`book_id`, `book`.`title`, `book`.`author` FROM `order` INNER JOIN `book`  WHERE `order`.student_id = 'vasya' && book.id=`order`.book_id && `order`.date > CURDATE() ORDER BY date");
        $result = json_decode(json_encode($result), true);


        return view("personal_account.student_lib_account", compact('result'));
    }
    public function student_lib_account2(){
        //TODO: сюда нужна авторизация для пользователя
        $result = DB::Select("SELECT `order`.`id`, `order`.`student_id`, `order`.`status`, `order`.`date`, `order`.`book_id`, `book`.`title`, `book`.`author` FROM `order` INNER JOIN `book`  WHERE `order`.student_id = 'vasya' && book.id=`order`.book_id && `order`.date <= CURDATE() ORDER BY date");
        $result = json_decode(json_encode($result), true);
        return view("personal_account.student_lib_account2", compact('result'));
    }
    public function edit_order_status0($order_id){
       // $order_id = DB::Select("SELECT `order`.`id` FROM `order` INNER JOIN `book` ON book.id=order.book_id");
        $result = DB:: Update("UPDATE `order` SET `status`='1' where `order`.id=".$order_id);
        $result = json_decode(json_encode($result), true);
        return BooksController::library_order_list();

    }
    public function edit_order_status1($order_id){
       // $order_id = DB::Select("SELECT `order`.`id` FROM `order` INNER JOIN `book` ON book.id=order.book_id");
        $result = DB:: Update("UPDATE `order` SET `status`='0' where `order`.id=".$order_id);
        $result = json_decode(json_encode($result), true);
        return BooksController::library_order_list();

    }
  }