<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ZipArchive;

class FileController extends Controller
{
    public function downloadAllFiles($folder)
    {
        $folder = urldecode($folder); // Très important pour retrouver "directory/12345"
    
        $folderPath = storage_path('app/public/' . $folder);
    
        if (!file_exists($folderPath) || !is_dir($folderPath)) {
            return response()->json(['error' => 'Dossier introuvable'], 404);
        }
    
        $zipFileName = basename($folder) . '.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName);
    
        $zip = new \ZipArchive;
        if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            $files = scandir($folderPath);
    
            foreach ($files as $file) {
                if ($file == '.' || $file == '..') continue;
    
                $filePath = $folderPath . '/' . $file;
                if (is_file($filePath)) {
                    $zip->addFile($filePath, $file);
                }
            }
    
            $zip->close();
        } else {
            return response()->json(['error' => 'Impossible de créer le fichier ZIP'], 500);
        }
    
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }
}
