<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 29.04.16
 * Time: 19:56
 */

namespace App\Testing;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\StructuralRecord whereTheme_code($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\StructuralRecord  whereSection_code($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\StructuralRecord  whereType_code($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\StructuralRecord  whereId_test($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\StructuralRecord  whereId_structure($value)
 *
 * @method static \Illuminate\Database\Eloquent|\App\Testing\StructuralRecord  get()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\StructuralRecord  distinct()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\StructuralRecord  where()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\StructuralRecord  select()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\StructuralRecord  first()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\StructuralRecord  insert($array)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\StructuralRecord  delete()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\StructuralRecord  table($array)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\StructuralRecord  max($array)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\StructuralRecord  toSql()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\StructuralRecord  count()
 *
 */

class StructuralRecord extends Eloquent{
    protected $table = 'structural_records';
    public $timestamps = false;
    protected $fillable = [];

    public static function add($id_structure, $request_section, $request_theme, $request_type){
        $id_test = TestStructure::whereId_structure($id_structure)->select('id_test')->first()->id_test;
        $sections = Section::select('section_code')->where('section_code', '>', 0)->get();
        $themes = Theme::select('theme_code')->where('theme_code', '>', 0)->get();
        $types = Type::select('type_code')->get();

        if ($request_section == 'Любой'){
            if ($request_type == 'Любой'){                                                                              // любой раздел, любая тема, любой тип (AAA)
                foreach ($sections as $section){
                    foreach ($themes as $theme){
                        if (Theme::belongsToSection($section['section_code'], $theme['theme_code'])){
                            foreach ($types as $type){
                                StructuralRecord::insert(array('theme_code' => $theme['theme_code'],
                                                'section_code' => $section['section_code'], 'type_code' => $type['type_code'],
                                                'id_test' => $id_test, 'id_structure' => $id_structure));
                            }
                        }
                    }
                }
            }
            else {                                                                                                      // любой раздел, любая тема (AA1)
                foreach ($sections as $section){
                    foreach ($themes as $theme){
                        if (Theme::belongsToSection($section['section_code'], $theme['theme_code'])){
                            StructuralRecord::insert(array('theme_code' => $theme['theme_code'],
                                'section_code' => $section['section_code'], 'type_code' => $request_type,
                                'id_test' => $id_test, 'id_structure' => $id_structure));
                        }
                    }
                }
            }
        }
        else {
            if ($request_theme == 'Любая'){
                if ($request_type == 'Любой'){                                                                          // любая тема, любой тип (1AA)
                    foreach ($themes as $theme){
                        if (Theme::belongsToSection($request_section, $theme['theme_code'])){
                            foreach ($types as $type){
                                StructuralRecord::insert(array('theme_code' => $theme['theme_code'],
                                    'section_code' => $request_section, 'type_code' => $type['type_code'],
                                    'id_test' => $id_test, 'id_structure' => $id_structure));
                            }
                        }
                    }
                }
                else {                                                                                                  // любая тема (1A1)
                    foreach ($themes as $theme){
                        if (Theme::belongsToSection($request_section, $theme['theme_code'])){
                            StructuralRecord::insert(array('theme_code' => $theme['theme_code'],
                                'section_code' => $request_section, 'type_code' => $request_type,
                                'id_test' => $id_test, 'id_structure' => $id_structure));
                        }
                    }
                }
            }
            else {
                if ($request_type == 'Любой'){                                                                          // любой тип (11A)
                    foreach ($types as $type){
                        StructuralRecord::insert(array('theme_code' => $request_theme,
                            'section_code' => $request_section, 'type_code' => $type['type_code'],
                            'id_test' => $id_test, 'id_structure' => $id_structure));
                    }
                }
                else {                                                                                                  // (111)
                    StructuralRecord::insert(array('theme_code' => $request_theme,
                        'section_code' => $request_section, 'type_code' => $request_type,
                        'id_test' => $id_test, 'id_structure' => $id_structure));
                }
            }
        }
    }
} 