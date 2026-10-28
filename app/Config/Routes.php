<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Siswa::index');
$routes->post('siswa/tambah', 'Siswa::tambah');
$routes->post('siswa/edit/(:num)', 'Siswa::edit/$1');
$routes->post('siswa/hapus/(:num)', 'Siswa::hapus/$1');
