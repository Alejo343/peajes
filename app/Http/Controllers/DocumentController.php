<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use Carbon\Carbon;
use App\Models\Values;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;
use Exception;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpFoundation\StreamedResponse;


class DocumentController extends Controller
{
    public function index()
    {
        if (Auth::guest()) {
            return view('welcome');
        } else {
            $values = Values::orderBy('id')->get();
            return view('welcome', compact('values'));
        }
    }

    /**
     * Sumar 845 al concecutivo 15 veces y enviarlo para una tabla
     *
     * @param  \Illuminate\Http\Request  $request The request object containing the consecutive number and date.
     * @return \Illuminate\Contracts\View\View Returns the 'welcome' view with the calculated data.
     * If the user is authenticated, it also includes the list of values.
     */
    public function addConsecutive(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'consecutive' => 'required|numeric',
            'date' => 'required|date'
        ]);

        $data = array();

        // Parse the date and initialize the consecutive number
        $date = Carbon::parse($validatedData['date']);
        $consecutive = $validatedData['consecutive'];

        // Add the initial date and consecutive number to the data array
        $data = [
            ['date' => $date->format('Y-m-d'), 'consecutive' => $consecutive],
        ];

        // Calculate the original length of the consecutive string once
        $length = strlen($consecutive);

        // Calculate the new date and consecutive number for the next 14 days
        for ($i = 1; $i < 15; $i++) {
            $newDate = $date->addDay();

            // Convert consecutive to integer and perform the sum
            $newConsecutive = (int)$consecutive + 845 * $i;

            // Convert back to string and maintain leading zeros with the original length
            $formattedConsecutive = str_pad($newConsecutive, $length, '0', STR_PAD_LEFT);

            // Add the new date and consecutive number to the data array
            $data[] = [
                'date' => $newDate->format('Y-m-d'),
                'consecutive' => $formattedConsecutive
            ];
        }

        // Check if the user is authenticated
        if (Auth::guest()) {
            // Return the 'welcome' view with the calculated data
            return view('welcome', ['data' => $data]);
        } else {
            // Fetch the list of values from the database
            $values = Values::orderBy('id')->get();

            // Return the 'welcome' view with the calculated data and the list of values
            return view('welcome', ['data' => $data, 'values' => $values]);
        }
    }

    public function upload(Request $request)
    {
        $validatedData = $request->validate([
            'option-toll' => 'required|string',
            'consecutive' => 'required|numeric',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        // Almacenar el valor original de la variable
        $originalOptionToll = $validatedData['option-toll'];

        // Modificar el valor solo para el caso específico
        if ($validatedData['option-toll'] == 'Betania_T-B') {
            $validatedData['option-toll'] = 'Betania';
        }

        // Buscar el valor del peaje en la base de datos
        $value = Values::where('name', $validatedData['option-toll'])->first();

        // Restaurar el valor original
        $validatedData['option-toll'] = $originalOptionToll;

        // Convertir la fecha a formato legible para el documento
        $validatedData['date'] = date('d/m/Y', strtotime($validatedData['date']));

        // define el nombre del nuevo archivo
        $fileName = $validatedData['option-toll'] . '.docx';

        // encontrar el archivo de plantilla correspondiente al tipo de peaje
        $filePath = 'public/docs/' . $validatedData['option-toll'] . '.docx';

        // Crear una instancia de TemplateProcessor con la ruta del archivo
        $newToll = new TemplateProcessor(Storage::path($filePath));

        // Reemplazar los valores de la plantilla
        $newToll->setValues(
            array(
                'code' => $validatedData['consecutive'],
                'date' => $validatedData['date'],
                'time' => $validatedData['time'],
                'value' => $value['value'],
            )
        );

        // $outputFilePath = 'output/' . $fileName;
        // $newToll->saveAs(Storage::path($outputFilePath));
        // $uploadedFile = fopen(Storage::path($outputFilePath), 'r');

        $outputFilePath = '/tmp/' . $fileName;
        $newToll->saveAs($outputFilePath);
        $uploadedFile = fopen($outputFilePath, 'r');

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

        // unlink(Storage::path($outputFilePath));

        // Obtener la URL para descargar el documento
        $url = $this->urlDownloadDocument($fileName);
        return redirect()->away($url);
    }

    /**
     * Genera una URL formada para descargar el documento de Firebase Storage.
     *
     * @param string $fileName Nombre del documento a descargar.
     *
     * @return string|Illuminate\Http\JsonResponse La URL firmada para descargar el documento.
     * If the document does not exist, it returns a JSON response with a 404 status code and an error message.
     */
    public function urlDownloadDocument($fileName)
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

    public function updateValue(Request $request)
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

        return redirect('/')->with('success', 'Peajes actualizados con éxito');
    }
}
