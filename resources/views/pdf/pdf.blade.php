$fpdf = new Fpdf
           ();
           $fpdf->AddPage();
           $fpdf->SetFont('Arial','B',16);
           $fpdf->Cell(40,10,'Hello World!');
           $fpdf->Output();
           exit;