<?php

namespace App\Http\Controllers;

use App\Models\Promotion;   //nama model
use App\Models\Employee;   //nama model
use App\Http\Controllers\Controller;
use App\Models\ParentUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class PromotionController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index(Request $request)
    {
        $title = "Naik Pangkat";
        if($request->get('year')){
            $title = "Naik Pangkat";
            $year = $request->get('year');
            $period = $request->get('period');
            $promotion = $request->get('search');
            $promotion = Promotion::where('parent_unit_id', Auth::user()->parent_unit_id)
                        ->where(function ($query) use ($year) {
                            $query->where('year', $year);
                        })
                        ->where(function ($query) use ($period) {
                            $query->where('period', $period);
                        })
                        ->when(!empty($promotion), function ($query) use ($promotion) {
                            $query->whereHas('employee', function ($query) use ($promotion) {
                                $query->where('name', 'LIKE', '%' . $promotion . '%')
                                    ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                            });
                        })->orderBy('id','DESC')->paginate(25)->onEachSide(1);
            
            $count_promotion_hold = Promotion::where('parent_unit_id', Auth::user()->parent_unit_id)
                        ->whereIn('status',['Hold','Diperbaiki'])
                        ->where(function ($query) use ($year) {
                            $query->where('year', $year);
                        })
                        ->where(function ($query) use ($period) {
                            $query->where('period', $period);
                        })
                        ->when(!empty($promotion), function ($query) use ($promotion) {
                            $query->whereHas('employee', function ($query) use ($promotion) {
                                $query->where('name', 'LIKE', '%' . $promotion . '%')
                                    ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                            });
                        })->count();

            $count_promotion_dikirim = Promotion::where('parent_unit_id', Auth::user()->parent_unit_id)
                        ->where('status','Dikirim')
                        ->where(function ($query) use ($year) {
                            $query->where('year', $year);
                        })
                        ->where(function ($query) use ($period) {
                            $query->where('period', $period);
                        })
                        ->when(!empty($promotion), function ($query) use ($promotion) {
                            $query->whereHas('employee', function ($query) use ($promotion) {
                                $query->where('name', 'LIKE', '%' . $promotion . '%')
                                    ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                            });
                        })->count();
            
            $count_promotion_accept= Promotion::where('parent_unit_id', Auth::user()->parent_unit_id)
                        ->where('status','Diterima')
                        ->where(function ($query) use ($year) {
                            $query->where('year', $year);
                        })
                        ->where(function ($query) use ($period) {
                            $query->where('period', $period);
                        })
                        ->when(!empty($promotion), function ($query) use ($promotion) {
                            $query->whereHas('employee', function ($query) use ($promotion) {
                                $query->where('name', 'LIKE', '%' . $promotion . '%')
                                    ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                            });
                        })->count();
            
            if($request->input('page')){
                return view('admin.promotion.index',compact('title','promotion','count_promotion_hold','count_promotion_dikirim','count_promotion_accept'));
            } else {
                return view('admin.promotion.index',compact('title','promotion','count_promotion_hold','count_promotion_dikirim','count_promotion_accept'));
            }
        } else {
            
            return view('admin.promotion.index',compact('title'));
        } 
    }

    ## Tampikan Data
    public function index_admin(Request $request, $parent_unit)
    {
        $title = "Naik Pangkat";
        
        $parent_unit = Crypt::decrypt($parent_unit);
        $get_parent_unit = ParentUnit::where('id',$parent_unit)->first();

        if($request->get('year')){
            $title = "Naik Pangkat";
            $year = $request->get('year');
            $period = $request->get('period');
            $promotion = $request->get('search');
            $promotion = Promotion::
                        where('parent_unit_id', $parent_unit)
                        ->where(function ($query) use ($year) {
                            $query->where('year', $year);
                        })
                        ->where(function ($query) use ($period) {
                            $query->where('period', $period);
                        })
                        ->when(!empty($promotion), function ($query) use ($promotion) {
                            $query->whereHas('employee', function ($query) use ($promotion) {
                                $query->where('name', 'LIKE', '%' . $promotion . '%')
                                    ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                            });
                        })->orderBy('id','DESC')->paginate(25)->onEachSide(1);
            
            $count_promotion_hold = Promotion::
                        where('parent_unit_id', $parent_unit)
                        ->whereIn('status',['Hold','Diperbaiki'])
                        ->where(function ($query) use ($year) {
                            $query->where('year', $year);
                        })
                        ->where(function ($query) use ($period) {
                            $query->where('period', $period);
                        })
                        ->when(!empty($promotion), function ($query) use ($promotion) {
                            $query->whereHas('employee', function ($query) use ($promotion) {
                                $query->where('name', 'LIKE', '%' . $promotion . '%')
                                    ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                            });
                        })->count();

            $count_promotion_dikirim = Promotion::
                        where('parent_unit_id', $parent_unit)
                        ->where('status','Dikirim')
                        ->where(function ($query) use ($year) {
                            $query->where('year', $year);
                        })
                        ->where(function ($query) use ($period) {
                            $query->where('period', $period);
                        })
                        ->when(!empty($promotion), function ($query) use ($promotion) {
                            $query->whereHas('employee', function ($query) use ($promotion) {
                                $query->where('name', 'LIKE', '%' . $promotion . '%')
                                    ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                            });
                        })->count();
            
            $count_promotion_accept= Promotion::
                        where('parent_unit_id', $parent_unit)
                        ->where('status','Diterima')
                        ->where(function ($query) use ($year) {
                            $query->where('year', $year);
                        })
                        ->where(function ($query) use ($period) {
                            $query->where('period', $period);
                        })
                        ->when(!empty($promotion), function ($query) use ($promotion) {
                            $query->whereHas('employee', function ($query) use ($promotion) {
                                $query->where('name', 'LIKE', '%' . $promotion . '%')
                                    ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                            });
                        })->count();
            
            if($request->input('page')){
                return view('admin.promotion.index_admin',compact('title','promotion','count_promotion_hold','count_promotion_dikirim','count_promotion_accept','get_parent_unit'));
            } else {
                return view('admin.promotion.index_admin',compact('title','promotion','count_promotion_hold','count_promotion_dikirim','count_promotion_accept','get_parent_unit'));
            }
        } else {
            
            return view('admin.promotion.index_admin',compact('title','get_parent_unit'));
        } 
    }

	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "Naik Pangkat";
        $year = $request->get('year');
        $period = $request->get('period');
        $promotion = $request->get('search');
        $promotion = Promotion::where('parent_unit_id', Auth::user()->parent_unit_id)
                    ->where(function ($query) use ($year) {
                        $query->where('year', $year);
                    })
                    ->where(function ($query) use ($period) {
                        $query->where('period', $period);
                    })
                    ->when(!empty($promotion), function ($query) use ($promotion) {
                        $query->whereHas('employee', function ($query) use ($promotion) {
                            $query->where('name', 'LIKE', '%' . $promotion . '%')
                                ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                        });
                    })->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        $count_promotion_hold = Promotion::where('parent_unit_id', Auth::user()->parent_unit_id)
                    ->whereIn('status',['Hold','Diperbaiki'])
                    ->where(function ($query) use ($year) {
                        $query->where('year', $year);
                    })
                    ->where(function ($query) use ($period) {
                        $query->where('period', $period);
                    })
                    ->when(!empty($promotion), function ($query) use ($promotion) {
                        $query->whereHas('employee', function ($query) use ($promotion) {
                            $query->where('name', 'LIKE', '%' . $promotion . '%')
                                ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                        });
                    })->count();

        $count_promotion_dikirim = Promotion::where('parent_unit_id', Auth::user()->parent_unit_id)
                    ->where('status','Dikirim')
                    ->where(function ($query) use ($year) {
                        $query->where('year', $year);
                    })
                    ->where(function ($query) use ($period) {
                        $query->where('period', $period);
                    })
                    ->when(!empty($promotion), function ($query) use ($promotion) {
                        $query->whereHas('employee', function ($query) use ($promotion) {
                            $query->where('name', 'LIKE', '%' . $promotion . '%')
                                ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                        });
                    })->count();

        $count_promotion_accept= Promotion::where('parent_unit_id', Auth::user()->parent_unit_id)
                    ->where('status','Diterima')
                    ->where(function ($query) use ($year) {
                        $query->where('year', $year);
                    })
                    ->where(function ($query) use ($period) {
                        $query->where('period', $period);
                    })
                    ->when(!empty($promotion), function ($query) use ($promotion) {
                        $query->whereHas('employee', function ($query) use ($promotion) {
                            $query->where('name', 'LIKE', '%' . $promotion . '%')
                                ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                        });
                    })->count();

        if($request->input('page')){
            return view('admin.promotion.index',compact('title','promotion','count_promotion_hold','count_promotion_dikirim','count_promotion_accept'));
        } else {
            return view('admin.promotion.search',compact('title','promotion','count_promotion_hold','count_promotion_dikirim','count_promotion_accept'));
        }
    }
	
	## Tampilkan Data Search
	public function search_admin(Request $request, $parent_unit)
    {
        $title = "Naik Pangkat";
        
        $parent_unit = Crypt::decrypt($parent_unit);
        $get_parent_unit = ParentUnit::where('id',$parent_unit)->first();

        $year = $request->get('year');
        $period = $request->get('period');
        $promotion = $request->get('search');
        $promotion = Promotion::
                    whereNotIn('status',['Hold'])
                    ->where('parent_unit_id', $parent_unit)
                    ->where(function ($query) use ($year) {
                        $query->where('year', $year);
                    })
                    ->where(function ($query) use ($period) {
                        $query->where('period', $period);
                    })
                    ->when(!empty($promotion), function ($query) use ($promotion) {
                        $query->whereHas('employee', function ($query) use ($promotion) {
                            $query->where('name', 'LIKE', '%' . $promotion . '%')
                                ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                        });
                    })->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        $count_promotion_hold = Promotion::
                    where('parent_unit_id', $parent_unit)
                    ->whereIn('status',['Hold','Diperbaiki'])
                    ->where(function ($query) use ($year) {
                        $query->where('year', $year);
                    })
                    ->where(function ($query) use ($period) {
                        $query->where('period', $period);
                    })
                    ->when(!empty($promotion), function ($query) use ($promotion) {
                        $query->whereHas('employee', function ($query) use ($promotion) {
                            $query->where('name', 'LIKE', '%' . $promotion . '%')
                                ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                        });
                    })->count();

        $count_promotion_dikirim = Promotion::
                    where('parent_unit_id', $parent_unit)
                    ->where('status','Dikirim')
                    ->where(function ($query) use ($year) {
                        $query->where('year', $year);
                    })
                    ->where(function ($query) use ($period) {
                        $query->where('period', $period);
                    })
                    ->when(!empty($promotion), function ($query) use ($promotion) {
                        $query->whereHas('employee', function ($query) use ($promotion) {
                            $query->where('name', 'LIKE', '%' . $promotion . '%')
                                ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                        });
                    })->count();

        $count_promotion_accept= Promotion::
                    where('parent_unit_id', $parent_unit)
                    ->where('status','Diterima')
                    ->where(function ($query) use ($year) {
                        $query->where('year', $year);
                    })
                    ->where(function ($query) use ($period) {
                        $query->where('period', $period);
                    })
                    ->when(!empty($promotion), function ($query) use ($promotion) {
                        $query->whereHas('employee', function ($query) use ($promotion) {
                            $query->where('name', 'LIKE', '%' . $promotion . '%')
                                ->orWhere('name', 'LIKE', '%' . $promotion . '%');
                        });
                    })->count();

        if($request->input('page')){
            return view('admin.promotion.index_admin',compact('title','promotion','count_promotion_hold','count_promotion_dikirim','count_promotion_accept','get_parent_unit'));
        } else {
            return view('admin.promotion.search_admin',compact('title','promotion','count_promotion_hold','count_promotion_dikirim','count_promotion_accept','get_parent_unit'));
        }
    }
	
    ## Tampilkan Form Create
    public function create()
    {
        $title = "Naik Pangkat";
        $employee = Employee::where('parent_unit_id', Auth::user()->parent_unit_id)->get();
		$view=view('admin.promotion.create',compact('title','employee'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store(Request $request)
    {
        $this->validate($request, [
            'employee_id' => 'required',
            'promotion_type' => 'required'
        ]);

		$promotion = New Promotion();
        
        $employee = Employee::where('id',$request->employee_id)->first();
        $promotion->fill($request->all());
        $promotion->nip = $employee->nip;
        $promotion->parent_unit_id = Auth::user()->parent_unit_id;
    	$promotion->save();
        
        activity()->log('Tambah Data Promotion');
		return redirect('/promotion?year='.$request->year.'&&period='.$request->period)->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit($promotion)
    {
        $title = "Naik Pangkat";
        $employee = Employee::get();
        $promotion = Crypt::decrypt($promotion);
        $promotion = Promotion::where('id',$promotion)->first();
        $view=view('admin.promotion.edit', compact('title','employee','promotion'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, $promotion)
    {
        
        $promotion = Crypt::decrypt($promotion);
        $promotion = Promotion::where('id',$promotion)->first();

        $this->validate($request, [
            'employee_id' => 'required',
            'promotion_type' => 'required'
        ]);

        
        $employee = Employee::where('id',$request->employee_id)->first();
        $promotion->fill($request->all());
        $promotion->nip = $employee->nip;
    	$promotion->save();
		
        activity()->log('Ubah Data Promotion dengan ID = '.$promotion->id);
		return redirect('/promotion?year='.$request->year.'&&period='.$request->period)->with('status','Data Diubah');
    }

    ## Hapus Data
    public function delete(Promotion $promotion)
    {
    	$promotion->delete();

        activity()->log('Hapus Data Promotion dengan ID = '.$promotion->id);
		return redirect('/promotion?year='.$promotion->year.'&&period='.$promotion->period)->with('status','Data Dihapus');
    }

    ## Kirim Pengajuan
    public function send($year, $period, Request $request)
    {
        $promotion = Promotion::where('parent_unit_id',Auth::user()->parent_unit_id)->where('year',$year)->where('period',$period)->get();

        foreach($promotion as $v){
            $promotion = Promotion::where('id',$v->id)->first();
            if($request->segment(2)=="send"){
                $promotion->status = "Dikirim";
            } elseif($request->segment(2)=="accept"){
                $promotion->status = "Diterima";
            } elseif($request->segment(2)=="reject"){
                $promotion->status = "Ditolak";
            }
            $promotion->save();
        }
		
        activity()->log('Kirim Data Promotion dengan ID = '.$promotion->id);
		return redirect('/promotion?search=&&year='.$year.'&&period='.$period)->with('status', 'Data Berhasil Dikirim');
    }

    ## Kirim Pengajuan
    public function process($promotion, Request $request)
    {
        $promotion = Crypt::decrypt($promotion);
        $promotion = Promotion::where('id',$promotion)->first();

        if($request->segment(2)=="accept"){
            $promotion->status = "Diterima";
        } elseif($request->segment(2)=="reject"){
            $promotion->status = "Ditolak";
        }
        $promotion->save();
		
        activity()->log('Kirim Data Promotion dengan ID = '.$promotion->id);
		return redirect('/promotion/'.Crypt::encrypt($promotion->parent_unit_id).'?search=&&year='.$promotion->year.'&&period='.$promotion->period)->with('status', 'Data Berhasil Dikirim');
    }

    ## Perbaiki Pengajuan
    public function fix_document($promotion, Request $request)
    {
        $promotion = Crypt::decrypt($promotion);
        $promotion = Promotion::where('id',$promotion)->first();

        $promotion->status = "Diperbaiki";
        $promotion->note = $request->note;
    	$promotion->save();
		
        activity()->log('Kirim Data Promotion dengan ID = '.$promotion->id);
		return redirect('/promotion/'.Crypt::encrypt($promotion->parent_unit_id).'?search=&&year='.$promotion->year.'&&period='.$promotion->period)->with('status', 'Data Berhasil Dikirim');
    }

    ## Cetak dokumen surat
    public function print_letter($parent_unit_id, $year, $period)
    {
        $parent_unit_id = Crypt::decrypt($parent_unit_id);
        $promotion = Promotion::where('parent_unit_id',$parent_unit_id)->where('year',$year)->where('period',$period)->first();
        $parent_unit = ParentUnit::where('id',$parent_unit_id)->first();
        $count_promotion = Promotion::where('parent_unit_id',$parent_unit_id)->where('year',$year)->where('period',$period)->count();
        
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setWidth(9);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(16);
        $sheet->getColumnDimension('E')->setWidth(16);
        $sheet->getColumnDimension('F')->setWidth(16);
        $sheet->getColumnDimension('G')->setWidth(16);

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Paid');
        $drawing->setDescription('Paid');
        $drawing->setPath(public_path('upload/setting/16782784661.png'));
        $drawing->setCoordinates('C1');
        $drawing->setWidth(65); // Atur lebar gambar ke 200 piksel
        $drawing->setHeight(65); // Atur tinggi gambar ke 100 piksel
        // $drawing->setOffsetX(20);
        // $drawing->setRotation(0);
        // $drawing->getShadow()->setVisible(true);
        // $drawing->getShadow()->setDirection(45);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        $sheet->setCellValue('A1', 'PEMERINTAH PROVINSI SULAWESI TENGGARA'); $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setSize(16);
        $sheet->setCellValue('A2', $parent_unit->name); $sheet->mergeCells('A2:G2');
        $sheet->getStyle('A1')->getFont()->setSize(14);
        $sheet->setCellValue('A3', 'Jl. Haluoleo Anduonohu Kompleks Bumi Praja Kantor Gubernur, Kendari 93232'); $sheet->mergeCells('A3:G3');
        $sheet->getStyle('A1:G3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->setCellValue('F5', 'Kendari,  '.date('d').' '.$this->getNamaBulan(date('m')).' '.date('Y'));
        $sheet->setCellValue('F7', 'Kepada');
        $sheet->setCellValue('F9', 'Gubernur Sulawesi Tenggara');
        $sheet->setCellValue('F10', 'Cq. Kepala Badan Kepegawaian Daerah');
        $sheet->setCellValue('F11', 'Provinsi Sulawesi Tenggara');
        $sheet->setCellValue('F12', 'Di -');
        $sheet->setCellValue('F13', 'Kendari');

        $sheet->setCellValue('A15', 'SURAT PENGANTAR'); $sheet->mergeCells('A15:G15');
        $sheet->setCellValue('A16', 'NO.'); $sheet->mergeCells('A16:G16');
        $sheet->getStyle('A15:A16')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


        $sheet->setCellValue('A18', 'NO');
        $sheet->setCellValue('B18', 'URAIAN PENGANTAR'); $sheet->mergeCells('B18:C18');
        $sheet->setCellValue('D18', 'BANYAKNYA');
        $sheet->setCellValue('E18', 'KETERANGAN');$sheet->mergeCells('E18:G18');
        $sheet->getStyle('A18:G18')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A19', '1');

        $sheet->setCellValue('B19', 'Daftar Usulan Kenaikan Pangkat periode : '.$promotion->period.' '.$promotion->year); $sheet->mergeCells('B19:C19');
        $sheet->setCellValue('B20', 'a.n '.$promotion->employee->name.' dan Kawan-kawan');$sheet->mergeCells('B20:C20');
        $sheet->mergeCells('B21:C21');
        $sheet->mergeCells('B22:C22');
        $sheet->mergeCells('B23:C23');
        $sheet->mergeCells('B24:C24');
        $sheet->mergeCells('B25:C25');
        $sheet->mergeCells('B26:C26');
        $sheet->mergeCells('B27:C27');

        $sheet->setCellValue('D19', $count_promotion);

        $sheet->setCellValue('E19', 'Berkas usul terdiri dari :');$sheet->mergeCells('E19:G19');
        $sheet->setCellValue('E20', '1. FC Karpeg');$sheet->mergeCells('E20:G20');
        $sheet->setCellValue('E21', '2. FC Karis/Karsu	');$sheet->mergeCells('E21:G21');;	
        $sheet->setCellValue('E22', '3. SK CPNS dan Pengangkatan PNS');$sheet->mergeCells('E22:G22');	
        $sheet->setCellValue('E23', '4. SK Pangkat Terakhir	');$sheet->mergeCells('E23:G23');
        $sheet->setCellValue('E24', '5. SKP 2 Tahun Terakhir');$sheet->mergeCells('E24:G24');
        $sheet->setCellValue('E25', '6. FC Ijazah Terakhir');$sheet->mergeCells('E25:G25');
        $sheet->setCellValue('E26', '7. Bahan Kelengkapan lainnya');$sheet->mergeCells('E26:G26');
        $sheet->setCellValue('E27', '8. Lain-Lain');$sheet->mergeCells('E27:G27');

        $sheet->setCellValue('A30', 'Sesuai ketentuan dalam peraturan pemerintah Nomor 99 Tahun 2000 jo Peraturan Pemerintah Nomor 12 Tahun 2002, yang');	
        $sheet->setCellValue('A31', 'bersangkutan telah memenuhi syarat untuk dapat dipertimbangkan kenaikan pangkatnya setingkat lebih tinggi.');	
        
        $sheet->setCellValue('E34', 'Pengirim');	

        $sheet->setCellValue('E36', $parent_unit->leader_call.' '.$parent_unit->name);	
        $sheet->setCellValue('E37', 'PROVINSI SULAWESI TENGGARA');	
        $sheet->setCellValue('E41', $parent_unit->leader_name);	

        $leader = Employee::where('nip',$parent_unit->leader_nip)->first();
        		
        $sheet->setCellValue('E42', $leader->classes->rank.' '.$leader->classes->class);	
        $sheet->setCellValue('E43', "NIP : ".$leader->nip);	

        $sheet->getStyle('A18:G27')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        // $sheet->getStyle('A4:F4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A15')->getFont()->setBold(true);
        $sheet->getStyle('A18:G18')->getFont()->setBold(true);
        
        $type = 'xlsx';
        $fileName = "SURAT PENGAJUAN KENAIKAN PANGKAT ".$parent_unit->name.".".$type;

        if($type == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
        } else if($type == 'xls') {
            $writer = new Xls($spreadsheet);			
        }		
        $writer->save("public/upload/report/".$fileName);
        header("Content-Type: application/vnd.ms-excel");
        return redirect(url('/')."/public/upload/report/".$fileName);    

    }

    ## Cetak dokumen surat
    public function print_attachment($parent_unit_id, $year, $period)
    {
        $parent_unit_id = Crypt::decrypt($parent_unit_id);
        $promotion = Promotion::where('parent_unit_id',$parent_unit_id)->where('year',$year)->where('period',$period)->get();
        $parent_unit = ParentUnit::where('id',$parent_unit_id)->first();
        
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(16);
        $sheet->getColumnDimension('E')->setWidth(16);
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->getColumnDimension('G')->setWidth(18);
        $sheet->getColumnDimension('H')->setWidth(67);

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Paid');
        $drawing->setDescription('Paid');
        $drawing->setPath(public_path('upload/setting/16782784661.png'));
        $drawing->setCoordinates('C1');
        $drawing->setWidth(65); // Atur lebar gambar ke 200 piksel
        $drawing->setHeight(65); // Atur tinggi gambar ke 100 piksel
        // $drawing->setOffsetX(20);
        // $drawing->setRotation(0);
        // $drawing->getShadow()->setVisible(true);
        // $drawing->getShadow()->setDirection(45);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        $sheet->setCellValue('A1', 'PEMERINTAH PROVINSI SULAWESI TENGGARA'); $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setSize(16);
        $sheet->setCellValue('A2', $parent_unit->name); $sheet->mergeCells('A2:H2');
        $sheet->getStyle('A1')->getFont()->setSize(14);
        $sheet->setCellValue('A3', 'Jl. Haluoleo Anduonohu Kompleks Bumi Praja Kantor Gubernur, Kendari 93232'); $sheet->mergeCells('A3:H3');
        $sheet->getStyle('A1:H3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->setCellValue('A5', 'LAMPIRAN : DAFTAR NAMA PEGAWAI YANG DIUSULKAN UNTUK KENAIKAN PANGKAT PERIODE OKTOBER TAHUN 2023');
        $sheet->mergeCells('A5:H5');
        $sheet->getStyle('A5:H5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->setCellValue('A7', 'NO');$sheet->mergeCells('A7:A8');
        $sheet->setCellValue('B7', 'NIP');$sheet->mergeCells('B7:B8');
        $sheet->setCellValue('C7', 'NAMA PEGAWAI');$sheet->mergeCells('C7:C8');
        $sheet->setCellValue('D7', 'GOLONGAN');$sheet->mergeCells('D7:E7');
        $sheet->setCellValue('D8', 'LAMA');
        $sheet->setCellValue('E8', 'BARU');
        $sheet->setCellValue('F7', 'JENIS KP');$sheet->mergeCells('F7:F8');
        $sheet->setCellValue('G7', 'JABATAN');$sheet->mergeCells('G7:G8');
        $sheet->setCellValue('H7', 'UNIT KERJA');$sheet->mergeCells('H7:H8');

        $rows = 9;
        $no = 1;
    
        foreach($promotion as $v){

            $sheet->setCellValue('A' . $rows, $no++);
            $sheet->setCellValue('B' . $rows, "'".$v->nip);
            $sheet->setCellValue('C' . $rows, $v->employee->name);
            $sheet->setCellValue('D' . $rows, $v->last_promotion);
            $sheet->setCellValue('E' . $rows, $v->new_promotion);
            $sheet->setCellValue('F' . $rows, $v->promotion_type);
            $sheet->setCellValue('G' . $rows, $v->employee->position);
            $sheet->setCellValue('H' . $rows, $v->employee->unit->name);
            
            $rows++;
        }

        $sheet->getStyle('A7:H'.($rows-1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A7:H8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A7:H8')->getFont()->setBold(true);
        
        $type = 'xlsx';
        $fileName = "LAMPIRAN PENGAJUAN KENAIKAN PANGKAT ".$parent_unit->name.".".$type;

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
