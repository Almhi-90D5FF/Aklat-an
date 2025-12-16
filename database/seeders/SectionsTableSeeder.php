<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionsTableSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'code' => 'ARCHIVES',
                'name' => 'University Archives',
                'email' => 'archives-mainlib.updiliman@up.edu.ph',
                'telephone' => '8981-8500 local 2868',
                'description' => 'University archival materials and records.',
                'resources' => 'Archival documents, institutional records'
            ],
            [
                'code' => 'FILIPINIANA',
                'name' => 'Filipiniana Books Section',
                'email' => 'fibooks-mainlib.updiliman@up.edu.ph',
                'telephone' => '8981-8500 local 2859',
                'description' => 'Filipiniana and Philippine studies materials.',
                'resources' => 'Books, theses, reference materials'
            ],
            [
                'code' => 'ISAIS',
                'name' => 'Information Services and Instruction Section',
                'email' => 'libraryinfo.updiliman@up.edu.ph',
                'telephone' => '8981-8500 local 2861',
                'description' => 'Reference and instruction services.',
                'resources' => 'Reference books, media services'
            ],
            [
                'code' => 'MICROFILM',
                'name' => 'ISAIS Microfilm',
                'email' => 'libraryinfo.updiliman@up.edu.ph',
                'telephone' => '8981-8500 local 2861',
                'description' => 'Microfilm and archival media.',
                'resources' => 'Microfilm collections'
            ],
            [
                'code' => 'SERIALS',
                'name' => 'Serials Section',
                'email' => 'serials-mainlib.updiliman@up.edu.ph',
                'telephone' => '8981-8500 local 2860',
                'description' => 'Periodicals and journals.',
                'resources' => 'Journals, magazines'
            ],
            [
                'code' => 'SPECIAL',
                'name' => 'Special Collections Section',
                'email' => 'specol-mainlib.updiliman@up.edu.ph',
                'telephone' => '8981-8500 local 2855',
                'description' => 'Rare and special materials.',
                'resources' => 'Special collections, rare books'
            ],
            [
                'code' => 'SSP',
                'name' => 'Social Sciences and Philosophy Library',
                'email' => 'cssplib.upd@up.edu.ph',
                'telephone' => '8981-8500 local 2867',
                'description' => 'Social sciences and philosophy resources.',
                'resources' => 'Books, journals'
            ],
            [
                'code' => 'AIT',
                'name' => 'Asian Institute of Tourism',
                'email' => 'aitlibrary.upd@up.edu.ph',
                'telephone' => '8981-8500 local 2800',
                'description' => 'Tourism and hospitality resources.',
                'resources' => 'Tourism studies materials'
            ],
        ];

        foreach ($sections as $section) {
            Section::updateOrCreate(
                ['code' => $section['code']],
                $section
            );
        }
    }
}