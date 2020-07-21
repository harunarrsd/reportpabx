<?php
	$url='http://localhost/ReportPABX';
	$dbhost='localhost';
	$dbuser='root';
	$dbpass='';
	$dbname='db_ippabx';

	$koneksi = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

	if ($koneksi->connect_error)
	{
		die('Maaf! Koneksi Gagal : '.$koneksi->connect_error);
	}

	$url=rtrim($url,'/');
?>