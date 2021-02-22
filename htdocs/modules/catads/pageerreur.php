<?php
//Ajout pageerreur.php CPascalWeb - 21 août 2009 
//page d'erreur rentabiliweb si erreur dans la saisis du code
 
include("../../mainfile.php");
include "../../header.php";

xoops_header();
	echo "<div class='errorMsg'><h2>"._MD_CATADS_CODE_RENTABI_INVALIDE."</h2></div>";
	echo '<table  width="100%" class="outer" cellspacing="1"><tr><th colspan="2"></th></tr>';
	echo "<tr><td class='head'align='center'>\n";
	echo _MD_CATADS_MESS_RENTABI."</td><td class='even'></td></tr>
			<tr><td class='head' align='center'><input class='formButton' value="._CLOSE." type='button' onclick='javascript:window.close();' /></td><td class='even'></td></tr>
			</table></form>\n";
xoops_footer();

?>