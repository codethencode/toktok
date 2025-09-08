<?php
namespace App\Http\Controllers;
use App\Models\Basket;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Carbon;
use PhpOffice\PhpWord\SimpleType\Jc;


class WordExportController extends Controller
{
    public function generateWord($orderId)
    {

       $basket = Basket::with(['company', 'tribunal', 'dossierCustomer'])
            ->where('order_id', $orderId)
            ->firstOrFail();

        //dd($basket);
                
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Titre
        $title = $section->addText("DOSSIER DE PLAIDOIRIE", [
            'name' => 'Georgia',
            'size' => 22,
            'bold' => true,
            'color' => 'CC9900',
        ], ['alignment' => 'center']);

        // Ligne de séparation
        $section->addText(str_repeat("―", 30), [], ['alignment' => 'center']);

        // En-tête
        $section->addTextBreak();
        $section->addText("LAWBEE-AVOCATS®", ['bold' => true, 'color' => '000'], ['alignment' => 'center']);
        $section->addText("David ATTALI", ['italic' => true], ['alignment' => 'center']);
        $section->addText("Avocat au Barreau\n14 rue Pythéas - 13001 Marseille", [], ['alignment' => 'center']);
        $section->addText("Tél. : + 33 (0)9. 51.95.71.43 - Fax : + 33 (0)4.86.55.66.09", [], ['alignment' => 'center']);
        $section->addText("info@avocatattali.com", [], ['alignment' => 'center']);
        $section->addText(" {$basket->company->name}", ['bold' => true, 'underline' => 'none', 'color' => '000']);
        $section->addTextBreak(2);

        // Partie(s) représentée(s)
        $section->addText("PARTIE(S) REPRESENTEE(S) :", ['bold' => true, 'color' => '000']);

        // Nom du client s’il existe
        if ($basket->dossierCustomer) {
            $section->addText($basket->dossierCustomer->full_name ?? '');
        }

        // Espace
        $section->addTextBreak(40);

        // Ligne de bas de page simulée
        $section->addText("Dossier confectionné avec la collaboration de toquetoque.net",[],['alignment' => 'center']);
        $section->addText(str_repeat("―", 30), [], ['alignment' => 'center']);

        
        // Ajoute d'autres sections/paragraphes ici…

        // $footer = $section->addFooter();
        // $footer->addText("Juridiction : " . $basket->tribunal->name);
        // $footer->addText("Audience : " . $basket->company->name);
        // $footer->addText("RG : " . $basket->dossierCustomer->name);


        //

        // Footer
        $juridiction = $basket->tribunal->juridiction ?? '';
        $audience = $basket->tribunal->date_audience ? Carbon::parse($basket->tribunal->date_audience)->format('d/m/Y H:i:s') : '';
        $rg = $basket->tribunal->rg ?? '';



// Juridiction
$textRun1 = $section->addTextRun(['alignment' => Jc::CENTER]);
$textRun1->addText("Juridiction :", ['bold' => true, 'underline' => 'single', 'color' => '000']);
$textRun1->addText(" {$basket->tribunal->name}", ['bold' => true, 'underline' => 'none', 'color' => '000']);

// Audience
$textRun2 = $section->addTextRun(['alignment' => Jc::CENTER]);
$textRun2->addText("Audience :", ['bold' => true, 'underline' => 'single', 'color' => '000']);
$textRun2->addText(" {$basket->tribunal->date_audience}", ['bold' => true, 'underline' => 'none', 'color' => '000']);

// Affaire
$textRun3 = $section->addTextRun(['alignment' => Jc::CENTER]);
$textRun3->addText("Affaire :", ['bold' => true, 'underline' => 'single', 'color' => '000']);
$textRun3->addText(" {$basket->tribunal->parties_representees}", ['bold' => true, 'underline' => 'none', 'color' => '000']);

// RG
$textRun4 = $section->addTextRun(['alignment' => Jc::CENTER]);
$textRun4->addText("RG :", ['bold' => true, 'underline' => 'single', 'color' => '000']);
$textRun4->addText(" {$basket->order_name}", ['bold' => true, 'underline' => 'none', 'color' => '000']);



        // Export
        $fileName = 'Dossier_Plaidoirie_' . $orderId . '.docx';
        $tempFile = tempnam(sys_get_temp_dir(), 'word');
        $phpWordWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $phpWordWriter->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);

        //

    }
}
