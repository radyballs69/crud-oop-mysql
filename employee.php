<?php 

include_once './vendor/autoload.php';

use App\Controller\Employee;

$employee = new Employee;

if (isset($_REQUEST['type'])) {
    $request = (object) $_REQUEST;

    if ($_REQUEST['type'] === 'read') {
        echo json_encode($employee->read());
    }

    if ($_REQUEST['type'] === 'fetch') {
        echo json_encode($employee->fetch($request));
    }

    if ($_REQUEST['type'] === 'save') {
        echo json_encode($employee->save($request));
    }

    if ($_REQUEST['type'] === 'delete') {
        echo json_encode($employee->delete($request));
    }
}

echo null;