<?php

namespace App\Http\Controllers;

use App\Models\SalaryIncrease;   //nama model
use App\Models\Employee;   //nama model
use App\Http\Controllers\Controller;
use App\Models\ParentUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class SalaryIncreaseController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index(Request $request)
    {
        $title = "KGB (Kenaikan Gaji Berkala)";
        $salary_increase = SalaryIncrease::where('parent_unit_id', Auth::user()->parent_unit_id)
                                ->orderByRaw("
                                CASE 
                                    WHEN status = 'Hold' THEN 1
                                    WHEN status = 'Dikirim' THEN 2
                                    WHEN status = 'Diperbaiki' THEN 3
                                    WHEN status = 'Diterima' THEN 4
                                    WHEN status = 'Ditolak' THEN 5
                                    ELSE 6
                                END
                            ")->paginate(25)->onEachSide(1);
        
        $count_salary_increase_hold = SalaryIncrease::where('parent_unit_id', Auth::user()->parent_unit_id)
                                    ->whereIn('status',['Hold','Diperbaiki'])->count();

        $count_salary_increase_dikirim = SalaryIncrease::where('parent_unit_id', Auth::user()->parent_unit_id)
                                    ->where('status','Dikirim')->count();
    
        $count_salary_increase_accept= SalaryIncrease::where('parent_unit_id', Auth::user()->parent_unit_id)
                            ->where('status','Diterima')->count();
        
        if($request->input('page')){
            return view('admin.salary_increase.index',compact('title','salary_increase','count_salary_increase_hold','count_salary_increase_dikirim','count_salary_increase_accept'));
        } else {
            return view('admin.salary_increase.index',compact('title','salary_increase','count_salary_increase_hold','count_salary_increase_dikirim','count_salary_increase_accept'));
        }
    }

    ## Tampikan Data
    public function index_admin(Request $request, $parent_unit)
    {
        $title = "KGB (Kenaikan Gaji Berkala)";
        
        $parent_unit = Crypt::decrypt($parent_unit);
        $get_parent_unit = ParentUnit::where('id',$parent_unit)->first();

        $salary_increase = SalaryIncrease::where('parent_unit_id', $parent_unit)
                            ->whereNotIn('status',['Hold'])
                            ->orderByRaw("
                                CASE 
                                    WHEN status = 'Hold' THEN 1
                                    WHEN status = 'Dikirim' THEN 2
                                    WHEN status = 'Diperbaiki' THEN 3
                                    WHEN status = 'Diterima' THEN 4
                                    WHEN status = 'Ditolak' THEN 5
                                    ELSE 6
                                END
                            ")->paginate(25)->onEachSide(1);
        
        $count_salary_increase_hold = SalaryIncrease::where('parent_unit_id', $parent_unit)
                                    ->whereIn('status',['Hold','Diperbaiki'])->count();

        $count_salary_increase_dikirim = SalaryIncrease::where('parent_unit_id', $parent_unit)
                                        ->where('status','Dikirim')->count();
        
        $count_salary_increase_accept= SalaryIncrease::where('parent_unit_id', $parent_unit)
                                        ->where('status','Diterima')->count();
        
        return view('admin.salary_increase.index_admin',compact('title','salary_increase','count_salary_increase_hold','count_salary_increase_dikirim','count_salary_increase_accept','get_parent_unit'));
        
    }

	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "KGB (Kenaikan Gaji Berkala)";
        $salary_increase = $request->get('search');
        $salary_increase = SalaryIncrease::where('parent_unit_id', Auth::user()->parent_unit_id)
                   ->when(!empty($salary_increase), function ($query) use ($salary_increase) {
                        $query->whereHas('employee', function ($query) use ($salary_increase) {
                            $query->where('nip', 'LIKE', '%' . $salary_increase . '%')
                                ->orWhere('name', 'LIKE', '%' . $salary_increase . '%');
                        });
                    })->orderByRaw("
                        CASE 
                            WHEN status = 'Hold' THEN 1
                            WHEN status = 'Dikirim' THEN 2
                            WHEN status = 'Diperbaiki' THEN 3
                            WHEN status = 'Diterima' THEN 4
                            WHEN status = 'Ditolak' THEN 5
                            ELSE 6
                        END
                    ")->paginate(25)->onEachSide(1);
        
        $count_salary_increase_hold = SalaryIncrease::where('parent_unit_id', Auth::user()->parent_unit_id)
                    ->whereIn('status',['Hold','Diperbaiki'])
                    ->when(!empty($salary_increase), function ($query) use ($salary_increase) {
                        $query->whereHas('employee', function ($query) use ($salary_increase) {
                            $query->where('nip', 'LIKE', '%' . $salary_increase . '%')
                                ->orWhere('name', 'LIKE', '%' . $salary_increase . '%');
                        });
                    })->orderBy('id','DESC')->paginate(25)->onEachSide(1);

        $count_salary_increase_dikirim = SalaryIncrease::where('parent_unit_id', Auth::user()->parent_unit_id)
                    ->where('status','Dikirim')
                    ->when(!empty($salary_increase), function ($query) use ($salary_increase) {
                        $query->whereHas('employee', function ($query) use ($salary_increase) {
                            $query->where('nip', 'LIKE', '%' . $salary_increase . '%')
                                ->orWhere('name', 'LIKE', '%' . $salary_increase . '%');
                        });
                    })->orderBy('id','DESC')->paginate(25)->onEachSide(1);

        $count_salary_increase_accept= SalaryIncrease::where('parent_unit_id', Auth::user()->parent_unit_id)
                    ->where('status','Diterima')
                    ->when(!empty($salary_increase), function ($query) use ($salary_increase) {
                        $query->whereHas('employee', function ($query) use ($salary_increase) {
                            $query->where('nip', 'LIKE', '%' . $salary_increase . '%')
                                ->orWhere('name', 'LIKE', '%' . $salary_increase . '%');
                        });
                    })->orderBy('id','DESC')->paginate(25)->onEachSide(1);

        if($request->input('page')){
            return view('admin.salary_increase.index',compact('title','salary_increase','count_salary_increase_hold','count_salary_increase_dikirim','count_salary_increase_accept'));
        } else {
            return view('admin.salary_increase.search',compact('title','salary_increase','count_salary_increase_hold','count_salary_increase_dikirim','count_salary_increase_accept'));
        }
    }
	
	## Tampilkan Data Search
	public function search_admin(Request $request, $parent_unit)
    {
        $title = "KGB (Kenaikan Gaji Berkala)";
        
        $parent_unit = Crypt::decrypt($parent_unit);
        $get_parent_unit = ParentUnit::where('id',$parent_unit)->first();

        $salary_increase = $request->get('search');
        $salary_increase = SalaryIncrease::whereNotIn('status',['Hold'])
                            ->where('parent_unit_id', $parent_unit)
                            ->when(!empty($salary_increase), function ($query) use ($salary_increase) {
                                $query->whereHas('employee', function ($query) use ($salary_increase) {
                                    $query->where('nip', 'LIKE', '%' . $salary_increase . '%')
                                        ->orWhere('name', 'LIKE', '%' . $salary_increase . '%');
                                });
                            })->orderByRaw("
                            CASE 
                                WHEN status = 'Hold' THEN 1
                                WHEN status = 'Dikirim' THEN 2
                                WHEN status = 'Diperbaiki' THEN 3
                                WHEN status = 'Diterima' THEN 4
                                WHEN status = 'Ditolak' THEN 5
                                ELSE 6
                            END
                        ")->paginate(25)->onEachSide(1);
        
        $count_salary_increase_hold = SalaryIncrease::
                    where('parent_unit_id', $parent_unit)
                    ->whereIn('status',['Hold','Diperbaiki'])
                    ->when(!empty($salary_increase), function ($query) use ($salary_increase) {
                        $query->whereHas('employee', function ($query) use ($salary_increase) {
                            $query->where('nip', 'LIKE', '%' . $salary_increase . '%')
                                ->orWhere('name', 'LIKE', '%' . $salary_increase . '%');
                        });
                    })->count();

        $count_salary_increase_dikirim = SalaryIncrease::
                    where('parent_unit_id', $parent_unit)
                    ->where('status','Dikirim')
                    ->when(!empty($salary_increase), function ($query) use ($salary_increase) {
                        $query->whereHas('employee', function ($query) use ($salary_increase) {
                            $query->where('nip', 'LIKE', '%' . $salary_increase . '%')
                                ->orWhere('name', 'LIKE', '%' . $salary_increase . '%');
                        });
                    })->count();

        $count_salary_increase_accept= SalaryIncrease::
                    where('parent_unit_id', $parent_unit)
                    ->where('status','Diterima')
                    ->when(!empty($salary_increase), function ($query) use ($salary_increase) {
                        $query->whereHas('employee', function ($query) use ($salary_increase) {
                            $query->where('nip', 'LIKE', '%' . $salary_increase . '%')
                                ->orWhere('name', 'LIKE', '%' . $salary_increase . '%');
                        });
                    })->count();

        if($request->input('page')){
            return view('admin.salary_increase.index_admin',compact('title','salary_increase','count_salary_increase_hold','count_salary_increase_dikirim','count_salary_increase_accept','get_parent_unit'));
        } else {
            return view('admin.salary_increase.search_admin',compact('title','salary_increase','count_salary_increase_hold','count_salary_increase_dikirim','count_salary_increase_accept','get_parent_unit'));
        }
    }
	
    ## Tampilkan Form Create
    public function create()
    {
        $title = "KGB (Kenaikan Gaji Berkala)";
        $employee = Employee::where('parent_unit_id', Auth::user()->parent_unit_id)->get();
		$view=view('admin.salary_increase.create',compact('title','employee'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store(Request $request)
    {
        $this->validate($request, [
            'employee_id' => 'required'
        ]);

		$salary_increase = New SalaryIncrease();
        
        $employee = Employee::where('id',$request->employee_id)->first();
        $salary_increase->fill($request->all());
        $salary_increase->nip = $employee->nip;
        $salary_increase->parent_unit_id = Auth::user()->parent_unit_id;
        $salary_increase->old_salary = str_replace(".", "", $request->old_salary);
        $salary_increase->new_salary = str_replace(".", "", $request->new_salary);
    	$salary_increase->save();
        
        activity()->log('Tambah Data Salary Increase');
		return redirect('salary_increase')->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit($salary_increase)
    {
        $title = "KGB (Kenaikan Gaji Berkala)";
        $employee = Employee::get();
        $salary_increase = Crypt::decrypt($salary_increase);
        $salary_increase = SalaryIncrease::where('id',$salary_increase)->first();
        $view=view('admin.salary_increase.edit', compact('title','employee','salary_increase'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, $salary_increase)
    {
        
        $salary_increase = Crypt::decrypt($salary_increase);
        $salary_increase = SalaryIncrease::where('id',$salary_increase)->first();

        $this->validate($request, [
            'employee_id' => 'required'
        ]);

        
        $employee = Employee::where('id',$request->employee_id)->first();
        $salary_increase->fill($request->all());
        $salary_increase->nip = $employee->nip;
        $salary_increase->old_salary = str_replace(".", "", $request->old_salary);
        $salary_increase->new_salary = str_replace(".", "", $request->new_salary);
    	$salary_increase->save();
		
        activity()->log('Ubah Data Salary Increase dengan ID = '.$salary_increase->id);
		return redirect('salary_increase')->with('status','Data Diubah');
    }

    ## Hapus Data
    public function delete(SalaryIncrease $salary_increase)
    {
    	$salary_increase->delete();

        activity()->log('Hapus Data SalaryIncrease dengan ID = '.$salary_increase->id);
		return redirect('salary_increase')->with('status','Data Dihapus');
    }

    ## Kirim Pengajuan
    public function send($salary_increase, Request $request)
    {
        $salary_increase = Crypt::decrypt($salary_increase);
        $salary_increase = SalaryIncrease::where('id',$salary_increase)->first();

        if($request->segment(2)=="send"){
            $salary_increase->status = "Dikirim";
        } elseif($request->segment(2)=="accept"){
            $salary_increase->status = "Diterima";
        } elseif($request->segment(2)=="reject"){
            $salary_increase->status = "Ditolak";
        }
        $salary_increase->save();
		
        activity()->log('Kirim Data Salary Increase dengan ID = '.$salary_increase->id);
		return redirect('/salary_increase')->with('status', 'Data Berhasil Dikirim');
    }

    ## Kirim Pengajuan
    public function process($salary_increase, Request $request)
    {
        $salary_increase = Crypt::decrypt($salary_increase);
        $salary_increase = SalaryIncrease::where('id',$salary_increase)->first();

        if($request->segment(2)=="accept"){
            $salary_increase->status = "Diterima";
        } elseif($request->segment(2)=="reject"){
            $salary_increase->status = "Ditolak";
        }
        $salary_increase->save();
		
        activity()->log('Kirim Data SalaryIncrease dengan ID = '.$salary_increase->id);
		return redirect('/salary_increase/'.Crypt::encrypt($salary_increase->parent_unit_id).'?search=&&year='.$salary_increase->year.'&&period='.$salary_increase->period)->with('status', 'Data Berhasil Dikirim');
    }

    ## Perbaiki Pengajuan
    public function fix_document($salary_increase, Request $request)
    {
        $salary_increase = Crypt::decrypt($salary_increase);
        $salary_increase = SalaryIncrease::where('id',$salary_increase)->first();

        $salary_increase->status = "Diperbaiki";
        $salary_increase->note = $request->note;
    	$salary_increase->save();
		
        activity()->log('Kirim Data SalaryIncrease dengan ID = '.$salary_increase->id);
		return redirect('/salary_increase/'.Crypt::encrypt($salary_increase->parent_unit_id).'?search=&&year='.$salary_increase->year.'&&period='.$salary_increase->period)->with('status', 'Data Berhasil Dikirim');
    }

    ## Reload Data
    public function reload()
    {
        return view('admin.salary_increase.reload');
    }

    ## Cetak dokumen surat
    public function print($salary_increase)
    {
        $salary_increase = Crypt::decrypt($salary_increase);
        $salary_increase = SalaryIncrease::where('id',$salary_increase)->first();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(3);
        $sheet->getColumnDimension('C')->setWidth(28);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(5);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(12);

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Paid');
        $drawing->setDescription('Paid');
        $drawing->setPath(public_path('upload/setting/16782784661.png'));
        $drawing->setCoordinates('A1');
        $drawing->setWidth(65); // Atur lebar gambar ke 200 piksel
        $drawing->setHeight(65); // Atur tinggi gambar ke 100 piksel
        // $drawing->setOffsetX(20);
        // $drawing->setRotation(0);
        // $drawing->getShadow()->setVisible(true);
        // $drawing->getShadow()->setDirection(45);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        $sheet->setCellValue('A1', 'PEMERINTAH PROVINSI SULAWESI TENGGARA'); $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setSize(16);
        $sheet->setCellValue('A2', $salary_increase->parent_unit->name); $sheet->mergeCells('A2:H2');
        $sheet->getStyle('A2')->getFont()->setSize(14);
        $sheet->setCellValue('A3', 'Jl. Haluoleo Anduonohu Kompleks Bumi Praja Kantor Gubernur, Kendari 93231'); $sheet->mergeCells('A3:H3');
        $sheet->setCellValue('A4', 'Telepon (0401) . . . . . . . .,   Email . . . . . . . . . ., Website www.sultraprov.go.id'); $sheet->mergeCells('A4:H4');
        $sheet->getStyle('A1:H4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->setCellValue('A9', 'Nomor');
        $sheet->setCellValue('B9', ': '.$salary_increase->letter_number);

        $sheet->setCellValue('A10', 'Lampiran');
        $sheet->setCellValue('B10', ': '.$salary_increase->attachment);

        $sheet->setCellValue('A11', 'Perihal');
        $sheet->setCellValue('B11', ': Kenaikan Gaji Berkala');
        $sheet->setCellValue('B12', '  An.'.$salary_increase->employee->name);

        $sheet->setCellValue('F6', 'Kendari,  '.date('d-m-Y', strtotime($salary_increase->letter_date)));
        $sheet->setCellValue('F8', 'Kepada');
        $sheet->setCellValue('E9', 'Yth.');
        $sheet->setCellValue('F9', 'Kepala Badan Pengelola Keuangan');
        $sheet->setCellValue('F10', 'dan Aset Daerah Prov. Sultra');
        $sheet->setCellValue('F11', 'di -');
        $sheet->setCellValue('F12', '   K e n d a r i');

        $sheet->setCellValue('B14', '              Dengan ini diberitahukan bahwa berhubung telah dipenuhinya masa kerja dan');
        $sheet->setCellValue('B15', 'syarat-syarat lainnya kepada :');

        $sheet->setCellValue('B17', '1.');
        $sheet->setCellValue('C17', 'Nama');
        $sheet->setCellValue('D17', ': '.$salary_increase->employee->front_title.' '.$salary_increase->employee->name.' '.$salary_increase->employee->back_title);

        $sheet->setCellValue('B18', '2.');
        $sheet->setCellValue('C18', 'N i p');
        $sheet->setCellValue('D18', ': '.$salary_increase->employee->nip);

        $sheet->setCellValue('B19', '3.');
        $sheet->setCellValue('C19', 'Pangkat / Golongan');
        $sheet->setCellValue('D19', ': '.$salary_increase->employee->classes->class);

        $sheet->setCellValue('B20', '4.');
        $sheet->setCellValue('C20', 'Kantor Tempat Bekerja');
        $sheet->setCellValue('D20', ': '.$salary_increase->employee->unit->name);

        $sheet->setCellValue('B21', '5.');
        $sheet->setCellValue('C21', 'Gaji Pokok Lama');
        $sheet->setCellValue('D21', ': '.number_format($salary_increase->old_salary, 0, ',', '.') );

        $sheet->setCellValue('B30', '6.');
        $sheet->setCellValue('C30', 'Gaji Pokok Baru');
        $sheet->setCellValue('D30', ': '.number_format($salary_increase->new_salary, 0, ',', '.') );

        $sheet->setCellValue('B31', '7.');
        $sheet->setCellValue('C31', 'Berdasarkan Masa Kerja');
        $sheet->setCellValue('D31', ': '.$salary_increase->year_new_salary.' Tahun '.$salary_increase->month_new_salary.' Bulan');

        $sheet->setCellValue('B32', '8.');
        $sheet->setCellValue('C32', 'Dalam Golongan');
        $sheet->setCellValue('D32', ': '.$salary_increase->class);

        $sheet->setCellValue('B33', '9.');
        $sheet->setCellValue('C33', 'Mulai Tanggal');
        $sheet->setCellValue('D33', ': '.date('d-m-Y', strtotime($salary_increase->start_new_date)) );

        $sheet->setCellValue('B34', '10.');
        $sheet->setCellValue('C34', 'Status Pegawai Ybs');
        $sheet->setCellValue('D34', ': Pegawai Negeri Sipil Daerah');

        $sheet->setCellValue('B35', '11.');
        $sheet->setCellValue('C35', 'KGB Berikutnya');
        $sheet->setCellValue('D35', ': '.date('d-m-Y', strtotime($salary_increase->next_kgb)) );

        $sheet->setCellValue('C22', 'Atas dasar Surat Keputusan terakhir tentang Gaji/Pangkat yang ditetapkan :');
        
        $sheet->setCellValue('C23', 'a. Oleh Pejabat');
        $sheet->setCellValue('D23', ': '.$salary_increase->placeman);

        $sheet->setCellValue('C24', 'b. Tanggal');
        $sheet->setCellValue('D24', ': '.date('d-m-Y', strtotime($salary_increase->sk_date)) );

        $sheet->setCellValue('C25', 'c. Nomor');
        $sheet->setCellValue('D25', ': '.$salary_increase->sk_number);

        $sheet->setCellValue('C26', 'd. Tanggal Mulai Berlakunya');
        $sheet->setCellValue('C27', '     Gaji Tersebut');
        $sheet->setCellValue('D26', ': '.date('d-m-Y', strtotime($salary_increase->start_old_date)));

        $sheet->setCellValue('C28', 'e. Masa Kerja Golongan pada');
        $sheet->setCellValue('C29', '    tanggal tersebut');
        $sheet->setCellValue('D28', ': '.$salary_increase->year_old_salary.' Tahun '.$salary_increase->month_old_salary.' Bulan');

        $sheet->setCellValue('B37', '              Diharapkan agar sesuai Anggaran Pendapatan Belanja Daerah Provinsi Sulawesi ');
        $sheet->setCellValue('B38', 'Tenggara Tahun 2020 kepada Pegawai tersebut dapat dibayarkan penghasilannya');
        $sheet->setCellValue('B39', 'berdasarkan gaji pokok baru.');

        $sheet->setCellValue('D40', $salary_increase->parent_unit->leader_call.' '.$salary_increase->parent_unit->name);	
        $sheet->setCellValue('D41', 'PROVINSI SULAWESI TENGGARA');	
        $sheet->setCellValue('D45', $salary_increase->parent_unit->leader_name);	

        $leader = Employee::where('nip',$salary_increase->parent_unit->leader_nip)->first();
        		
        $sheet->setCellValue('D46', $leader->classes->rank.' '.$leader->classes->class);	
        $sheet->setCellValue('D47', "NIP : ".$leader->nip);	

        // $sheet->setCellValue('A16', 'NO.'); $sheet->mergeCells('A16:G16');
        // $sheet->getStyle('A15:A16')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // $sheet->setCellValue('A18', 'NO');
        // $sheet->setCellValue('B18', 'URAIAN PENGANTAR'); $sheet->mergeCells('B18:C18');
        // $sheet->setCellValue('D18', 'BANYAKNYA');
        // $sheet->setCellValue('E18', 'KETERANGAN');$sheet->mergeCells('E18:G18');
        // $sheet->getStyle('A18:G18')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // $sheet->setCellValue('A19', '1');

        // $sheet->setCellValue('B19', 'Daftar Usulan Kenaikan Pangkat periode : '.$salary_increase->period.' '.$salary_increase->year); $sheet->mergeCells('B19:C19');
        // $sheet->setCellValue('B20', 'a.n '.$salary_increase->employee->name.' dan Kawan-kawan');$sheet->mergeCells('B20:C20');
        // $sheet->mergeCells('B21:C21');
        // $sheet->mergeCells('B22:C22');
        // $sheet->mergeCells('B23:C23');
        // $sheet->mergeCells('B24:C24');
        // $sheet->mergeCells('B25:C25');
        // $sheet->mergeCells('B26:C26');
        // $sheet->mergeCells('B27:C27');

        // $sheet->setCellValue('D19', $count_salary_increase);

        // $sheet->setCellValue('E19', 'Berkas usul terdiri dari :');$sheet->mergeCells('E19:G19');
        // $sheet->setCellValue('E20', '1. FC Karpeg');$sheet->mergeCells('E20:G20');
        // $sheet->setCellValue('E21', '2. FC Karis/Karsu	');$sheet->mergeCells('E21:G21');;	
        // $sheet->setCellValue('E22', '3. SK CPNS dan Pengangkatan PNS');$sheet->mergeCells('E22:G22');	
        // $sheet->setCellValue('E23', '4. SK Pangkat Terakhir	');$sheet->mergeCells('E23:G23');
        // $sheet->setCellValue('E24', '5. SKP 2 Tahun Terakhir');$sheet->mergeCells('E24:G24');
        // $sheet->setCellValue('E25', '6. FC Ijazah Terakhir');$sheet->mergeCells('E25:G25');
        // $sheet->setCellValue('E26', '7. Bahan Kelengkapan lainnya');$sheet->mergeCells('E26:G26');
        // $sheet->setCellValue('E27', '8. Lain-Lain');$sheet->mergeCells('E27:G27');

        // $sheet->setCellValue('A30', 'Sesuai ketentuan dalam peraturan pemerintah Nomor 99 Tahun 2000 jo Peraturan Pemerintah Nomor 12 Tahun 2002, yang');	
        // $sheet->setCellValue('A31', 'bersangkutan telah memenuhi syarat untuk dapat dipertimbangkan kenaikan pangkatnya setingkat lebih tinggi.');	
        
        // $sheet->setCellValue('E34', 'Pengirim');	

        // $sheet->setCellValue('E36', $parent_unit->leader_call.' '.$parent_unit->name);	
        // $sheet->setCellValue('E37', 'PROVINSI SULAWESI TENGGARA');	
        // $sheet->setCellValue('E41', $parent_unit->leader_name);	

        // $leader = Employee::where('nip',$parent_unit->leader_nip)->first();
        		
        // $sheet->setCellValue('E42', $leader->classes->rank.' '.$leader->classes->class);	
        // $sheet->setCellValue('E43', "NIP : ".$leader->nip);	

        // $sheet->getStyle('A18:G27')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        // // $sheet->getStyle('A4:F4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // $sheet->getStyle('A1')->getFont()->setBold(true);
        // $sheet->getStyle('A2')->getFont()->setBold(true);
        // $sheet->getStyle('A15')->getFont()->setBold(true);
        // $sheet->getStyle('A18:G18')->getFont()->setBold(true);
        
        $type = 'xlsx';
        $fileName = "SURAT KENAIKAN GAJI BERKALA (".$salary_increase->employee->name.").".$type;

        if($type == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
        } else if($type == 'xls') {
            $writer = new Xls($spreadsheet);			
        }		
        $writer->save("public/upload/report/".$fileName);
        header("Content-Type: application/vnd.ms-excel");
        return redirect(url('/')."/public/upload/report/".$fileName);    

    }
    
    function getNamaBulan($bulan) {
        $bulanStr = str_pad($bulan, 2, '0', STR_PAD_LEFT);
        $namaBulan = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        );
    
        return $namaBulan[$bulanStr];
    }
}
