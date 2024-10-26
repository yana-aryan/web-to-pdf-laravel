<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mpdf\Mpdf;

class PDFController extends Controller
{
    public function generatePDF(Request $request){
        
        $validate = $request->validate([
            'htmlContent' => 'required|string', // Ensure htmlContent is provided
        ]);
        
        // Log the HTML content for debugging
        Log::info('output: ', ["gettype"=>$validate["htmlContent"]]);
        
        try {
            // Create an instance of mPDF
            $mpdf = new Mpdf();
            
            // Write the HTML content to the PDF
            // $mpdf->WriteHTML($validate["htmlContent"]);
            $mpdf->WriteHTML("<h1>hello aryan</h1>");
            
            // Output the PDF as a download
            return response()->stream(function() use ($mpdf) {
                // echo $mpdf->Output('', 'S'); // 'D' for download
                // $mpdf->Output('generated_pdf.pdf', 'D'); // 'D' for download
                $mpdf->Output();
            }, 200, [
                "Content-Type" => "application/pdf",
                "Content-Disposition" => "attachment; filename=\"generated_pdf.pdf\""
            ]);
        } catch (\Mpdf\MpdfException $e) {
            // Log any errors encountered during PDF generation
            Log::error('mPDF error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);} 
    }
}
