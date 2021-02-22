<?php

include_once( "admin_header.php" );
include_once '../include/functions.php';
include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/admin/functions.php";

xoops_cp_header();
//modif CPascalWeb - ajout d'un menu accueil vignettes plus bas
//catads_admin_menu(0, _AM_CATADS_INDEXMANAGE);
//fin
global $xoopsModule;
//         $adminmenu = $xoopsModule->getAdminMenu();
// echo "==>menu : <pre>" . print_r($adminmenu, true) . "</pre>";

/*                    functions                  */
/**********************************************************
 *
 **********************************************************/
function display_statistiques(){
global $xoopsDB, $adminObject;

$indentation = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$tMsg = array();
        //ajout CPascalWeb - 14 septembre 2010 - Compte le nombre total des catégories et sous catégories
		$resultat = $xoopsDB->queryF("SHOW TABLE STATUS FROM `".XOOPS_DB_NAME."` LIKE '".$xoopsDB->prefix("catads_cat")."'"); 
		$countCatTotal = $xoopsDB->fetchArray($resultat);		
		$tMsg[] = sprintf("<label>" . "<strong>". _AM_CATADS_COUNTCATTOTAL ."</strong>" . "</label>","<font color='green'>". $countCatTotal['Rows'] ."</font>");
        //------------------------------------------------------------------------------------------
		//Compte le nombre total d'annonces
		$resultat = $xoopsDB->queryF("SHOW TABLE STATUS FROM `".XOOPS_DB_NAME."` LIKE '".$xoopsDB->prefix("catads_ads")."'"); 
		$countAdsTotal = $xoopsDB->fetchArray($resultat);
		$tMsg[] = sprintf("<label>" . "<strong>". _AM_CATADS_COUNTADSTOTAL ."</strong>" . "</label>","<font color='green'>". $countAdsTotal['Rows'] ."</font>");
        //------------------------------------------------------------------------------------------
		$tMsg[] = '';
        //------------------------------------------------------------------------------------------
		//Compte le nombre total d'annonces en ligne
		$resultat = $xoopsDB->query("SELECT count(*) from ".$xoopsDB->prefix("catads_ads")." WHERE waiting = '0' AND expired > ".time()."");
		list($countAdsTotalLigne)=$xoopsDB->fetchRow($resultat);
		$tMsg[] = sprintf("<label>" . "{$indentation}<strong>". _AM_CATADS_COUNTADSLIGNE ."</strong>" . "</label>","<a href=\"ads.php?sel_status=2&amp;sel_order=ASC\"><font color='green'>". $countAdsTotalLigne ."</font></a>");
        //------------------------------------------------------------------------------------------
		//Compte le nombre total d'annonces en attente
		$resultat = $xoopsDB->query("SELECT count(*) from ".$xoopsDB->prefix("catads_ads")." WHERE waiting = '1'");
		list($countAdsTotalWaiting)=$xoopsDB->fetchRow($resultat);
        
		if($countAdsTotalWaiting > 0)//ajout CPascalWeb - 15 septembre 2010 - affichage couleur suivant résultat
		{
    		//affiche lien + gif si il y a une annonce en attente de validation
    		$tMsg[] = sprintf("<label>" . "{$indentation}<strong>". _AM_CATADS_COUNTADSWAIT ."</strong>" . "</label>","<a href=\"ads.php?sel_status=1&amp;sel_order=ASC\"><font color='red'>". $countAdsTotalWaiting ."</font>&nbsp;<img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/attention_pf.gif' style='position:relative; top: 1px;'valign='middle' alt='' /></a>");
		}
		else
		{
    		//sinon affiche en mode normal
    		$tMsg[] = sprintf("<label>" . "{$indentation}<strong>". _AM_CATADS_COUNTADSWAIT ."</strong>" . "</label>","<font color='green'>". $countAdsTotalWaiting ."</font>");
		}	
        //------------------------------------------------------------------------------------------
		//Compte le nombre total d'annonces expirées
		$resultat = $xoopsDB->query("SELECT count(*) from ".$xoopsDB->prefix("catads_ads")." WHERE expired < ".time()."");
		list($countAdsTotalExpire)=$xoopsDB->fetchRow($resultat);
        
        
		if($countAdsTotalExpire > 0)//ajout CPascalWeb - 15 septembre 2010 - affichage couleur suivant résultat
		{
    		//affiche lien + image si il y a une annonce expirée
    		$tMsg[] = sprintf( "{$indentation}<strong>". _AM_CATADS_COUNTADSEXPIRE ."</strong>"  ,"<a href=\"ads.php?sel_status=3&amp;sel_order=ASC\"><font color='red'>". $countAdsTotalExpire ."</font>&nbsp;<img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/attention_pf.png' style='position:relative; top: 1px;'valign='middle' alt='' /></a>");
		}
		else
		{
    		//sinon affiche en mode normal
    		$tMsg[] = sprintf(  "{$indentation}<strong>". _AM_CATADS_COUNTADSEXPIRE ."</strong>"  ,"<font color='green'>". $countAdsTotalExpire ."</font>");
		}			
        
	
        //--------------------------------------------------------------
        
    $boxName = _AM_CATADS_RECUPADS;
    $adminObject->addInfoBox($boxName);
    foreach ($tMsg as $msg){
        $adminObject->addInfoBoxLine( $msg, '','', '', 'information');
    }


}

/**********************************************************
 *	Espace utilisé
 **********************************************************/
function display_espace_used(){
global $xoopsDB, $adminObject, $xoopsModule;

$indentation = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$tMsg = array();


    //----------------------------------------------------------------------------------
    //nombre d'images et de la taille du fichier uploads/catads/images/annonces/original 		
    //----------------------------------------------------------------------------------
	$dirup = XOOPS_ROOT_PATH . "/uploads/".$xoopsModule->dirname()."/images/annonces/original/";
	$racine=opendir($dirup);
	$taille=0;
	$fileup = 0;
	 while($dossier=@readdir($racine))
		{
			if(!in_array($dossier, Array("..", ".")))
			{
				if(is_dir("$dirup/$dossier"))
				{
					$taille+=taille_dossier("$dirup/$dossier");
				}
				else
				{
					$taille+=@filesize("$dirup/$dossier");
				}
				$fileup++;
			}
		}
		$fileup -= 1;
	@closedir($racine);

	if ($fileup == -1)
	{
		$fileup = 0;
	}

	$tMsg[] = sprintf("<label>". _AM_CATADS_NBPICTURE_FILE_ORIGINAL ." (<font color='green'>" . _AM_CATADS_LENGTH.': ' . Size($taille). "</font>)</label>","<font color='green'>". $fileup ."</font>");


    //-------------------------------------------------------------------------------
    //nombre d'images et de la taille du fichier uploads/catads/images/annonces/thumb 		
    //-------------------------------------------------------------------------------
	$dirup = XOOPS_ROOT_PATH . "/uploads/".$xoopsModule->dirname()."/images/annonces/thumb/";
	$racine=opendir($dirup);
	$taille=0;
	$fileup = 0;
	 while($dossier=@readdir($racine))
		{
			if(!in_array($dossier, Array("..", ".")))
			{
				if(is_dir("$dirup/$dossier"))
				{
					$taille+=taille_dossier("$dirup/$dossier");
				}
				else
				{
					$taille+=@filesize("$dirup/$dossier");
				}
				$fileup++;
			}
		}
		$fileup -= 1;
	@closedir($racine);

	if ($fileup == -1)
	{
		$fileup = 0;
	}		
	$tMsg[] = sprintf("<label>". _AM_CATADS_NBPICTURE_FILE_THUMB ." (<font color='green'>" . _AM_CATADS_LENGTH.': ' . Size($taille). "</font>)</label>","<font color='green'>". $fileup ."</font>");



    //----------------------------------------------------------------------------------
    //nombre d'images et de la taille du fichier uploads/catads/images/annonces/categories			
    //----------------------------------------------------------------------------------
	$dirup = XOOPS_ROOT_PATH . "/uploads/".$xoopsModule->dirname()."/images/categories";
	$racine=opendir($dirup);
	$taille=0;
	$fileup = 0;
	 while($dossier=@readdir($racine))
		{
			if(!in_array($dossier, Array("..", ".")))
			{
				if(is_dir("$dirup/$dossier"))
				{
					$taille+=taille_dossier("$dirup/$dossier");
				}
				else
				{
					$taille+=@filesize("$dirup/$dossier");
				}
				$fileup++;
			}
		}
		$fileup -= 1;
	@closedir($racine);

	if ($fileup == -1)
	{
		$fileup = 0;
		//$taille = 0;
	}		
	$tMsg[] = sprintf("<label>". _AM_CATADS_NBPICTURE_FILE_CAT ." (<font color='green'>" . _AM_CATADS_LENGTH.': ' . Size($taille). "</font>)</label>","<font color='green'>". $fileup ."</font>");

    //--------------------------------------------------------------------
    $boxName = _AM_CATADS_STOCK;
    $adminObject->addInfoBox($boxName);
    foreach ($tMsg as $msg){
        $adminObject->addInfoBoxLine( $msg, '','', '', 'information');
    }


}
/* ********************************************* */

        
  if ($isFwModuleAdmin || true){
     // $index_admin = new ModuleAdmin();
      
      $adminObject->addInfoBox('id');
      $adminObject->addInfoBoxLine( "ID Module : " . $xoopsModule->getVar('mid'));
      $adminObject->addInfoBoxLine( "Dossier : " . $xoopsModule->getVar('dirname'));
  //echoArray($xoopsModule);
//       $adminObject->addInfoBox('description');
//       $adminObject->addInfoBoxLine("_MI_FAQ_XOOPSFAQ_INFO", '', '', 'information');    
      
//       $f = XOOPS_PATH . "/Frameworks/jquery/plugins/showHide.js";
//       $msg = (file_exists($f)) ? _MI_FAQ_SHOWHIDE_OK  : _MI_FAQ_SHOWHIDE_NO;
//      $adminObject->addInfoBoxLine('description', sprintf($msg, $f), '', '', 'information');

      //echo $adminObject->addNavigation('index.php');

      echo  $adminObject->renderButton('right', '');
      
      //echo $adminObject->renderMenuIndex();      
      
    display_statistiques(); 
    display_espace_used();     
/******************************************/      

 $adminObject->displayNavigation(basename(__FILE__));
//     
// 
 $adminObject->displayIndex();

  }
	

xoops_cp_footer();

?>