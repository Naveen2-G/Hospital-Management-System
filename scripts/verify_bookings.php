<?php
$projectRoot = dirname(__DIR__);
require $projectRoot . '/vendor/autoload.php';
$app = require $projectRoot . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
// Query sample rows
$lab = $app['db']->table('lab_bookings')->whereNotNull('report_file')->select('id','user_id','patient_id','report_uploaded_at')->limit(10)->get()->toArray();
$hp = $app['db']->table('health_package_bookings')->whereNotNull('report_file')->select('id','user_id','patient_id','report_uploaded_at')->limit(10)->get()->toArray();
echo json_encode(['lab' => $lab, 'health' => $hp], JSON_PRETTY_PRINT);

// Counts
$counts = [];
$counts['lab_total_with_report'] = $app['db']->table('lab_bookings')->whereNotNull('report_file')->count();
$counts['lab_with_patient_id'] = $app['db']->table('lab_bookings')->whereNotNull('report_file')->whereNotNull('patient_id')->count();
$counts['lab_missing_patient_id'] = $app['db']->table('lab_bookings')->whereNotNull('report_file')->whereNull('patient_id')->count();
$counts['health_total_with_report'] = $app['db']->table('health_package_bookings')->whereNotNull('report_file')->count();
$counts['health_with_patient_id'] = $app['db']->table('health_package_bookings')->whereNotNull('report_file')->whereNotNull('patient_id')->count();
$counts['health_missing_patient_id'] = $app['db']->table('health_package_bookings')->whereNotNull('report_file')->whereNull('patient_id')->count();

echo "\n\nCounts:\n";
echo json_encode($counts, JSON_PRETTY_PRINT);

// Detailed health package rows with potential patient matches
$details = $app['db']->table('health_package_bookings as hb')
	->leftJoin('patients as p_email', 'p_email.email', '=', 'hb.email')
	->leftJoin('patients as p_phone', 'p_phone.phone', '=', 'hb.phone')
	->leftJoin('patients as p_name', 'p_name.name', '=', 'hb.patient_name')
	->whereNotNull('hb.report_file')
	->select('hb.id','hb.patient_name','hb.email','hb.phone','hb.package_name',
		'hb.user_id','hb.patient_id',
		'p_email.id as patient_id_by_email',
		'p_phone.id as patient_id_by_phone',
		'p_name.id as patient_id_by_name')
	->get()
	->toArray();

echo "\n\nHealth details with potential matches:\n";
echo json_encode($details, JSON_PRETTY_PRINT);
