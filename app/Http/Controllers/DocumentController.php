<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;
use Exception;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpFoundation\StreamedResponse;


class DocumentController extends Controller
{
    public function upload(Request $request)
    {
        $validatedData = $request->validate([
            'option-toll' => 'required|string',
            'consecutive' => 'required|numeric',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        // Convertir la fecha a formato legible para el documento
        $validatedData['date'] = date('d/m/Y', strtotime($validatedData['date']));

        //define el nobre del archivo
        $fileName = $validatedData['consecutive'] . '.docx';

        // Definir la ruta del archivo en la carpeta 'storage/app/public/docs'
        $filePath = 'public/docs/' . $validatedData['option-toll'] . '.docx';

        // Crear una instancia de TemplateProcessor con la ruta del archivo
        $newToll = new TemplateProcessor(Storage::path($filePath));

        //Reemplazar los valores de la plantilla
        $newToll->setValues(
            array(
                'code' => $validatedData['consecutive'],
                'date' => $validatedData['date'],
                'time' => $validatedData['time']
            )
        );

        //Definir la ruta del archivo de salida
        $outputFilePath = 'output/' . $fileName;

        //Guardar el archivo procesado
        $newToll->saveAs(Storage::path($outputFilePath));

        $uploadedFile = fopen(Storage::path($outputFilePath), 'r');

        // Subimos el archivo a Firebase Storage
        try {
            $firebase = app('firebase.storage');
            $firebase->getBucket()->upload(
                $uploadedFile,
                [
                    'name' => 'Documents/' . $fileName
                ]
            );
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 'Error al subir el archivo.');
        }

        $url = $this->downloadLastDocument($fileName);
        return redirect()->away($url);
    }

    public function downloadLastDocument($fileName)
    {
        $expiresAt = new \DateTime('tomorrow');

        $firebase = app('firebase.storage');
        $docReference = $firebase->getBucket()->object('Documents/' . $fileName);

        if ($docReference->exists()) {
            $doc = $docReference->signedUrl($expiresAt);
        } else {
            return response()->json('Error al descargar el archivo.');
        }

        return $doc;
    }
}
