<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 5; $i++) {
            $company = Company::factory()->create();

            for($j = 0; $j < 10; $j++) {
                $employee = Employee::factory()->create();
                $job = Job::factory()->for($employee)->for($company)->create();
                $job->createYears();
            }


        }
            // Company::factory()
            // ->count(10)
            // ->hasEmployees(10)
            // ->create();
    }
}
