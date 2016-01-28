<?php

use Illuminate\Database\Seeder;

class RulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rules')->insert([
                [
                    'category'	=> 'Groceries',
                    'pattern' 	=> 'Extra Foods',
                    'amount'	=> null,
                ],
                [
                    'category'	=> 'Groceries',
                    'pattern' 	=> 'Sobey',
                    'amount'	=> null,
                ],
                [
                    'category'	=> 'Groceries',
                    'pattern' 	=> 'Costco',
                    'amount'	=> null,
                ],
                [
                    'category'	=> 'Winesdays',
                    'pattern' 	=> 'Moxie',
                    'amount'	=> null,
                ],
                [
                    'category'	=> 'Winesdays',
                    'pattern' 	=> 'St. James Hotel',
                    'amount'	=> null,
                ],
                [
                    'category'	=> 'Work Lunch',
                    'pattern' 	=> 'The Pint',
                    'amount'	=> null,
                ],
                [
                    'category'	=> 'Groceries',
                    'pattern' 	=> 'Real Cdn Superstore',
                    'amount'	=> null,
                ],
                [
                    'category'	=> 'Education',
                    'pattern' 	=> 'Athabasca University',
                    'amount'	=> null,
                ],
                [
                    'category'	=> 'Education',
                    'pattern' 	=> 'Winnipeg Technical',
                    'amount'	=> null,
                ],
                [
                    'category'	=> 'Mobile Phone',
                    'pattern' 	=> 'Rogers',
                    'amount'	=> null,
                ],
                [
                    'category'	=> 'Hydro',
                    'pattern' 	=> 'Misc Payment',
                    'amount'	=> null,
                ],
                [
                    'category'	=> 'River Park Fd',
                    'pattern' 	=> 'Gas',
                    'amount'	=> null,
                ],
                [
                    'category'	=> 'Finance Charge',
                    'pattern' 	=> 'Loan Interest',
                    'amount'	=> null,
                ],
                [
                    'category'	=> 'Transfer',
                    'pattern' 	=> 'Transfer',
                    'amount'	=> null,
                ],                
                [
                    'category'	=> 'Transfer',
                    'pattern' 	=> 'Payment - Thank You',
                    'amount'	=> null,
                ],                
                [
                    'category'	=> 'Mortgage',
                    'pattern' 	=> 'Mortgage',
                    'amount'	=> null,
                ],                
                [
                    'category'	=> 'Internet',
                    'pattern' 	=> 'Shaw Cablesystems',
                    'amount'	=> null,
                ],                
                [
                    'category'	=> 'Utilities',
                    'pattern' 	=> 'Www Trf Dda',
                    'amount'	=> 60.00,
                ],
                [
                    'category'	=> 'Home Insurance',
                    'pattern' 	=> 'Www Trf Dda',
                    'amount'	=> 187.00,
                ],
                [
                    'category'	=> 'Kids School',
                    'pattern' 	=> 'Cheque',
                    'amount'	=> 170.00,
                ],
                [
                    'category'	=> 'Payroll',
                    'pattern' 	=> 'Payroll',
                    'amount'	=> null,
                ],      
                [
                    'category' 	=> 'Government Payment',
                    'pattern'	=> 'Federal Payment',
                    'amount'	=> null,
                ],      
                [
                    'category'	=> 'Auto Insurance',
                    'pattern' 	=> 'Mpi - Online Pmt',
                    'amount'	=> null,
                ],      
                [
                    'category'	=> 'Pet Supplies',
                    'pattern' 	=> 'Pet Valu',
                    'amount'	=> null,
                ],      
                [
                    'category'	=> 'Auto Payment',
                    'pattern' 	=> 'Term Loan',
                    'amount'	=> null,
                ],      
                [
                    'category'	=> 'Property Tax',
                    'pattern' 	=> 'Property Tax',
                    'amount'	=> null,
                ],      
            ]);
    }
}
