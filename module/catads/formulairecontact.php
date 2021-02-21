<?php
//Ajout de la page formulairecontact.php CPascalWeb - 21 août 2009 
//formulaire micropaiement Rentabiliweb

include("../../mainfile.php");
include "../../header.php";
xoops_header();

foreach ($_POST as $k => $v) {${$k} = $v;}
foreach ($_GET as $k => $v) {${$k} = $v;}

//Javascript pour ouvrir fenêtre pop up des drapeaux
echo "<script type='text/javascript'>
function rwf_ouvrir_popup(rwf_url){
	var rwf_width = 300;
	var rwf_height = 390;
	var rwf_left	= ((screen.width - rwf_width) / 2);
	window.open(rwf_url, 'MicroPaiement', 
	'toolbar=0, location=0, directories=0, status=0, scrollbars=0,' +
	'resizable=1, copyhistory=0, menuBar=0, width='+rwf_width+', height='+rwf_height+','+
	'left='+rwf_left+',top=40');
}
</script>";
				echo '<table  width="100%" class="outer" cellspacing="1"><tr><th colspan="2"></th></tr>';
				echo "<tr><td class='head'align='center'>";
				//option texte intro 
				echo $xoopsModuleConfig['introtexte'];"</td></tr>";
				echo'<br />';
?>
<!----------------------------------RESTE A MODIFIER AJOUT OPTION DANS RUBRIQUE DE CATADS DU CHOIX COULEURS, TAILLE POP UP, LOGO  -->
<link href="http://data.rentabiliweb.com/css/popup2007/popup1_form.css" rel="stylesheet" type="text/css" />
<div id="rentabiliweb_form_popup">
	<div id="rentabiliweb_form_popup_top"><br />
		<div id="rentabiliweb_form_popup_top_logo">
			<a href="http://www.rentabiliweb.com/fr/?trackADV=351138">
				<img src="http://data.rentabiliweb.com/i/form2007/imgs/logo.gif" alt="Rentabiliweb.com" />
			</a>
		</div>
	</div>
	<div id="rentabiliweb_form_popup_content">
		<div id="rentabiliweb_form_popup_content_block_left">
			<div id="rentabiliweb_form_popup_content_block_left_pays">
				<div id="rentabiliweb_form_popup_content_block_left_pays_label"><?php echo $xoopsModuleConfig['infotexte'];?></div>
				<div id="rentabiliweb_form_popup_content_block_left_pays_flags">
						<a href="javascript:void(0);"
								onclick="rwf_ouvrir_popup('http://composants.rentabiliweb.com/form/popup.php?doc_id=<?php echo $xoopsModuleConfig['idsite'];?>&site_id=<?php echo $xoopsModuleConfig['idprotect'];?>&pays_code=fr&skin_color=blue2&default_language=fr&default_payment_type=audiotel')">
								<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/74.gif" alt="France" title="France" />
								</a>
	<a href="javascript:void(0);"
								onclick="rwf_ouvrir_popup('http://composants.rentabiliweb.com/form/popup.php?doc_id=<?php echo $xoopsModuleConfig['idsite'];?>&site_id=<?php echo $xoopsModuleConfig['idprotect'];?>&pays_code=dt&skin_color=blue2&default_language=fr&default_payment_type=audiotel')">
								<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/238.gif" alt="France DOM TOM" title="France DOM TOM" />
								</a>
	<a href="javascript:void(0);"
								onclick="rwf_ouvrir_popup('http://composants.rentabiliweb.com/form/popup.php?doc_id=<?php echo $xoopsModuleConfig['idsite'];?>&site_id=<?php echo $xoopsModuleConfig['idprotect'];?>&pays_code=be&skin_color=blue2&default_language=fr&default_payment_type=audiotel')">
								<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/22.gif" alt="Belgium" title="Belgium" />
								</a>
	<a href="javascript:void(0);"
								onclick="rwf_ouvrir_popup('http://composants.rentabiliweb.com/form/popup.php?doc_id=<?php echo $xoopsModuleConfig['idsite'];?>&site_id=<?php echo $xoopsModuleConfig['idprotect'];?>&pays_code=ch&skin_color=blue2&default_language=fr&default_payment_type=audiotel')">
								<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/205.gif" alt="Switzerland" title="Switzerland" />
								</a>
	<a href="javascript:void(0);"
								onclick="rwf_ouvrir_popup('http://composants.rentabiliweb.com/form/popup.php?doc_id=<?php echo $xoopsModuleConfig['idsite'];?>&site_id=<?php echo $xoopsModuleConfig['idprotect'];?>&pays_code=ca&skin_color=blue2&default_language=fr&default_payment_type=audiotel')">
								<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/38.gif" alt="Canada" title="Canada" />
								</a>
	<a href="javascript:void(0);"
								onclick="rwf_ouvrir_popup('http://composants.rentabiliweb.com/form/popup.php?doc_id=<?php echo $xoopsModuleConfig['idsite'];?>&site_id=<?php echo $xoopsModuleConfig['idprotect'];?>&pays_code=lu&skin_color=blue2&default_language=fr&default_payment_type=audiotel')">
								<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/131.gif" alt="Luxembourg" title="Luxembourg" />
								</a>
	<a href="javascript:void(0);"
								onclick="rwf_ouvrir_popup('http://composants.rentabiliweb.com/form/popup.php?doc_id=<?php echo $xoopsModuleConfig['idsite'];?>&site_id=<?php echo $xoopsModuleConfig['idprotect'];?>&pays_code=ro&skin_color=blue2&default_language=fr&default_payment_type=audiotel')">
								<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/180.gif" alt="Romania" title="Romania" />
								</a>
	<a href="javascript:void(0);"
								onclick="rwf_ouvrir_popup('http://composants.rentabiliweb.com/form/popup.php?doc_id=<?php echo $xoopsModuleConfig['idsite'];?>&site_id=<?php echo $xoopsModuleConfig['idprotect'];?>&pays_code=de&skin_color=blue2&default_language=fr&default_payment_type=audiotel')">
								<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/5.gif" alt="Germany" title="Germany" />
								</a>
	<a href="javascript:void(0);"
								onclick="rwf_ouvrir_popup('http://composants.rentabiliweb.com/form/popup.php?doc_id=<?php echo $xoopsModuleConfig['idsite'];?>&site_id=<?php echo $xoopsModuleConfig['idprotect'];?>&pays_code=es&skin_color=blue2&default_language=fr&default_payment_type=audiotel')">
								<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/63.gif" alt="Spain" title="Spain" />
								</a>
	<a href="javascript:void(0);"
								onclick="rwf_ouvrir_popup('http://composants.rentabiliweb.com/form/popup.php?doc_id=<?php echo $xoopsModuleConfig['idsite'];?>&site_id=<?php echo $xoopsModuleConfig['idprotect'];?>&pays_code=it&skin_color=blue2&default_language=fr&default_payment_type=audiotel')">
								<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/114.gif" alt="Italy" title="Italy" />
								</a>
	<a href="javascript:void(0);"
								onclick="rwf_ouvrir_popup('http://composants.rentabiliweb.com/form/popup.php?doc_id=<?php echo $xoopsModuleConfig['idsite'];?>&site_id=<?php echo $xoopsModuleConfig['idprotect'];?>&pays_code=uk&skin_color=blue2&default_language=fr&default_payment_type=audiotel')">
								<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/81.gif" alt="United KingDom" title="United KingDom" />
								</a>
	<a href="javascript:void(0);"
								onclick="rwf_ouvrir_popup('http://composants.rentabiliweb.com/form/popup.php?doc_id=<?php echo $xoopsModuleConfig['idsite'];?>&site_id=<?php echo $xoopsModuleConfig['idprotect'];?>&pays_code=at&skin_color=blue2&default_language=fr&default_payment_type=audiotel')">
								<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/16.gif" alt="Austria" title="Austria" />
								</a>
	<a href="javascript:void(0);"
								onclick="rwf_ouvrir_popup('http://composants.rentabiliweb.com/form/popup.php?doc_id=<?php echo $xoopsModuleConfig['idsite'];?>&site_id=<?php echo $xoopsModuleConfig['idprotect'];?>&pays_code=pl&skin_color=blue2&default_language=fr&default_payment_type=audiotel')">
								<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/171.gif" alt="Poland" title="Poland" />
								</a>
	<a href="javascript:void(0);"
								onclick="rwf_ouvrir_popup('http://composants.rentabiliweb.com/form/popup.php?doc_id=<?php echo $xoopsModuleConfig['idsite'];?>&site_id=<?php echo $xoopsModuleConfig['idprotect'];?>&pays_code=nz&skin_color=blue2&default_language=fr&default_payment_type=audiotel')">
								<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/159.gif" alt="New Zealand" title="New Zealand" />
								</a>
	<a href="javascript:void(0);"
								onclick="rwf_ouvrir_popup('http://composants.rentabiliweb.com/form/popup.php?doc_id=<?php echo $xoopsModuleConfig['idsite'];?>&site_id=<?php echo $xoopsModuleConfig['idprotect'];?>&pays_code=au&skin_color=blue2&default_language=fr&default_payment_type=audiotel')">
								<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/15.gif" alt="Australia" title="Australia" />
								</a>
	<a href="javascript:void(0);"
								onclick="rwf_ouvrir_popup('http://composants.rentabiliweb.com/form/popup.php?doc_id=<?php echo $xoopsModuleConfig['idsite'];?>&site_id=<?php echo $xoopsModuleConfig['idprotect'];?>&pays_code=us&skin_color=blue2&default_language=fr&default_payment_type=audiotel')">
								<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/65.gif" alt="United States" title="United States" />
								</a>
	<a href="javascript:void(0);"
								onclick="rwf_ouvrir_popup('http://composants.rentabiliweb.com/form/popup.php?doc_id=<?php echo $xoopsModuleConfig['idsite'];?>&site_id=<?php echo $xoopsModuleConfig['idprotect'];?>&pays_code=nl&skin_color=blue2&default_language=fr&default_payment_type=audiotel')">
								<img src="http://data.rentabiliweb.com/i/form2007/flags/25_15/167.gif" alt="Netherlands" title="Netherlands" />
								</a>
				</div>
			</div><br />
				<div id="rentabiliweb_form_popup_content_block_left_code">
				<form action="http://secure.rentabiliweb.com/micropaiement.php" method="get">
					<div id="rentabiliweb_form_popup_content_block_left_code_label">
					Saisissez votre code:&nbsp;  
					</div>
					<div id="rentabiliweb_form_popup_content_block_left_code_input">
                        <input type="hidden" name="ads_id" value="<?php echo $ads_id;?>" />	
						<input type="hidden" name="id" value="<?php echo $xoopsModuleConfig['idsite'];?>" />
						<input type="text" name="code" value="" id="rentabiliweb_form_popup_content_block_left_code_input_code" />
					</div>
					<div id="rentabiliweb_form_popup_content_block_left_code_button">
						<input type="image" src="http://data.rentabiliweb.com/i/form2007/imgs/ok.gif" align="absmiddle" value="ok" name="submit" alt="Validez" />
					</div><br />
				</form>
				</div>
		</div>
	</div>
	<div class="clear_both"></div>
</div>
<?php
    echo'<br />';
	echo "<tr><td class='head' align='center'><input class='formButton' value="._CLOSE." type='button' onclick='javascript:window.close();' /></td></tr>
	</table>";
	xoops_footer();
?>
