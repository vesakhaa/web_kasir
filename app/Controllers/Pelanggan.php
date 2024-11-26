<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pelanggan as ModelsPelanggan;
use CodeIgniter\HTTP\ResponseInterface;
class Pelanggan extends BaseController
{
    public function index()
    {
        $model = new ModelsPelanggan();
        $data = [
            'data' => $model->paginate(10, group: 'pelanggan'),
            'pager' => $model->pager,
        ];
        return view('v_pelanggan', $data);
    }

    public function store()
    {
        $data = $this->request->getJSON(true);
        $newPelanggan = new ModelsPelanggan();
        $newPelanggan->save([
            'nama_pelanggan' => $data['name'],
            'alamat_pelanggan' => $data['address'],
            'no_telp' => $data['phone'],
        ]);

        return redirect()->to('/pelanggan');
    }

    public function show($id)
    {
        $pelanggan = new ModelsPelanggan();
        $data = $pelanggan->find($id);

        if (!$data) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Pelanggan tidak ditemukan']);
        }

        return $this->response->setJSON($data);
    }

    public function update($id)
    {
        $pelangganModel = new ModelsPelanggan();
        $data = $this->request->getJSON(true);

        $pelanggan = $pelangganModel->find($id);
        if (!$pelanggan) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Pelanggan tidak ditemukan']);
        }

        $pelangganModel->update($id, [
            'nama_pelanggan' => $data['name'],
            'alamat_pelanggan' => $data['address'],
            'no_telp' => $data['phone'],
        ]);

        return $this->response->setJSON($data);
    }

    public function delete($id)
    {
        $pelangganModel = new ModelsPelanggan();

        $pelanggan = $pelangganModel->find($id);
        if (!$pelanggan) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Pelanggan tidak ditemukan']);
        }

        $pelangganModel->delete($id);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Data pelanggan berhasil dihapus']);
    }
}