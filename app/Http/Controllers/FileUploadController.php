<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
public function index($orderId)
{
$path = storage_path("app/public/{$orderId}");
$files = is_dir($path) ? array_diff(scandir($path), ['.', '..']) : [];

// Pass the files to the view
return view('files.index', [
'orderId' => $orderId,
'files' => $files
]);
}

public function list($orderId)
{
$path = storage_path("app/public/{$orderId}");
$files = is_dir($path) ? array_diff(scandir($path), ['.', '..']) : [];

return response()->json([
'files' => array_values($files) // Send only the file names
]);
}

public function upload(Request $request, $orderId)
{
$files = $request->file('filepond');

if (!is_array($files)) {
$files = [$files];
}

foreach ($files as $file) {
$filename = strtolower(trim(preg_replace('/[^A-Za-z0-9-]/', '-', $file->getClientOriginalName())));
$file->storeAs("public/{$orderId}", $filename);
}

return response()->json(['success' => true]);
}

public function delete(Request $request)
{
$filename = $request->input('file');
$orderId = $request->input('orderId');
$filePath = storage_path("app/public/{$orderId}/{$filename}");

if (file_exists($filePath)) {
unlink($filePath);
}

return response()->json(['success' => true]);
}
}
