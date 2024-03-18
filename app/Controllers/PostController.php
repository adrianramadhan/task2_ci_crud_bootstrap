<?php

namespace App\Controllers;

use App\Models\PostModel;
use CodeIgniter\Controller;

class PostController extends Controller
{
    public function index()
    {
        $postModel = new PostModel();

        $data = [
            'posts' => $postModel->paginate(10),
            'pager' => $postModel->pager,
        ];

        return view('posts/index', $data);
    }

    public function create()
    {
        return view('posts/create');
    }

    public function store()
    {
        // Load helper form and url
        helper(['form', 'url']);

        // Define validation
        $validation = $this->validate([
            'title' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Judul harus diisi.',
                ],
            ],
            'content' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Konten harus diisi.',
                ],
            ],
        ]);

        if (!$validation) {
            return view('posts/create', [
                'validation' => $this->validator,
            ]);
        } else {
            // model initiate
            $postModel = new PostModel();

            // insert data into database
            $postModel->save([
                'title' => $this->request->getPost('title'),
                'content' => $this->request->getPost('content'),
            ]);

            // flash message
            session()->setFlashdata('message', 'Data berhasil disimpan.');

            return redirect()->to(base_url('post'));
        }
    }

    public function edit($id)
    {
        $postModel = new PostModel();

        $data = [
            'post' => $postModel->find($id),
        ];

        return view('posts/edit', $data);
    }

    public function update($id)
    {
        // Load helper form and url
        helper(['form', 'url']);

        // Define validation
        $validation = $this->validate([
            'title' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Judul harus diisi.',
                ],
            ],
            'content' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Konten harus diisi.',
                ],
            ],
        ]);

        if (!$validation) {
            $postModel = new PostModel();

            return view('posts/edit', [
                'post' => $postModel->find($id),
                'validation' => $this->validator
            ]);
        } else {
            // model initiate
            $postModel = new PostModel();

            // update data into database
            $postModel->update($id,[
                'title' => $this->request->getPost('title'),
                'content' => $this->request->getPost('content'),
            ]);

            // flash message
            session()->setFlashdata('message', 'Data berhasil diupdate.');

            return redirect()->to(base_url('post'));
        }
    }

    public function delete($id)
    {
        // model initiate
        $postModel = new PostModel();

        // delete data from database
        $post = $postModel->find($id);

        if ($post) {
            $postModel->delete($id);
            
            // flash message
            session()->setFlashdata('message', 'Data berhasil dihapus.');
            return redirect()->to(base_url('post'));
        } else {
            // flash message
            session()->setFlashdata('message', 'Data tidak ditemukan.');
            return redirect()->to(base_url('post'));
        }
    }
}
