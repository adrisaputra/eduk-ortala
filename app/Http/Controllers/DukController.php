<?php

namespace App\Http\Controllers;

use App\Models\Unit;   //nama model
use App\Models\Employee;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Carbon\Carbon;

class DukController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }

    ## Tampikan Data
    public function index()
    {
        $title = "DUK";
        $unit = Unit::orderBy('id','DESC')->get();
        $employee = Employee::select('employees.*')
                    ->leftJoin('classes', 'employees.class_id', '=', 'classes.id')
                    ->leftJoin('class_histories', 'class_histories.classes_id', '=', 'classes.id')
                    ->groupBy('employees.nip')
                    ->orderBy('class_id','DESC')
                    ->orderBy('class_histories.tmt','DESC')
                    ->orderBy('unit_id','ASC')
                    ->orderBy('class_histories.mk_month','DESC')
                    ->orderBy('date_of_birth','ASC')
                    ->paginate(25)->onEachSide(1);
        $masa_kerja = array();
        $usia = array();

        foreach($employee as $i => $v){
            if($v->class_history_first($v->nip)->first()){
                $masa_kerja[$i] = $this->hitungSelisihBulan($v->class_history_first($v->nip)->first()->tmt);
            } else {
                $masa_kerja[$i]['tahun'] = "-";
                $masa_kerja[$i]['bulan'] = "-";
            }
            $usia[$i] = $this->hitungUsia($v->date_of_birth);
        }

        return view('admin.duk.index',compact('title','unit','employee','masa_kerja','usia'));

    }

    ## Tampilkan Data Search
    public function search(Request $request)
    {
        $title = "Unit Organisasi";
        $unit = Unit::orderBy('id','DESC')->get();
        $employee = $request->get('search');
        $employee = Employee::select('employees.*')
                    ->leftJoin('classes', 'employees.class_id', '=', 'classes.id')
                    ->leftJoin('class_histories', 'class_histories.classes_id', '=', 'classes.id')
                    ->where(function ($query) use ($employee) {
                        $query->where('employees.nip', 'LIKE', '%'.$employee.'%')
                            ->orWhere('employees.name', 'LIKE', '%'.$employee.'%');
                    })->groupBy('employees.nip')
                    ->orderBy('class_id','DESC')
                    ->orderBy('class_histories.tmt','DESC')
                    ->orderBy('unit_id','ASC')
                    ->orderBy('class_histories.mk_month','DESC')
                    ->orderBy('date_of_birth','ASC')
                    ->paginate(25)->onEachSide(1);
        $masa_kerja = array();
        $usia = array();
        
                
        foreach($employee as $i => $v){
            if($v->class_history_first($v->nip)->first()){
                $masa_kerja[$i] = $this->hitungSelisihBulan($v->class_history_first($v->nip)->first()->tmt);
            } else {
                $masa_kerja[$i]['tahun'] = "-";
                $masa_kerja[$i]['bulan'] = "-";
            }
            $usia[$i] = $this->hitungUsia($v->date_of_birth);
        }
        
        if($request->input('page')){
            return view('admin.duk.index',compact('title','unit','employee','masa_kerja','usia'));
        } else {
            return view('admin.duk.search',compact('title','unit','employee','masa_kerja','usia'));
        }
    }

    ## Tampilkan Data Search
    public function print(Request $request)
    {
        
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
 
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(7);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(16);
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->getColumnDimension('H')->setWidth(7);
        $sheet->getColumnDimension('I')->setWidth(7);
        $sheet->getColumnDimension('J')->setWidth(16);
        $sheet->getColumnDimension('K')->setWidth(7);
        $sheet->getColumnDimension('L')->setWidth(7);
        $sheet->getColumnDimension('M')->setWidth(60);
        $sheet->getColumnDimension('N')->setWidth(10);
        $sheet->getColumnDimension('O')->setWidth(22);
        $sheet->getColumnDimension('P')->setWidth(25);
        $sheet->getColumnDimension('Q')->setWidth(10);
        $sheet->getColumnDimension('R')->setWidth(7);
        $sheet->getColumnDimension('S')->setWidth(10);

        $sheet->setCellValue('A1', 'DATA DUK'); $sheet->mergeCells('A1:S1');
        $sheet->getStyle('A1:S1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A4:S6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A4:S6')->getFont()->setBold(true);

        $sheet->setCellValue('A4', 'NO');$sheet->mergeCells('A4:A5');
        $sheet->setCellValue('B4', 'NIP');$sheet->mergeCells('B4:B5');
        $sheet->setCellValue('C4', 'NAMA');$sheet->mergeCells('C4:C5');

        $sheet->setCellValue('D4', 'PANGKAT');$sheet->mergeCells('D4:E4');
        $sheet->setCellValue('D5', 'GOL.');
        $sheet->setCellValue('E5', 'TMT');

        $sheet->setCellValue('F4', 'JABATAN');$sheet->mergeCells('F4:G4');
        $sheet->setCellValue('F5', 'NAMA (ESELON)');
        $sheet->setCellValue('G5', 'TMT');

        $sheet->setCellValue('H4', 'MASA KERJA');$sheet->mergeCells('H4:I4');
        $sheet->setCellValue('H5', 'TAHUN');
        $sheet->setCellValue('I5', 'BULAN');

        $sheet->setCellValue('J4', 'LPJ');$sheet->mergeCells('J4:L4');
        $sheet->setCellValue('J5', 'NAMA');
        $sheet->setCellValue('K5', 'TAHUN');
        $sheet->setCellValue('L5', 'JUMLAH');

        $sheet->setCellValue('M4', 'PENDIDIKAN');$sheet->mergeCells('M4:O4');
        $sheet->setCellValue('M5', 'NAMA');
        $sheet->setCellValue('N5', 'LULUS');
        $sheet->setCellValue('O5', 'TINGKAT');

        $sheet->setCellValue('P4', 'LAHIR');$sheet->mergeCells('P4:R4');
        $sheet->setCellValue('P5', 'TEMPAT');
        $sheet->setCellValue('Q5', 'TANGGAL');
        $sheet->setCellValue('R5', 'USIA');
        
        $sheet->setCellValue('S4', 'KET.');$sheet->mergeCells('S4:S4');

        $sheet->setCellValue('A6', '1');
        $sheet->setCellValue('B6', '2');
        $sheet->setCellValue('C6', '3');
        $sheet->setCellValue('D6', '4');
        $sheet->setCellValue('E6', '5');
        $sheet->setCellValue('F6', '6');
        $sheet->setCellValue('G6', '7');
        $sheet->setCellValue('H6', '8');
        $sheet->setCellValue('I6', '9');
        $sheet->setCellValue('J6', '10');
        $sheet->setCellValue('K6', '11');
        $sheet->setCellValue('L6', '12');
        $sheet->setCellValue('M6', '13');
        $sheet->setCellValue('N6', '14');
        $sheet->setCellValue('O6', '15');
        $sheet->setCellValue('P6', '16');
        $sheet->setCellValue('Q6', '17');
        $sheet->setCellValue('R6', '18');
        $sheet->setCellValue('S6', '19');
        
        $rows = 7;
        $no = 1;

        $employee = Employee::select('employees.*')
                    ->leftJoin('classes', 'employees.class_id', '=', 'classes.id')
                    ->leftJoin('class_histories', 'class_histories.classes_id', '=', 'classes.id')
                    ->groupBy('employees.nip')
                    ->orderBy('class_id','DESC')
                    ->orderBy('class_histories.tmt','DESC')
                    ->orderBy('unit_id','ASC')
                    ->orderBy('class_histories.mk_month','DESC')
                    ->orderBy('date_of_birth','ASC')->get();
        $masa_kerja = array();
        $usia = array();

        foreach($employee as $i => $v){
            
            if($v->class_history_first($v->nip)->first()){
                $masa_kerja[$i] = $this->hitungSelisihBulan($v->class_history_first($v->nip)->first()->tmt);
            } else {
                $masa_kerja[$i]['tahun'] = "-";
                $masa_kerja[$i]['bulan'] = "-";
            }
            $usia[$i] = $this->hitungUsia($v->date_of_birth);

            $sheet->setCellValue('A' . $rows, $no++);
            $sheet->setCellValue('B' . $rows, "'".$v->nip);
            $sheet->getStyle('B' . $rows)->getNumberFormat()->setFormatCode('0');
            $sheet->setCellValue('C' . $rows, $v->front_title.' '.$v->name.' '.$v->back_title);
            $sheet->setCellValue('D' . $rows, $v->classes ? $v->classes->class : '');
            $sheet->setCellValue('E' . $rows, $v->classes && $v->classes->class_history($v->nip)->first() ? date('d-m-Y', strtotime($v->classes->class_history($v->nip)->first()->tmt)) : '');
            $sheet->setCellValue('F' . $rows, $v->position_history($v->nip)->first() ? $v->position_history($v->nip)->first()->position : '');
            $sheet->setCellValue('G' . $rows, $v->position_history($v->nip)->first() ? date('d-m-Y', strtotime($v->position_history($v->nip)->first()->tmt)) : '');
            $sheet->setCellValue('H' . $rows, $masa_kerja[$i]['tahun']);
            $sheet->setCellValue('I' . $rows, $masa_kerja[$i]['bulan']);
            $sheet->setCellValue('J' . $rows, $v->training_history_first($v->nip)->first() ? $v->training_history_first($v->nip)->first()->name : '');
            $sheet->setCellValue('K' . $rows, $v->training_history_first($v->nip)->first() ? date('d-m-Y', strtotime($v->training_history_first($v->nip)->first()->start)) : '');
            $sheet->setCellValue('L' . $rows, $v->training_history_first($v->nip)->first() ? $v->training_history_first($v->nip)->first()->hours : '');
            $sheet->setCellValue('M' . $rows, $v->education_history_last($v->nip)->first() ? $v->education_history_last($v->nip)->first()->education->name : '');
            $sheet->setCellValue('N' . $rows, $v->education_history_last($v->nip)->first() ? date('d-m-Y', strtotime($v->education_history_last($v->nip)->first()->diploma_date)) : '');
            $sheet->setCellValue('O' . $rows, $v->education_history_last($v->nip)->first() ? $v->education_history_last($v->nip)->first()->level : '');
            $sheet->setCellValue('P' . $rows, $v->birthplace);
            $sheet->setCellValue('Q' . $rows, date('d-m-Y', strtotime($v->date_of_birth )));
            $sheet->setCellValue('R' . $rows, $usia[$i]);
            $sheet->setCellValue('S' . $rows, $v->status);

            // $sheet->getStyle('A' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            // $sheet->setCellValue('B' . $rows, date('d-m-Y', strtotime($v->updated_at)));
            // $sheet->getStyle('B' . $rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            // $sheet->setCellValue('C' . $rows, $v->cart->product->name);
           
            $rows++;
        }
        
        // $sheet->getStyle('F' . $rows)->getNumberFormat()->setFormatCode('#,##0');
        // $sheet->getStyle('A' . $rows.':F4'. $rows)->getFont()->setBold(true);

        $sheet->getStyle('A4:S'.$rows)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A4:F4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:F4')->getFont()->setBold(true);
        
        $type = 'xlsx';
        $fileName = "DATA DUK.".$type;

        if($type == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
        } else if($type == 'xls') {
            $writer = new Xls($spreadsheet);			
        }		
        $writer->save("public/upload/report/".$fileName);
        header("Content-Type: application/vnd.ms-excel");
        return redirect(url('/')."/public/upload/report/".$fileName);    

    }


    function hitungSelisihBulan($tanggalAkhir)
    {
        $res = array();

        $awal = Carbon::now()->startOfMonth();
        $akhir = Carbon::parse($tanggalAkhir)->startOfMonth();

        $selisih = $akhir->diffInMonths($awal);

        $selisihTahun = floor($selisih / 12);
        $selisihBulan = $selisih % 12;

        $res['tahun'] = $selisihTahun;
        $res['bulan'] = $selisihBulan;

        return $res;
    }

    function hitungUsia($tanggalLahir)
    {
        $tanggalLahir = Carbon::parse($tanggalLahir);
        $usia = $tanggalLahir->age;

        return $usia;
    }

}
