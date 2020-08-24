<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 05.05.2019
 * Time: 17:00
 */

namespace App\Library\DAO;


use App\Library\Models\Ebook;
use Illuminate\Http\Request;
use Validator;
use DateTime;
use App\Mypdf;
use Illuminate\Filesystem\Filesystem;

class EbookDAO {
    const DIR_PARENT_MODULE = 'download/library/';
    const DIR_THIS_MODULE_DOCS = 'ebook/docs/';
    const DIR_THIS_MODULE_IMAGES = 'ebook/images/';
    private $dir_save_docs;
    private $dir_save_images;

    public function __construct() {
        $this->dir_save_docs = $this::DIR_PARENT_MODULE . $this::DIR_THIS_MODULE_DOCS;
        $this->dir_save_images = $this::DIR_PARENT_MODULE . $this::DIR_THIS_MODULE_IMAGES;
    }

    public function allEbooksGroupByGenre(){
        return Ebook::leftJoin('genres_books', 'genres_books.id', 'ebook.id_genre')
            ->get()
            ->groupBy('name')
            ->map( function ($ebooks) {
                return $ebooks->sortByDesc('id_ebook');
            });
    }

    public function searchEbooks($author_or_title) {
        return Ebook::where('ebook_title', 'like', "%$author_or_title%")
            ->orWhere('ebook_author', 'like', "%$author_or_title%")
            ->leftJoin('genres_books', 'genres_books.id', 'ebook.id_genre')
            ->get()
            ->groupBy('name')
            ->map( function ($ebooks) {
                return $ebooks->sortByDesc('id_ebook');
            });
    }

    public function getEbook($id_ebook){
        return Ebook::where('id_ebook',$id_ebook)
            ->leftJoin('genres_books', 'genres_books.id', 'ebook.id_genre')
            ->first();
    }

    public function validateStore(Request $request) {
        return Validator::make($request->all(), [
            'ebook_title' => 'required|max:255',
            'ebook_author' => 'required|max:255',
            'ebook_img' => 'required|image',
            'ebook_file' => 'required|file|mimes:doc,docx,pdf,djvu',
            'id_genre' => 'required',
        ]);
    }

    public function validateUpdate(Request $request) {
        return Validator::make($request->all(), [
            'ebook_title' => 'required|max:255',
            'ebook_author' => 'required|max:255',
            'ebook_img' => 'image',
            'ebook_file' => 'file|mimes:doc,docx,pdf,djvu',
            'id_genre' => 'required',
        ]);
    }

    public function deleteFileIfExist($dir_parent_module,$path_file){
        $all_path = $dir_parent_module . $path_file;
        if ($path_file != null && file_exists(public_path($all_path))) {
            if (!app(Filesystem::class)->delete(public_path($all_path))) {
                die('Ошибка удалении файла ' . $path_file);
            }
        }
    }

    public function updateEbook(Request $request, $id_ebook) {
        $ebook = $this->getEbook($id_ebook);
        $ebook['ebook_title'] = $request->input('ebook_title');
        $ebook['ebook_author'] = $request->input('ebook_author');
        $ebook['id_genre'] = $request->input('id_genre');
        $ebook['ebook_desc'] = $request->input('ebook_desc');
        if ($request->hasFile('ebook_img') ) {
            $this->deleteFileIfExist($this::DIR_PARENT_MODULE, $ebook['ebook_path_img']);
            $ebook['ebook_path_img'] = $this->storeImageFile($request);
        }
        if ($request->hasFile('ebook_file') ) {
            $this->deleteFileIfExist($this::DIR_PARENT_MODULE, $ebook['ebook_path_file']);
            $ebook['ebook_path_file'] = $this->storeDocFile($request);
        }
        $ebook->update();
        return $ebook['id_ebook'];
    }

    public function storeEbook(Request $request) {
        $ebook = new Ebook();
        $ebook['ebook_title'] = $request->input('ebook_title');
        $ebook['ebook_author'] = $request->input('ebook_author');
        $ebook['id_genre'] = $request->input('id_genre');
        $ebook['ebook_desc'] = $request->input('ebook_desc');
        if ($request->hasFile('ebook_img') ) {
            $ebook['ebook_path_img'] = $this->storeImageFile($request);
        }
        if ($request->hasFile('ebook_file') ) {
            $ebook['ebook_path_file'] = $this->storeDocFile($request);
        }
        $ebook->save();
        return $ebook['id_ebook'];
    }

    public function storeDocFile(Request $request) {
        $date = new DateTime();
        $now =  $date->getTimestamp();
        $file_origin_name = $request->file('ebook_file')->getClientOriginalName();
        $file_name = $now .'_'. Mypdf::translit($file_origin_name);
        if (!copy($_FILES['ebook_file']['tmp_name'], $this->dir_save_docs . $file_name)){
            die('Ошибка при копировании файла' . $file_name . ' в директорию ' . $this->dir_save_docs);
        } else {
            return $this::DIR_THIS_MODULE_DOCS . $file_name;
        }
    }

    public function storeImageFile(Request $request) {
        $date = new DateTime();
        $now =  $date->getTimestamp();
        $file_origin_name = $request->file('ebook_img')->getClientOriginalName();
        $file_name = $now .'_'. Mypdf::translit($file_origin_name);
        if (!copy($_FILES['ebook_img']['tmp_name'], $this->dir_save_images . $file_name)){
            die('Ошибка при копировании файла' . $file_name . ' в директорию ' . $this->dir_save_images);
        } else {
           return $this::DIR_THIS_MODULE_IMAGES . $file_name;
        }
    }

    public function deleteEbook($id_ebook) {
        $ebook = Ebook::findOrFail($id_ebook);
        $this->deleteFileIfExist($this::DIR_PARENT_MODULE, $ebook['ebook_path_img']);
        $this->deleteFileIfExist($this::DIR_PARENT_MODULE, $ebook['ebook_path_file']);
        $ebook->delete();
    }
}