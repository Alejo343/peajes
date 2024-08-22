<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;
use Exception;
use Symfony\Component\HttpFoundation\StreamedResponse;



class DocumentController extends Controller
{
    public function upload(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'option-toll' => 'required|string',
    //         'consecutive' => 'required|numeric',
    //         'date' => 'required|date',
    //         'time' => 'required|date_format:H:i',
    //     ]);

    //     // Convertir la fecha a formato legible para el documento
    //     $validatedData['date'] = date('d/m/Y', strtotime($validatedData['date']));

    //     // Definir la ruta del archivo en la carpeta 'storage/app/public/docs'
    //     $filePath = 'public/docs/' . $validatedData['option-toll'] . '.docx';

    //     // Crear una instancia de TemplateProcessor con la ruta del archivo
    //     $newToll = new TemplateProcessor(Storage::path($filePath));

    //     //Reemplazar los valores de la plantilla
    //     $newToll->setValues(
    //         array('code' => $validatedData['consecutive'], 'date' => $validatedData['date'], 'time' => $validatedData['time'])
    //     );

    //     // // Definir la ruta del archivo de salida
    //     $outputFilePath = 'output/new' . $validatedData['option-toll'] . time() . '.docx';

    //     //Guardar el archivo procesado
    //     $newToll->saveAs(Storage::path($outputFilePath));

    //     Document::convertToPdf($outputFilePath);

    //     //Devolver el archivo generado como descarga al usuario
    //     return response()->download(Storage::path($outputFilePath))->deleteFileAfterSend(true);
    // }
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

        // Reemplazar los valores de la plantilla
        $newToll->setValues([
            'code' => $validatedData['consecutive'],
            'date' => $validatedData['date'],
            'time' => $validatedData['time']
        ]);

        // Definir la ruta del archivo temporal
        $tempFilePath = Storage::path('temp/new' . $validatedData['option-toll'] . time() . '.docx');

        // Guardar el archivo procesado temporalmente
        $newToll->saveAs($tempFilePath);

        // Leer el contenido del archivo temporal
        $docxContent = file_get_contents($tempFilePath);

        // Convertir el contenido del archivo a base64
        $docxBase64 = base64_encode($docxContent);

        // Guardar el string base64 en la base de datos
        Document::create([
            'base64' => $docxBase64,
            // Otros campos que necesites guardar
        ]);

        // Eliminar el archivo temporal si ya no lo necesitas
        unlink($tempFilePath);

        // Devolver la respuesta al usuario
        return response()->json(['message' => 'Documento guardado exitosamente en la base de datos.']);
    }

    public function downloadLastDocument()
    {
        // Obtener el último documento guardado en la base de datos
        $lastDocument = Document::latest()->first();

        if (!$lastDocument) {
            return response()->json(['message' => 'No se encontró ningún documento.'], 404);
        }

        // Convertir el base64 de nuevo a contenido binario
        $docxContent = base64_decode($lastDocument->file_base64);

        // Definir la ruta del archivo temporal donde se guardará el DOCX
        $tempFilePath = storage_path('app/temp/' . $lastDocument->name . '.docx');

        // Guardar el contenido en un archivo DOCX temporal
        file_put_contents($tempFilePath, $docxContent);

        // Enviar el archivo como una descarga al usuario
        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }
}
