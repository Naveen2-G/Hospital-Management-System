<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Cardiology', 'description' => 'Heart and cardiovascular system care'],
            ['name' => 'Neurology', 'description' => 'Brain, spine, and nervous system disorders'],
            ['name' => 'Dermatology', 'description' => 'Skin, hair, and nail care'],
            ['name' => 'Pediatrics', 'description' => 'Infant, child, and adolescent healthcare'],
            ['name' => 'Orthopedics', 'description' => 'Bones, joints, and musculoskeletal system'],
            ['name' => 'Ophthalmology', 'description' => 'Eye care and vision treatments'],
            ['name' => 'ENT', 'description' => 'Ear, nose, and throat care'],
            ['name' => 'General Medicine', 'description' => 'Primary healthcare and general treatments'],
            ['name' => 'Surgery', 'description' => 'Surgical procedures and operations'],
            ['name' => 'Emergency', 'description' => '24/7 emergency and trauma care'],
            ['name' => 'Radiology', 'description' => 'Medical imaging and diagnostics'],
            ['name' => 'Pathology', 'description' => 'Laboratory testing and diagnostics'],
        ];

        foreach ($departments as $dept) {
            Department::updateOrCreate(['name' => $dept['name']], $dept);
        }
    }
}
