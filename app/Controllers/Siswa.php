<?php

namespace App\Controllers;

use App\Models\SiswaModel;
use CodeIgniter\HTTP\RedirectResponse;

class Siswa extends BaseController
{
    public function index(): string
    {
        $siswaModel = new SiswaModel();
        $siswa = $siswaModel->paginate(10, 'siswa');

        return view('siswa/index', [
            'siswa' => $siswa,
            'pager' => $siswaModel->pager,
        ]);
    }

    public function tambah(): RedirectResponse
    {
        $rules = [
            'nis' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $siswaModel = new SiswaModel();
        $data = $this->validator->getValidated();

        if (! $siswaModel->insert($data)) {
            return redirect()->back()
                ->withInput()
                ->with('saveError', 'Data siswa gagal disimpan. Silakan coba lagi.');
        }

        return redirect()->to(site_url('/'))
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(int $id): RedirectResponse
    {
        $siswaModel = new SiswaModel();

        if ($siswaModel->find($id) === null) {
            return redirect()->to(site_url('/'))
                ->with('editError', 'Data siswa tidak ditemukan.');
        }

        $rules = [
            'nis' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('editErrors', $this->validator->getErrors())
                ->with('editId', $id);
        }

        $data = $this->validator->getValidated();

        if (! $siswaModel->update($id, $data)) {
            return redirect()->back()
                ->withInput()
                ->with('editError', 'Data siswa gagal diperbarui. Silakan coba lagi.')
                ->with('editId', $id);
        }

        return redirect()->to(site_url('/'));
    }

    public function hapus(int $id): RedirectResponse
    {
        $siswaModel = new SiswaModel();

        if ($siswaModel->find($id) === null) {
            return redirect()->to(site_url('/'))
                ->with('deleteError', 'Data siswa tidak ditemukan.');
        }

        if (! $siswaModel->delete($id)) {
            return redirect()->to(site_url('/'))
                ->with('deleteError', 'Data siswa gagal dihapus. Silakan coba lagi.');
        }

        return redirect()->to(site_url('/'));
    }
}
