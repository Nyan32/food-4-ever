<?php
    session_start();
    include('../_dbconfig/dbConfig.php');
    $response = array('validasi'=>array('persetujuan' =>0,
                                        'tanggalPesanan' =>0),
                      'status'=>0);

    if(isset($_POST['id']) && isset($_POST['tanggalPesanan']) && isset($_POST['persetujuan'])){
        
        $everythingIsValidated = 1;
        
        $id = $_POST['id'];
        $tanggalPesanan = $_POST['tanggalPesanan'];
        $persetujuan = $_POST['persetujuan'];

        if($tanggalPesanan!=''){
            $response['validasi']['tanggalPesanan']=1;
        }
        else{
            $everythingIsValidated = 0;
        }

        if($persetujuan=='true'){
            $response['validasi']['persetujuan']=1;
        }
        else{
            $everythingIsValidated = 0;
        }
        
        if($everythingIsValidated==1){
            $stmt= $db->prepare('SELECT status FROM reserve_table_tb WHERE id=:id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);
            $stmt->execute();
            $status_table = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(!is_bool($status_table)){
                if($status_table['status']=='tersedia'){
                    $stmt= $db->prepare('INSERT INTO reserve_history_tb VALUES (NULL, :tanggalPesanan, NOW(), :id, (SELECT id FROM account_tb WHERE SHA2(email, 256)=:email), "tmp", "tmp")');
                    $stmt->bindParam(':tanggalPesanan', $tanggalPesanan);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);
                    $stmt->bindParam(':email', $_SESSION['userID']);
                    $stmt->execute();

                    $lastID = $db->lastInsertId();
                    $receiptCode = hash('sha256', $lastID);
                    $filename = 'receipt-'.$lastID.'.pdf';
        
                    $stmt = $db->prepare('UPDATE reserve_history_tb SET filename=:filename, receipt_code=:receiptCode WHERE id=:id');
                    $stmt->bindParam(':filename', $filename);
                    $stmt->bindParam(':receiptCode', $receiptCode);
                    $stmt->bindParam(':id', $lastID, PDO::PARAM_INT, 255);
                    $stmt->execute();
        
                    $stmt= $db->prepare('UPDATE reserve_table_tb SET status="tidak tersedia" WHERE id=:id');
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT, 255);
                    $stmt->execute();
        
                    $response['status'] = 1;
        
                    //====================================================================================
                    require_once('../_library/TCPDF-main/tcpdf.php');
        
                    $stmt = $db->prepare('SELECT * FROM reserve_history_tb a JOIN reserve_table_tb b ON a.reserve_table_id=b.id WHERE a.id=:id');
                    $stmt->bindParam(':id', $lastID, PDO::PARAM_INT, 255);
                    $stmt->execute();
                    $hisDetail = $stmt->fetch(PDO::FETCH_ASSOC);
        
                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
        
                    $pdf->SetCreator(PDF_CREATOR);
                    $pdf->SetAuthor('Food4Ever');
                    $pdf->SetTitle('Receipt Penyewaan Tempat');
                    $pdf->SetSubject('Receipt Penyewaan Tempat');
        
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
                    $html = '<h1 style="text-align:center;">Receipt</h1><hr><br>';
                    $pdf->writeHTML($html, true, false, true, false, '');
                    $pdf->SetFont($fontname, '', 12, '', false);
                    
                    $html='<p>Melalui surat ini, saya menyatakan tempat yang saya pesan,</p>
                    <table style="width:100%;border-collapse: collapse;"  cellpadding="6">
                        <tr style="width:100%;">
                            <th style="width:30%">
                                receipt no:
                            </th>
                            <th style="width:70%;">'.$hisDetail['receipt_code'].'</th>
                        </tr>
                        <tr style="width:100%;">
                            <th style="width:30%">
                                nama meja:
                            </th>
                            <th style="width:70%;">'.$hisDetail['nama_meja'].'</th>
                        </tr>
                        <tr style="width:100%;">
                            <th style="width:30%">
                                harga:
                            </th>
                            <th style="width:70%;">Rp. '.number_format($hisDetail['harga'], 0, '.', ',').'</th>
                        </tr>
                        <tr style="width:100%;">
                            <th style="width:30%">
                                kapasitas:
                            </th>
                            <th style="width:70%;">'.$hisDetail['kapasitas'].'</th>
                        </tr>
                        <tr style="width:100%;">
                            <th style="width:30%">
                                tanggal dipesan:
                            </th>
                            <th style="width:70%;">'.$hisDetail['tanggal_dipesan'].'</th>
                        </tr>
                        <tr style="width:100%;">
                            <th style="width:30%">
                                tanggal pemesanan:
                            </th>
                            <th style="width:70%;">'.$hisDetail['tanggal'].'</th>
                        </tr>
                    </table>
                    
                    <p>dapat dibatalkan jika saya tidak dapat hadir dalam 1 jam dari waktu pemesanan dan saya tidak dapat meminta pengembalian uang.</p>';
        
                    $pdf->writeHTML($html, true, false, true, false, '');
        
                    $pdf->lastPage();
        
                    $pdf->Output(dirname(__FILE__).'/../administrator/receipt/tempat/'.$hisDetail['filename'], 'F');
                }
                else{
                    $response['status'] = 2;
                }
            }
            else{
                $response['status'] = 2;
            }
        }
    }

    echo json_encode($response);
    unset($stmt);
    unset($db);
?>