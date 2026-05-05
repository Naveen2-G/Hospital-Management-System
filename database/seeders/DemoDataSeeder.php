<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Room;
use App\Models\Bed;
use App\Models\Medicine;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\Admission;
use App\Models\LabTest;
use App\Models\Staff;
use App\Models\Setting;
use App\Models\Notification;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Doctors
        $doctors = [
            ['name'=>'Dr. Rajesh Sharma','email'=>'rajesh@hms.com','phone'=>'9876543001','specialization'=>'Interventional Cardiology','qualification'=>'MD, DM Cardiology, FACC','experience_years'=>15,'consultation_fee'=>1500,'department_id'=>1],
            ['name'=>'Dr. Anita Desai','email'=>'anita@hms.com','phone'=>'9876543002','specialization'=>'Cardiac Surgery','qualification'=>'MS, MCh Cardiac Surgery','experience_years'=>12,'consultation_fee'=>2000,'department_id'=>1],
            ['name'=>'Dr. Anil Kumar','email'=>'anil@hms.com','phone'=>'9876543003','specialization'=>'Neurophysiology','qualification'=>'MD, DM Neurology, FRCP','experience_years'=>20,'consultation_fee'=>1800,'department_id'=>2],
            ['name'=>'Dr. Priya Patel','email'=>'priya@hms.com','phone'=>'9876543004','specialization'=>'Cosmetic Dermatology','qualification'=>'MD Dermatology','experience_years'=>10,'consultation_fee'=>1200,'department_id'=>3],
            ['name'=>'Dr. Sneha Reddy','email'=>'sneha@hms.com','phone'=>'9876543005','specialization'=>'Neonatology','qualification'=>'MD Pediatrics','experience_years'=>8,'consultation_fee'=>1000,'department_id'=>4],
            ['name'=>'Dr. Vikram Singh','email'=>'vikram@hms.com','phone'=>'9876543006','specialization'=>'Trauma Surgery','qualification'=>'MS Orthopedics','experience_years'=>14,'consultation_fee'=>1600,'department_id'=>5],
            ['name'=>'Dr. Deepa Iyer','email'=>'deepa@hms.com','phone'=>'9876543007','specialization'=>'Retinal Surgery','qualification'=>'MS Ophthalmology','experience_years'=>11,'consultation_fee'=>1400,'department_id'=>6],
            ['name'=>'Dr. Rahul Mehta','email'=>'rahul@hms.com','phone'=>'9876543008','specialization'=>'General Practice','qualification'=>'MBBS, MD','experience_years'=>9,'consultation_fee'=>800,'department_id'=>8],
        ];
        foreach ($doctors as $d) { Doctor::create($d); }

        // Patients
        $patientData = [
            ['name'=>'Amit Verma','email'=>'amit@email.com','phone'=>'9800000001','dob'=>'1990-05-12','gender'=>'male','blood_group'=>'A+','address'=>'12 MG Road, Mumbai'],
            ['name'=>'Sunita Devi','email'=>'sunita@email.com','phone'=>'9800000002','dob'=>'1985-11-23','gender'=>'female','blood_group'=>'B+','address'=>'45 Nehru Nagar, Delhi'],
            ['name'=>'Ravi Kumar','email'=>'ravi@email.com','phone'=>'9800000003','dob'=>'1978-02-08','gender'=>'male','blood_group'=>'O+','address'=>'78 Anna Salai, Chennai'],
            ['name'=>'Priya Sharma','email'=>'priyasharma@email.com','phone'=>'9800000004','dob'=>'1995-07-30','gender'=>'female','blood_group'=>'AB+','address'=>'23 Park Street, Kolkata'],
            ['name'=>'Mohan Das','email'=>'mohan@email.com','phone'=>'9800000005','dob'=>'1965-09-17','gender'=>'male','blood_group'=>'A-','address'=>'56 MG Road, Bangalore'],
            ['name'=>'Kavita Singh','email'=>'kavita@email.com','phone'=>'9800000006','dob'=>'1992-01-05','gender'=>'female','blood_group'=>'B-','address'=>'89 Civil Lines, Lucknow'],
            ['name'=>'Arjun Nair','email'=>'arjun@email.com','phone'=>'9800000007','dob'=>'2000-12-20','gender'=>'male','blood_group'=>'O-','address'=>'34 Marine Drive, Kochi'],
            ['name'=>'Fatima Begum','email'=>'fatima@email.com','phone'=>'9800000008','dob'=>'1988-04-14','gender'=>'female','blood_group'=>'A+','address'=>'67 Charminar Rd, Hyderabad'],
            ['name'=>'Vikash Yadav','email'=>'vikash@email.com','phone'=>'9800000009','dob'=>'1975-08-22','gender'=>'male','blood_group'=>'B+','address'=>'12 Boring Rd, Patna'],
            ['name'=>'Lakshmi Menon','email'=>'lakshmi@email.com','phone'=>'9800000010','dob'=>'1998-03-09','gender'=>'female','blood_group'=>'O+','address'=>'90 Residency Rd, Thiruvananthapuram'],
        ];
        foreach ($patientData as $p) { Patient::create($p); }

        // Appointments
        $statuses = ['pending','confirmed','completed','cancelled'];
        $types = ['regular','emergency','video'];
        $slots = ['09:00 - 09:30','09:30 - 10:00','10:00 - 10:30','10:30 - 11:00','11:00 - 11:30','14:00 - 14:30','14:30 - 15:00','15:00 - 15:30'];
        for ($i = 0; $i < 25; $i++) {
            Appointment::create([
                'patient_id' => rand(1, 10),
                'doctor_id' => rand(1, 8),
                'department_id' => rand(1, 8),
                'appointment_date' => Carbon::today()->addDays(rand(-7, 7)),
                'time_slot' => $slots[array_rand($slots)],
                'status' => $statuses[array_rand($statuses)],
                'type' => $types[array_rand($types)],
            ]);
        }

        // Rooms & Beds
        $roomTypes = ['ICU','General','Private','Semi-Private'];
        $rates = ['ICU'=>5000,'General'=>1000,'Private'=>3000,'Semi-Private'=>2000];
        for ($floor = 1; $floor <= 3; $floor++) {
            foreach ($roomTypes as $idx => $type) {
                $roomNum = $floor . str_pad($idx + 1, 2, '0', STR_PAD_LEFT);
                $room = Room::create([
                    'room_number' => $roomNum,
                    'type' => $type,
                    'floor' => "Floor $floor",
                    'capacity' => $type === 'General' ? 4 : ($type === 'Semi-Private' ? 2 : 1),
                    'rate_per_day' => $rates[$type],
                    'status' => ['available','available','occupied'][rand(0,2)],
                ]);
                $bedCount = $room->capacity;
                for ($b = 1; $b <= $bedCount; $b++) {
                    Bed::create([
                        'room_id' => $room->id,
                        'bed_number' => $room->room_number . '-B' . $b,
                        'status' => rand(0,1) ? 'available' : 'occupied',
                    ]);
                }
            }
        }

        // Medicines
        $meds = [
            ['name'=>'Paracetamol 500mg','category'=>'Analgesic','manufacturer'=>'Cipla','unit_price'=>5,'stock_quantity'=>500,'reorder_level'=>50],
            ['name'=>'Amoxicillin 250mg','category'=>'Antibiotic','manufacturer'=>'Sun Pharma','unit_price'=>12,'stock_quantity'=>300,'reorder_level'=>30],
            ['name'=>'Omeprazole 20mg','category'=>'Antacid','manufacturer'=>'Dr. Reddy','unit_price'=>8,'stock_quantity'=>400,'reorder_level'=>40],
            ['name'=>'Metformin 500mg','category'=>'Anti-diabetic','manufacturer'=>'Lupin','unit_price'=>6,'stock_quantity'=>250,'reorder_level'=>25],
            ['name'=>'Atorvastatin 10mg','category'=>'Lipid-lowering','manufacturer'=>'Cipla','unit_price'=>15,'stock_quantity'=>200,'reorder_level'=>20],
            ['name'=>'Amlodipine 5mg','category'=>'Antihypertensive','manufacturer'=>'Torrent','unit_price'=>10,'stock_quantity'=>350,'reorder_level'=>35],
            ['name'=>'Cetirizine 10mg','category'=>'Antihistamine','manufacturer'=>'Zydus','unit_price'=>4,'stock_quantity'=>15,'reorder_level'=>50],
            ['name'=>'Ibuprofen 400mg','category'=>'NSAID','manufacturer'=>'Alkem','unit_price'=>7,'stock_quantity'=>8,'reorder_level'=>30],
        ];
        foreach ($meds as $m) { Medicine::create($m); }

        // Lab Tests
        $tests = [
            ['name'=>'Complete Blood Count (CBC)','category'=>'Hematology','price'=>350],
            ['name'=>'Blood Glucose Fasting','category'=>'Biochemistry','price'=>150],
            ['name'=>'Lipid Profile','category'=>'Biochemistry','price'=>600],
            ['name'=>'Thyroid Profile (T3, T4, TSH)','category'=>'Endocrinology','price'=>800],
            ['name'=>'Liver Function Test','category'=>'Biochemistry','price'=>500],
            ['name'=>'Kidney Function Test','category'=>'Biochemistry','price'=>450],
            ['name'=>'Urine Routine','category'=>'Microbiology','price'=>200],
            ['name'=>'Chest X-Ray','category'=>'Radiology','price'=>400],
        ];
        foreach ($tests as $t) { LabTest::create($t); }

        // Invoices & Payments
        for ($i = 1; $i <= 10; $i++) {
            $total = rand(1, 5) * 1000;
            $paid = rand(0, 1) ? $total : rand(0, $total);
            $status = $paid >= $total ? 'paid' : ($paid > 0 ? 'partial' : 'unpaid');
            $inv = Invoice::create([
                'patient_id' => rand(1, 10),
                'invoice_number' => 'INV-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'total_amount' => $total,
                'paid_amount' => $paid,
                'due_amount' => $total - $paid,
                'status' => $status,
                'due_date' => Carbon::today()->addDays(rand(-5, 30)),
                'created_at' => Carbon::today()->subDays(rand(0, 14)),
            ]);
            InvoiceItem::create([
                'invoice_id' => $inv->id,
                'description' => 'Consultation Fee',
                'quantity' => 1,
                'unit_price' => $total,
                'total' => $total,
            ]);
            if ($paid > 0) {
                Payment::create([
                    'invoice_id' => $inv->id,
                    'amount' => $paid,
                    'method' => ['cash','card','online'][rand(0,2)],
                    'paid_at' => Carbon::today()->subDays(rand(0, 7)),
                ]);
            }
        }

        // Staff
        $staffData = [
            ['name'=>'Nurse Anjali','email'=>'anjali@hms.com','phone'=>'9700000001','designation'=>'Head Nurse','department_id'=>1,'salary'=>45000],
            ['name'=>'Technician Ravi','email'=>'techrav@hms.com','phone'=>'9700000002','designation'=>'Lab Technician','department_id'=>12,'salary'=>35000],
            ['name'=>'Receptionist Meera','email'=>'meera@hms.com','phone'=>'9700000003','designation'=>'Front Desk','department_id'=>8,'salary'=>25000],
        ];
        foreach ($staffData as $s) {
            $s['joining_date'] = Carbon::today()->subMonths(rand(1, 24));
            Staff::create($s);
        }

        // Settings
        Setting::set('hospital_name', 'HMS Hospital', 'general');
        Setting::set('hospital_address', '123 Healthcare Avenue, Mumbai 400001', 'general');
        Setting::set('hospital_phone', '+91-22-12345678', 'general');
        Setting::set('hospital_email', 'info@hms-hospital.com', 'general');

        // Notifications
        Notification::create(['user_id' => 1, 'title' => 'Welcome', 'message' => 'Welcome to HMS Admin Dashboard!', 'type' => 'system']);
        Notification::create(['user_id' => 1, 'title' => 'Low Stock Alert', 'message' => 'Cetirizine 10mg stock is below reorder level.', 'type' => 'alert']);
        Notification::create(['user_id' => 1, 'title' => 'New Appointment', 'message' => 'A new appointment has been booked for today.', 'type' => 'appointment']);
    }
}
