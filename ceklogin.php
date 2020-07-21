<?php
	session_start(); //memulai session

	//check apakah ada akses post dari halaman login?, jika tidak kembali kehalaman depan
	if( !isset($_POST['user']) ) 
	{
		header('location:index.php');
		exit();
	}
	$error = ''; //set nilai default dari error,

	require ( 'database.php' );
	$username = trim( $_POST['user'] );
	$password = trim( $_POST['pass'] );

	if( strlen($username) < 2 )
	{
		//validasi username tidak bpleh kosong
 		$error = '<div class="alert alert-danger" role="alert">
 		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  		<span class="sr-only">Error:</span>Username Tidak Boleh Kosong!</div>';
	}
	else if( strlen($password) < 2 )
	{
 		//validasi password tidak boleh kosong
		$error = '<div class="alert alert-danger" role="alert">
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  		<span class="sr-only">Error:</span>Password Tidak Boleh Kosong!</div>';
	}
	else
	{
 		//mengubah semua karakter ke bentuk string
 		$username = $koneksi->escape_string($username);
 		$password = $koneksi->escape_string($password);

		//hash dengan md5
 		$password = md5($password);

 		//SQL command untuk memilih data berdasarkan parameter $username dan $password yang diinputkan
 		$sql = "SELECT nama, level FROM users
   				WHERE username='$username'
   				AND password='$password' LIMIT 1";

 		//melakukan perintah
 		$query = $koneksi->query($sql);

 		//check query
 	if( !$query )
 	{
  		die( 'Oops!! Sepertinya ada kesalahan database '. $koneksi->error );
 	}

 	//check hasil perintah
 	if( $query->num_rows == 1 )
 	{
  		//jika data yang dimaksud ada maka akan ditampilkan
  		$row =$query->fetch_assoc();

  		//data nama disimpan di session browser
  		$_SESSION['nama_u'] = $row['nama'];
  		$_SESSION['akses']    = $row['level'];

  		if( $row['level'] === 'manager')
  		{
   			//data hak Admin di set
   			$_SESSION['saya_manager']= 'TRUE';
  		}

  		//menuju halaman sesuai hak akses
  		header('location:'.$url.'/'.$_SESSION['akses'].'/');
  		exit();	
 	}
 	else
 	{

  		//jika data yang dimaksud tidak ada
  		$error = '<div class="alert alert-danger" role="alert">
  		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  		<span class="sr-only">Error:</span>Username dan Password Tidak ditemukan!</div>';
 	}

}

if( !empty($error) )
{
 	//simpan error pada session
 	$_SESSION['error'] = $error;
 	header('location:'.$url.'/');
 	exit();
}
?>