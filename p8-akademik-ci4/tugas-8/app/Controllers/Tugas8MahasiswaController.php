<?php

namespace App\Controllers;

use App\Models\Tugas8MahasiswaModel;

class Tugas8MahasiswaController extends BaseController
{
    protected $helpers = ['form'];

    private function mahasiswaModel(): Tugas8MahasiswaModel
    {
        return new Tugas8MahasiswaModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Data Mahasiswa',
            'mahasiswa' => $this->mahasiswaModel()->orderBy('nim', 'ASC')->findAll(),
        ];

        return view('tugas8/mahasiswa/index', $data);
    }

    public function create()
    {
        return view('tugas8/mahasiswa/create', [
            'title'     => 'Tambah Mahasiswa',
            'mahasiswa' => [],
        ]);
    }

    public function store()
    {
        $rules = [
            'nim'  => 'required|min_length[5]|max_length[20]|alpha_numeric_punct|is_unique[mahasiswa_tugas8.nim]',
            'nama' => 'required|min_length[3]|max_length[100]',
            'prodi' => 'required|min_length[3]|max_length[100]',
            'ipk'  => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[4]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->mahasiswaModel()->insert([
            'nim'   => trim((string) $this->request->getPost('nim')),
            'nama'  => trim((string) $this->request->getPost('nama')),
            'prodi' => trim((string) $this->request->getPost('prodi')),
            'ipk'   => $this->request->getPost('ipk'),
        ]);

        return redirect()->to(site_url('tugas8/mahasiswa'))
            ->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $mahasiswa = $this->mahasiswaModel()->find($id);

        if (! $mahasiswa) {
            return redirect()->to(site_url('tugas8/mahasiswa'))
                ->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        return view('tugas8/mahasiswa/edit', [
            'title'     => 'Ubah Data Mahasiswa',
            'mahasiswa' => $mahasiswa,
        ]);
    }

    public function update(int $id)
    {
        $mahasiswa = $this->mahasiswaModel()->find($id);

        if (! $mahasiswa) {
            return redirect()->to(site_url('tugas8/mahasiswa'))
                ->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $rules = [
            'nim'  => "required|min_length[5]|max_length[20]|alpha_numeric_punct|is_unique[mahasiswa_tugas8.nim,id,{$id}]",
            'nama' => 'required|min_length[3]|max_length[100]',
            'prodi' => 'required|min_length[3]|max_length[100]',
            'ipk'  => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[4]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->mahasiswaModel()->update($id, [
            'nim'   => trim((string) $this->request->getPost('nim')),
            'nama'  => trim((string) $this->request->getPost('nama')),
            'prodi' => trim((string) $this->request->getPost('prodi')),
            'ipk'   => $this->request->getPost('ipk'),
        ]);

        return redirect()->to(site_url('tugas8/mahasiswa'))
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $mahasiswa = $this->mahasiswaModel()->find($id);

        if (! $mahasiswa) {
            return redirect()->to(site_url('tugas8/mahasiswa'))
                ->with('error', 'Data mahasiswa tidak ditemukan atau sudah dihapus.');
        }

        $this->mahasiswaModel()->delete($id);

        return redirect()->to(site_url('tugas8/mahasiswa'))
            ->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}
