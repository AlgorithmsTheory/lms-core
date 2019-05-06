<?php


namespace App\Library\DAO;

use App\Mypdf;
use Illuminate\Http\Request;
use App\Library\Models\Extra;
use Validator;
use DateTime;
use Illuminate\Filesystem\Filesystem;

class ExtraDAO
{
     const DIR_PARENT_MODULE = 'download/library/';
     const DIR_THIS_MODULE_DOCS = 'extra/docs/';
     private $dir_save_docs;

    public function __construct()
    {
        $this->dir_save_docs = $this::DIR_PARENT_MODULE . $this::DIR_THIS_MODULE_DOCS;
    }

    public function allExtras(){
        return Extra::all()->sortByDesc('id_extra');
    }

    public function getExtra($id_extra){
        return Extra::where('id_extra',$id_extra)->first();
    }

    public function validate(Request $request)
    {
        return Validator::make($request->all(), [
            'extra_header' => 'required|max:355',
            'extra_file' => 'file|mimes:doc,docx,pdf'
        ]);
    }

    public function storeDocFile(Request $request) {
        $date = new DateTime();
        $now =  $date->getTimestamp();
        $file_origin_name = $request->file('extra_file')->getClientOriginalName();
        $file_name = $now .'_'. Mypdf::translit($file_origin_name);
        if (!copy($_FILES['extra_file']['tmp_name'], $this->dir_save_docs . $file_name)){
            die('Ошибка при копировании файла' . $file_name . ' в директорию ' . $this->dir_save_docs);
        } else {
            return $this::DIR_THIS_MODULE_DOCS . $file_name;
        }
    }

    public function deleteFileIfExist($dir_parent_module,$path_file){
        $all_path = $dir_parent_module . $path_file;
        if ($path_file != null && file_exists(public_path($all_path))) {
            if (!app(Filesystem::class)->delete(public_path($all_path))) {
                die('Ошибка удалении файла ' . $path_file);
            }
        }
    }

    public function storeExtra(Request $request) {
        $new_extra = new Extra();
        $new_extra['extra_header'] = $request->input('extra_header');
        if ($request->hasFile('extra_file') ) {
            $new_extra['path_file'] = $this->storeDocFile($request);
        }
        $new_extra['extra_desc'] = $request->input('extra_desc');
        $new_extra->save();
        return $new_extra['id_extra'];
    }

    public function updateExtra(Request $request, $id_extra) {
        $extra = $this->getExtra($id_extra);
        $extra['extra_header'] = $request->input('extra_header');
        if ($request->hasFile('extra_file') ) {
            $this->deleteFileIfExist($this::DIR_PARENT_MODULE, $extra['path_file']);
            $extra['path_file'] = $this->storeDocFile($request);
        }
        $extra['extra_desc'] = $request->input('extra_desc');
        $extra->update();
        return $extra['id_extra'];
    }

    public function deleteExtra($id_extra) {
        $extra = Extra::findOrFail($id_extra);
        $this->deleteFileIfExist($this::DIR_PARENT_MODULE, $extra['path_file']);
        $extra->delete();
    }


}