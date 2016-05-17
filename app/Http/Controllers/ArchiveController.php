<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 16.05.16
 * Time: 16:23
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class ArchiveController extends Controller {
    const ARCHIVE_PATH = 'archive/';

    public function index(){
        $folders = scandir($this::ARCHIVE_PATH, SCANDIR_SORT_DESCENDING);
        array_pop($folders);
        array_pop($folders);
        $files = [];

        for ($i = 0; $i < count($folders); $i++){
            if (is_file($this::ARCHIVE_PATH.$folders[$i])){
                for ($j = $i; $j < count($folders)-1; $j++){
                    $buffer = $folders[$j+1];
                    $folders[$j+1] = $folders[$j];
                    $folders[$j] = $buffer;
                }
                $i--;
                array_push($files, $folders[count($folders)-1]);
                array_pop($folders);
            }
        }

        $path = $this::ARCHIVE_PATH;
        $nodes[0] = $this::ARCHIVE_PATH;
        return view ('archive.index', compact('folders', 'files', 'path', 'nodes'));
    }

    public function folder($folder_name, Request $request){
        $path = $request->input('path').$folder_name.'/';
        $folders = scandir($path, SCANDIR_SORT_DESCENDING);
        array_pop($folders);
        array_pop($folders);
        $files = [];

        for ($i = 0; $i < count($folders); $i++){
            if (is_file($path.$folders[$i])){
                for ($j = $i; $j < count($folders)-1; $j++){
                    $buffer = $folders[$j+1];
                    $folders[$j+1] = $folders[$j];
                    $folders[$j] = $buffer;
                }
                $i--;
                array_push($files, $folders[count($folders)-1]);
                array_pop($folders);
            }
        }

        $nodes = explode('/', $path);
        $prev_folder = $nodes[count($nodes)-3];
        $prev_path = '';
        for ($i = 0; $i < count($nodes) - 3; $i++){
            $prev_path .= $nodes[$i].'/';
        }
        return view ('archive.index', compact('folders', 'files', 'path', 'nodes', 'prev_path', 'prev_folder'));
    }

    public function download(Request $request){
        $nodes = explode('/', $request->input('file-path'));
        $filename = $nodes[count($nodes) - 1];
        header("HTTP/1.1 200 OK");
        header("Connection: close");
        header("Content-Transfer-Encoding: binary");
        header("Content-Type: application/zip");
        header("Content-Length: ".filesize($request->input('file-path')));
        header("Content-Disposition: attachment; filename=".$filename);
        readfile($request->input('file-path'));
    }

    public function delete(Request $request){
        unlink($request->input('file_path'));
        return;
    }
} 