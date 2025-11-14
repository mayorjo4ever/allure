<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Microorganism;
use Illuminate\Support\Facades\DB;

class TreatmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $treatments = [
            'Acinetobacter Baumannii' => 'Carbapenems, Colistin',
            'Aspergillus Fumigatus' => 'Voriconazole, Amphotericin B',
            'Bacillus Anthracis' => 'Ciprofloxacin, Doxycycline',
            'Bacillus Cereus' => 'Vancomycin, Clindamycin',
            'Blastomyces Dermatitidis' => 'Itraconazole, Amphotericin B',
            'Campylobacter Jejuni' => 'Azithromycin, Erythromycin',
            'Candida Albicans' => 'Fluconazole, Echinocandins',
            'Citrobacter Spp.' => 'Ceftriaxone, Carbapenems',
            'Coccidioides Immitis' => 'Fluconazole, Itraconazole',
            'Corynebacterium Diphtheriae' => 'Erythromycin, Antitoxin',
            'Cryptococcus Neoformans' => 'Amphotericin B + Flucytosine, Fluconazole',
            'Enterobacter Spp.' => 'Carbapenems, Cefepime',
            'Enterococcus Faecalis' => 'Ampicillin, Vancomycin',
            'Enterococcus Faecium' => 'Linezolid, Daptomycin',
            'Epidermophyton Spp.' => 'Terbinafine, Topical antifungals',
            'Escherichia Coli' => 'Nitrofurantoin, Ceftriaxone',
            'Haemophilus Influenzae' => 'Amoxicillin-Clavulanate, Ceftriaxone',
            'Histoplasma Capsulatum' => 'Itraconazole, Amphotericin B',
            'Klebsiella Pneumoniae' => 'Carbapenems, Ceftriaxone',
            'Listeria Monocytogenes' => 'Ampicillin, Gentamicin',
            'Moraxella Catarrhalis' => 'Amoxicillin-Clavulanate, Macrolides',
            'Mucor Spp.' => 'Amphotericin B, Surgical debridement',
            'Neisseria Gonorrhoeae' => 'Ceftriaxone + Azithromycin',
            'Neisseria Meningitidis' => 'Ceftriaxone, Penicillin G',
            'Non-Albicans Species Candida' => 'Echinocandins, Amphotericin B',
            'Paracoccidioides Brasiliensis' => 'Itraconazole, Amphotericin B',
            'Pneumocystis Jirovecii' => 'Trimethoprim-Sulfamethoxazole (TMP-SMX)',
            'Proteus Mirabilis' => 'Ceftriaxone, Piperacillin-Tazobactam',
            'Pseudomonas Aeruginosa' => 'Piperacillin-Tazobactam, Meropenem',
            'Rhizopus Spp' => 'Amphotericin B, Surgical intervention',
            'Salmonella Typhi' => 'Ceftriaxone, Azithromycin',
            'Serratia Marcescens' => 'Carbapenems, Fluoroquinolones',
            'Shigella Spp.' => 'Ciprofloxacin, Azithromycin',
            'Staphylococcus Aureus' => 'Nafcillin (MSSA), Vancomycin (MRSA)',
            'Staphylococcus Epidermidis' => 'Vancomycin',
            'Staphylococcus Saprophyticus' => 'Nitrofurantoin, TMP-SMX',
            'Streptococcus Agalactiae (Group B)' => 'Penicillin G, Ampicillin',
            'Streptococcus Pneumoniae' => 'Penicillin, Ceftriaxone',
            'Streptococcus Pyogenes (Group A)' => 'Penicillin V, Amoxicillin',
            'Trichophyton Spp.' => 'Terbinafine, Griseofulvin',
            'Microsporum Spp.' => 'Griseofulvin, Terbinafine',
            'Vibrio Cholerae' => 'Doxycycline, Rehydration therapy',
            'Viridans Group Streptococci' => 'Penicillin G, Ceftriaxone',
        ];

        foreach ($treatments as $organism => $treatment) {
            $micro = Microorganism::where('name', $organism)->first();
            if ($micro) {
                DB::table('treatments')->insert([
                    'microorganism_id' => $micro->id,
                    'treatment' => $treatment,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
