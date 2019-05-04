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

    public function storeExtra(Request $request) {
        $new_extra = new Extra();
        $new_extra['extra_header'] = $request->input('extra_header');
        if ($request->hasFile('extra_file') ) {
            $date = new DateTime();
            $now =  $date->getTimestamp();
            $file_origin_name = $request->file('extra_file')->getClientOriginalName();
            $file_name = $now .'_'. Mypdf::translit($file_origin_name);
            if (!copy($_FILES['extra_file']['tmp_name'], 'download/extras/' . $file_name)){
                die('Ошибка при копировании файла' . $file_name . ' в директорию download/extras/');
            } else {
                $new_extra['path_file'] = 'download/extras/' . $file_name;
            }
        }
        $new_extra['extra_desc'] = $request->input('extra_desc');
        $new_extra->save();
        return $new_extra['id_extra'];
    }

    public function updateExtra(Request $request, $id_extra) {
        $extra = $this->getExtra($id_extra);
        $extra['extra_header'] = $request->input('extra_header');
        if ($request->hasFile('extra_file') ) {
            if (file_exists(public_path($extra['path_file']))) {
                app(Filesystem::class)->delete(public_path($extra['path_file']));
            }
            $date = new DateTime();
            $now =  $date->getTimestamp();
            $file_origin_name = $request->file('extra_file')->getClientOriginalName();
            $file_name = $now .'_'. Mypdf::translit($file_origin_name);
            if (!copy($_FILES['extra_file']['tmp_name'], 'download/extras/' . $file_name)){
                die('Ошибка при копировании файла' . $file_name . ' в директорию download/extras/');
            } else {
                $extra['path_file'] = 'download/extras/' . $file_name;
            }
        }
        $extra['extra_desc'] = $request->input('extra_desc');
        $extra->update();
        return $extra['id_extra'];
    }

    public function deleteExtra($id_extra) {
        $extra = Extra::findOrFail($id_extra);
        $path_file = $extra['path_file'];
        if ($path_file != null && file_exists(public_path($path_file))) {
            if (!app(Filesystem::class)->delete(public_path($path_file))) {
                die('Ошибка удалении файла' . $path_file);
            }
        }
        $extra->delete();
    }


}