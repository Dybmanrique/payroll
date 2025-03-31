<?php

namespace App\Livewire\Workers;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CheckBallots extends Component
{
    public $months, $years;
    public $month, $year;
    public $month_start, $year_start, $month_end, $year_end;
    public $payments = [];

    public function mount()
    {
        $currentYear = date('Y');
        $this->years = range($currentYear, 2024);
        $this->months = config('periods_spanish');
    }

    public function searchEspecificPayment()
    {
        $this->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        $employeeId = auth('worker')->user()->id;
        $month = str_pad($this->month, 2, '0', STR_PAD_LEFT); // Asegura formato MM
        $year = $this->year;

        $this->payments = [];
        $this->payments = DB::table('payments')
            ->join('contracts', 'contracts.id', '=', 'payments.contract_id')
            ->join('employees', 'employees.id', '=', 'contracts.employee_id')
            ->join('periods', 'periods.id', '=', 'payments.period_id')
            ->join('payrolls', 'payrolls.id', '=', 'periods.payroll_id')
            ->where('employees.id', $employeeId)
            ->where('periods.mounth', $month)
            ->where('payrolls.year', $year)
            ->select('payments.id', 'payments.total_remuneration', 'payments.net_pay', 'periods.mounth', 'payrolls.year')
            ->get();
    }

    public function searchPaymentsByRange()
    {
        $this->validate([
            'month_start' => 'required|integer|min:1|max:12',
            'year_start' => 'required|integer|min:2000|max:' . date('Y'),
            'month_end' => 'required|integer|min:1|max:12',
            'year_end' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        // Convertimos a formato YYYY-MM para comparar más fácil
        $startDate = "{$this->year_start}-" . str_pad($this->month_start, 2, '0', STR_PAD_LEFT);
        $endDate = "{$this->year_end}-" . str_pad($this->month_end, 2, '0', STR_PAD_LEFT);

        // Validación manual: la fecha de fin debe ser mayor o igual a la fecha de inicio
        if ($endDate < $startDate) {
            $this->addError('error_extra', 'La fecha de fin debe ser mayor o igual a la fecha de inicio.');
            return;
        }

        $employeeId = auth('worker')->user()->id;

        $this->payments = [];
        $this->payments = DB::table('payments')
            ->join('contracts', 'contracts.id', '=', 'payments.contract_id')
            ->join('employees', 'employees.id', '=', 'contracts.employee_id')
            ->join('periods', 'periods.id', '=', 'payments.period_id')
            ->join('payrolls', 'payrolls.id', '=', 'periods.payroll_id')
            ->where('employees.id', $employeeId)
            ->whereRaw("CONCAT(payrolls.year, '-', LPAD(periods.mounth, 2, '0')) BETWEEN ? AND ?", [$startDate, $endDate])
            ->select('payments.id', 'payments.total_remuneration', 'payments.net_pay', 'periods.mounth', 'payrolls.year')
            ->get();
    }

    public function render()
    {
        return view('livewire.workers.check-ballots');
    }
}
