<?php 
function Conectarse() 
{ 
   if (!($link=mysqli_connect("localhost","givensfit","Yenaro123"))) 
   { 
      echo "Error conectando a la base de datos."; 
      exit(); 
   } 
   if (!(mysqli_select_db($link,"appweb_proyecto")))
   { 
      echo "Error seleccionando la base de datos."; 
      exit(); 
   } 
   return $link; 
} 
?>
