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
        Log::info('output: ', ["fonts path"=>public_path("Poppins"),"gettype"=>$validate["htmlContent"]]);
        
        try {
            // Create an instance of mPDF
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'default_font_size' => 12,
                'default_font' => 'arial',
                // 'margin_left' => 10,
                // 'margin_right' => 10,
                // 'margin_top' => 10,
                // 'margin_bottom' => 10,
                ]);
            
            // Write the HTML content to the PDF
            $mpdf->WriteHTML(file_get_contents(public_path('css/style.css')), \Mpdf\HTMLParserMode::HEADER_CSS);
            $mpdf->WriteHTML($validate["htmlContent"]);
            // $mpdf->WriteHTML("<h1>hello aryan</h1>");
            
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