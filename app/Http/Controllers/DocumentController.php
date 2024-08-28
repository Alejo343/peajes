<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Values;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;
use Exception;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpFoundation\StreamedResponse;


class DocumentController extends Controller
{
    public function showWelcome()
    {
        // Obtener los 3 registros de la tabla 'values'
        $values = Values::all();

        // Pasar los registros a la vista welcome
        return view('welcome', compact('values'));
    }
    public function upload(Request $request)
    {
        $validatedData = $request->validate([
            'option-toll' => 'required|string',
            'consecutive' => 'required|numeric',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        $value = Values::where('name', $validatedData['option-toll'])->first();

        // Convertir la fecha a formato legible para el documento
        $validatedData['date'] = date('d/m/Y', strtotime($validatedData['date']));

        // define el nombre del nuevo archivo
        $fileName = $validatedData['consecutive'] . '.docx';

        // encontrar el archivo de plantilla correspondiente al tipo de peaje
        $filePath = 'public/docs/' . $validatedData['option-toll'] . '.docx';

        // Crear una instancia de TemplateProcessor con la ruta del archivo
        $newToll = new TemplateProcessor(Storage::path($filePath));

        //Reemplazar los valores de la plantilla
        $newToll->setValues(
            array(
                'code' => $validatedData['consecutive'],
                'date' => $validatedData['date'],
                'time' => $validatedData['time'],
                'value' => $value['value'],
            )
        );

        // Definir la ruta del archivo de salida
        $outputFilePath = 'output/' . $fileName;

        // Guardar el archivo procesado
        $newToll->saveAs(Storage::path($outputFilePath));

        // Leer el archivo procesado
        $uploadedFile = fopen(Storage::path($outputFilePath), 'r');


        // $outputFilePath = '/tmp/' . $fileName;
        // $newToll->saveAs($outputFilePath);
        // $uploadedFile = fopen($outputFilePath, 'r');

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
            return response()->json(['message' => 'Error al subir el archivo.', 'error' => $e->getMessage()], 500);
        }

        unlink(Storage::path($outputFilePath));

        // Obtener la URL para descargar el documento
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
            return response()->json('El documento no existe.', 404);
        }

        return $doc;
    }

    public function updateAll(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'fields.*' => 'required|string|max:255',
        ]);

        // Iterar sobre los valores recibidos y actualizar cada registro
        foreach ($request->values as $id => $fieldValue) {
            $value = Values::findOrFail($id);
            $value->value = $fieldValue;  // Actualiza el campo 'value'
            $value->save();
        }

        // Redirigir o devolver una respuesta
        return redirect()->route('welcome')->with('success', 'Registros actualizados con éxito');
    }
}
