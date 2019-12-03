<?php

namespace App\Modules\Csv;

class Processor
{
    /**
     * Domestic data
     *
     * @var array
     */
    protected $domestic = [];

    /**
     * Foreign data
     *
     * @var array
     */
    protected $foreign = [];

    /**
     * The column to identify the row with.
     *
     * @var string
     */
    protected $identifier = '';

    /**
     * The columns to to compare against rows
     *
     * @var string
     */
    protected $matcher = '';

    /**
     * Processor class
     *
     * @param array $domestic
     * @param array $foreign
     * @param string $identifier
     * @param string $matcher
     */
    public function __construct(array $domestic, array $foreign, string $identifier, string $matcher)
    {
        $this->domestic = $domestic;
        $this->foreign = $foreign;
        $this->identifier = $identifier;
        $this->matcher = $matcher;
    }

    public function handle()
    {
        // Prepare containers to transport compared record
        $domestic = [];
        $foreign = [];

        $records = $this->domestic['records'];

        // We wont be using foreach to enable us know the current index of our loop
        for($i=0; $i<=(count($records)-1); $i++) {
            // Get the first record from the domestic file.
            $domestic_record = $records[$i];

            // Now lets find a record that matches its identifier.
            $foreign_record  = $this->foreign['records']
                ->where($this->identifier, $domestic_record->{$this->identifier})
                ->first();


            // Lets make sure we found something before proceeding.
            if (empty($foreign_record)) {
                // If it is indeed empty then we have to notify the user
                // by giving our result a twitter bootstrap class of danger.
                $domestic_record->meta_data = [
                    'type' => 'absent',
                    'classes' => 'table-danger'
                ];

                $domestic[] = $domestic_record;
                $foreign[] = $foreign_record;

                continue;
            }

            // If we have a record.
            // And the columns we wish to compare does not match.
            // We will assign the classes a twitter bootstrap background warning class
            // and a type attribute of "unmatched"
            if ($domestic_record->{$this->matcher} !== $foreign_record->{$this->matcher}) {

                $domestic_record->meta_data = [
                    'type' => 'unmatched',
                    'matching_row' => [
                        'header' => $this->foreign['header'],
                        'records' => $foreign_record->toArray()
                    ],
                    'classes' => 'table-warning'
                ];

                $foreign_record->meta_data = [
                    'type' => 'unmatched',
                    'matching_row'  => [
                        'header'    => $this->domestic['header'],
                        'records'   => $domestic_record->toArray()
                    ],
                    'classes' => 'table-warning'
                ];
                // dump($domestic_record);

                $domestic[] = $domestic_record;
                $foreign[] = $foreign_record;

                continue;
                
            } elseif ($domestic_record->{$this->matcher} === $foreign_record->{$this->matcher}) {

                $domestic_record->meta_data = [
                    'type' => 'matched',
                    'matching_row' => [
                        'header' => $this->foreign['header'],
                        'records' => $foreign_record->toArray()
                    ],
                    'classes' => ''
                ];

                $foreign_record->meta_data = [
                    'type' => 'matched',
                    'matching_row' => [
                        'header' => $this->domestic['header'],
                        'records' => $domestic_record->toArray()
                    ],
                    'classes' => ''
                ];

                $domestic[] = $domestic_record;
                $foreign[] = $foreign_record;
            }
        }

        // Merge the old data.
        // This would return any row that had no matching pair.
        $this->domestic['records']->merge($domestic);
        $this->foreign['records']->merge($foreign);

        return $this;
    }

    public function getResult()
    {
        return [
            'domestic' => $this->domestic,
            'foreign' => $this->foreign
        ];
    }
}