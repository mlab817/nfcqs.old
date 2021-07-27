<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    /**
     * Upload project report form.
     *
     * @param Request $request
     */
    public function uploadReportForm(Request $request)
    {
        return view('reports.upload');
    }

    /**
     * Upload project report.
     *
     * @param Request $request
     */
    public function uploadReport(Request $request)
    {
        $remarks = trim($request->input('remarks'));
        $file = $request->file('file');

        // validation
        $validator = Validator::make(
            [
                'remarks' => $remarks,
                'file' => $file
            ], [
            'remarks' => 'required|max:100',
            'file' => 'required|mimes:doc,dox,xls,xlsx,pdf,ppt,pptx',
        ]);

        if (!$validator->fails()) {

            // get file extension
            $path = $_FILES['file']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);

            // file repo destination
            $dest = 'uploads/project-reports/' . strtolower(rand() . '.' . $ext);

            // copy the files
            copy($file, $dest);

            // insert the file
            DB::table('project_reports')
                ->insert([
                    'filename' => $dest,
                    'remarks' => $remarks
                ]);

            return "File successfully uploaded.";
        } else {
            return $validator->errors();
        }
    }

    /**
     * List of project reports.
     *
     * @param Request $request
     */
    public function reportList(Request $request)
    {
        $data = DB::table('project_reports')
            ->orderBy('id', 'DESC')
            ->get();

        return view('reports.list')->with([
            'data' => $data
        ]);
    }
}
