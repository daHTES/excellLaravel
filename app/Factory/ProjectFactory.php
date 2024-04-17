<?php

namespace App\Factory;


use App\Models\Type;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ProjectFactory{
    private $typeId;
    private $title;
    private $serviceCount;
    private $deadLine;
    private $contractedAt;
    private $comment;
    private $paymentFourthStep;
    private $workerCount;
    private $hasInvestors;
    private $effectiveValue;
    private $createdAtTime;
    private $paymentSecondStep;
    private $paymentThirdStep;
    private $isChain;
    private $isOnTime;
    private $hasOutsource;
    private $paymentFirstStep;

    /**
     * ProjectFactory constructor.
     * @param $typeId
     * @param $title
     * @param $serviceCount
     * @param $deadLine
     * @param $contractedAt
     * @param $comment
     * @param $paymentFourthStep
     * @param $workerCount
     * @param $hasInvestors
     * @param $effectiveValue
     * @param $createdAtTime
     * @param $paymentSecondStep
     * @param $paymentThirdStep
     * @param $isChain
     * @param $isOnTime
     * @param $hasOutsource
     */
    public function __construct(
        $typeId,
        $title,
        $serviceCount,
        $deadLine,
        $contractedAt,
        $comment,
        $paymentFourthStep,
        $workerCount,
        $hasInvestors,
        $effectiveValue,
        $createdAtTime,
        $paymentSecondStep,
        $paymentThirdStep,
        $paymentFirstStep,
        $isChain,
        $isOnTime,
        $hasOutsource)
    {
        $this->typeId = $typeId;
        $this->title = $title;
        $this->createdAtTime = $createdAtTime;
        $this->deadLine = $deadLine;
        $this->contractedAt = $contractedAt;
        $this->isChain = $isChain;
        $this->isOnTime = $isOnTime;
        $this->hasOutsource = $hasOutsource;
        $this->hasInvestors = $hasInvestors;
        $this->workerCount = $workerCount;
        $this->serviceCount = $serviceCount;
        $this->paymentSecondStep = $paymentSecondStep;
        $this->paymentThirdStep = $paymentThirdStep;
        $this->paymentFirstStep = $paymentFirstStep;
        $this->paymentFourthStep = $paymentFourthStep;
        $this->comment = $comment;
        $this->effectiveValue = $effectiveValue;
    }

    public static function make($map, $row){

        return new self(
                    self::getTypeId($map, $row['0']),
                    $row['1'],
                    Date::excelToDateTimeObject((int)$row['2']),
                    Date::excelToDateTimeObject((int)$row['7']),
                    isset($row['9'])? Date::excelToDateTimeObject((int)$row['9']) : null,
                    isset($row['3']) ? self::getBool($row['3']) : null,
                    isset($row['8']) ? self::getBool($row['8']) : null,
                    isset($row['5']) ? self::getBool($row['5']) : null,
                   isset($row['6']) ? self::getBool($row['6']) : null,
                    isset($row['4']) ? $row['4'] : null,
                    $row['10'],
                    $row['14'],
                    $row['15'],
                   $row['13'],
                    $row['16'],
                   $row['11'],
                   $row['12']

        );

    }

    private static function getTypeId($map, $title){

        return isset($map[$title]) ? $map[$title] : Type::create(['title' => $title])->id;

    }

    private static function getBool($item): bool{

        return $item == 'Да';

    }

    public function getValues(): array{

        $props = get_object_vars($this);
        $res = [];
        foreach ($props as $key => $prop){
            $res[Str::snake($key)] = $prop;
        }
        return $res;
    }

}


?>
