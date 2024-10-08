<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use IntlDateFormatter;
use App\Models\Values;
use App\Models\Consecutive;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;
use Exception;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpFoundation\StreamedResponse;


class DocumentController extends Controller
{
    /**
     * Displays the welcome page with the list of tolls or redirects to the login page if the user is not authenticated.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (Auth::guest()) {
            $consecutives = Consecutive::all();
            return view('welcome', compact('consecutives'));
        }

        $values = Values::orderBy('id')->get();
        $consecutives = Consecutive::all();

        return view('welcome', compact('values', 'consecutives'));
    }

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

        // Definir los valores para el documento
        $values = array(
            'code' => $validatedData['consecutive'],
            'time' => $validatedData['time']
        );

        if ($validatedData['option-toll'] == 'Betania_Tulua_Buga' || $validatedData['option-toll'] == 'Betania_Buga_Tulua') {
            if ($validatedData['option-toll'] == 'Betania_Tulua_Buga') {
                $values['direction'] = 'TULUA-BUGA';
                // dd('tulua buga');
            }
            if ($validatedData['option-toll'] == 'Betania_Buga_Tulua') {
                $values['direction'] = 'BUGA-TULUA';
                // dd('buga tulua');
            }

            // Crear una instancia de Carbon desde la fecha en formato 'd/m/Y'
            $date = Carbon::createFromFormat('d/m/Y', $validatedData['date']);

            // Crear un formateador para mostrar el mes en español
            $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::FULL, IntlDateFormatter::NONE, null, null, 'MMM');

            // Extraer el mes en abreviatura trilítera, el día y el año
            // $values['dateM'] = strtoupper($date->format('M'));
            $values['dateM'] = strtoupper($formatter->format($date));
            $values['dateD'] = $date->format('d');
            $values['dateY'] = $date->format('Y');

            // Corregir nombre para la busqueda del word
            $validatedData['option-toll'] = 'Betania';
        } else {
            $values['date'] = $validatedData['date'];
        }


        // Busca y asigna el valor del peaje en la base de datos
        $value = Values::where('name', $validatedData['option-toll'])->first();
        $values['value'] = $value->value;

        // define el nombre del nuevo archivo
        $fileName = $validatedData['option-toll']  . '-' . $validatedData['consecutive'] . '.docx';

        // encontrar el archivo de plantilla correspondiente al tipo de peaje
        $filePath = 'public/docs/' . $validatedData['option-toll'] . '.docx';

        // Crear una instancia de TemplateProcessor con la ruta del archivo
        $newToll = new TemplateProcessor(Storage::path($filePath));

        // Asignar los valores a $newToll
        $newToll->setValues($values);

        // Para trabajr local{
        $outputFilePath = 'output/' . $fileName;
        $newToll->saveAs(Storage::path($outputFilePath));
        $uploadedFile = fopen(Storage::path($outputFilePath), 'r');
        // }

        // // para trabajar en deployment{
        // $outputFilePath = '/tmp/' . $fileName;
        // $newToll->saveAs($outputFilePath);
        // $uploadedFile = fopen($outputFilePath, 'r');
        // // }

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

        // Eliminamos el archivo temporalmente almacenado
        unlink(Storage::path($outputFilePath));

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

        // return redirect('/')->with('success', 'Peajes actualizados con éxito');
        return redirect('/')->with('message', [
            'type' => 'success',
            'text' => 'Peajes actualizados con éxito'
        ]);
    }

    public function saveConsecutive(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'name' => 'required|string',
            'consecutive' => 'required|numeric',
        ]);

        //Cambia la clave consecutive por code
        $validatedData['code'] = $validatedData['consecutive'];
        unset($validatedData['consecutive']);

        try {
            Consecutive::create($validatedData);
        } catch (Exception $e) {
            return redirect('/')->with('message', [
                'type' => 'error',
                'text' => 'Error al guardar elsecutivo: ' . $e->getMessage()
            ]);
        }

        return redirect('/')->with('message', [
            'type' => 'success',
            'text' => 'Consecutivo guardado'
        ]);
    }

    //show all consecutives
    public function showConsecutives()
    {
        $consecutives = Consecutive::all();
        return view('consecutives', compact('consecutives'));
    }

    //delte consecutive
    public function destroyConsecutive($id)
    {
        $consecutive = Consecutive::find($id);
        if ($consecutive) {
            $consecutive->delete();
            return redirect('/');
        }
        return redirect('/')->with('message', [
            'type' => 'error',
            'text' => 'Error al eliminar, intenta de nuevo'
        ]);
    }

    //TODO: Metodo para guardar la distacncia entre cada trayecto
}
