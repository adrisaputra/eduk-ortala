<?php

namespace App\Http\Controllers;

use App\Models\Vision;   //nama model
use App\Models\Office;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class ReportController extends Controller
{
    ## Tampilkan Data Search
    public function index()
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getColumnDimension('A')->setWidth(7);  
		$sheet->getColumnDimension('B')->setWidth(7);
		$sheet->getColumnDimension('C')->setWidth(30);
		$sheet->getColumnDimension('D')->setWidth(7);
		$sheet->getColumnDimension('E')->setWidth(30);
		$sheet->getColumnDimension('F')->setWidth(7);
		$sheet->getColumnDimension('G')->setWidth(30);
		$sheet->getColumnDimension('H')->setWidth(40);
		$sheet->getColumnDimension('I')->setWidth(15);
		$sheet->getColumnDimension('J')->setWidth(15);
		$sheet->getColumnDimension('K')->setWidth(15);
		$sheet->getColumnDimension('L')->setWidth(15);
		$sheet->getColumnDimension('M')->setWidth(15);
		$sheet->getColumnDimension('N')->setWidth(15);
		$sheet->getColumnDimension('O')->setWidth(15);
		$sheet->getColumnDimension('P')->setWidth(15);
		$sheet->getColumnDimension('Q')->setWidth(15);
		$sheet->getColumnDimension('R')->setWidth(15);
		$sheet->getColumnDimension('S')->setWidth(15);
		$sheet->getColumnDimension('T')->setWidth(15);
		$sheet->getColumnDimension('U')->setWidth(15);
		$sheet->getColumnDimension('V')->setWidth(15);
		$sheet->getColumnDimension('W')->setWidth(15);
		$sheet->getColumnDimension('X')->setWidth(15);
		$sheet->getColumnDimension('Y')->setWidth(15);
		$sheet->getColumnDimension('Z')->setWidth(15);
		$sheet->getColumnDimension('AA')->setWidth(15);
		$sheet->getColumnDimension('AB')->setWidth(15);
		$sheet->getColumnDimension('AC')->setWidth(15);
		$sheet->getColumnDimension('AD')->setWidth(15);
		$sheet->getColumnDimension('AE')->setWidth(15);
		$sheet->getColumnDimension('AF')->setWidth(15);
		$sheet->getColumnDimension('AG')->setWidth(15);
		$sheet->getColumnDimension('AH')->setWidth(15);
		$sheet->getColumnDimension('AI')->setWidth(15);
		$sheet->getColumnDimension('AJ')->setWidth(15);
		$sheet->getColumnDimension('AK')->setWidth(15);
		$sheet->getColumnDimension('AL')->setWidth(15);
		$sheet->getColumnDimension('AM')->setWidth(15);
		$sheet->getColumnDimension('AN')->setWidth(15);
		$sheet->getColumnDimension('AO')->setWidth(15);
		$sheet->getColumnDimension('AP')->setWidth(15);
		$sheet->getColumnDimension('AQ')->setWidth(15);
		$sheet->getColumnDimension('AR')->setWidth(15);
		$sheet->getColumnDimension('AS')->setWidth(15);
		$sheet->getColumnDimension('AT')->setWidth(15);
		$sheet->getColumnDimension('AU')->setWidth(15);

        $sheet->setCellValue('A6', 'NO');$sheet->mergeCells('A6:A8');
        $sheet->setCellValue('B6', 'TUJUAN');$sheet->mergeCells('B6:C8');
        $sheet->setCellValue('D6', 'SASARAN');$sheet->mergeCells('D6:E8');
        $sheet->setCellValue('F6', 'PROGRAM');$sheet->mergeCells('F6:G8');
        $sheet->setCellValue('H6', 'INDIKATOR KINERJA');$sheet->mergeCells('H6:H8');
        $sheet->setCellValue('I6', 'SATUAN');$sheet->mergeCells('I6:I9');
        $sheet->setCellValue('J6', 'DATA CAPAIAN PADA AWAL TAHUN PERENCANAAN');$sheet->mergeCells('J6:J9');
        $sheet->setCellValue('K6', 'TARGET PADA AKHIR PERIODE PERENCANAAN');$sheet->mergeCells('K6:L8');

        $sheet->setCellValue('M6', 'TARGET RPJMD TAHUN KE -');$sheet->mergeCells('M6:V7');
        $sheet->setCellValue('M8', '1 (2017)');$sheet->mergeCells('M8:N8');
        $sheet->setCellValue('O8', '2 (2018)');$sheet->mergeCells('O8:P8');
        $sheet->setCellValue('Q8', '3 (2019)');$sheet->mergeCells('Q8:R8');
        $sheet->setCellValue('S8', '4 (2020)');$sheet->mergeCells('S8:T8');
        $sheet->setCellValue('U8', '5 (2021)');$sheet->mergeCells('U8:V8');

        $sheet->setCellValue('W6', 'CAPAIAN RPJMD TAHUN KE -');$sheet->mergeCells('W6:AF7');
        $sheet->setCellValue('W8', '1 (2017)');$sheet->mergeCells('W8:X8');
        $sheet->setCellValue('Y8', '2 (2018)');$sheet->mergeCells('Y8:Z8');
        $sheet->setCellValue('AA8', '3 (2019)');$sheet->mergeCells('AA8:AB8');
        $sheet->setCellValue('AC8', '4 (2020)');$sheet->mergeCells('AC8:AD8');
        $sheet->setCellValue('AE8', '5 (2021)');$sheet->mergeCells('AE8:AF8');

        $sheet->setCellValue('AG6', 'TINGKAT CAPAIAN TARGET RPJMD KABUPATEN HASIL PELAKSANAAN RKPD KABUPATEN TAHUN KE -');$sheet->mergeCells('AG6:AP7');
        $sheet->setCellValue('AG8', '1 (2017)');$sheet->mergeCells('AG8:AH8');
        $sheet->setCellValue('AI8', '2 (2018)');$sheet->mergeCells('AI8:AJ8');
        $sheet->setCellValue('AK8', '3 (2019)');$sheet->mergeCells('AK8:AL8');
        $sheet->setCellValue('AM8', '4 (2020)');$sheet->mergeCells('AM8:AN8');
        $sheet->setCellValue('AO8', '5 (2021)');$sheet->mergeCells('AO8:AP8');
        
        $sheet->setCellValue('AQ6', 'CAPAIAN PADA AKHIR TAHUN PERENCANAAN');$sheet->mergeCells('AQ6:AR8');
        $sheet->setCellValue('AS6', 'RASION CAPAIAN AKHIR (%)');$sheet->mergeCells('AS6:AT8');
        $sheet->setCellValue('AU6', 'OPD');$sheet->mergeCells('AU6:AU8');

        
        $sheet->getStyle('A6:AU8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A6:AU8')->getAlignment()->setvertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A6:AU8')->getFont()->setBold(true);
        $sheet->getStyle('A6:AU8') ->getAlignment()->setWrapText(true);



        $rows = 4;
        $no = 1;
    
        // $pegawai = Pegawai::where('status', 0)
        //             ->where('status_hapus', 0)
        //             ->get();
        
        // foreach($pegawai as $v){
        //     $sheet->setCellValue('A' . $rows, $no++);
        //     $sheet->setCellValue('B' . $rows, $v->nip);
        //     $sheet->getStyle('B' . $rows)->getNumberFormat()->setFormatCode('0');
        //     $sheet->setCellValue('C' . $rows, $v->nama_pegawai);
        //     $rows++;
        // }
        
        $sheet->getStyle('A3:C'.($rows-1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A3:C'.($rows-1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $type = 'xlsx';
        $fileName = "DATA RPJMD.".$type;

        if($type == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
        } else if($type == 'xls') {
            $writer = new Xls($spreadsheet);			
        }		
        $writer->save("public/upload/report/".$fileName);
        header("Content-Type: application/vnd.ms-excel");
        return redirect(url('/')."/public/upload/report/".$fileName);    

    }
}
