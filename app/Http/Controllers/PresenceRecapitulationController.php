<?php

namespace App\Http\Controllers;

use App\Helpers\DayHelpers;
use App\Helpers\MonthHelpers;
use App\Models\PresenceRecapitulation;   //nama model
use App\Http\Controllers\Controller;
use App\Models\ParentUnit;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class PresenceRecapitulationController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "Rekapitulasi Absensi";
        $parent_unit = ParentUnit::get();
        if(Auth::user()->group_id!=1){
            $presence_recapitulation = PresenceRecapitulation::
                                        where('parent_unit_id', Auth::user()->parent_unit_id)
                                        ->whereYear('date', date('Y'))
                                        ->whereMonth('date', date('m'))
                                        ->orderBy('date','DESC')->paginate(25)->onEachSide(1);
        } else {
            $presence_recapitulation = NULL;
        }
        return view('admin.presence_recapitulation.index',compact('title','presence_recapitulation','parent_unit'));
    }

	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "Rekapitulasi Absensi";
        $year = $request->get('year');
        $month = $request->get('month');
        $parent_unit_id = $request->get('parent_unit_id');
        
        $presence_recapitulation = PresenceRecapitulation::
                                    whereYear('date', $year)
                                    ->whereMonth('date', $month)
                                    ->where('parent_unit_id', $parent_unit_id)
                                    ->orderBy('id','DESC')->paginate(25)->onEachSide(1);

        if($request->input('page')){
            return view('admin.presence_recapitulation.index',compact('title','presence_recapitulation'));
        } else {
            return view('admin.presence_recapitulation.search',compact('title','presence_recapitulation'));
        }
    }
	
    ## Tampilkan Form Create
    public function create()
    {
        $title = "Rekapitulasi Absensi";
		$view=view('admin.presence_recapitulation.create',compact('title'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required',
            'employee_amount' => 'required'
        ]);

		$presence_recapitulation = New PresenceRecapitulation();
        $presence_recapitulation->fill($request->all());
        $presence_recapitulation->day =  DayHelpers::day_name(date("l", strtotime($request->date)));
        $presence_recapitulation->h = $request->employee_amount - ($request->tl + $request->ct + $request->s + $request->th);
        $presence_recapitulation->parent_unit_id = Auth::user()->parent_unit_id;
    	$presence_recapitulation->save();
        
        activity()->log('Tambah Data Presence Recapitulation');
		return redirect('/presence_recapitulation')->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit($presence_recapitulation)
    {
        $title = "Rekapitulasi Absensi";
        $presence_recapitulation = Crypt::decrypt($presence_recapitulation);
        $presence_recapitulation = PresenceRecapitulation::where('id',$presence_recapitulation)->first();
        $view=view('admin.presence_recapitulation.edit', compact('title','presence_recapitulation'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, $presence_recapitulation)
    {
        
        $presence_recapitulation = Crypt::decrypt($presence_recapitulation);
        $presence_recapitulation = PresenceRecapitulation::where('id',$presence_recapitulation)->first();

        $this->validate($request, [
            'date' => 'required',
            'employee_amount' => 'required'
        ]);

        $presence_recapitulation->fill($request->all());
        $presence_recapitulation->day =  DayHelpers::day_name(date("l", strtotime($request->date)));
        $presence_recapitulation->h = $request->employee_amount - ($request->tl + $request->ct + $request->s + $request->th);
    	$presence_recapitulation->save();
		
        activity()->log('Ubah Data Presence Recapitulation dengan ID = '.$presence_recapitulation->id);
		return redirect('/presence_recapitulation')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete(PresenceRecapitulation $presence_recapitulation)
    {
		$presence_recapitulation->delete();

        activity()->log('Hapus Data Presence Recapitulation dengan ID = '.$presence_recapitulation->id);
        return redirect('/presence_recapitulation')->with('status', 'Data Berhasil Dihapus');
    }

    ## Cetak Data
    public function print(Request $request)
    {
        
        $parent_unit_id = $request->get('parent_unit_id');
        $year = $request->get('year');
        $month = $request->get('month');

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
 
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->getColumnDimension('H')->setWidth(33);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(20);
        
        $sheet->setCellValue('A1', 'DAFTAR REKAPITULASI ABSENSI LAPANGAN (APEL/PAGI) ASN LINGKUP SETDA PROV. SULTRA'); $sheet->mergeCells('A1:J1');
        $sheet->setCellValue('A2', 'BULAN '.MonthHelpers::month_name($month).' TAHUN '.$year); $sheet->mergeCells('A2:J2');

        $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:J2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $parent_unit = ParentUnit::where('id',$parent_unit_id)->first();
        $sheet->setCellValue('A4', $parent_unit->name); 

        $sheet->getStyle('A6:J6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A6:J7')->getFont()->setBold(true);

        $sheet->setCellValue('A6', 'NO');$sheet->mergeCells('A6:A7');
        $sheet->setCellValue('B6', 'HARI/TANGGAL');$sheet->mergeCells('B6:B7');
        $sheet->setCellValue('C6', 'JUMLAH ASN');$sheet->mergeCells('C6:C7');
        $sheet->setCellValue('D6', 'LAPORAN');$sheet->mergeCells('D6:I6');
        $sheet->setCellValue('J6', 'KETERANGAN');$sheet->mergeCells('J6:J7');

        $sheet->setCellValue('D7', 'TL');
        $sheet->setCellValue('E7', 'CUTI');
        $sheet->setCellValue('F7', 'SAKIT');
        $sheet->setCellValue('G7', 'HADIR');
        $sheet->setCellValue('H7', 'TANPA KETERANGAN (TIDAK HADIR)');
        $sheet->setCellValue('I7', 'RATA-RATA HADIR (%)');

        $rows = 8;
        $no = 1;

        $presence_recapitulation = PresenceRecapitulation::
                                    whereYear('date', $year)
                                    ->whereMonth('date', $month)
                                    ->where('parent_unit_id', $parent_unit_id)
                                    ->orderBy('id','DESC')->get();

        foreach($presence_recapitulation as $i => $v){
            
            $x = $v->h; 
            $persentase = ($x/$v->employee_amount)*100;

            $sheet->setCellValue('A' . $rows, $no++);
            $sheet->setCellValue('B' . $rows, $v->day.' / '.date('d-m-Y', strtotime($v->date)) );
            
            $sheet->setCellValue('C' . $rows, $v->employee_amount);
            $sheet->getStyle('C' . $rows)->getNumberFormat()->setFormatCode('0');

            $sheet->setCellValue('D' . $rows, $v->tl);
            $sheet->getStyle('D' . $rows)->getNumberFormat()->setFormatCode('0');

            $sheet->setCellValue('E' . $rows, $v->ct);
            $sheet->getStyle('E' . $rows)->getNumberFormat()->setFormatCode('0');

            $sheet->setCellValue('F' . $rows, $v->s);
            $sheet->getStyle('F' . $rows)->getNumberFormat()->setFormatCode('0');

            $sheet->setCellValue('G' . $rows, $v->h);
            $sheet->getStyle('G' . $rows)->getNumberFormat()->setFormatCode('0');

            $sheet->setCellValue('H' . $rows, $v->th);
            $sheet->getStyle('H' . $rows)->getNumberFormat()->setFormatCode('0');

            $sheet->setCellValue('I' . $rows, number_format($persentase, 2)." %");

            $sheet->setCellValue('J' . $rows, $v->desc);

            $rows++;
        }
        
        // $sheet->getStyle('F' . $rows)->getNumberFormat()->setFormatCode('#,##0');
        // $sheet->getStyle('A' . $rows.':F4'. $rows)->getFont()->setBold(true);

        $sheet->getStyle('A6:J'.($rows-1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        // $sheet->getStyle('A4:F4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // $sheet->getStyle('A1:F4')->getFont()->setBold(true);
        
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
}
