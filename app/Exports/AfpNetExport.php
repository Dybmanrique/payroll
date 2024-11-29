<?php

namespace App\Exports;

use App\Models\Payment;
use App\Models\Period;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class AfpNetExport implements FromCollection, ShouldAutoSize, WithColumnFormatting
{
    use Exportable;

    protected $list;

    public function forList(array $list)
    {
        $this->list = $list;

        return $this;
    }

    public function collection()
    {
        return new Collection($this->list);
    }

    public function columnFormats(): array
    {
        return [
            'L' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }

    // public function headings(): array
    // {
    //     return [
    //         'Número de secuencia',
    //         'CUSPP',
    //         'Tipo  de documento de identidad',
    //         'Número de documento de indentidad',
    //         'Apellido paterno	',
    //         'Apellido materno	',
    //         'Nombres	',
    //         'Relación Laboral 	',
    //         'Inicio de RL	',
    //         'Cese de RL	',
    //         'Excepcion de Aportar	',
    //         'Remuneración asegurable	',
    //         'Aporte voluntario del afiliado con fin previsional	',
    //         'Aporte voluntario del afiliado sin fin previsional	',
    //         'Aporte voluntario del empleador	',
    //         'Tipo de trabajo o Rubro	',
    //         'AFP (Conviene dejar en blanco)',
    //     ];
    // }
}
