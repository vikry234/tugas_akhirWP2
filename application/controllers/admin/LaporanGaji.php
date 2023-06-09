<?php 

class LaporanGaji extends CI_Controller
{
	
	public function index()
	{
		$data['title'] = "Laporan Gaji Pegawai";
		$this->load->view('templates_admin/header', $data);
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/filterLaporanGaji');
		$this->load->view('templates_admin/footer');
	}

	public function cetakLaporanGaji()
	{
		$data['title'] = "Cetak Laporan Gaji Pegawai";
		if((isset($_GET['bulan']) && $_GET['bulan'] != '') && (isset($_GET['tahun']) && $_GET['tahun'] != '')){
		    $bulan = $_GET['bulan'];
		    $tahun = $_GET['tahun'];
		    $bulantahun = $bulan.$tahun;
		  }
		  else{
		    $bulan = date('m');
		    $tahun = date('Y');
		    $bulantahun = $bulan.$tahun;
  		}
  		$data['potongan'] = $this->penggajianModel->get_data('potongan_gaji')->result();
		$data['cetakGaji'] = $this->db->query("SELECT data_pegawai.nik, data_pegawai.nama_pegawai, data_pegawai.jenis_kelamin, data_jabatan.nama_jabatan, data_jabatan.gaji_pokok, data_jabatan.tj_transport, data_jabatan.uang_makan, data_kehadiran.alpha
			FROM data_pegawai
			LEFT JOIN data_kehadiran ON data_kehadiran.nik = data_pegawai.nik
			LEFT JOIN data_jabatan ON data_jabatan.nama_jabatan = data_pegawai.jabatan
			WHERE data_kehadiran.bulan = '$bulantahun'
			ORDER BY data_pegawai.nama_pegawai ASC")->result();
		$this->load->view('templates_admin/header', $data);
		$this->load->view('admin/CetakDataGaji', $data);
	}
}

 ?>