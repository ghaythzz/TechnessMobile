<?php
namespace App\Service;

use Dompdf\Dompdf;

class PdfGenerator
{
    private $dompdf;

    public function __construct()
    {
        $this->dompdf = new Dompdf();
    }

    public function generatePdf($html)
    {
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A5', 'portrait');
        $this->dompdf->render();
        return $this->dompdf->output();
    }
}
