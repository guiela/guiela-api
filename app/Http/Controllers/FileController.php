<?php

namespace App\Http\Controllers;

use App\Modules\Csv\File;
use App\Modules\Csv\Processor;
use App\Http\Requests\FileRequest;
use App\Http\Requests\ProcessRequest;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  App\Http\Requests\FileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function convert(FileRequest $request)
    {
        try {
            $response = $this->extractFile($request, 'file', $request->delimiter ?? ';');

        } catch (\Exception $exception) {
            $response = [
                'message' => $exception->getMessage()
            ];
        }

        return response()->json($response);
    }

    /**
     * Handle the incoming request.
     *
     * @param ProcessRequest $request
     * @return void
     */
    public function process(ProcessRequest $request)
    {
        try {
            $domestic = $this->extractFile($request, 'domestic', $request->delimiter['domestic'] ?? ';');
            $foreign = $this->extractFile($request, 'foreign', $request->delimiter['foreign'] ?? ';');

            $processor = new Processor($domestic, $foreign, strtolower($request->input('identifier')), strtolower($request->input('matcher')));

            $response = $processor->handle()->getResult();
        } catch (\Exception $exception) {
            $response = [
                'message' => $exception->getMessage()
            ];
        }

        return response()->json($response);
    }

    /**
     * Extract file from request.
     *
     * @param [type] $request
     * @param string $attribute
     * @return array
     */
    protected function extractFile($request, string $attribute, string $delimiter)
    {
        $filename = $request->file($attribute)->getClientOriginalName(); 
        $path = Storage::disk('custom')->putFileAs('/csv', $request->file($attribute), $filename);

        return (new File(public_path('uploads/' . $path), $delimiter))->getRecords();
    }
}