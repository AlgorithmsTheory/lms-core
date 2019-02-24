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


class DefinitionDAO {
    public function allDefinition(){
        $definitions = Definition::all();
        foreach ($definitions as $definition) {
            $definition->getLinkToLectureAttribute();
        }
        return  $definitions;
    }

    public function getDefinition($index){
        return Definition::where('id',$index)->first();
    }

    public function storeDefinition(AddDefinitionRequest $request){
        $definition = new Definition();

        $definition->name = $request->definition_name;
        $definition->content = $request->definition_content;
        if ($request->id_lecture != null && $request->name_anchor!=null) {
            $definition->id_lecture = $request->id_lecture;
            $definition->name_anchor = $request->name_anchor;
        }
        $definition->save();
    }

    public function updateDefinition(UpdateDefinitionRequest $request, $id){
        $definition = Definition::findOrFail($id);
        $definition->name = $request->definition_name;
        $definition->content = $request->definition_content;
        if ($request->id_lecture == null || $request->name_anchor == null) {
            $definition->id_lecture = null;
            $definition->name_anchor = null;
        } else {
            $definition->id_lecture = $request->id_lecture;
            $definition->name_anchor = $request->name_anchor;
        }
        $definition->save();
    }

    public function deleteDefinition($id){
        $definition = Definition::findOrFail($id);
        $definition->delete();
    }
}