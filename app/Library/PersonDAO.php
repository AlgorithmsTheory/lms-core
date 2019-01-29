<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 22.01.2019
 * Time: 16:28
 */

namespace App\Library;


use App\Http\Requests\AddPersonRequest;
use App\Http\Requests\EditPersonRequest;
use App\Person;
use DateTime;
use Illuminate\Filesystem\Filesystem;
use DB;

class PersonDAO
{
    public function allPerson(){
        return Person::all();
    }

    public function getPerson($index){
        return Person::where('id',$index)->first();
    }

    public function store_Person(AddPersonRequest $request){
        if ($request->hasFile('picture')){
            if ($request->file('picture')->isValid()){
                $name = mt_rand(0, 10000) . $request->file('picture')->getClientOriginalName();
                if (!copy($_FILES['picture']['tmp_name'], 'img/library/persons/' . $name)){
                    return 'Ошибка при копировании изображения';
                }else{
                    $person = new Person();
                    $person->image_patch = 'img/library/persons/' . $name;
                    $person->name = $request->name_person;
                    $person->year_birth = $request->year_birth;
                    $person->year_death = $request->year_death;
                    $person->content = $request->person_text;
                    $person->save();
                }
            }else{
                return 'Ошибка при загрузке изображения';
            }
        }
        return 'ok';
    }

    public function updatePerson(EditPersonRequest $request, $id){
        $person = Person::findOrFail($id);
        $person->name = $request->name_person;
        $person->year_birth = $request->year_birth;
        $person->year_death = $request->year_death;
        $person->content = $request->person_text;
        if ($request->hasFile('picture')){
            if ($request->file('picture')->isValid()){
                $name = mt_rand(0, 10000) . $request->file('picture')->getClientOriginalName();
                if (!copy($_FILES['picture']['tmp_name'], 'img/library/persons/' . $name)){
                    return 'Ошибка при копировании изображения';
                }else{
                    app(Filesystem::class)->delete(public_path($person->image_patch));
                    $person->image_patch = 'img/library/persons/' . $name;
                }
            }else{
                return 'Ошибка при загрузке изображения';
            }
        }
        $person->save();
        return 'ok';
    }

    public function deletePerson($id){
        $person = Person::findOrFail($id);
        if (file_exists(public_path($person->image_patch))) {
            if (!app(Filesystem::class)->delete(public_path($person->image_patch))) {
                return back()->withInput()->withErrors(['Ошибка при удалении изображения']);
            }
        }
        $person->delete();
    }
}