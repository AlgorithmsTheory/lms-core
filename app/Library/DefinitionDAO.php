<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 22.01.2019
 * Time: 16:28
 */

namespace App\Library;


use App\Http\Requests\AddDefinitionRequest;
use App\Http\Requests\UpdateDefinitionRequest;

use App\Definition;


class DefinitionDAO
{
    public function allDefinition(){
        $Definitions = Definition::all();
        foreach ($Definitions as $Definition) {
            $Definition->getLinkToLectureAttribute();
        }
        return  $Definitions;
    }

    public function getDefinition($index){
        return Definition::where('id',$index)->first();
    }

    public function store_Definition(AddDefinitionRequest $request){
        $definition = new Definition();

        $definition->name = $request->definition_name;
        $definition->content = $request->definition_content;
        if ($request->id_lecture != null && $request->name_anchor!=null) {
            $definition->idLecture = $request->id_lecture;
            $definition->nameAnchor = $request->name_anchor;
        }
        $definition->save();
    }

    public function updateDefinition(UpdateDefinitionRequest $request, $id){
        $definition = Definition::findOrFail($id);
        $definition->name = $request->definition_name;
        $definition->content = $request->definition_content;
        if ($request->id_lecture == null || $request->name_anchor == null) {
            $definition->idLecture = null;
            $definition->nameAnchor = null;
        } else {
            $definition->idLecture = $request->id_lecture;
            $definition->nameAnchor = $request->name_anchor;
        }
        $definition->save();
    }

    public function deleteDefinition($id){
        $definition = Definition::findOrFail($id);
        $definition->delete();
    }
}