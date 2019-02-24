<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 22.01.2019
 * Time: 16:28
 */

namespace App\Library;



use App\EducationalMaterial;
use Illuminate\Filesystem\Filesystem;
use App\Http\Requests\AddEducationMaterialRequest;
use App\Http\Requests\EditEducationMaterialRequest;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeExtensionGuesser as MimeType;

class EducationalMaterialDAO {

    public function allEducationalMaterial(){
        return EducationalMaterial::all();
    }

    public function getEducationalMaterial($id){
        return EducationalMaterial::where('id',$id)->first();
    }

    public function storeEducationalMaterial(AddEducationMaterialRequest $request){
        if ($request->hasFile('education_material_file')){
            if ($request->file('education_material_file')->isValid()){
                $mimetypes = new MimeType;
                $rundomNumber = mt_rand(0, 10000);
                switch ($mimetypes->guess($request->file('education_material_file')->getMimeType())) {
                    case "doc":
                        $name = $rundomNumber . "EducationMaterial".".doc";
                        break;
                    case "docx":
                        $name = $rundomNumber . "EducationMaterial".".docx";
                        break;
                    case "pdf":
                        $name = $rundomNumber . "EducationMaterial".".pdf";
                        break;
                }
                if (!copy($_FILES['education_material_file']['tmp_name'], 'download/educational_material/' . $name)){
                    return 'Ошибка при копировании файла';
                }else{
                    $educationalMaterial = new EducationalMaterial();
                    $educationalMaterial->file_path = 'download/educational_material/' . $name;
                    $educationalMaterial->name = $request->name;
                    $educationalMaterial->save();
                }
            }else{
                return 'Ошибка при загрузки файла';
            }
        }
        return 'ok';
    }

    public function updateEducationalMaterial(EditEducationMaterialRequest $request, $id){
        $educationalMaterial = EducationalMaterial::findOrFail($id);
        $educationalMaterial->name = $request->name;
        if ($request->hasFile('education_material_file')){
            if ($request->file('education_material_file')->isValid()){
                $mimetypes = new MimeType;
                $rundomNumber = mt_rand(0, 10000);
                switch ($mimetypes->guess($request->file('education_material_file')->getMimeType())) {
                    case "doc":
                        $name = $rundomNumber . "EducationMaterial".".doc";
                        break;
                    case "docx":
                        $name = $rundomNumber . "EducationMaterial".".docx";
                        break;
                    case "pdf":
                        $name = $rundomNumber . "EducationMaterial".".pdf";
                        break;
                }
                if (!copy($_FILES['education_material_file']['tmp_name'], 'download/educational_material/' . $name)){
                    return 'Ошибка при копировании файла';
                }
                if ($educationalMaterial->file_path != null && file_exists(public_path($educationalMaterial->file_path))) {
                    if (!app(Filesystem::class)->delete(public_path($educationalMaterial->file_path))) {
                        return 'Ошибка удаления файла';
                    }
                }
                    $educationalMaterial->file_path = 'download/educational_material/' . $name;

            }else{
                return 'Ошибка при загрузке файла';
            }
        }
        $educationalMaterial->save();
        return 'ok';
    }

    public function deleteEducationalMaterial($id){
        $educationalMaterial = EducationalMaterial::findOrFail($id);
        if (file_exists(public_path($educationalMaterial->file_path))) {
            if (!app(Filesystem::class)->delete(public_path($educationalMaterial->file_path))) {
                return "Ошибка при удалении файла";
            }
        }
        $educationalMaterial->delete();
        return "ok";
    }
}