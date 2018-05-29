<?php

namespace App\Repositories;

use App\File;

class FileRepo extends BaseRepo
{

    protected $controlCheckInstanceRepo;

    public function __construct(ControlCheckInstanceRepo $controlCheckInstanceRepo)
    {
        $this->controlCheckInstanceRepo=$controlCheckInstanceRepo;
    }

    public function getModel()
    {
        return new File;
    }

    public function csvToArray($filename = '', $delimiter = ';')
    {
        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }

    public function importGradesFromCsv($url,$control_check_id) {
        try{
            $gradesArr = $this->csvToArray($url);

            foreach($gradesArr as $index => $row)
            {
                $controlCheckInstance = $this->controlCheckInstanceRepo
                    ->getControlCheckInstanceForStudent($control_check_id,$row['id_number']);
                $controlCheckInstance->setCalification($row['qualification']);
                $this->controlCheckInstanceRepo->updateWithoutData($controlCheckInstance);
            }
            return 'true';
        } catch(\Exception $e) {
            return 'false';
        }
    }

}