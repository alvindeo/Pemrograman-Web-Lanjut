<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use CodeIgniter\HTTP\ResponseInterface;
use Dompdf\Dompdf;
// Pastikan Anda sudah menginstal Dompdf melalui Composer

class ProdukController extends BaseController
{

    protected $produk;
    
    function __construct()
    {
        $this->produk = new ProductModel();
    }

    /*
    fungsi dibawah ini yang bertanggung jawab untuk
    menangani request dari http://localhost:8080/produk/edit/23
    */

    public function index()
    {
        $produk = $this->produk->findAll();
        $data['produk'] = $produk;

        return view('v_produk', $data);
    }

    public function create()
    {
        $dataFoto = $this->request->getFile('foto');

        $dataForm = [
            'nama' => $this->request->getPost('nama'),
            'harga' => $this->request->getPost('harga'),
            'jumlah' => $this->request->getPost('jumlah'),
            'created_at' => date("Y-m-d H:i:s")
        ];

        if ($dataFoto->isValid()) {
            $fileName = $dataFoto->getRandomName();
            $dataForm['foto'] = $fileName;
            $dataFoto->move('img/', $fileName);
        }

        $this->produk->insert($dataForm);

        return redirect('produk')->with('success', 'Data Berhasil Ditambah');
    } 

    public function edit($id)
    {
        $dataProduk = $this->produk->find($id);

        $dataForm = [
            'nama' => $this->request->getPost('nama'),
            'harga' => $this->request->getPost('harga'),
            'jumlah' => $this->request->getPost('jumlah'),
            'updated_at' => date("Y-m-d H:i:s")
        ];

        if ($this->request->getPost('check') == 1) {
            if ($dataProduk['foto'] != '' and file_exists("img/" . $dataProduk['foto'] . "")) {
                unlink("img/" . $dataProduk['foto']);
            }

            $dataFoto = $this->request->getFile('foto');

            if ($dataFoto->isValid()) {
                $fileName = $dataFoto->getRandomName();
                $dataFoto->move('img/', $fileName);
                $dataForm['foto'] = $fileName;
            }
        }

        $this->produk->update($id, $dataForm);

        return redirect('produk')->with('success', 'Data Berhasil Diubah');
    }

    public function delete($id)
    {
        $dataProduk = $this->produk->find($id);

        if ($dataProduk['foto'] != '' and file_exists("img/" . $dataProduk['foto'] . "")) {
            unlink("img/" . $dataProduk['foto']);
        }

        $this->produk->delete($id);

        return redirect('produk')->with('success', 'Data Berhasil Dihapus');
    }

    public function download(){
        //get data from database
    $produk = $this->produk->findAll();

		//pass data to file view
    $html = view('v_produkPDF', ['product' => $produk]);

		//set the pdf filename
    $filename = date('y-m-d-H-i-s') . '-produk';

    // instantiate and use the dompdf class
    $dompdf = new Dompdf();

    // load HTML content (file view)
    $dompdf->loadHtml($html);

    // (optional) setup the paper size and orientation
    $dompdf->setPaper('A4', 'potrait');

    // render html as PDF
    $dompdf->render();

    // output the generated pdf
    $dompdf->stream($filename);
    }
}