<?php

namespace App\Modules\Csv;

use Ramsey\Uuid\Uuid;
use League\Csv\Reader;
use League\Csv\Statement;
use App\Modules\Csv\Record;
use App\Modules\Csv\ResultWrapper;

/**
 * File class.
 * 
 * @author Anitche Chisom <anitchec.dev@gmail.com>
 */
class File
{
    protected $file_path;

    protected $records;

    /**
     * File construct.
     *
     * @param string $file_path
     * @param string $delimiter
     */
    public function __construct(string $file_path, string $delimiter)
    {
        $this->file_path = $file_path;

        $this->extractDataFromFile($delimiter);
    }

    /**
     * Extract data from file path into an object
     *
     * @param string $delimiter
     * @return void
     */
    public function extractDataFromFile(string $delimiter = ';'): void
    {
        //load the CSV document from a stream
        $stream = fopen($this->file_path, 'r');
        $file = Reader::createFromStream($stream);
        $file->setDelimiter($delimiter);
        $file->setHeaderOffset(0);

        //build a statement
        $stmt = new Statement();

        //query your records from the document
        $records = $stmt->process($file);

        $this->records = $records;
    }

    /**
     * Create a collection from the from the records.
     * 
     * @return array
     */
    public function getRecords(): array
    {
        $data = [];

        // Get records
        $records = $this->records->getRecords();

        // Loop through
        foreach ($records as $row) {
            
            //  1.  Trim the values of the array keys and values to remove white spaces 
            //      which could cause a bug in our code when applying a where clause.
            $keys = array_map('trim', array_keys($row));
            $value = array_map('trim', $row);
            $stripResults = array_combine($keys, $value);
    
            //  2.  Making sure array keys are always lowercase regardless the 
            //      file format to have uniform format.
            $lowercaseResult = array_change_key_case(array_map('trim', $stripResults), CASE_LOWER);

            $merged = array_merge([
                'uuid' => Uuid::uuid4(),
                'data' => $lowercaseResult
            ], $lowercaseResult);

            // Wrap the data in an eloquent model.
            $data[] = new Record($merged);
        }

        $wrapper = new ResultWrapper;

        // Finally we wrap everything in a collection before returning the result.
        $collection = \collect($data);

        $wrapper->setHeader($this->records->getHeader())
                ->setRecords($collection);
         
        return $wrapper->getResult();
    }
}
