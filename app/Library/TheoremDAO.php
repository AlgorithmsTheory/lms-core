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

class TheoremDAO {

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

    public function storeTheorem(AddTheoremRequest $request){
        $theorem = new Theorem();
        $theorem->name = $request->theorem_name;
        $theorem->content = $request->theorem_content;
        $theorem->exam = $request->exam;
        $theorem->doc = $request->doc;
        if ($request->id_lecture != null && $request->name_anchor!=null) {
            $theorem->id_lecture = $request->id_lecture;
            $theorem->name_anchor = $request->name_anchor;
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
            $theorem->id_lecture = null;
            $theorem->name_anchor = null;
        } else {
            $theorem->id_lecture = $request->id_lecture;
            $theorem->name_anchor = $request->name_anchor;
        }
        $theorem->save();
    }

    public function deleteTheorem($id){
        $theorem = Theorem::findOrFail($id);
        $theorem->delete();
    }
}