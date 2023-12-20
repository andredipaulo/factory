<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
class PdfController extends Controller
{
    public function gerarPDF(Request $request)
    {
        $requestData = $request['tabela'];
        $template    = ($request['template']) ?? 'template';

        $tableData = [];
        foreach ($requestData as $data)
        {
            $tableData[] = $data;
        }

        $data = [
            'tableData' => $tableData,
        ];
        
        $pdf = PDF::loadView('pdf.'.$template, $data)->setPaper('legal', 'portrait');
        //  return $pdf->stream('exemplo.pdf');

        $pdfContent = $pdf->output();

        // Converte o conteúdo do PDF para Base64
        $pdfBase64 = base64_encode($pdfContent);

        return response()->json(['pdf' => $pdfBase64]);

        // $pdf->setOptions(['isPhpEnabled' => true]); // Ative o suporte a PHP na view
        //
        // $pdfFile = $pdf->output(); // Obtém o conteúdo do PDF
        //
        // return response($pdfFile)
        //  ->header('Content-Type', 'application/pdf')
        //  ->header('Content-Disposition', 'inline; filename=exemplo.pdf');

        //return $pdf->setPaper('a4')->stream('document.pdf');
        //return $pdf->stream('document.pdf');
        //return $pdf->download('tabela.pdf');

    }


}
