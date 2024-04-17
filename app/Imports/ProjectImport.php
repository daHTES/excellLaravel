<?php

namespace App\Imports;

use App\Factory\ProjectFactory;
use App\Models\FailedRow;
use App\Models\Project;
use App\Models\Type;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use function Carbon\this;

class ProjectImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $typesMap = $this->getTypesMap(Type::all());


        foreach ($collection as $row){


            $projectFactory = ProjectFactory::make($typesMap, $row);

            Project::create($projectFactory->getValues());

        }



                //if(!isset($row['Наименование'])) continue;

//                Project::create([
//                    'type_id' =>$this->getTypeId($typesMap, $row['0']),
//                    'title' => $row['1'],
//                    'created_at_time' => Date::excelToDateTimeObject((int)$row['2']),
//                    'deadline' => Date::excelToDateTimeObject((int)$row['7']),
//                    'contracted_at' => isset($row['9'])? Date::excelToDateTimeObject((int)$row['9']) : null,
//                    'is_chain' => isset($row['3']) ? $this->getBool($row['3']) : null,
//                    'is_on_time' => isset($row['8']) ? $this->getBool($row['8']) : null,
//                    'has_outsource' =>isset($row['5']) ? $this->getBool($row['5']) : null,
//                    'has_investors' =>isset($row['6']) ? $this->getBool($row['6']) : null,
//                    'worker_count' => isset($row['4']) ? $row['4'] : null,
//                    'service_count' => $row['10'],
//                    'payment_second_step' => $row['14'],
//                    'payment_third_step' => $row['15'],
//                    'payment_first_step' => $row['13'],
//                    'payment_fourth_step' => $row['16'],
//                    'comment' => $row['11'],
//                    'effective_value' => $row['12'],
//                ]);
    }

    private function getTypesMap($types): array {
        $map = [];
        foreach ($types as $type){
            $map[$type->title] = $type->id;
        }
        return $map;
    }

}
