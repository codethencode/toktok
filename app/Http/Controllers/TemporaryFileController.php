<?php

namespace App\Http\Controllers;

use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class TemporaryFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->isMethod('delete')) {
            $filepond = $request->json()->all();
            $folder = $filepond['folder'];
            $tempFile = TemporaryFile::query()->where('folder', $folder)->first();
            $path = storage_path('public/temp/' . $folder);
            if (is_dir($path) && $tempFile) {
                DB::beginTransaction();

                try {
                    unlink($path . '/' . $tempFile->filename);
                    rmdir($path);
                    $tempFile->delete();
                    DB::commit();

                    return response()->json(['message' => 'success']);
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Error deleting directory: ' . $e->getMessage());
                    return response()->json(['message' => 'failed'], 500);
                }
            }
            return response()->json(['message' => 'failed'], 500);
        }
        if ($request->hasFile('filepond')) {
            $files  = $request->file('filepond');
            foreach ($files as $key => $file) {
                $filename = $file->getClientOriginalName();
                $folder = uniqid() . '-' . time();
                $file->storeAs('public/temp/' . $folder, $filename);

                try {
                    $temporaryFile = TemporaryFile::query()->create([
                        'folder' => $folder,
                        'filename' => $filename,
                    ]);
                    dd($temporaryFile); // Affichez l'objet créé pour vérifier que tout fonctionne
                } catch (\Exception $e) {
                    dd($e->getMessage()); // Affichez l'erreur s'il y en a une
                }

                TemporaryFile::query()->create(['folder' => $folder, 'filename' => $filename]);
                // Arr::add($folders, $key, $folder);
                return response()->json(['folder' => $folder], 200);
            }
        }
    }



//AJAX

    public function handleGetRequest(Request $request)
    {
        // Traitez ici la requête GET, par exemple en retournant des métadonnées de fichiers
        return response()->json([
            'status' => 'success',
            'data' => 'Metadata or file data'
        ]);
    }


    public function indexAjax($directory)
    {
        $files = Storage::disk('public')->files($directory);
        return view('partials.file-list', compact('files'))->render();
    }

    // Méthode pour supprimer un fichier
    public function destroyAjax(Request $request)
    {
        $filePath = $request->input('path');
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            return response()->json(['status' => 'success', 'message' => 'Fichier supprimé avec succès']);
        }
        return response()->json(['status' => 'error', 'message' => 'Fichier non trouvé']);
    }



    public function listFiles(Request $request) {
        // Lister tous les fichiers dans le répertoire

        $files = Storage::disk('public')->files($request->input('directory'));
        $orderId = $request->input('directory');
        // Inclure les sous-répertoires
        // $files = Storage::disk('local')->allFiles($directory);

        return view('account.pond007', compact('files', 'orderId'));
    }

public function upload(Request $request)
{
    Log::info('initUpload');

    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $filename = strtolower(trim(preg_replace('/[^A-Za-z0-9-]/', '-', $file->getClientOriginalName())));
        $path = $file->storeAs('public/', $filename); // Stocke le fichier dans storage/app/public/uploads

        Log::info($path);

        return response()->json(['path' => $path], 200);
    }

    return response()->json(['message' => 'No file uploaded'], 400);
}

public function uploadv2(Request $request, $directory)
{
    Log::info('Upload request received.'.$directory);

    // Valider le fichier
    $request->validate([
        'filepond' => 'required|image|mimes:jpeg,png,jpg|max:102400',
    ]);

    // Stocker le fichier
    if ($request->file('filepond')) {

        Log::info('File stored at: ');

        $file = $request->file('filepond');
        // Obtenez le nom original du fichier
        $originalName = $file->getClientOriginalName();

        // Transformez le nom du fichier
        $sanitizedFileName = $this->sanitizeFileName($originalName);

        Log::info('File stored at: ' . $originalName);
        // Définissez le chemin où vous voulez enregistrer le fichier
       // $path = $file->storeAs('public/uploads', $originalName);

        // Obtenez le nom original du fichier
        $originalName = $file->getClientOriginalName();

        // Transformez le nom du fichier
        $sanitizedFileName = $this->sanitizeFileName($originalName);

        //$filename = strtolower(trim(preg_replace('/[^A-Za-z0-9-]/', '-', $file->getClientOriginalName())));
        $path = $file->storeAs($directory.'/', $sanitizedFileName, 'public');

        //$path = $request->file('filepond')->store($directory, 'public');
        Log::info('File stored at: ' . $path);

        //return $path;
        return response()->json(['path' => $path, 'status' => 'success'], 200);
    }

    Log::error('File upload failed.');
    return response()->json(['status' => 'error'], 400);
}


    public function revert(Request $request)
    {
        // Décodage de la chaîne JSON en tableau associatif
        $data = json_decode($request->getContent(), true);

        // Vérifiez si le décodage a réussi et si le champ 'path' existe
        if (isset($data['path'])) {
            // Récupération du chemin
            $path = $data['path'];
            Storage::disk('public')->delete($path);
            Log::info('Reverted path: ' .$path);
        } else {
            Log::info('Erreur Reverted path');
        }
           Storage::disk('public')->delete($request->getContent());
          //  $path = 'public' . $request->getContent();
          //  Storage::delete($path);
           Log::info('Reverted path: ' . $request->getContent());
    }


    public function handle(Request $request)
    {

        $folder = json_decode($request->getContent());
        //. ['data' => json_encode($request->all())]
       Log::info($folder);

        $action = $request->input('action');
        $filename = $request->input('filename');

        Log::info('action: ' . $action);

        switch ($action) {
            case 'delete':
                Log::info('Delete request received.');
                return $this->delete($filename);
            default:
                return response()->json(['status' => 'error', 'message' => 'Invalid action'], Response::HTTP_BAD_REQUEST);
        }
    }

    private function delete($filename)
    {
        try {
            $path = 'public/uploads/' . $filename;

            if (Storage::exists($path)) {
                Storage::delete($path);
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'File not found'], Response::HTTP_NOT_FOUND);
            }
        } catch (\Exception $e) {
            // Log the exception message
            \Log::error('File deletion error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'An error occurred'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


private function sanitizeFileName($filename)
{
    // Mettre en minuscules
    $filename = strtolower($filename);

    // Remplacer les accents par leurs équivalents non accentués
    $filename = $this->removeAccents($filename);

    // Remplacer les apostrophes et les underscores par des tirets
    $filename = str_replace(['\'', '_'], '-', $filename);

    // Remplacer tous les caractères non-alphanumériques (hors points pour l'extension) par des tirets
    $filename = preg_replace('/[^a-z0-9\.]+/', '-', $filename);

    // Supprimer les tirets multiples et les tirets au début ou à la fin du nom
    $filename = trim(preg_replace('/-+/', '-', $filename), '-');

    return $filename;
}

    private function removeAccents($string)
    {
        return strtr($string, [
            'à' => 'a', 'â' => 'a', 'ä' => 'a',
            'ç' => 'c',
            'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
            'î' => 'i', 'ï' => 'i',
            'ô' => 'o', 'ö' => 'o',
            'ù' => 'u', 'û' => 'u', 'ü' => 'u',
            'ÿ' => 'y',
            'À' => 'a', 'Â' => 'a', 'Ä' => 'a',
            'Ç' => 'c',
            'É' => 'e', 'È' => 'e', 'Ê' => 'e', 'Ë' => 'e',
            'Î' => 'i', 'Ï' => 'i',
            'Ô' => 'o', 'Ö' => 'o',
            'Ù' => 'u', 'Û' => 'u', 'Ü' => 'u',
            'Ÿ' => 'y',
        ]);
    }



}
