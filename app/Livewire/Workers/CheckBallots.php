<?php

namespace App\Livewire\Workers;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CheckBallots extends Component
{
    public $months, $years;
    public $month, $year;
    public $payments = [];

    public function mount(){
        $currentYear = date('Y');
        $this->years = range($currentYear, 2000);
        $this->months = config('periods_spanish');
    }

    public function searchEspecificPayment(){
        $this->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        $employeeId = auth('worker')->user()->id;
        $month = str_pad($this->month, 2, '0', STR_PAD_LEFT); // Asegura formato MM
        $year = $this->year;

        $this->payments = DB::table('payments')
            ->join('contracts', 'contracts.id', '=', 'payments.contract_id')
            ->join('employees', 'employees.id', '=', 'contracts.employee_id')
            ->join('periods', 'periods.id', '=', 'payments.period_id')
            ->join('payrolls', 'payrolls.id', '=', 'periods.payroll_id')
            ->where('employees.id', $employeeId)
            ->where('periods.mounth', $month)
            ->where('payrolls.year', $year)
            ->select('payments.id','payments.total_remuneration', 'payments.net_pay', 'periods.mounth', 'payrolls.year')
            ->get();
    }

    public function render()
    {
        return view('livewire.workers.check-ballots');
    }
}
