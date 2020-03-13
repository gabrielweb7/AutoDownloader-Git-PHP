<?php

	/**
	*       AutoDownloader Git PHP
	*	    Baixando master.zip do Git
	*       Movendo arquivos para raiz
	*       Deletando zip e pasta temporarias
	*       Version: 1.1
	*       Created By Gabriel da Luz
	*/

	$nameDiretorio = "PEDMAP";
	
	$gitUrl = "https://github.com/gabrielweb7/".$nameDiretorio;

	$zipName = "master.zip"; 
	
	file_put_contents($zipName, file_get_contents("{$gitUrl}/archive/{$zipName}") );
	
	if(filesize($zipName) == 0) { 
		die('Este repositorio é publico ? :: '."{$gitUrl}/archive/{$zipName}");
	}
	
	echo "Baixando Projeto Git: {$gitUrl} <br />";
	
	echo "Tamanho do arquivo: ".filesize($zipName);

	
	$unzip = new ZipArchive;

	$out = $unzip->open($zipName);

	if ($out === TRUE) {

	  $unzip->extractTo('./');
	  $unzip->close();
	  
	  echo '<b style="color:blue;">File Extraido!!</b><br><br><a href="../">[Voltar]</a> <br><br>';
	  
	  /* Deletando zip */
	  unlink($zipName); 
	  
	  /* Movendo diretorio da extração para raiz */
	  copy_dir('./'.$nameDiretorio.'-master', './', true);
	  
	  deleteAll('./'.$nameDiretorio.'-master');

	} else {

	  echo 'Error para extrair :/';

	}
	
	/** Created by Gabriel da Luz **/
	
	function copy_dir($diretorio, $destino, $ver_acao = false){
		if ($destino{strlen($destino) - 1} == '/'){
			$destino = substr($destino, 0, -1);
		}
		if (!is_dir($destino)){
			if ($ver_acao){
				echo "Criando diretorio {$destino}\n <br />";
			}
			mkdir($destino, 0755);
		}

		$folder = opendir($diretorio);

		while ($item = readdir($folder)){
			if ($item == '.' || $item == '..'){
				continue;
			}
			if (is_dir("{$diretorio}/{$item}")){
				copy_dir("{$diretorio}/{$item}", "{$destino}/{$item}", $ver_acao);
			}else{
				if ($ver_acao){
					echo "Copiando {$item} para {$destino}"."\n <br />";
				}
				copy("{$diretorio}/{$item}", "{$destino}/{$item}");
			}
		}
	}
	   
	function deleteAll($str) { 
		  
		if (is_file($str)) { 
			return unlink($str); 
		} 
		elseif (is_dir($str)) { 
			$scan = glob(rtrim($str, '/').'/{*,.[!.]*,..?*}', GLOB_BRACE); 
			foreach($scan as $index=>$path) { 
				deleteAll($path); 
			} 
			return @rmdir($str); 
		}
		
	} 
	
?>