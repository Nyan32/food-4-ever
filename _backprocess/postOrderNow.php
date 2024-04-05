<?php
    session_start();
    include('../_dbconfig/dbConfig.php');
    $response = array('validasi'=>array('alamat' => 0),
                      'status'=>0);

    if(isset($_SESSION['pesanan_sementara']) && count($_SESSION['pesanan_sementara'])>0 && isset($_POST['alamat'])){
        
        $everythingIsValidated = 1;
        $regexAlamat= '/^[a-z0-9.\- \/,]+$/i';

        $alamat = trim(strtoupper($_POST['alamat']));
        $pesanan = $_SESSION['pesanan_sementara'];
        $key = array_keys($pesanan);

        if($alamat!=''){
            if(preg_match($regexAlamat, $alamat)==1){
                $response['validasi']['alamat']=1;
            }
            else{
                $response['validasi']['alamat']=2;
                $everythingIsValidated = 0;
            }
        }
        else{
            $everythingIsValidated = 0;
        }
        
        if($everythingIsValidated==1){

            $stmt = $db->prepare('INSERT INTO purchase_history_tb VALUES (NULL, "tmp", NOW(), :alamat, (SELECT id FROM account_tb WHERE SHA2(email, 256)=:email), NULL)');
            $stmt->bindParam(':alamat', $alamat, PDO::PARAM_STR, 255);
            $stmt->bindParam(':email', $_SESSION['userID']);
            $stmt->execute();

            $lastID = $db->lastInsertId();
            $receiptCode = hash('sha256',$lastID);
            $filename = 'receipt-'.$lastID.'.pdf';

            $stmt = $db->prepare('UPDATE purchase_history_tb SET receipt_code=:receipt_code, filename=:filename WHERE id=:id');
            $stmt->bindParam(':receipt_code', $receiptCode);
            $stmt->bindParam(':filename', $filename);
            $stmt->bindParam(':id', $lastID, PDO::PARAM_INT, 255);
            $stmt->execute();

            for($i=0;$i<count($key);$i++){
                $ammount = $pesanan[$key[$i]];

                $stmt = $db->prepare('INSERT INTO purchase_history_detail_tb VALUES (:receipt_code, :menu_id, :jumlah)');
                $stmt->bindParam(':receipt_code', $receiptCode, PDO::PARAM_STR, 50);
                $stmt->bindParam(':menu_id', $key[$i], PDO::PARAM_INT, 255);
                $stmt->bindParam(':jumlah', $ammount, PDO::PARAM_INT, 10);
                $stmt->execute();
            }

            $_SESSION['pesanan_sementara'] = array();
            $response['status'] = 1;

            //====================================================================================
            require_once('../_library/TCPDF-main/tcpdf.php');
            
            $stmt = $db->prepare('SELECT * FROM purchase_history_detail_tb a JOIN purchase_history_tb b ON a.receipt_code = b.receipt_code JOIN menu_tb c ON a.menu_id=c.id WHERE b.id=:id');
            $stmt->bindParam(':id', $lastID, PDO::PARAM_INT, 255);
            $stmt->execute();
            $hisDetail = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Food4Ever');
            $pdf->SetTitle('Receipt Pembelian Makanan');
            $pdf->SetSubject('Receipt Pembelian Makanan');

            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                require_once(dirname(__FILE__).'/lang/eng.php');
                $pdf->setLanguageArray($l);
            }

            $fontname = TCPDF_FONTS::addTTFfont('../_library/font/overclock/Overlock-Bold.ttf', 'TrueTypeUnicode', '', 96);

            $pdf->AddPage();

            $pdf->SetFont($fontname, '', 20, '', false);
            $html = '<h1 style="text-align:center;">Receipt</h1><br>';
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->SetFont($fontname, '', 12, '', false);

            $html='
                <table style="width:100%;border-collapse: collapse;"  cellpadding="6">
                    <tr style="width:100%;">
                        <th style="width:30%">
                            Waktu Pembelian:
                        </th>
                        <th style="width:70%;">'.$hisDetail[0]['tanggal_beli'].'</th>
                    </tr>
                    <tr style="width:100%;">
                        <th style="width:30%">
                            Alamat:
                        </th>
                        <th style="width:70%;">'.$hisDetail[0]['alamat'].'</th>
                    </tr>
                    <tr style="width:100%;">
                        <th style="width:30%">
                            No. Receipt:
                        </th>
                        <th style="width:70%;">'.$hisDetail[0]['receipt_code'].'</th>
                    </tr>
                </table>
                <hr>
                <br>';
            $pdf->writeHTML($html, true, false, true, false, '');

            $html='
                <table style="width:100%;border-collapse: collapse;"  cellpadding="6">
                    <tbody>
                        <tr style="width:100%; background-color:black; color:white; text-align:center">
                            <td style="border: 1px solid black; width:12%">
                                Nominal
                            </td>
                            <td style="border: 1px solid black; width:68%">
                                Nama Makanan
                            </td>
                            <td style="border: 1px solid black; width:20%">
                                Harga
                            </td>
                        </tr>';
                $total = 0;
                for($i=0;$i<count($hisDetail);$i++){
                    $total_satuan = $hisDetail[$i]['jumlah']*$hisDetail[$i]['harga_makanan'];
                    $total = $total+$total_satuan;
                    $html .= 
                        '<tr style="width:100%; background-color:rgb(228, 228, 228); color:black;">
                            <td style="border: 1px solid black;">'.$hisDetail[$i]['jumlah'].'x</td>
                            <td style="border: 1px solid black;">'.$hisDetail[$i]['nama_makanan'].'</td>
                            <td style="border: 1px solid black;">Rp. '.number_format($total_satuan, 0, '.', ',').'</td>
                        </tr>';
                }
                $html .= 
                    '</tbody>
                </table>
                <h3>Total: Rp.'.number_format($total, 0, '.', ',').'</h3>
                ';

            $pdf->writeHTML($html, true, false, true, false, '');

            $pdf->lastPage();

            $pdf->Output(dirname(__FILE__).'/../administrator/receipt/makanan/'.$hisDetail[0]['filename'], 'F');
        }
    }
    else{
        $response['status'] = 2; 
    }

    echo json_encode($response);
    unset($stmt);
    unset($db);
?>