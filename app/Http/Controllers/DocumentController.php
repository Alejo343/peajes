<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;
use Exception;
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

        // Definir la ruta del archivo en la carpeta 'storage/app/public/docs'
        $filePath = 'public/docs/' . $validatedData['option-toll'] . '.docx';

        // Crear una instancia de TemplateProcessor con la ruta del archivo
        $newToll = new TemplateProcessor(Storage::path($filePath));

        //Reemplazar los valores de la plantilla
        $newToll->setValues(
            array('code' => $validatedData['consecutive'], 'date' => $validatedData['date'], 'time' => $validatedData['time'])
        );

        // // Definir la ruta del archivo de salida
        $outputFilePath = 'output/new' . $validatedData['option-toll'] . time() . '.docx';

        //Guardar el archivo procesado
        $newToll->saveAs(Storage::path($outputFilePath));

        //Devolver el archivo generado como descarga al usuario
        return response()->download(Storage::path($outputFilePath))->deleteFileAfterSend(true);
    }
}
