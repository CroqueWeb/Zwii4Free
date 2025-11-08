<?php // Copyright (C) 2017, CroqueWeb. GNU General Public License, version 3
if($this->getUrl(0) == "membres"){
$zu=$this->getInput('ZWII_USER_ID');
if(isset($zu)){
echo"<h2>Page privée de ".ucfirst($zu)."</h2>";
$dir="site/file/source/".$zu;
if(!is_dir($dir)){mkdir($dir,0705);}
function QE($fn){
$in=finfo_open(FILEINFO_MIME_ENCODING);
$ty=finfo_buffer($in,file_get_contents($fn));
finfo_close($in);
return in_array($ty,['utf-8','us-ascii']);}
$width=560;
$height=314;
if(is_dir($dir)){
if($dh=opendir($dir)){
while(($file=readdir($dh))!==false){
if(($file!=".")&&($file!="..")&&(filetype($dir."/".$file)=="file")){
$ex=substr($file,-3);
$fs=filesize($dir."/".$file);
$fs=round($fs/1000);
$nf=str_replace("_"," ",$file);
$ob=$dir."/".$file;
$dl="<a href=\"".$ob."\" target=\"_blank\" title=\"télécharger ce fichier -> clic droit - enregistrer la cible du lien\">".$nf."</a> : ".$fs." Ko \n<br><br>\n";
if($ex=="mp4"||$ex=="m4v"){echo"<video src=\"".$ob."\" type=\"video/mp4\" width=\"".$width."\" height=\"".$height."\" preload=\"auto\" controls></video>\n<br>".$dl."<br>\n";}
elseif($ex=="mp3"){echo"<audio src=\"".$ob."\" type=\"audio/mp3\" preload=\"auto\" controls></audio>\n<br>".$dl."<br>\n";}
elseif($ex=="gif"||$ex=="jpg"||$ex=="png"){echo"<a href=\"".$ob."\" title=\"Afficher ce fichier\" data-lity><img src=\"".$ob."\" alt=\"image\"></a>\n<br><br>\n";}
elseif($ex=="txt"){echo "<pre>";
if(QE($ob)=='utf-8'){readfile($ob);}
else{$te=file_get_contents($ob);print(utf8_encode($te));}
echo"</pre>\n<br>".$dl."<br>\n";}
else{echo"Téléchargez le fichier : ".$dl."<br>\n";}
}}
closedir($dh);
}
clearstatcache();
}
echo"<p style=\"width:250px;border: 1px solid black;text-align:center;font-size:1.2em;background:#eee;\"><a style=\"display:block;color:#333;\" href=\"javascript:location.reload();\">Actualiser la liste des fichiers</a></p>\n".
"<p style=\"border: 1px dotted black;text-align:center;font-size:0.9em;\"> Fin de l'espace privé </p>";
}}
elseif($this->getUrl(0) == "contact"){
include ("contact.php");
}
?>
