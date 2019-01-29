<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 22.01.2019
 * Time: 16:28
 */

namespace App\Library;


use App\Http\Requests\AddTheoremRequest;
use App\Http\Requests\UpdateTheoremRequest;

use App\Theorem;
use DateTime;
use Illuminate\Filesystem\Filesystem;
use DB;

class TheoremDAO
{
    public function allTheorem(){
        $theorems = Theorem::all();
        foreach ($theorems as $theorem) {
            $theorem->getLinkToLectureAttribute();
        }
        return  $theorems;
    }

    public function getTheorem($index){
        return Theorem::where('id',$index)->first();
    }

    public function store_Theorem(AddTheoremRequest $request){
        $theorem = new Theorem();
        $theorem->name = $request->theorem_name;
        $theorem->content = $request->theorem_content;
        $theorem->exam = $request->exam;
        $theorem->doc = $request->doc;
        if ($request->id_lecture != null && $request->name_anchor!=null) {
            $theorem->idLecture = $request->id_lecture;
            $theorem->nameAnchor = $request->name_anchor;
        }
        $theorem->save();

    }

    public function updateTheorem(UpdateTheoremRequest $request, $id){
        $theorem = Theorem::findOrFail($id);
        $theorem->name = $request->theorem_name;
        $theorem->content = $request->theorem_content;
        $theorem->exam = $request->exam;
        $theorem->doc = $request->doc;
        if ($request->id_lecture == null || $request->name_anchor == null) {
            $theorem->idLecture = null;
            $theorem->nameAnchor = null;
        } else {
            $theorem->idLecture = $request->id_lecture;
            $theorem->nameAnchor = $request->name_anchor;
        }
        $theorem->save();
    }

    public function deleteTheorem($id){
        $theorem = Theorem::findOrFail($id);
        $theorem->delete();
    }
}