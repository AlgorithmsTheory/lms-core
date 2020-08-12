<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 19.03.2019
 * Time: 2:26
 */

namespace App\Statements\DAO;
use Illuminate\Http\Request;

interface ItemSectionDAO {
    public function get($id);
    public function store(Request $request);
    public function update(Request $request);
    public function delete(Request $request);
    public function getStoreValidate(Request $request);
    public function getUpdateValidate(Request $request);
}