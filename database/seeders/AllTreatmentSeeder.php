<?php

namespace Database\Seeders;

use App\Models\AllTreatment;
use Illuminate\Database\Seeder;

class AllTreatmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $treatments = 
               [
                ['id' => 1, 'name' => 'Amoxicillin'],
                ['id' => 2, 'name' => 'Amoxicillin-Clavulanate'],
                ['id' => 3, 'name' => 'Amphotericin B'],
                ['id' => 4, 'name' => 'Amphotericin B + Flucytosine'],
                ['id' => 5, 'name' => 'Ampicillin'],
                ['id' => 6, 'name' => 'Antitoxin'],
                ['id' => 7, 'name' => 'Azithromycin'],
                ['id' => 8, 'name' => 'Carbapenems'],
                ['id' => 9, 'name' => 'Cefepime'],
                ['id' => 10, 'name' => 'Ceftriaxone'],
                ['id' => 11, 'name' => 'Ceftriaxone + Azithromycin'],
                ['id' => 12, 'name' => 'Ciprofloxacin'],
                ['id' => 13, 'name' => 'Clindamycin'],
                ['id' => 14, 'name' => 'Colistin'],
                ['id' => 15, 'name' => 'Daptomycin'],
                ['id' => 16, 'name' => 'Doxycycline'],
                ['id' => 17, 'name' => 'Echinocandins'],
                ['id' => 18, 'name' => 'Erythromycin'],
                ['id' => 19, 'name' => 'Fluconazole'],
                ['id' => 20, 'name' => 'Fluoroquinolones'],
                ['id' => 21, 'name' => 'Gentamicin'],
                ['id' => 22, 'name' => 'Griseofulvin'],
                ['id' => 23, 'name' => 'Itraconazole'],
                ['id' => 24, 'name' => 'Linezolid'],
                ['id' => 25, 'name' => 'Macrolides'],
                ['id' => 26, 'name' => 'Meropenem'],
                ['id' => 27, 'name' => 'Nafcillin (MSSA)'],
                ['id' => 28, 'name' => 'Nitrofurantoin'],
                ['id' => 29, 'name' => 'Penicillin'],
                ['id' => 30, 'name' => 'Penicillin G'],
                ['id' => 31, 'name' => 'Penicillin V'],
                ['id' => 32, 'name' => 'Piperacillin-Tazobactam'],
                ['id' => 33, 'name' => 'Rehydration therapy'],
                ['id' => 34, 'name' => 'Surgical debridement'],
                ['id' => 35, 'name' => 'Surgical intervention'],
                ['id' => 36, 'name' => 'TMP-SMX'],
                ['id' => 37, 'name' => 'Terbinafine'],
                ['id' => 38, 'name' => 'Topical antifungals'],
                ['id' => 39, 'name' => 'Trimethoprim-Sulfamethoxazole (TMP-SMX)'],
                ['id' => 40, 'name' => 'Vancomycin'],
                ['id' => 41, 'name' => 'Vancomycin (MRSA)'],
                ['id' => 42, 'name' => 'Voriconazole'],
            ];
            AllTreatment::insert($treatments); 
    }
}
