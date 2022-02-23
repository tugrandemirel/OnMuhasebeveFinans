<?php

namespace App\Http\Controllers\front\fatura;

use App\Fatura;
use App\FaturaIslem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    //
    public function index()
    {
        return view('front.fatura.index');
    }

    public function create($type)
    {
        if($type == 0)
            return view('front.fatura.gelir.create');
        else
            return view('front.fatura.gider.create');
    }

    public function store(Request $request)
    {
        $type = $request->route('type');
        $all = $request->except('_token');

         $islem = $all['islem'];
         unset($all['islem']);
        $all['faturaTipi'] = $type;

        $create = Fatura::create($all);
        if ($create)
        {
            if (count($islem)!=0)
            {
                foreach ($islem as $key => $value) {
                    $islemArray = [
                        'faturaId'=> $create->id,
                        'kalemId' => $value['kalemId'],
                        'miktar' => $value['gun_adet'],
                        'fiyat' => $value['tutar'],
                        'kdv' => $value['kdv'],
                        'araToplam' => $value['toplam_tutar'],
                        'kdvToplam' => $value['kdv_toplam'],
                        'genelToplam' => $value['genel_toplam'],
                        'text' => $value['text'],
                    ];
                    FaturaIslem::create($islemArray);
                }
            }
            return redirect()->back()->with('status', 'Fatura Eklendi');
        }
        else
            return redirect()->back()->with('status', 'Fatura eklenemedi');
    }

    public function edit($id)
    {
        $c = Fatura::where('id', $id)->count();
        if ($c != 0)
        {
            $data = Fatura::where('id', $id)->get();
            $dataIslem = FaturaIslem::where('faturaId', $id)->get();

            if ($data[0]['faturTipi'] == 0)
            {
//                 gelir
                return view('front.fatura.gelir.edit', ['data'=>$data, 'dataIslem'=>$dataIslem]);
            }
            else
                return view('front.fatura.gider.edit', ['data'=>$data, 'dataIslem'=>$dataIslem]);
        }
        else
            return redirect('/');
    }

    public function update(Request $request)
    {
        $id = $request->route('id');

        $c = Fatura::where('id', $id)->count();
        if ($c != 0)
        {
            $all = $request->except('_token');
            $islem = $all['islem'];
            unset($all['islem']);

            $upate = Fatura::where('id', $id)->update($all);
            if (count($islem)!=0)
            {
                foreach ($islem as $key => $value) {
                    FaturaIslem::where('faturaId', $id)->delete();
                    $islemArray = [
                        'faturaId' => $id,
                        'kalemId' => $value['kalemId'],
                        'miktar' => $value['gun_adet'],
                        'fiyat' => $value['tutar'],
                        'kdv' => $value['kdv'],
                        'araToplam' => $value['toplam_tutar'],
                        'kdvToplam' => $value['kdv_toplam'],
                        'genelToplam' => $value['genel_toplam'],
                        'text' => $value['text'],
                    ];
                    FaturaIslem::create($islemArray);
                }
                return redirect()->back()->with('status', 'Fatura Düzenlendi');
            }
        }
        else
            return redirect('/');
    }

    public function data(Request $request)
    {
        $table = Fatura::query();
        $data = DataTables::of($table)
            ->addColumn('edit', function ($table){
                return '<a href="'.route('fatura.edit', ['id'=>$table->id]).'">Düzenle</a>';
            })
            ->addColumn('delete', function ($table){
                return '<a href="'.route('fatura.delete', ['id'=>$table->id]).'">Delete</a>';
            })
            ->addColumn('musteri', function ($table){
                return Musteriler::getPublicName($table->musteriId);
            })
            ->editColumn('faturaTipi', function ($table){
                if ($table->faturaTipi == 0) { return 'Gelir';} else { return 'Gider';}
            })
            ->rawColumns(['edit', 'delete'])
            ->make(true);
        return $data;
    }
}
