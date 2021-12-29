<?php

namespace App\Http\Controllers;

use App\Models\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Pdf::orderBy('id','desc')->first();
        return view('pdfview',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pdfGenerate()
    {
        $pdf = app('dompdf.wrapper')->loadView('invoice');
        return $pdf->stream('invoice.pdf');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        if($request->hasFile('upload')){

            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName , PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;

            $request->file('upload')->move(public_path('images'),$fileName);

            $CKeditorFuncNum = $request->input('CKEditorFuncNum');

            $url = asset('images/'.$fileName);

            $msg = "Image upload Sucessfully";

            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKeditorFuncNum,'$url','$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');

            echo $response;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pdf  $pdf
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();

        Pdf::updateOrCreate([
            'id'=>$request->id,
        ],[
            'title' => $inputs['title'],
            'content' => $inputs['ckeditor'],
        ]);

        if($request->id){
            $msg = "Update Sucessfully";
        }else{
            $msg = "Addded Sucessfully";
        }
        $arr = array('status' => 200, 'msg' => $msg);
        return response()->json($arr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pdf  $pdf
     * @return \Illuminate\Http\Response
     *Generate PDF
      */

        public function createPDF() {
            // retreive all records from db
            $data = Pdf::all();

            // share data to view
            // view()->share('employee',$data);

            $pdf = app('dompdf.wrapper')->loadView('pdf_doc', $data);

            // download PDF file with download method
            return $pdf->download('pdf_file.pdf');

          }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pdf  $pdf
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pdf $pdf)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pdf  $pdf
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pdf $pdf)
    {
        //
    }
}
