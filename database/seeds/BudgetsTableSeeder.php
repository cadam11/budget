<?php

use Illuminate\Database\Seeder;

class BudgetsTableSeeder extends Seeder
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
                    'category' => 'Auto Insurance',
                    'variable' => false,
                    'amount' => 503,
                    'month' => $month->toDateTimeString(),
                ],
                [
                    'category' => 'Auto Payment',
                    'variable' => false,
                    'amount' => 687,
                    'month' => $month->toDateTimeString(),
                ],
                [
                    'category' => 'Gas',
                    'variable' => true,
                    'amount' => 200,
                    'month' => $month->toDateTimeString(),
                ],
                [
                    'category' => 'Hydro',
                    'variable' => false,
                    'amount' => 151,
                    'month' => $month->toDateTimeString(),
                ],
                [
                    'category' => 'Internet',
                    'variable' => false,
                    'amount' => 34,
                    'month' => $month->toDateTimeString(),
                ],
                [
                    'category' => 'Mobile Phone',
                    'variable' => false,
                    'amount' => 86,
                    'month' => $month->toDateTimeString(),
                ],
                [
                    'category' => 'Utilities',
                    'variable' => false,
                    'amount' => 60,
                    'month' => $month->toDateTimeString(),
                ],
                [
                    'category' => 'Education',
                    'variable' => false,
                    'amount' => 904,
                    'month' => $month->toDateTimeString(),
                ],
                [
                    'category' => 'Finance Charge',
                    'variable' => false,
                    'amount' => 122,
                    'month' => $month->toDateTimeString(),
                ],
                [
                    'category' => 'Groceries',
                    'variable' => true,
                    'amount' => 900,
                    'month' => $month->toDateTimeString(),
                ],
                [
                    'category' => 'Winesdays',
                    'variable' => true,
                    'amount' => 60,
                    'month' => $month->toDateTimeString(),
                ],
                [
                    'category' => 'Work Lunch',
                    'variable' => true,
                    'amount' => 120,
                    'month' => $month->toDateTimeString(),
                ],
                [
                    'category' => 'Home Insurance',
                    'variable' => false,
                    'amount' => 187,
                    'month' => $month->toDateTimeString(),
                ],
                [
                    'category' => 'Mortgage',
                    'variable' => false,
                    'amount' => 1373,
                    'month' => $month->toDateTimeString(),
                ],
                [
                    'category' => 'Kids School',
                    'variable' => false,
                    'amount' => 170,
                    'month' => $month->toDateTimeString(),
                ],
                [
                    'category' => 'Dog Walker',
                    'variable' => false,
                    'amount' => 120,
                    'month' => $month->toDateTimeString(),
                ],
                [
                    'category' => 'Pet Supplies',
                    'variable' => true,
                    'amount' => 150,
                    'month' => $month->toDateTimeString(),
                ],
                [
                    'category' => 'Property Tax',
                    'variable' => false,
                    'amount' => 397,
                    'month' => $month->toDateTimeString(),
                ],
            ]);
    }
}
