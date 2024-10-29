<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payment;
use App\Models\Payroll;
use App\Models\Period;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        // $employee = Employee::find(1);
        // dd($employee->afps()->first()->obligatory_contribution);
        return view('admin.payrolls.index');
    }
    public function data()
    {
        return Payroll::all();
    }

    public function create()
    {
        return view('admin.payrolls.create');
    }

    public function edit(Payroll $payroll)
    {
        return view('admin.payrolls.edit', compact('payroll'));
    }

    public function destroy(Request $request)
    {
        try {
            Payroll::find($request->id)->delete();
            return response()->json([
                'message' => 'Eliminado correctamente',
                'code' => '200'
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => 'No se puede eliminar',
                'code' => '500'
            ]);
        }
    }
    public function view(Request $request)
    {
        try {
            $payroll = Payroll::findOrFail($request->id);
            $payroll->employees;
            return response()->json([
                'content' => $payroll,
                'code' => '200'
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'content' => 'Algo salió mal',
                'code' => '500'
            ]);
        }
    }
    public function mcpp(Period $period)
    {
        define("INGRESOS", 1);
        define("DESCUENTOS", 2);
        define("APORTACIONES", 3);

        define("CONTRATO_ADMINISTRATIVO_DE_SERVICIOS", 4);

        $prefix = "PLL";
        $executing_unit = "001479";
        $year_process = "2024";
        $mounth_process = "10";
        $payroll_type = "01";
        $payroll_class = "03";
        $correlative = "0001";
        $extension = ".txt";

        $name = "{$prefix}{$executing_unit}{$year_process}{$mounth_process}{$payroll_type}{$payroll_class}{$correlative}{$extension}";

        $body = "";
        foreach ($period->employees as $key => $employee) {
            $identity_document_type = "2";
            $identity_document_number = $employee->dni;
            $funding_resource = $period->payroll->funding_resource->code;

            //HONORARIOS
            $airhsp_concept = INGRESOS;
            $airhsp_concept_code = "0131";
            $description = "HONORARIOS";
            $amount = $employee->remuneration;
            $airhsp_record_type = CONTRATO_ADMINISTRATIVO_DE_SERVICIOS;
            $airhsp_code_employee = $employee->airhsp_code;
            $body .= "{$identity_document_type}|{$identity_document_number}|{$funding_resource}|{$airhsp_concept}|{$airhsp_concept_code}|{$description}|{$amount}|{$airhsp_record_type}|{$airhsp_code_employee}\n";

            //ONP
            if ($employee->pension_system === 'onp') {
                $airhsp_concept = DESCUENTOS;
                $airhsp_concept_code = "0000";
                $description = "ONP";
                $amount = ($employee->remuneration) * 0.13;
                $body .= "{$identity_document_type}|{$identity_document_number}|{$funding_resource}|{$airhsp_concept}|{$airhsp_concept_code}|{$description}|{$amount}|{$airhsp_record_type}|{$airhsp_code_employee}\n";
            }

            //AFP
            if ($employee->pension_system === 'afp') {
                $airhsp_concept = DESCUENTOS;
                $airhsp_concept_code = "0000";
                if($employee->afps){
                    //AFP AP OBLIG
                    $description = "AFP AP OBLIG";
                    $amount = ($employee->remuneration) * ($employee->afps()->first()->obligatory_contribution);
                    $body .= "{$identity_document_type}|{$identity_document_number}|{$funding_resource}|{$airhsp_concept}|{$airhsp_concept_code}|{$description}|{$amount}|{$airhsp_record_type}|{$airhsp_code_employee}\n";

                    //AFP SEGURO
                    $description = "AFP SEGURO";
                    $amount = ($employee->remuneration) * ($employee->afps()->first()->life_insurance);
                    $body .= "{$identity_document_type}|{$identity_document_number}|{$funding_resource}|{$airhsp_concept}|{$airhsp_concept_code}|{$description}|{$amount}|{$airhsp_record_type}|{$airhsp_code_employee}\n";

                    //AFP COM VAR
                    $description = "AFP COM VAR";
                    $amount = ($employee->remuneration) * ($employee->afps()->first()->variable_commission);
                    $body .= "{$identity_document_type}|{$identity_document_number}|{$funding_resource}|{$airhsp_concept}|{$airhsp_concept_code}|{$description}|{$amount}|{$airhsp_record_type}|{$airhsp_code_employee}\n";
                }
            }

            //ESSALUD
            if($employee->essalud === true){
                $description = "ESSALUD";
                $amount = ($employee->remuneration) * (0.09);
                $body .= "{$identity_document_type}|{$identity_document_number}|{$funding_resource}|{$airhsp_concept}|{$airhsp_concept_code}|{$description}|{$amount}|{$airhsp_record_type}|{$airhsp_code_employee}\n";
            }
        }

        $count_rows = substr_count($body, "\n");
        $total_income = "1000.00";
        $total_discounts = "5000.00";
        $total_contributions = "500.00";

        //FIRST ROW
        $header = "{$executing_unit}|{$year_process}|{$mounth_process}|{$payroll_type}|{$payroll_class}|{$correlative}|{$count_rows}|{$total_income}|{$total_discounts}|{$total_contributions}";
        $content = "{$header}\n{$body}";

        // Crear y devolver el archivo como descarga
        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . $name . '"');
        try {
        } catch (\Exception $ex) {
            dd('algo salió mal');
        }
    }
}
