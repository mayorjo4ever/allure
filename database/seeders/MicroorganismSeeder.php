<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Microorganism;

class MicroorganismSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $microorganisms = [
            ['id' => 1, 'name' => 'Acinetobacter Baumannii'],
            ['id' => 2, 'name' => 'Aspergillus Fumigatus'],
            ['id' => 3, 'name' => 'Bacillus Anthracis'],
            ['id' => 4, 'name' => 'Bacillus Cereus'],
            ['id' => 5, 'name' => 'Blastomyces Dermatitidis'],
            ['id' => 6, 'name' => 'Campylobacter Jejuni'],
            ['id' => 7, 'name' => 'Candida Albicans'],
            ['id' => 8, 'name' => 'Citrobacter Spp.'],
            ['id' => 9, 'name' => 'Coccidioides Immitis'],
            ['id' => 10, 'name' => 'Corynebacterium Diphtheriae'],
            ['id' => 11, 'name' => 'Cryptococcus Neoformans'],
            ['id' => 12, 'name' => 'Enterobacter Spp.'],
            ['id' => 13, 'name' => 'Enterococcus Faecalis'],
            ['id' => 14, 'name' => 'Enterococcus Faecium'],
            ['id' => 15, 'name' => 'Epidermophyton Spp.'],
            ['id' => 16, 'name' => 'Escherichia Coli'],
            ['id' => 17, 'name' => 'Haemophilus Influenzae'],
            ['id' => 18, 'name' => 'Histoplasma Capsulatum'],
            ['id' => 19, 'name' => 'Klebsiella Pneumoniae'],
            ['id' => 20, 'name' => 'Listeria Monocytogenes'],
            ['id' => 21, 'name' => 'Moraxella Catarrhalis'],
            ['id' => 22, 'name' => 'Mucor Spp.'],
            ['id' => 23, 'name' => 'Neisseria Gonorrhoeae'],
            ['id' => 24, 'name' => 'Neisseria Meningitidis'],
            ['id' => 25, 'name' => 'Non-Albicans Species Candida'],
            ['id' => 26, 'name' => 'Paracoccidioides Brasiliensis'],
            ['id' => 27, 'name' => 'Pneumocystis Jirovecii'],
            ['id' => 28, 'name' => 'Proteus Mirabilis'],
            ['id' => 29, 'name' => 'Pseudomonas Aeruginosa'],
            ['id' => 30, 'name' => 'Rhizopus Spp'],
            ['id' => 31, 'name' => 'Salmonella Typhi'],
            ['id' => 32, 'name' => 'Serratia Marcescens'],
            ['id' => 33, 'name' => 'Shigella Spp.'],
            ['id' => 34, 'name' => 'Staphylococcus Aureus'],
            ['id' => 35, 'name' => 'Staphylococcus Epidermidis'],
            ['id' => 36, 'name' => 'Staphylococcus Saprophyticus'],
            ['id' => 37, 'name' => 'Streptococcus Agalactiae (Group B)'],
            ['id' => 38, 'name' => 'Streptococcus Pneumoniae'],
            ['id' => 39, 'name' => 'Streptococcus Pyogenes (Group A)'],
            ['id' => 40, 'name' => 'Trichophyton Spp.'],
            ['id' => 41, 'name' => 'Microsporum Spp.'],
            ['id' => 42, 'name' => 'Vibrio Cholerae'],
            ['id' => 43, 'name' => 'Viridans Group Streptococci']
        ];

        Microorganism::insert($microorganisms);
    }
}
