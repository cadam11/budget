<?php

use Illuminate\Database\Seeder;

class NonExpenseBudgetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $month = \Carbon\Carbon::now()->startOfMonth();

        DB::table('budgets')->insert([
                [
                    'category' => 'Payroll',
                    'variable' => false,
                    'amount' => 5600,
                    'month' => $month->toDateTimeString(),
                    'type' => 'Income',
                ],
                [
                    'category' => 'Government Payment',
                    'variable' => false,
                    'amount' => 320,
                    'month' => $month->toDateTimeString(),
                    'type' => 'Income',
                ],
                [
                    'category' => 'Transfer',
                    'variable' => false,
                    'amount' => 0,
                    'month' => $month->toDateTimeString(),
                    'type' => 'Ignored',
                ],
            ]);
    }
}
