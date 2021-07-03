<?php

namespace App\Controller;

use App\Database\QueryBuilder;

class Employee 
{
    protected $build;

    public function __construct()
    {
        $this->build = new QueryBuilder;
    }

    public function read()
    {
        $data = [];
        try {
            $records = $this->build->select()->from('employee')
                        ->orderBy('created_at', 'asc')->get();

            $html = '
                <tr>
                    <td colspan="6">No records found!</td>
                </tr>
            ';

            if (! empty($records)) {
                $html = '';
                foreach ($records as $val) {
                    $id     = "$val->employee_number";
                    $html  .= "
                        <tr>
                            <td>". $val->employee_number ."</td>
                            <td>". $val->fullname ."</td>
                            <td>". $val->email ."</td>
                            <td>". $val->mobile_number ."</td>
                            <td>". format_date($val->created_at, "M j, Y | g:i A") ."</td>
                            <td>". format_date($val->updated_at, "M j, Y | g:i A") ."</td>
                            <td>
                                <button type='button' class='btn btn-sm btn-outline-warning' onclick='editEmployee(\"$id\")'>Edit</button>

                                <button type='button' class='btn btn-sm btn-outline-danger' onclick='deleteEmployee(\"$id\")'>Delete</button>
                            </td>
                        </tr>
                    ";
                }
            } 

            $data['status'] = 'success';
            $data['data']   = $html;
        } catch (\Exception $e) {
            $data['status']     = 'error';
            $data['message']    = "There's something wrong with the process.";
        }

        return $data;
    }

    public function fetch($request)
    {
        $data = [];
        try {
            $record = $this->build->select()->from('employee')
                        ->where('employee_number =', $request->id)->first();

            $data['status'] = 'success';
            $data['data']   = $record;
        } catch (\Exception $e) {
            $data['status']     = 'error';
            $data['message']    = "There's something wrong with the process.";
        }

        return $data;
    }

    public function save($request)
    {
        $data = [];
        try {
            $type   = 'saved';
            $params = [
                'employee_number' => $request->employee_number,
                'lname' => $request->lname,
                'fname' => $request->fname,
                'mname' => $request->mname,
                'fullname' => $this->concat_fullname($request->lname, $request->fname, $request->mname),
                'email' => $request->email,
                'mobile_number' => $request->mobile_number
            ];

            if (empty($request->key)) {
                $params['created_at'] = date('Y-m-d H:i:s');

                $this->build->table('employee')->insert($params);
            } else {
                $params['updated_at'] = date('Y-m-d H:i:s');

                $this->build->table('employee')
                    ->where('employee_number =', $request->key)
                    ->update($params);

                $type = 'updated';
            }

            $data['status']     = 'success';
            $data['message']    = "Data has been successfully $type!";
        } catch (\Exception $e) {
            $data['status']     = 'error';
            $data['message']    = "There's something wrong with the process.";
        }

        return $data;
    }

    public function delete($request)
    {
        try {
            $this->build->table('employee')
                ->where('employee_number =', $request->id)->delete();

            $data['status']     = 'success';
            $data['message']    = "Data has been successfully deleted!";
        } catch (\Exception $e) {
            $data['status']     = 'error';
            $data['message']    = "There's something wrong with the process.";
        }

        return $data;
    }

    private function concat_fullname($lname, $fname, $mname)
    {
        $mname = empty($mname) ? ' ' : " $mname[0] ";

        return $fname . $mname . $lname;
    }
}