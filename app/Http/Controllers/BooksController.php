<?php

namespace App\Http\Controllers;
use Request;
use DateTime;

class BooksController extends Controller {
    
    
    public function index(){
        $link = mysqli_connect('localhost','root','root','libr'); 
        $link->query("SET CHARACTER SET utf8");
	    $query = "SELECT id, coverImg, title, author, format FROM book" ; 
	    $result = $link->query($query);
        $searchquery = ""; 
        return view("library.books", compact('result','searchquery'));
    }
    
    
    public function search(){
        $search = Request::input('search');
        $link = mysqli_connect('localhost','root','root','libr'); 
        $link->query("SET CHARACTER SET utf8");
	    $query = "SELECT id, coverImg, title, author, format FROM `book` WHERE UPPER(`title`) LIKE UPPER('%$search%') OR UPPER(`author`) LIKE UPPER('%$search%')"; 
	    $result = $link->query($query);
        $searchquery = $search;
        return view("library.books", compact('result','searchquery'));
    }
    
    public function getBook($id){
        $link = mysqli_connect('localhost','root','root','libr'); // соединяюсь
	   $link->query("SET CHARACTER SET utf8");
        $query = "SELECT * FROM book WHERE book.id = ".$id;
	   $result = $link->query($query);
	   $row = mysqli_fetch_array($result);
        return view("library.book", compact('id','row'));
    }
    
     public function lection($id){
       $book_id = $id;
       $link = mysqli_connect('localhost','root','root','libr'); // соединяюсь
	   $link->query("SET CHARACTER SET utf8");
	   $query1 = "SELECT lection.id, lection.date FROM `lection` where lection.date not in (SELECT date FROM `order` where order.book_id ='$book_id')";
	   $result1 = $link->query($query1);
       $success = false;
    return view("library.lection", compact('book_id','result1', 'success'));
     }

    public function ebookindex(){
        $link = mysqli_connect('localhost','root','root','libr');
        $link->query("SET CHARACTER SET utf8");
        $results = array();
        for ($i = 0; $i < 5; $i++){
            $query = "SELECT * FROM ebook WHERE section=$i";
            $results[$i] = $link->query($query);
        }
        $searchquery = "";
        return view("library.ebooks", compact('results','searchquery'));
    }
    public function esearch(){
        $search = Request::input('search');
        $link = mysqli_connect('localhost','root','root','libr');
        $link->query("SET CHARACTER SET utf8");
        $query = "SELECT * FROM `ebook` WHERE UPPER(`title`) LIKE UPPER('%$search%') OR UPPER(`author`) LIKE UPPER('%$search%')";
        $results = $link->query($query);
        $searchquery = $search;
        return view("library.ebooks", compact('results','searchquery'));
    }

    public function order($book_id){
        $date = Request::input('date');
        $link = mysqli_connect('localhost','root','root','libr'); // соединяюсь
        $link->query("SET CHARACTER SET utf8");
        $query2 = "INSERT INTO `order` (`id`, `book_id`, `student_id`, `date` ) VALUES ( NULL, '$book_id', \"vasya\", '$date')";
        $result1 = $link->query($query2);
        $query1 = "SELECT lection.id, lection.date FROM `lection` where lection.date not in (SELECT date FROM `order` where order.book_id ='$book_id')";
        $result1 = $link->query($query1);
        $success = true;
        return view("library.lection", compact('book_id','result1', 'success'));
    }
    public function library_calendar(){
        $success = false;
        return view("personal_account.library_calendar", compact('success'));
    }

    public function create_date(){
        $datapicker = Request::input('datapicker');
        $link = mysqli_connect('localhost','root','root','libr');
        $link->query("SET CHARACTER SET utf8");

        //if(isset($_POST['data_picker'])) {
           // $datapicker = $_POST['data_picker'];
            $query1 = "TRUNCATE TABLE `lection`";
            $result = $link->query($query1);
            $date = new DateTime($datapicker);
            $query = "INSERT INTO `lection`(`id`, `date`) VALUES(NULL,'".$date->format('Y-m-d')."')";
            $result = $link->query($query);

            for ($j=0; $j<16; $j++) {
                $query = "INSERT INTO `lection`(`id`, `date`) VALUES(NULL,'".$date->format('Y-m-d')."')";
                $date->modify('+7 day');
                //$datapicker = $date->format('Y-m-d');
                $link->query($query);
            }
            $link->close();
        $success = true;
        return view("personal_account.library_calendar", compact('success'));
    }

    public function library_order_list(){
        $link = mysqli_connect('localhost','root','root','libr');
        $link->query("SET CHARACTER SET utf8");
        $query = "SELECT `order`.`id`, `order`.`student_id`, `order`.`date`, `order`.`book_id`, `book`.`title`, `book`.`author` FROM `order` INNER JOIN `book` ON book.id=order.book_id ORDER BY date";
        $result = $link->query($query);

        return view("personal_account.library_order_list", compact('result'));
    }

    public function order_list_delete(){
        $link = mysqli_connect('localhost','root','root','libr');
        $link->query("SET CHARACTER SET utf8");
        $return = Request::input('return');
        if (count($return) > 0){
            foreach ($return as $id) {
                $query = "DELETE FROM `order` WHERE order.id=".$id;
                $result = $link->query($query);
            }
        }
        $query = "SELECT `order`.`id`, `order`.`student_id`, `order`.`date`, `order`.`book_id`, `book`.`title`, `book`.`author` FROM `order` INNER JOIN `book` ON book.id=order.book_id ORDER BY date";
        $result = $link->query($query);

        return view("personal_account.library_order_list", compact('result'));
    }
  } 