<?php
namespace App\Controller;

use App\Controller\AppController;
use PHPExcel; 
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;
use PHPExcel_Worksheet_PageSetup;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Fill;
use Cake\Datasource\ConnectionManager;
use PHPExcel_Cell_DataValidation;
use PHPExcel_Style_NumberFormat;
use FPDF;
use Cake\Mailer\Email;
/**
 * Exports Controller
 */
class ExportsController extends AppController
{
    private $excel;

    private $writter;

    private $montly_header;

    private $alphabet = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

    private $sales_header = array(
        "A" => "Numéro",
        "B" => "Type",
        "C" => "Agent",
        "D" => "Client",
        "E" => "Destinataire",
        "F" => "Paquet",
        "G" => "En route",
        "H" => "Livré",
        "I" => "Poid",
        "J" => "Total HTG",
        "K" => "Total USD",
        "L" => "Date",
        "M" => "Heure"
    );

    private $invoices_header = array(
        "A" => "Date",
        "B" => "Heure",
        "C" => "Numéro",
        "D" => "Camion",
        "E" => "Produit",
        "F" => "Volume",
        "G" => "Total"
    );

    private $status_header = array(
        "A" => "Numéro",
        "B" => "Client",
        "C" => "Camion",
        "D" => "Produit",
        "E" => "Volume (M3)",
        "F" => "Date",
        "G" => "Heure",
        "H" => "Chargé",
        "I" => "Sortie"
    );

    private $products_header = array(
        "A" => "Produit",
        "B" => "Fiches",
        "C" => "Poid",
        "D" => "Pourcentage",
        "E" => "Cummulé",
    );

    private $customers_header = array(
        "A" => "Compagnie",
        "B" => "Représentant",
        "C" => "Type",
        "D" => "Devise",
        "E" => "Téléphone",
        "F" => "Email",
        "G" => "Limite Crédit",
        "H" => "Réduction (%)",
        "I" => "Statut",
        "J" => "ID",
    );

    private $months = array("01" => "Janvier", "02" => "Février", "03" => "Mars", "04" => "Avril", "05" => "Mai", "06" => "Juin", "07" => "Juillet","08" => "Août", "09" => "Septembre", "10" => "Octobre", "11" => "Novembre", "12" => "Décembre");

    private $years = array("2019" => "2019", "2020" => "2020", '2021' => '2021', '2022' => '2022', '2023' => '2023', '2023' => '2023', '2024' => '2024');

    private $from;
    
    private $to;

    private function setDates(){
        $this->from = $this->request->session()->read("from");
        $this->to = $this->request->session()->read("to");
    }


    public function sales($type, $customer, $user, $reussies, $transport){
        $this->setDocument("BELGAZ System", "BELGAZ System", "BELGAZ Sales Report - [ FROM : ".$this->from." ] - [ TO : ".$this->to." ]", "BELGAZ Sales Report", "BELGAZ Sales Report");
        $this->setDates();
        $sales = $this->getSales($type, $customer, $user, $reussies, $transport);
        $this->setHeader($this->sales_header, "Ventes BELGAZ [".$sales->count()." FICHES]");
    
        $i=4;
         $total = 0; $total_us = 0; $volume=0; 
        foreach($sales as $sale){

            if($sale->status == 0 || $sale->status == 4 || $sale->status == 6 || $sale->status == 7){
                $this->excel->getActiveSheet()->getStyle('A'.$i.":M".$i)->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'AFEEEE')
                        )
                    )
                );
            }
            $aff_us = 0;
            $aff = 0;
            if($sale->status == 0 || $sale->status == 6 || $sale->status == 10){
                $total_us = $total_us + $sale->total;
                $aff_us = $sale->total;
            }

            if($sale->status == 1 || $sale->status == 4 || $sale->status == 7){
                $total = $total + $sale->total;
                $aff = $sale->total; 
            }
            $volume = $volume + $sale->products_sales[0]->quantity;
            
            $this->excel->getActiveSheet()->SetCellValue("A".$i, $sale->sale_number); 
            $type = "";
            if($sale->status == 0 || $sale->status == 7){
                $type.="[CR]";
            }
            if($sale->status == 1 || $sale->status == 10){
                $type.="[CASH]";
            }
            if($sale->status == 4 || $sale->status == 6){
                $type.="[CH]";
            }
            if($sale->status == 0 || $sale->status == 3 || $sale->status == 6 || $sale->status == 9){
                $type.="[USD]";
            }
            if($sale->status == 4 || $sale->status == 5 || $sale->status == 7 || $sale->status == 8){
                $type.="[HTG]";
            }
            if($sale->status == 2 || $sale->status == 3 || $sale->status == 5 || $sale->status == 8 || $sale->status == 9 || $sale->status == 11){
                $type.="[X]";
            }
            $this->excel->getActiveSheet()->SetCellValue("B".$i, $type); 
            $this->excel->getActiveSheet()->SetCellValue("C".$i, strtoupper(substr($sale->user->last_name, 0,1).substr($sale->user->first_name, 0,1))); 
            if(!empty($sale->customer->last_name)){
                $this->excel->getActiveSheet()->SetCellValue("D".$i, substr(strtoupper($sale->customer->last_name." ".$sale->customer->first_name), 0, 15)); 
            }else{
                $this->excel->getActiveSheet()->SetCellValue("D".$i, substr(strtoupper($sale->customer->last_name." ".$sale->customer->first_name), 0, 15)); 
            }
            $this->excel->getActiveSheet()->SetCellValue("E".$i, substr($sale->receiver->name, 0, 15));
            $this->excel->getActiveSheet()->SetCellValue("F".$i, $sale->truck->immatriculation);

            if($sale->charged == 0){
                $this->excel->getActiveSheet()->SetCellValue("G".$i, "NON");
            }else{
                $this->excel->getActiveSheet()->SetCellValue("G".$i, date("Y-m-d H:i", strtotime($sale->charged_time)));
            }

            if($sale->sortie == 0){
                $this->excel->getActiveSheet()->SetCellValue("H".$i, "NON");
            }else{
                $this->excel->getActiveSheet()->SetCellValue("H".$i, date("Y-m-d H:i", strtotime($sale->sortie_time)));
            }
             
            $this->excel->getActiveSheet()->SetCellValue("I".$i, $sale->products_sales[0]->quantity); 
            if($sale->status == 0 || $sale->status == 6 || $sale->status == 10){
                $this->excel->getActiveSheet()->SetCellValue("K".$i, number_format($aff_us, 2, ".", '')); 
            }else{
                $this->excel->getActiveSheet()->SetCellValue("J".$i, number_format($aff, 2, ".", ''));
            }
            
            $this->excel->getActiveSheet()->SetCellValue("L".$i, date('Y-m-d', strtotime($sale->created))); 
            $this->excel->getActiveSheet()->SetCellValue("M".$i, date('h:i A', strtotime($sale->created))); 

            $i++;
        }
        $this->excel->getActiveSheet()->SetCellValue("A3", "TOTAL"); 
        $this->excel->getActiveSheet()->SetCellValue("I3", number_format($volume, 2, ".", '')); 
        $this->excel->getActiveSheet()->SetCellValue("J3", number_format($total, 2, ".", '')); 
        $this->excel->getActiveSheet()->SetCellValue("K3", number_format($total_us, 2, ".", '')); 
        $this->excel->getActiveSheet()->getStyle("A3:M3")->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'B22222')
                )
            )
        );
        $this->style();
        $this->output("export_ventes_".date("Ymd"));
    }

    public function invoicesPdf(){
        $from = $this->request->session()->read("from")." 00:00:00";
        $to = $this->request->session()->read("to")." 23:59:59";
        $products_results = [];
        $email = "";
        if($this->request->is(['patch', 'put', "post"])){
            $customer_id = $this->request->getData()['customer_id'];
            $month = date("m", strtotime($this->request->session()->read("from")));
            $year = date("Y", strtotime($this->request->session()->read("from")));
            $email = $this->request->getData()['email'];
        }

        $this->loadModel('Customers');
        $customer = $this->Customers->get($customer_id, ["contain" => ['Rates']]);
        require_once(ROOT . DS . 'vendor' . DS  . 'fpdf'  . DS . 'fpdf.php');
        
        $fpdf = new FPDF();
        $fpdf->AddPage();
        $fpdf->Image(ROOT.'/webroot/img/logo.png',10,4,50);
        $fpdf->SetFont('Arial','B',9);
        $fpdf->Cell(190,0,date('l j F Y'),0,0, 'R');
        $fpdf->Ln(7);
        $fpdf->Cell(190,0,"",'B',0, 'R');
        $fpdf->Ln(5);
        $fpdf->SetFont('Arial','B',8);
        $from_a = date("j M Y", strtotime($from));
        $to_a = date("t M Y", strtotime($from));
        $fpdf->Cell(90,0,utf8_decode("RESUME DES VENTES - " . strtoupper(date("M Y", strtotime($from)))),0,0, 'L');
        if(!empty($customer->first_name)){
            $fpdf->Cell(100,0,utf8_decode("CLIENT #".$customer->customer_number." - ".strtoupper($customer->first_name)),0,0, 'R');
        }else{
            $fpdf->Cell(100,0,utf8_decode("CLIENT #".$customer->customer_number." - ".strtoupper($customer->last_name)),0,0, 'R');

        }


        $fpdf->Ln(5);
        
        $condition = "(s.status = 0 OR s.status = 4 OR s.status = 6 OR s.status = 7)";
        $conn = ConnectionManager::get('default');
        $sales = $conn->query("SELECT s.sale_number, s.transport, s.transport_fee, ps.quantity, t.immatriculation, ps.list_price, p.abbreviation, ps.price, p.name, s.created, s.total FROM `sales` s 
            LEFT JOIN products_sales ps on ps.sale_id = s.id
            LEFT JOIN trucks t ON t.id = s.truck_id
            LEFT JOIN products p ON p.id = ps.product_id
            WHERE s.customer_id = ".$customer_id." AND s.created >= '".$from."' AND s.created <= '".$to."' AND ".$condition." 
            ORDER BY ps.product_id ASC, s.created ASC"); 

        if(!empty($sales)){
            $product_name = "ab"; 
            $total_prod = 0; 
            $total = 0; 
            $volume=0;
            $volume_prod=0; 
            $transport_fee=0; 
            $transport=0;
            $increment = 0;
            $increment_prod=0;

            $fpdf->Cell(20,7,"DATE",'L,B,T,R',0, 'C');
            $fpdf->Cell(20,7,"#",'B,R,T',0, 'C');
            $fpdf->Cell(20,7,"CAMION",'B,R,T',0, 'C');
            $fpdf->Cell(20,7,"PRODUIT",'B,R,T',0, 'C');
            $fpdf->Cell(15,7,"VOLUME",'B,R,T',0, 'C');
            $fpdf->Cell(25,7,"PRIX CLIENT",'L,B,R,T',0, 'C');
            $fpdf->Cell(25,7,"PRIX",'L,B,R,T',0, 'C');
            $fpdf->Cell(20,7,"TRANSPORT",'L,B,R,T',0, 'C');
            $fpdf->Cell(25,7,"TOTAL (".$customer->rate->name.")",'B,R,T',0, 'C');
            $fpdf->Ln();
            $list_price = 0; $price = 0;
            $k=1;
            $fpdf->setFillColor(255,255,255); 
            foreach($sales as $sale){
                $fpdf->SetFont('Arial','B',8); 
                $total = $total + $sale['total']; 
                $volume = $volume + $sale['quantity']; 
                $transport_fee = $transport_fee + $sale['transport_fee']; 
                $transport = $transport + $sale['transport'];
                
                $increment = $increment + 1;
                if($product_name != $sale['abbreviation'] && $product_name != "ab"){
                    $fpdf->Cell(60,7,"TOTAL (" . $product_name . ")",'L,R,B,T',0, 'L');
                $fpdf->Cell(20,7,$increment_prod,'B,R,T',0, 'C');
                $fpdf->Cell(15,7,number_format($volume_prod, 2, ".", ",")." m3",'B,R,T',0, 'C');
                $fpdf->Cell(25,7,number_format($price, 2, ".", ",")." ".$customer->rate->name,'B,R,T',0, 'C');
                $fpdf->Cell(25,7,number_format($list_price, 2, ".", ",")." ".$customer->rate->name,'B,R,T',0, 'C');
                $fpdf->Cell(20,7,number_format($transport_fee, 2, ".", ",")." ".$customer->rate->name,'L,B,R,T',0, 'C');
                $fpdf->Cell(25,7,number_format($total_prod, 2, ".", ",")." ".$customer->rate->name,'B,R,T',0, 'C');
                $products_results[$product_name] = array("fiches" => $increment_prod, "volume" => $volume_prod, "total" => $total_prod, 'transport' => $transport, 'transport_fee' => $transport_fee);
                $total_prod = 0;$volume_prod = 0; $increment_prod=0;
                $fpdf->Ln("15");
                }

                if($product_name != $sale['abbreviation']){
                    $k = 1;
                    $fpdf->Cell(190,7,strtoupper($sale['name']),'L,R,T,B',0, 'L', true);
                    $product_name = $sale['abbreviation'];
                    $list_price = $sale['list_price'];
                    $price = $sale['price'];
                    $fpdf->Ln();
                }
                if($k % 2 == 0){
                    $fpdf->setFillColor(230,230,230);
                }
                $total_prod = $total_prod + $sale['total']; $increment_prod = $increment_prod + 1; $volume_prod = $volume_prod + $sale['quantity'];
                if($k== 1){
                    $top = ",T";
                }else{
                    $top = "";
                }
                $fpdf->SetFont('Arial','',7); 
                $fpdf->Cell(20,7,date("d/m", strtotime($sale['created'])),'L,R'.$top,0, 'C', true);
                $fpdf->Cell(20,7,$sale['sale_number'],'R,L'.$top,0, 'C', true);
                $fpdf->Cell(20,7,$sale['immatriculation'],'L,R'.$top,0, 'C', true);
                $fpdf->Cell(20,7,$sale['abbreviation'],'R,L'.$top,0, 'C', true);
                $fpdf->Cell(15,7,$sale['quantity']." m3",'R,L'.$top,0, 'C', true);
                $fpdf->Cell(25,7,number_format($sale['price'], 2, ".", ",")." ".$customer->rate->name,'R,L'.$top,0, 'C', true);
                $fpdf->Cell(25,7,number_format($sale['list_price'], 2, ".", ",")." ".$customer->rate->name,'R,L'.$top,0, 'C', true);
                
                if($sale['transport'] == 1){
                    $fpdf->Cell(20,7,number_format($sale['transport_fee'], 2, ".", ",")." ".$customer->rate->name,'L,R'.$top,0, 'C', true);
                }else{
                    $fpdf->Cell(20,7,"",'L,R'.$top,0, 'C', true);
                }
                $fpdf->Cell(25,7,number_format($sale['total'], 2, ".", ",")." ".$customer->rate->name,'R,L'.$top,0, 'C', true);
                
                $fpdf->Ln();
                $fpdf->setFillColor(255,255,255); 
                
                $k++;
            }
            $fpdf->SetFont('Arial','B',8); 

            $fpdf->Cell(60,7,"TOTAL (" . $sale['abbreviation'] . ")",'L,R,B,T',0, 'L');
            $fpdf->Cell(20,7,$increment_prod,'B,R,T',0, 'C');
            $fpdf->Cell(15,7,number_format($volume_prod, 2, ".", ",")." m3",'B,R,T',0, 'C');
            $fpdf->Cell(25,7,number_format($price, 2, ".", ",")." ".$customer->rate->name,'B,R,T',0, 'C');
            $fpdf->Cell(25,7,number_format($list_price, 2, ".", ",")." ".$customer->rate->name,'B,R,T',0, 'C');
            $fpdf->Cell(20,7,number_format($transport_fee, 2, ".", ",")." ".$customer->rate->name,'B,R,T',0, 'C');
            $fpdf->Cell(25,7,number_format($total_prod, 2, ".", ",")." ".$customer->rate->name,'B,R,T',0, 'C');
            $fpdf->Ln();
            $products_results[$product_name] = array("fiches" => $increment_prod, "volume" => $volume_prod, "total" => $total_prod, 'transport' => $transport, 'transport_fee' => $transport_fee);
            $fpdf->Ln(10);
            $fpdf->SetFont('Arial','B',8);
            $fpdf->Cell(190,7,"RESUME",'L,B,R,T',0, 'L');
            $fpdf->Ln();
            
            // $fpdf->Cell(10,7,"",'L,B,T',0, 'C');
            $fpdf->Cell(90,7,"PRODUIT",'L,B,R,T',0, 'L');
            $fpdf->Cell(25,7,"VOLUME (m3)",'B,R,T',0, 'C');
            $fpdf->Cell(50,7,"TRANSPORT (VOYAGES)",'B,R,T',0, 'C');
            $fpdf->Cell(25,7,"TOTAL (".$customer->rate->name.")",'B,R,T',0, 'C');
            $fpdf->Ln();

            $fpdf->SetFont('Arial','',7); 
            $i=1;
            // debug($products_results); 
            // die();
            $fpdf->setFillColor(255,255,255); 
            $total_r=0; $fiches_r = 0; $volume_r = 0; $transport_r=0;$transport_fee_r=0;
            foreach($products_results as $key => $value){
                if($i % 2 == 0){
                    $fpdf->setFillColor(230,230,230); 
                }
                if($i== 1){
                    $top = ",T";
                }else{
                    $top = "";
                }
                $volume_r = $volume_r + $value['volume'];
                $fiches_r = $fiches_r + $value['fiches'];
                $total_r = $total_r + $value['total'];
                $transport_r = $transport_r + $value['transport'];
                $transport_fee_r = $transport_fee_r + $value['transport_fee'];
                $fpdf->Cell(10,7,$i,'L,R'.$top,0, 'C', true);
                $fpdf->Cell(80,7,$key." (".$value['fiches'].")",'L,R'.$top,0, 'L', true);
                $fpdf->Cell(25,7,number_format($value['volume'], 2, ".", ",")." m3",'R,L'.$top,0, 'C', true);
                $fpdf->Cell(50,7,number_format($value['transport_fee'], 2, ".", ",")." ".$customer->rate->name." (".$value['transport'].")",'R,L'.$top,0, 'C', true);
                $fpdf->Cell(25,7,number_format($value['total'], 2, ".", ",")." ".$customer->rate->name,'R,L'.$top,0, 'C', true);
                $fpdf->Ln();
                $fpdf->setFillColor(255,255,255); 
                $i++;
            }   
            $fpdf->SetFont('Arial','B',8); 
            $fpdf->Cell(90,7,"TOTAL (".$customer->rate->name.") - (".$fiches_r." VOYAGES)",'L,B,R,T',0, 'L');
            $fpdf->Cell(25,7,number_format($volume_r, 2, ".", ",")." M3",'B,R,T',0, 'C');
            $fpdf->Cell(50,7,number_format($transport_fee_r, 2, ".", ",")." ".$customer->rate->name." (".$transport_r.")",'B,R,T',0, 'C');
            $fpdf->Cell(25,7,number_format($total_r, 2, ".", ",")." ".$customer->rate->name,'B,R,T',0, 'C');
            $fpdf->Ln();
        }

        $directoryName = ROOT."/webroot/tmp/facture_CL".$customer->customer_number."_".date('Ymd').'.pdf'; 
        
        if(!empty($email)){
            $fpdf->Output($directoryName,'F');
            $this->send($directoryName, $email);
            return $this->redirect(['controller' => 'Customers', "action" => "invoices"]);
        }else{
            $fpdf->Output('I');
        }
        
        die();
    }

    public function send($file, $mail){
        $email = new Email('default');
        $message = "Bonjour,\n\nTrouvez en pièce jointe le résumé de vos ventes à la BELGAZ.\n\n Nous vous remercions pour votre confiance. \n\n L'équipe BELGAZ";
        $email->from(['BELGAZsysteme@gmail.com' => 'BELGAZ'])
            ->to($mail)
            ->subject('BELGAZ - Résumé ventes')
            ->attachments(array(1 => $file))
            ->send($message);
    }

    public function invoices($customer_id,$month,$year){
        $this->loadModel('Customers'); 
        $customer = $this->Customers->get($customer_id, ["contain" => ['Rates']]);
        $this->setDocument("BELGAZ System", "BELGAZ System", "BELGAZ Facture Client - [ PERIODE : ".$month."/".$year." ] - [ CLIENT : ".$customer->name." ]", "BELGAZ Facture Client", "BELGAZ Facture Client");
        $from = $year."-".$month."-01 00:00:00";
        $to = date("Y-m-t 23:59:59", strtotime($from));
        $conn = ConnectionManager::get('default');
        $sales = $conn->query("SELECT s.sale_number, ps.quantity, t.immatriculation, p.abbreviation, p.name, s.created, s.total FROM `sales` s 
            LEFT JOIN products_sales ps on ps.sale_id = s.id
            LEFT JOIN trucks t ON t.id = s.truck_id
            LEFT JOIN products p ON p.id = ps.product_id
            WHERE s.customer_id = ".$customer_id." AND s.created >= '".$from."' AND s.created <= '".$to."' AND (s.status = 0 OR s.status = 4 OR s.status = 6 OR s.status = 7) 
            ORDER BY ps.product_id ASC, s.created ASC"); 
        $this->setHeader($this->invoices_header, "BELGAZ Facture Client - [ PERIODE : ".$month."/".$year." ] - [ CLIENT : ".$customer->name." ]");
        if(!empty($sales)){
            $product_name = "ab";$total_prod=0;$total=0;$volume_prod=0;$volume=0;$increment_prod=0;$increment=0;
            $i=3;
            foreach($sales as $sale){
                $total = $total + $sale['total']; 
                $volume = $volume + $sale['quantity'];
                $increment = $increment + 1;

                if($product_name != $sale['name'] && $product_name != "ab"){
                    $this->excel->getActiveSheet()->mergeCells('A'.$i.':D'.$i);
                    $this->excel->getActiveSheet()->SetCellValue("A".$i, "TOTAL");
                    $this->excel->getActiveSheet()->SetCellValue("E".$i, $increment_prod);
                    $this->excel->getActiveSheet()->SetCellValue("F".$i, number_format($volume_prod,2,".",","));
                    $this->excel->getActiveSheet()->SetCellValue("G".$i, number_format($total_prod,2,".","") . " ". $customer->rate->name); 
                    $this->excel->getActiveSheet()
                        ->getStyle("A".$i.":G".$i)
                        ->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setRGB('E7E6E6');
                    $i++;
                    $total_prod = 0;
                    $volume_prod = 0; 
                    $increment_prod=0;
                }
                if($product_name != $sale['name']){
                    $this->excel->getActiveSheet()->SetCellValue("A".$i, $sale['name']); 
                    $this->excel->getActiveSheet()
                        ->getStyle("A".$i.":G".$i)
                        ->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setRGB('D0CECE');
                    $this->excel->getActiveSheet()->mergeCells('A'.$i.':G'.$i);
                    $this->excel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->applyFromArray(
                     array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
                    );
                    $i++;
                    $product_name = $sale['name'];
                // add a merge cells and a color
                }

                $total_prod = $total_prod + $sale['total']; 
                $increment_prod = $increment_prod + 1;
                $volume_prod = $volume_prod + $sale['quantity'];

                $this->excel->getActiveSheet()->SetCellValue("A".$i, date("d/m/Y", strtotime($sale['created'])));
                $this->excel->getActiveSheet()->SetCellValue("B".$i, date("g:i A", strtotime($sale['created'])));
                $this->excel->getActiveSheet()->SetCellValue("C".$i, $sale['sale_number']);
                $this->excel->getActiveSheet()->SetCellValue("D".$i, $sale['immatriculation']); 
                $this->excel->getActiveSheet()->SetCellValue("E".$i, $sale['abbreviation']);
                $this->excel->getActiveSheet()->SetCellValue("F".$i, $sale['quantity']. "M3");
                $this->excel->getActiveSheet()->SetCellValue("G".$i, number_format($sale['total'],2,".","") . " ". $customer->rate->name);  
                $i++;
            }

            $this->excel->getActiveSheet()->mergeCells('A'.$i.':D'.$i);
            $this->excel->getActiveSheet()->SetCellValue("A".$i, "TOTAL");
            $this->excel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->applyFromArray(
                 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
                );
            $this->excel->getActiveSheet()->SetCellValue("E".$i, $increment_prod);
            $this->excel->getActiveSheet()->SetCellValue("F".$i, $volume_prod);
            $this->excel->getActiveSheet()->SetCellValue("G".$i, number_format($total_prod,2,".","") . " ". $customer->rate->name); 
            $this->excel->getActiveSheet()
                        ->getStyle("A".$i.":G".$i)
                        ->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setRGB('E7E6E6');
            $i++;

            $this->excel->getActiveSheet()->mergeCells('A'.$i.':D'.$i);
            $this->excel->getActiveSheet()->SetCellValue("A".$i, "TOTAL");
            $this->excel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->applyFromArray(
                 array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
                );
            $this->excel->getActiveSheet()->SetCellValue("E".$i, $increment);
            $this->excel->getActiveSheet()->SetCellValue("F".$i, $volume);
            $this->excel->getActiveSheet()->SetCellValue("G".$i, number_format($total,2,".","") . " ". $customer->rate->name); 
            $this->excel->getActiveSheet()
                        ->getStyle("A".$i.":G".$i)
                        ->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setRGB('C00000');

            $this->excel->getActiveSheet()->getStyle("A".$i.":G".$i)->getFont()
                                ->getColor()->setRGB('FFFFFF');
        }
        $this->styleInvoices();
        $this->output("FACTURE_CL".$customer->customer_number."_".$month."_".$year);
    }

    public function status(){
        $this->setDocument("BELGAZ System", "BELGAZ System", "BELGAZ Status Report - [ FROM : ".$this->from." ] - [ TO : ".$this->to." ]", "BELGAZ Status Report", "BELGAZ Status Report");
        $this->setDates();
        $sales = $this->getSales(3, '99999', '99999', 1, 1);
        $this->setHeader($this->status_header, "Chargements et Sorties BELGAZ [ ".$sales->count()." Voyages ]");
    
        $i=3;
        foreach($sales as $sale){
            $this->excel->getActiveSheet()->SetCellValue("A".$i, $sale->sale_number); 
            $this->excel->getActiveSheet()->SetCellValue("B".$i, substr(strtoupper($sale->customer->first_name." ".$sale->customer->last_name), 0, 15)); 
            $this->excel->getActiveSheet()->SetCellValue("C".$i, $sale->truck->immatriculation); 
            $this->excel->getActiveSheet()->SetCellValue("D".$i, $sale->products_sales[0]->product->abbreviation); 
            $this->excel->getActiveSheet()->SetCellValue("E".$i, $sale->products_sales[0]->quantity);
            $this->excel->getActiveSheet()->SetCellValue("F".$i, date('Y-m-d', strtotime($sale->created))); 
            $this->excel->getActiveSheet()->SetCellValue("G".$i, date('h:i A', strtotime($sale->created)));
            if($sale->charged == 0){
                $this->excel->getActiveSheet()->SetCellValue("H".$i, "NON");
            }else{
                $this->excel->getActiveSheet()->SetCellValue("H".$i, date("Y-m-d H:i", strtotime($sale->charged_time)));
            }

            if($sale->sortie == 0){
                $this->excel->getActiveSheet()->SetCellValue("I".$i, "NON");
            }else{
                $this->excel->getActiveSheet()->SetCellValue("I".$i, date("Y-m-d H:i", strtotime($sale->sortie_time)));
            }
            $i++;
            
        }
        $this->styleStatus();
        $this->output("export_chargements_".date("Ymd"));
    }

    public function customers(){
        $this->setDocument("BELGAZ System", "BELGAZ System", "BELGAZ Customers Report", "BELGAZ Customers Report", "BELGAZ Customers Report");
        $this->setDates(); $this->loadModel("Customers");
        $this->setHeader($this->customers_header, "Liste des clients BELGAZ");
        $customers = $this->Customers->find("all"); 
        $i=3;
        $types = array(1 => "CREDIT", 2 => "CHEQUE");
        $rates = array(1 => "HTG", 2 => "USD");
        $statuses = array(1 => "ACTIF", 0 => "BLOQUE");

        
        foreach($customers as $customer){
            $this->excel->getActiveSheet()->SetCellValue("A".$i, $customer->first_name);
            $this->excel->getActiveSheet()->SetCellValue("B".$i, $customer->last_name);
            $this->excel->getActiveSheet()->SetCellValue("C".$i, $types[$customer->type]);
            $this->excel->getActiveSheet()->SetCellValue("D".$i, $rates[$customer->rate_id]);
            $this->excel->getActiveSheet()->SetCellValue("E".$i, $customer->phone);
            $this->excel->getActiveSheet()->SetCellValue("F".$i, $customer->email);
            $this->excel->getActiveSheet()->SetCellValue("G".$i, $customer->credit_limit);
            $this->excel->getActiveSheet()->SetCellValue("H".$i, $customer->discount);
            $this->excel->getActiveSheet()->SetCellValue("I".$i, $statuses[$customer->status]);
            $this->excel->getActiveSheet()->SetCellValue("J".$i, $customer->id);
            $i++;
        }
        $this->styleCustomers();
        $this->output("export_clients_".date("Ymd"));
    }

    public function monthly(){
        $this->setDates();
        $this->loadModel("Products"); 
        $products = $this->Products->find("all", array("order" => array("position ASC")));
        $from = date("Y-m-01 00:00:00", strtotime($this->from));
        $to = date("Y-m-t 23:59:59", strtotime($this->from));
        $month = date("F Y", strtotime($from));
        $last = $this->setMonthlyHeader($products);
        $this->setDocument("BELGAZ System", "BELGAZ System", "BELGAZ Monthly Report - [ MONTH : ".$month." ]", "BELGAZ Monthly Report", "BELGAZ Monthly Report");
        $this->setHeader($this->monthly_header, "Rapport Mensuel BELGAZ [" . $month . "]");

        $current = $from;
        $monthly = $this->getMonthly($from, $to);
        $i = 3;
        while($current <= $to){
            $product_total = 0;
            $day = date("d", strtotime($current));
            if($day ==1 || $day == 5 || $day == 10 || $day == 15 || $day == 20 || $day == 25 || $day == 30){
                $this->excel->getActiveSheet()->getStyle("A".$i.":".$last.$i)->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'E9E8E8')
                        )
                    )
                );
            }
            $this->excel->getActiveSheet()->SetCellValue('A'.$i, date("D j M y",strtotime($current)));
            $j=2;
            foreach($products as $product){
                $volume = 0;
                foreach($monthly as $sale){
                    if($sale['date'] == date("Y-m-d", strtotime($current)) && $sale['id'] == $product->id){
                        $volume = $sale['total'];
                        break;
                    }
                }
                $product->total = $product->total + $volume;
                $product_total = $product_total + $volume;
                $volume = number_format($volume, 2, ".", "");
                $j++;
            }
            $this->excel->getActiveSheet()->SetCellValue('B'.$i, number_format($product_total,2,".",","));
            $current = date('Y-m-d', strtotime($current . ' + 1 day'));
            $i++;
        }

        $l=2;
        $this->excel->getActiveSheet()->SetCellValue("A".$i, "TOTAL");
        $last_total = 0;
        foreach($products as $product){
            $last_total = $last_total + $product->total;
            // $this->excel->getActiveSheet()->SetCellValue($this->alphabet[$l].$i, number_format($product->total,2));
            $l++;
        }
        $this->excel->getActiveSheet()->SetCellValue("B".$i, number_format($last_total, 2));
        

        $this->styleMonthly(15);
        $this->output("export_mensuel_".date("Ymd"));
    }

    public function monthlyCustomers(){
        $this->setDates();
        $this->loadModel("Products"); 
        $products = $this->Products->find("all", array("order" => array("position ASC")));
        $last = $this->setMonthlyHeader($products, 3);
        $this->setDocument("BELGAZ System", "BELGAZ System", "Rapport Client par Produits - [ DE : ".$this->from." ] - [ A : ".$this->to." ]", "BELGAZ Rapport Client par Produits", "BELGAZ Rapport Client par Produits");
        $this->setHeader($this->monthly_header, "Rapport Client par Produits BELGAZ [ DE : ".$this->from." ] - [ A : ".$this->to." ]");

        $customers = $this->getMonthlyCustomers($this->from, $this->to);
        $i = 3;
        $number = 1;
        $last_column = $this->excel->getActiveSheet()->getHighestColumn();
        $realtotal = 0; $realtotal_usd = 0; $real_volume = 0;
        foreach($customers as $customer){
            if($customer->total->count() > 0){
            $j=4;
            if($number % 2 == 0){
                $this->excel->getActiveSheet()
                    ->getStyle("A".$i.":".$last_column.$i)
                    ->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('E8E8E8');
            }
            if(!empty($customer->last_name)){
                $this->excel->getActiveSheet()->SetCellValue('A'.$i, strtoupper($customer->last_name));
            }else{
                $this->excel->getActiveSheet()->SetCellValue('A'.$i, strtoupper($customer->first_name));
            }
            if($customer->rate_id == 2){
                $total = 0;
                foreach($customer->total as $tot){
                    $total = $tot['total'];
                }
                $realtotal_usd = $realtotal_usd+$total;
                $this->excel->getActiveSheet()->SetCellValue('B'.$i, "0");
                $this->excel->getActiveSheet()->SetCellValue('C'.$i, number_format($total, 2, ".", ""));
                $this->excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode( '"$" #,##0.00_-' );
                $this->excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode( '"gdes" #,##0.00_-' );
            }else{
                $total = 0;
                foreach($customer->total as $tot){
                    $total = $tot['total'];
                }
                $realtotal = $realtotal+$total;
                $this->excel->getActiveSheet()->SetCellValue('C'.$i, "0");
                $this->excel->getActiveSheet()->SetCellValue('B'.$i, number_format($total, 2, ".", ""));
                $this->excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode( '"gdes" #,##0.00' );
                $this->excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode( '"$" #,##0.00' );
            }
            $volume = 0;
            foreach($customer->products as $prd){
                $volume = $volume + $prd['total_sold'];
                foreach($products as $prod){
                    if($prod->id == $prd['id']){
                        $prod->total = $prod->total + $prd['total_sold'];
                    }
                }
                $this->excel->getActiveSheet()->getStyle("D".$i)->getNumberFormat()->setFormatCode( '#,##0.00 "LBS"' );
                $this->excel->getActiveSheet()->SetCellValue("D".$i, number_format($volume,2,".",""));
                $real_volume = $real_volume + $volume;
               // $this->excel->getActiveSheet()->SetCellValue($this->alphabet[$j].$i, number_format($prd['total_sold'],2,".",""));
               // $this->excel->getActiveSheet()->getStyle($this->alphabet[$j].$i)->getNumberFormat()->setFormatCode( '#,##0.00 "m3"' );
               $j++; 
            }
            $transport = 0;
            foreach($customer->transport as $t){
                $transport = $t['transport'];
            }
            // $this->excel->getActiveSheet()->SetCellValue($this->alphabet[$j].$i, number_format($transport, 2, ".", ""));
            $number++; $i++;}
        }
        $last_row = $this->excel->getActiveSheet()->getHighestRow();
        $last_column = $this->excel->getActiveSheet()->getHighestColumn();
        $this->excel->getActiveSheet()
        ->setCellValue(
            'A'.($last_row +1),
            'TOTAL'
        );
        $this->excel->getActiveSheet()->getStyle('B'.($last_row +1))->getNumberFormat()->setFormatCode('"gdes" #,##0.00' );
        $this->excel->getActiveSheet()
        ->setCellValue(
            'B'.($last_row +1),
            $realtotal
        );

        $this->excel->getActiveSheet()->getStyle('C'.($last_row +1))->getNumberFormat()->setFormatCode( '"$" #,##0.00' );
        $this->excel->getActiveSheet()
        ->setCellValue(
            'C'.($last_row +1),
            number_format($realtotal_usd, 2, ".", "")
        );

        $this->excel->getActiveSheet()->getStyle('D'.($last_row +1))->getNumberFormat()->setFormatCode( '#,##0.00 "LBS"' );
        $this->excel->getActiveSheet()
        ->setCellValue(
            'D'.($last_row +1),
            number_format($real_volume, 2, ".", "")
        );
        
        // $in = 3;
        // foreach($products as $product){
        //     $this->excel->getActiveSheet()
        //     ->setCellValue(
        //         $this->alphabet[$in].($last_row +1),
        //         $product->total
        //     );
        //     $this->excel->getActiveSheet()->getStyle($this->alphabet[$in].($last_row +1))->getNumberFormat()->setFormatCode( '#,##0.00 "m3"' );
        //     $in++;
        // }
        $this->excel->getActiveSheet()
        ->getStyle("A".($last_row+1).":".$last_column.($last_row+1))
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('404040');
        $this->excel->getActiveSheet()->getStyle("A".($last_row+1).":".$last_column.($last_row+1))->getFont()
                                ->getColor()->setRGB('FFFFFF');
        $this->excel->getActiveSheet()->getStyle('A2:'.$last_column."2")->getFont()->setSize(9);
        $this->excel->getActiveSheet()->getStyle('A2:A'.$last_row)->getFont()->setSize(9);

        $this->excel->getActiveSheet()->getStyle("A2:".$last_column."2")->getFont()
                                ->getColor()->setRGB('FFFFFF');
        $this->excel->getActiveSheet()
        ->getStyle("A2:".$last_column."2")
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('404040');

        $this->styleMonthly(25);
        $this->output("export_mensuel_".date("Ymd"));
    }


    public function products($customer = false){
        $this->setDates();
        $this->loadModel("Customers");
        $this->setDocument("BELGAZ Système", "BELGAZ Système", "Rapport Produits - [ De : ".$this->from." ] - [ A : ".$this->to." ]", "BELGAZ Rapport / Produits", "BELGAZ Rapport / Produits");
        if($customer != "99999"){
            $cust = $this->Customers->get($customer);
            $name = " - [ CLIENT : " . $cust->name . " ]";
        }else{
            $name = "";
        }
        $last = $this->setHeader($this->products_header, "Rapport Ventes / Produits - [ De : ".$this->from." ] - [ A : ".$this->to." ]".$name);

        $products = $this->getProducts($customer);
        $i = 3;
        $total_volume=0; $total_trips=0;
        foreach ($products as $product){
            $total_volume = $total_volume + $product['total_sold'];
            $total_trips = $total_trips + $product['total_trips'];
        }
        $cummule = 0; 
        foreach($products as $product){
            if($total_volume != 0){
                $pourcentage = $product['total_sold']*100/$total_volume; $cummule = $cummule + $pourcentage;
            }else{
               $cummule = 0; $pourcentage=0; 
            }
            $this->excel->getActiveSheet()->SetCellValue("A".$i, strtoupper($product['name'])); 
            $this->excel->getActiveSheet()->SetCellValue("B".$i, $product['total_trips']); 
            $this->excel->getActiveSheet()->SetCellValue("C".$i, number_format($product['total_sold'],2,".", "")." LBS"); 
            $this->excel->getActiveSheet()->SetCellValue("D".$i, number_format($pourcentage, 3, ".", "")."%");
            $this->excel->getActiveSheet()->SetCellValue("E".$i, number_format($cummule, 3, ".", "")."%");
            $i++; 
        }
    
        $this->styleProducts();
        $this->output("export_produits_".date("Ymd"));
    }

    private function getMonthly($from, $to){
        $conn = ConnectionManager::get('default');
        $sales = $conn->query("SELECT SUM(sp.quantity) AS total, DATE(s.created) as date, p.name as product, p.id
            FROM sales s 
            LEFT JOIN products_sales sp ON sp.sale_id = s.id 
            LEFT JOIN products p ON p.id = sp.product_id 
            WHERE s.created >='".$from."' AND s.created <= '".$to."' AND (s.status = 0 OR s.status = 1 OR s.status =4 OR s.status = 6 OR s.status = 7)
            GROUP BY DATE(s.created), sp.product_id"); 
        return $sales;
    }

    private function getMonthlyCustomers($from, $to){
        $from = $from." 00:00:00";
        $to = $to." 23:59:59";
        $conn = ConnectionManager::get('default'); $this->loadModel("Customers");
        $condition = "(o.status = 1 OR o.status = 0 OR o.status = 4 OR o.status = 6 OR o.status = 7)";
        if($this->Auth->user()['role_id'] == 6){
            $condition  ="(o.status = 0 OR o.status = 4 OR o.status =6 OR o.status = 7)";
        }
        $customers = $this->Customers->find("all", array("order" => array("first_name ASC", "last_name ASC")));
        foreach($customers as $customer){
            $customer->products = $conn->query("SELECT p.id, p.position, (SELECT  SUM(op.quantity) FROM products_sales op LEFT JOIN sales o ON o.id = op.sale_id 
                WHERE op.product_id = p.id AND o.customer_id = ".$customer->id." AND o.created >= '".$from."' AND o.created <= '".$to."' AND ".$condition."
                GROUP BY op.product_id 
                ORDER BY op.product_id) AS total_sold , (SELECT  COUNT(op.quantity) FROM products_sales op LEFT JOIN sales o ON o.id = op.sale_id 
                WHERE op.product_id = p.id AND o.customer_id = ".$customer->id." AND o.created >= '".$from."' AND o.created <= '".$to."' AND ".$condition."
                GROUP BY op.product_id 
                ORDER BY op.product_id) AS total_trips 
                FROM `products` p 
                LEFT JOIN categories c ON c.id = p.category_id
                ORDER BY p.position ASC"); 
            $customer->total = $conn->query("SELECT  SUM(o.total) as total FROM sales o WHERE o.customer_id = ".$customer->id." AND o.created >= '".$from."' AND o.created <= '".$to."' AND ".$condition."
                GROUP BY o.customer_id 
                ORDER BY o.customer_id"); 
            $customer->transport = $conn->query("SELECT  COUNT(o.transport) as transport FROM sales o WHERE o.customer_id = ".$customer->id." AND o.transport = 1 AND o.created >= '".$from."' AND o.created <= '".$to."' AND ".$condition."
                GROUP BY o.customer_id 
                ORDER BY o.customer_id"); 
        } 
        return $customers;
    }

    private function getProducts($customer){
        $conn = ConnectionManager::get('default');

        $from = $this->from." 00:00:00";
        $to = $this->to." 23:59:59";

        $condition = "(o.status = 1 OR o.status = 0 OR o.status = 4 OR o.status = 6 OR o.status = 7)";
        if($this->Auth->user()['role_id'] == 6){
            $condition  ="(o.status = 0 OR o.status = 4 OR o.status =6 OR o.status = 7)";
        }

        if($customer != "99999"){;
            $product_list = $conn->query("SELECT p.id, p.`name`, p.`cash_price`, c.name as cname, (SELECT  SUM(op.quantity) FROM products_sales op LEFT JOIN sales o ON o.id = op.sale_id 
                WHERE op.product_id = p.id AND o.customer_id = ".$customer." AND o.created >= '".$from."' AND o.created <= '".$to."' AND ".$condition."
                GROUP BY op.product_id 
                ORDER BY op.product_id) AS total_sold , (SELECT  COUNT(op.quantity) FROM products_sales op LEFT JOIN sales o ON o.id = op.sale_id 
                WHERE op.product_id = p.id AND o.customer_id = ".$customer." AND o.created >= '".$from."' AND o.created <= '".$to."' AND ".$condition."
                GROUP BY op.product_id 
                ORDER BY op.product_id) AS total_trips 
                FROM `products` p 
                LEFT JOIN categories c ON c.id = p.category_id
                ORDER BY total_sold DESC");  
        }else{
           $product_list = $conn->query("SELECT p.id, p.`name`, p.`cash_price`, c.name as cname, (SELECT  SUM(op.quantity) FROM products_sales op LEFT JOIN sales o ON o.id = op.sale_id 
                WHERE op.product_id = p.id AND o.created >= '".$from."' AND o.created <= '".$to."' AND ".$condition."
                GROUP BY op.product_id 
                ORDER BY op.product_id) AS total_sold , (SELECT  COUNT(op.quantity) FROM products_sales op LEFT JOIN sales o ON o.id = op.sale_id 
                WHERE op.product_id = p.id AND o.created >= '".$from."' AND o.created <= '".$to."' AND ".$condition."
                GROUP BY op.product_id 
                ORDER BY op.product_id) AS total_trips 
                FROM `products` p 
                LEFT JOIN categories c ON c.id = p.category_id
                ORDER BY total_sold DESC");    
        }

        return $product_list;
    }

    private function setMonthlyHeader($products, $i = 1){
        $result = array();
        if($i==3){
            $result["A"] = "CLIENT";
            $result["B"] = "TOTAL HTG";
            $result["C"] = "TOTAL USD";
            $result["D"] = "POID (LBS)";
            $i++;
        }else{
            $result["A"] = "DATE";
            $result["B"] = "TOTAL";
            $i=1;
        }
        $last = $this->alphabet[$i];
        $this->monthly_header = $result;

        return $last;

    }

    private function setDocument($creator, $modified, $title, $subject, $description){
        require_once(ROOT . DS . 'vendor' . DS  . 'PHPExcel'  . DS . 'Classes' . DS . 'PHPExcel.php');
        require_once(ROOT . DS . 'vendor' . DS  . 'PHPExcel'  . DS . 'Classes' . DS . 'PHPExcel' . DS . 'IOFactory.php');

        $this->excel = new PHPExcel();
        
        $this->excel->getProperties()->setCreator("BELGAZ")
             ->setLastModifiedBy("BELGAZ POS System")
             ->setTitle("BELGAZ Exports")
             ->setSubject("BELGAZ Exports")
             ->setDescription("BELGAZ Exports");
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('BELGAZ Sales');
    } 

    private function setHeader($header, $title){
        $last_key = "A";
        $this->excel->getActiveSheet()->SetCellValue('A1', $title);
        foreach($header as $key => $value){
            $this->excel->getActiveSheet()->SetCellValue($key."2", $value); 
            $last_key = $key;          
        }
        $this->excel->getActiveSheet()->mergeCells('A1:'.$last_key.'1');
    }

    private function styleMonthly($size){
        $styleArray = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          ),
          'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );

        $styleArray2 = array(
          'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );

        $last_row = $this->excel->getActiveSheet()->getHighestRow();
        $last_column = $this->excel->getActiveSheet()->getHighestColumn();

        $this->excel->getActiveSheet()->getStyle( "A1:".$last_column."2" )->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle( "A1:A".$last_row)->getFont()->setBold(true) ;
        $this->excel->getActiveSheet()->getStyle('A2:'.$last_column.$last_row)->applyFromArray($styleArray);
        $this->excel->getActiveSheet()->getStyle('A2:A'.$last_row)->applyFromArray($styleArray2);
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth($size);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
    }

    private function styleCustomers(){
        $styleArray = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          ),
          'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );

        $alignment = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ));

        $last_row = $this->excel->getActiveSheet()->getHighestRow();
        $last_column = $this->excel->getActiveSheet()->getHighestColumn();

        $this->excel->getActiveSheet()->getStyle( "A1:J2" )->getFont()->setBold( true );
        $this->excel->getActiveSheet()->getStyle('A1:J'.$last_row)->applyFromArray($styleArray);
        $this->excel->getActiveSheet()->getStyle('A2:A'.$last_row)->applyFromArray($alignment);
        
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(7);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(35);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(5);

        $this->excel->getActiveSheet()
            ->getPageSetup()
            ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        $this->excel->getActiveSheet()
            ->getPageMargins()->setTop(0);
        $this->excel->getActiveSheet()
            ->getPageMargins()->setRight(0);
        $this->excel->getActiveSheet()
            ->getPageMargins()->setLeft(0);
        $this->excel->getActiveSheet()
            ->getPageMargins()->setBottom(0);

        $this->excel->getActiveSheet()
            ->getPageSetup()
            ->setPrintArea('A1:J'.$last_row);
    }

    private function styleProducts(){
        $styleArray = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          ),
          'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );

        $alignment = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ));

        $last_row = $this->excel->getActiveSheet()->getHighestRow();
        $last_column = $this->excel->getActiveSheet()->getHighestColumn();

        $this->excel->getActiveSheet()->getStyle( "A1:E2" )->getFont()->setBold( true );
        $this->excel->getActiveSheet()->getStyle('A1:E'.$last_row)->applyFromArray($styleArray);
        $this->excel->getActiveSheet()->getStyle('A2:A'.$last_row)->applyFromArray($alignment);
        
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(12);

        $this->excel->getActiveSheet()
            ->getPageSetup()
            ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        $this->excel->getActiveSheet()
            ->getPageMargins()->setTop(0);
        $this->excel->getActiveSheet()
            ->getPageMargins()->setRight(0);
        $this->excel->getActiveSheet()
            ->getPageMargins()->setLeft(0);
        $this->excel->getActiveSheet()
            ->getPageMargins()->setBottom(0);

        $this->excel->getActiveSheet()
            ->getPageSetup()
            ->setPrintArea('A1:E'.$last_row);
    }

    private function styleInvoices(){
        $styleArray = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          ),
          'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );

        $this->excel->getActiveSheet()->getStyle( "A2:G2" )->getFont()->setBold( true );
        $this->excel->getActiveSheet()->getStyle("A2:G2")->getFont()
                                ->getColor()->setRGB('FFFFFF');
        $this->excel->getActiveSheet()
        ->getStyle("A2:G2")
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('404040');

        $this->excel->getActiveSheet()->getRowDimension('3')->setRowHeight(15);
        $last_row = $this->excel->getActiveSheet()->getHighestRow();
        $this->excel->getActiveSheet()->getStyle('A1:G'.$last_row)->applyFromArray($styleArray);
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(14);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(9);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(11);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(11);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(16);
        $this->excel->getActiveSheet()
            ->getPageSetup()
            ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        $this->excel->getActiveSheet()->getStyle('A1:G'.$last_row)->getFont()->setSize(12);

        $this->excel->getActiveSheet()
            ->getPageSetup()
            ->setPrintArea('A1:G'.$last_row);
    }

    private function style(){
        $styleArray = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          ),
          'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );

        $this->excel->getActiveSheet()->getStyle( "A3:M3" )->getFont()->setBold( true );
        $this->excel->getActiveSheet()->getStyle("A3:M3")->getFont()
                                ->getColor()->setRGB('FFFFFF');

        $this->excel->getActiveSheet()->getRowDimension('3')->setRowHeight(15);
        $last_row = $this->excel->getActiveSheet()->getHighestRow();
        $this->excel->getActiveSheet()->getStyle('A1:M'.$last_row)->applyFromArray($styleArray);
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(13);
        $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(13);
        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(11);
        $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(9);

        $this->excel->getActiveSheet()
            ->getPageSetup()
            ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $this->excel->getActiveSheet()
            ->getPageSetup()
            ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        $this->excel->getActiveSheet()
            ->getPageMargins()->setTop(0);
        $this->excel->getActiveSheet()
            ->getPageMargins()->setRight(0);
        $this->excel->getActiveSheet()
            ->getPageMargins()->setLeft(0);
        $this->excel->getActiveSheet()
            ->getPageMargins()->setBottom(0);

        $this->excel->getActiveSheet()
            ->getPageSetup()
            ->setPrintArea('A1:M'.$last_row);
    }


    private function styleStatus(){
        $styleArray = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          ),
          'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );

        $this->excel->getActiveSheet()->getStyle( "A1:I2" )->getFont()->setBold( true );

        $this->excel->getActiveSheet()->getRowDimension('3')->setRowHeight(15);
        $last_row = $this->excel->getActiveSheet()->getHighestRow();
        $this->excel->getActiveSheet()->getStyle('A1:I'.$last_row)->applyFromArray($styleArray);
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(16);
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(16);

        $this->excel->getActiveSheet()
            ->getPageSetup()
            ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $this->excel->getActiveSheet()
            ->getPageSetup()
            ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        $this->excel->getActiveSheet()
            ->getPageMargins()->setTop(0);
        $this->excel->getActiveSheet()
            ->getPageMargins()->setRight(0);
        $this->excel->getActiveSheet()
            ->getPageMargins()->setLeft(0);
        $this->excel->getActiveSheet()
            ->getPageMargins()->setBottom(0);

        $this->excel->getActiveSheet()
            ->getPageSetup()
            ->setPrintArea('A1:I'.$last_row);
    }

    private function output($file){
        $this->writter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file.'.xls"');
        $this->writter->save('php://output');
        die();
    }

    private function getSales($type, $customer, $user, $transactions, $transport){
        $this->loadModel("Sales");
        $from = $this->from." 00:00:00";
        $to = $this->to." 23:59:59";

        $condition = "(Sales.status = 1 OR Sales.status = 0 OR Sales.status = 4 OR Sales.status = 6 OR Sales.status = 7)";
        if($this->Auth->user()['role_id'] == 6){
            $condition  ="(Sales.status = 0 OR Sales.status = 4 OR Sales.status = 6 OR Sales.status = 7)";
        }

        if($transactions == 2){
            $condition  = "(Sales.status = 2 OR Sales.status = 3 OR Sales.status = 5 OR Sales.status = 8 OR Sales.status = 9)";
        }
        if($transport == 3){
            $condition .= "AND Sales.transport = 0 ";
        }
        if($transport == 2){
            $condition  .= "AND Sales.transport = 1 ";
        }

        if($customer != "99999"){
            $condition .= " AND Sales.customer_id = ".$customer;
        }

        if($user != "99999"){
            $condition .= " AND Sales.user_id = ".$user;
        }



        if($type == 1){
            $sales = $this->Sales->find('all', array('order' => array("Sales.created DESC"), "conditions" => array("Sales.created >=" => $from, "Sales.created <=" => $to, $condition)))->contain(['Users', 'Customers', 'Trucks', 'Pointofsales', "ProductsSales" => ['Products'], 'Receivers'])->matching('ProductsSales', function ($q) {
                    return $q->where(['ProductsSales.quantity >' => 3]);
                });
        }elseif($type == 2){
           $sales = $this->Sales->find('all', array('order' => array("Sales.created DESC"), "conditions" => array("Sales.created >=" => $from, "Sales.created <=" => $to, $condition)))->contain(['Users', 'Customers', 'Trucks', 'Pointofsales', "ProductsSales" => ['Products'], 'Receivers'])->matching('ProductsSales', function ($q) {
                    return $q->where(['ProductsSales.quantity <=' => 3]);
                });
        }else{
            $sales = $this->Sales->find('all', array('order' => array("Sales.created DESC"), "conditions" => array("Sales.created >=" => $from, "Sales.created <=" => $to, $condition)))->contain(['Users', 'Customers', 'Trucks', 'Pointofsales', 'ProductsSales'  => ['Products'], 'Receivers']);
        }

        return $sales;
    }


}
