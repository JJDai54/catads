<?php

include_once(XOOPS_ROOT_PATH."/modules/catads/class/ads.php");
include_once(XOOPS_ROOT_PATH."/modules/catads/class/cat.php");
include_once(XOOPS_ROOT_PATH."/modules/catads/class/permissions.php");

function catads_upload($i) {
        global $xoopsModule, $xoopsModuleConfig, $preview_name, $msgstop;
        $created = time();
        $ext = preg_replace( "/^.+\.([^.]+)$/sU" , "\\1" , $_FILES['photo'.$i]['name']) ;
        include_once(XOOPS_ROOT_PATH."/class/uploader.php");
        $field = $_POST["xoops_upload_file"][$i] ;
        if( !empty( $field ) || $field != "" ) {
                // Vérifiez si le fichier est téléchargé
                if( $_FILES[$field]['tmp_name'] == "" || ! is_readable( $_FILES[$field]['tmp_name'] ) ) {
                    $msgstop .= sprintf(_MD_CATADS_FILEERROR, $xoopsModuleConfig['photo_maxsize']);
                } else {
                    $photos_dir = XOOPS_ROOT_PATH . "/uploads/".$xoopsModule->dirname()."/images/annonces/original" ;
                    $array_allowed_mimetypes = array("image/gif","image/pjpeg","image/jpeg","image/x-png") ;
                    $uploader = new XoopsMediaUploader( $photos_dir , $array_allowed_mimetypes , $xoopsModuleConfig['photo_maxsize'] ,  $xoopsModuleConfig['photo_maxwidth'] ,  $xoopsModuleConfig['photo_maxheight'] ) ;
                    if( $uploader->fetchMedia( $field ) && $uploader->upload() ) {
                        @unlink("$photos_dir/".$preview_name[$i]);
                        $tmp_name = $uploader->getSavedFileName() ;
                        $ext = preg_replace( "/^.+\.([^.]+)$/sU" , "\\1" , $tmp_name ) ;
                        $preview_name[$i] = 'tmp_'.$created.'_'.$i.'.'.$ext;
                        rename( "$photos_dir/$tmp_name" , "$photos_dir/$preview_name[$i]" ) ;
                } else {
                    $msgstop.= $uploader->getErrors();
            }
        }
    }
}

function getAdsItem($ads, $block = 0, $reduireTitle = 0) {
	global $xoopsModule, $xoopsModuleConfig;

        if (empty($xoopsModule) || $xoopsModule->getVar('dirname') != 'catads') {
               /* $module_handler =& xoops_gethandler('module');
                $module =& $module_handler->getByDirname('catads');
                $config_handler =& xoops_gethandler('config');
                $config =& $config_handler->getConfigsByCat(0,$module->getVar('mid'));*/
                $module_handler = xoops_gethandler('module');
                $module = $module_handler->getByDirname('catads');
                $config_handler = xoops_gethandler('config');
                $config = $config_handler->getConfigsByCat(0,$module->getVar('mid'));				
        } else {
                /*$module =& $xoopsModule;
                $config =& $xoopsModuleConfig;*/
                $module = $xoopsModule;
                $config = $xoopsModuleConfig;				
        }
                $a_item = array();
                $listads = array();
                foreach( $ads as $oneads ){
                        $ads_id = $oneads->getVar('ads_id');
                        $a_item['id'] = $ads_id;
                        $a_item['type'] = $oneads->getVar('ads_type');

                        // raccourcir le titre
                       // $reduireTitle = '1' ; // bug
                        $title_length = $xoopsModuleConfig['title_length'];
                        $desc_length = $xoopsModuleConfig['desc_length'];
                        // $title_length = '15' ; // bug

                        if ($reduireTitle > 0)
                        {
                            if ( strlen($oneads->getVar('ads_title')) < $title_length )
                            {
                                $a_item['title'] = $oneads->getVar('ads_title');
                            }
                            else
                            {
                                $recupereCaractere =  substr($oneads->getVar('ads_title'), 0, $title_length);
                                $last_space = strrpos($recupereCaractere, " ");
                                $a_item['title'] = substr($oneads->getVar('ads_title'), 0, $last_space)."...";
                            }
                        }
                        else
                        {
                            $a_item['title'] = $oneads->getVar('ads_title');
                        }
                        //raccourcir la description
                        // $desc_length = '60' ; // debug
                        if ( strlen($oneads->getVar('ads_desc')) < $desc_length )
                        {
//modif CPascalWeb 16 avril 2011							
                            //$a_item['desc'] = $oneads->getVar('ads_desc');
							$myts = MyTextSanitizer::getInstance();
							$a_item['desc'] = $myts->undoHtmlSpecialChars($oneads->getVar('ads_desc'));
//fin							
                        }
                        else
                        {
                            $recupereCaractere =  substr($oneads->getVar('ads_desc'), 0, $desc_length);
                            $last_space = strrpos($recupereCaractere, " ");
                            $a_item['desc'] = substr($oneads->getVar('ads_desc'), 0, $last_space)."...";
                        }

                        if ($oneads->getVar('price') > 0)
							$a_item['price'] = $oneads->getVar('price').' '.$oneads->getVar('monnaie');
							$a_item['price_option'] = $oneads->getVar('price_option');
							$a_item['date'] = ($oneads->getVar('published') > 0) ? formatTimestamp($oneads->getVar('published'),"s") : '';

                        // Code postal et ville concaténés pour l'inscription. Modifier ici si nécessaire.
							// $a_item['local'] = $oneads->getVar('codpost');
							// $a_item['local'] .= ' '.$oneads->getVar('town');
                            $a_item['local'] = $oneads->getVar('town');
							$pk_thumb_width = $xoopsModuleConfig['thumb_width']; 

                        if ( $oneads->getVar('photo0') == '')
                        { 
//modif CPascalWeb image pasphotos.png + chemin							
							//$a_item['photo'] = "<img  id=\"photo".$oneads->getVar('ads_id')."\" alt=\"\" class=\"miniature\" src=\"".XOOPS_URL."/modules/catads/images/no_dispo_mini.gif\" style=\"width: 60px; height: 60px;\"  />";
							$a_item['photo'] = "<img  id=\"photo".$oneads->getVar('ads_id')."\" alt=\"\" class=\"miniature\" src=\"".XOOPS_URL."/uploads/".$xoopsModule->dirname()."/images/annonces/thumb/pasphotos.png\" style=\"width: 60px; height: 60px;\"  />";
//fin
                        } else {
                            // affichage photo-image redimentionné - choix de fixer la largeur dans preference module(ex: 60, 70, 100px etc.) - ajout CPascalWeb title + alt + type + prix supposé pour un meilleur référencement naturel
                            $a_item['photo'] = '<a href="'.XOOPS_URL.'/uploads/'.$xoopsModule->dirname().'/images/annonces/original/'.$oneads->getVar('photo0').'" title="'.$GLOBALS['xoopsConfig']['sitename'].':'.$oneads->getVar('ads_type').' '.$oneads->getVar('price').' '.$oneads->getVar('ads_title').' '.$oneads->getVar('ads_desc').'" alt="'.$oneads->getVar('ads_desc').'" class="highslide" style="width: 250px;" onclick="return hs.expand(this)">
							<img class="miniature" src="'.XOOPS_URL.'/uploads/'.$xoopsModule->dirname().'/images/annonces/thumb/'.$oneads->getVar('thumb').'" title="'.$oneads->getVar('ads_type').' '.$oneads->getVar('price').' '.$oneads->getVar('ads_title').' '.$oneads->getVar('ads_desc').'" alt="'.$oneads->getVar('ads_desc').'" style="width:'.$pk_thumb_width.'px"/></a>';
                        }
//modif CPascalWeb image en format gif pour animation
						//En attente !
                        if ($oneads->getVar('waiting') == 1){
//modif CPascalWeb - supprime image - ajout texte + titre + alt supposé aider au référencement naturel						
                            //$a_item['status'] = "<img src='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/images/icon/en_attente.gif' title='".$oneads->getVar('ads_type').' '.$oneads->getVar('price').' '.$oneads->getVar('ads_title').' '.$oneads->getVar('ads_desc')."' />";
							$a_item['status'] = "<strong><font color='#F7BC5B' title='".$oneads->getVar('ads_type').' '.$oneads->getVar('price').' '.$oneads->getVar('ads_title').' '.$oneads->getVar('ads_desc')."'>"._MD_CATADS_ENATTENTE."</font></strong>";
//fin					
						//Expirée !	
						}elseif ($oneads->getVar('expired') < time()){
//modif CPascalWeb - supprime image - ajout texte + titre + alt supposé aider au référencement naturel							
                            //$a_item['status'] = "<img src='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/images/icon/expiree.gif' title='".$oneads->getVar('ads_type').' '.$oneads->getVar('price').' '.$oneads->getVar('ads_title').' '.$oneads->getVar('ads_desc')."' />";
							$a_item['status'] = "<strong><font color='red' title='".$oneads->getVar('ads_type').' '.$oneads->getVar('price').' '.$oneads->getVar('ads_title').' '.$oneads->getVar('ads_desc')."'>"._MD_CATADS_EXPIREE."</font></strong>";
//fin 
						}elseif ($oneads->getVar('suspend')){
//modif CPascalWeb - supprime image - ajout texte + titre + alt supposé aider au référencement naturel						
                            //$a_item['status'] = "<img src='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/images/icon/stop.gif' title='".$oneads->getVar('ads_type').' '.$oneads->getVar('price').' '.$oneads->getVar('ads_title').' '.$oneads->getVar('ads_desc')."' />";
							$a_item['status'] = "<strong><font color='red' title='".$oneads->getVar('ads_type').' '.$oneads->getVar('price').' '.$oneads->getVar('ads_title').' '.$oneads->getVar('ads_desc')."'>"._MD_CATADS_SUSPARANNOCEUR."</font></strong>";
//fin
//ajout fonction CPascalWeb - 17 septembre posibilité de suspendre ou de réactivé une annonce	                        
                        }elseif ($oneads->getVar('suspendadmin')){
							$a_item['status'] = "<strong><font color='red' title='".$oneads->getVar('ads_type').' '.$oneads->getVar('price').' '.$oneads->getVar('ads_title').' '.$oneads->getVar('ads_desc')."'>"._MD_CATADS_SUSPARADMIN."</font></strong>";
//fin
//ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse		
                        }elseif ($oneads->getVar('signalementannonce')){
							$a_item['status'] = "<strong><font color='red' title='".$oneads->getVar('ads_type').' '.$oneads->getVar('price').' '.$oneads->getVar('ads_title').' '.$oneads->getVar('ads_desc')."'>"._MD_CATADS_SIGNALEMENT."</font></strong>";
//fin					//Va bienôt expirée !
						}elseif ($oneads->getVar('published') > time()){
//modif CPascalWeb - supprime image - ajout texte + titre + alt supposé aider au référencement naturel							
                            //$a_item['status'] = "<img src='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/images/icon/en_attente.gif' title='".$oneads->getVar('ads_type').' '.$oneads->getVar('price').' '.$oneads->getVar('ads_title').' '.$oneads->getVar('ads_desc')."' />";
							$a_item['status'] = "<strong><font color='#F7BC5B' title='".$oneads->getVar('ads_type').' '.$oneads->getVar('price').' '.$oneads->getVar('ads_title').' '.$oneads->getVar('ads_desc')."'>"._MD_CATADS_VAEXPIREE."</font></strong>";
//fin						                        
						}else {
//modif CPascalWeb - supprime image - ajout texte + titre + alt supposé aider au référencement naturel						
                            //$a_item['status'] = "<img src='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/images/icon/en_ligne.gif' title='".$oneads->getVar('ads_type').' '.$oneads->getVar('price').' '.$oneads->getVar('ads_title').' '.$oneads->getVar('ads_desc')."' />";
							$a_item['status'] = "<strong><font color='#84A62B' title='".$oneads->getVar('ads_type').' '.$oneads->getVar('price').' '.$oneads->getVar('ads_title').' '.$oneads->getVar('ads_desc')."'>"._MD_CATADS_ENLIGNE."</font></strong>";
//fin						
						}
                        array_push($listads,$a_item);
                        unset($a_item);
                }
        return $listads;
}

//ajout fonction CPascalWeb - 16 novembre 2010 choix depuis préférence nombres d'annonces à afficher dans liste des derniéres annonces 	
//function showListLastAds($topic_id = 0, $reduireTitle = 0, $uid = 0, $start = 0, $limit = 4) {
function showListLastAds($topic_id = 0, $reduireTitle = 0, $uid = 0, $start = 0, $limit = '') {
    global $ads_handler, $xoopsModuleConfig;
	
        $criteria = new CriteriaCompo(new Criteria('waiting', '0'));
        $criteria->add(new Criteria('suspend','0'));
//ajout fonction CPascalWeb - 17 septembre posibilité de suspendre ou de réactivé une annonce					
		$criteria->add(new Criteria('suspendadmin','0'));				
//ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse	
        if($xoopsModuleConfig['active_suspect'] < '1'){
            $criteria->add(new Criteria('signalementannonce','0'));	
        } 
//fin
//ajout fonction CPascalWeb - 16 novembre 2010 choix depuis préférence nombres d'annonces à afficher dans liste des derniéres annonces 	
		$limit = $xoopsModuleConfig['nb_dernieres_annonces'];
//fin
        $criteria->add(new Criteria('published', time(), '<'));
        $criteria->add(new Criteria('expired', time(),'>'));
    if (is_array($topic_id)){
        $criteria2 = new CriteriaCompo();
    foreach($topic_id as $onecat) {
        $criteria2->add(new Criteria('cat_id',$onecat), 'OR');
    }
        $criteria->add($criteria2);
    } elseif ($topic_id > 0) {
        $criteria->add(new Criteria('cat_id', $topic_id));
    } elseif ($uid > 0)
        $criteria->add(new Criteria('uid', $uid));
        $criteria->setSort('published');
        $criteria->setOrder('DESC');
        $criteria->setStart($start);
        $criteria->setLimit($limit);
        $ads = $ads_handler->getObjects($criteria);
        $listads = getAdsItem($ads, 0, $reduireTitle);
    return $listads;
}


function showListAds($topic_id = 0, $uid = 0, $affichage_titre, $affichage_prix, $affichage_option_prix, $affichage_localisation, $affichage_date, $start = '', $limit = '') {
    global $ads_handler, $xoopsDB, $xoopsUser, $xoopsModuleConfig;
       $criteria = new CriteriaCompo();
       //appel critères supplémentaires (criteria)
        $criteria->add(new Criteria('waiting','0'), 'AND');
        $criteria->add(new Criteria('suspend','0'), 'AND');
//ajout fonction CPascalWeb - 17 septembre posibilité de suspendre ou de réactivé une annonce			
        $criteria->add(new Criteria('suspendadmin','0'), 'AND');		
//ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse	
        if($xoopsModuleConfig['active_suspect'] < '1'){
            $criteria->add(new Criteria('signalementannonce','0'), 'AND');	
        } 
//fin	
        $criteria->add(new Criteria('published', time(),'<'), 'AND');
        $criteria->add(new Criteria('expired', time(),'>'), 'AND');

        if (is_array($topic_id)){
            $criteria2 = new CriteriaCompo();
        foreach($topic_id as $onecat) {
            $criteria2->add(new Criteria('cat_id',$onecat), 'OR');
        }
            $criteria->add($criteria2);
        } elseif ($topic_id > 0) {
            $criteria->add(new Criteria('cat_id', $topic_id));
        } elseif ($uid > 0)
            $criteria->add(new Criteria('uid', $uid));
//Ajout
        if( $affichage_titre != '' || $affichage_prix != '' || $affichage_option_prix != '' || $affichage_localisation != '' || $affichage_date != '')
        {
        //Verif titre
        if ($affichage_titre != '' && $affichage_titre == 'ASC')  {
            $criteria->setSort('ads_title');
            $criteria->setOrder('ASC');
        }
        else if ($affichage_titre != '' && $affichage_titre == 'DESC'){
            $criteria->setSort('ads_title');
            $criteria->setOrder('DESC');
        }
        //Verif prix
        if ($affichage_prix != '' && $affichage_prix == 'ASC')  {
            $criteria->setSort('price');
            $criteria->setOrder('ASC');
        }
        else if ($affichage_prix != '' && $affichage_prix == 'DESC'){
            $criteria->setSort('price');
            $criteria->setOrder('DESC');
        }
        //Verif option prix
        if ($affichage_option_prix != '' && $affichage_option_prix == 'ASC')  {
            $criteria->setSort('price_option');
            $criteria->setOrder('ASC');
        }
        else if ($affichage_option_prix != '' && $affichage_option_prix == 'DESC'){
            $criteria->setSort('price_option');
            $criteria->setOrder('DESC');
        }
        //Verif localisation
        if ($affichage_localisation != '' && $affichage_localisation == 'ASC')  {
            $criteria->setSort('codpost');
            $criteria->setOrder('ASC');
        }
        else if ($affichage_localisation != '' && $affichage_localisation == 'DESC'){
            $criteria->setSort('codpost');
            $criteria->setOrder('DESC');
        }
        //Verif date
        if ($affichage_date != '' && $affichage_date == 'ASC')  {
            $criteria->setSort('published');
            $criteria->setOrder('ASC');
        }
        else if ($affichage_date != '' && $affichage_date == 'DESC'){
            $criteria->setSort('published');
            $criteria->setOrder('DESC');
        }
        }
        else
        {
        //Autrement on affiche les annonces par date, la plus recente
            $criteria->setSort('published');
            $criteria->setOrder('DESC');
        }

        //Ajout
            $criteria->setStart($start);
            $criteria->setLimit($limit);
            $ads = $ads_handler->getObjects($criteria);
            $listads = getAdsItem($ads);
        return $listads;
}


//ajout CPascalWeb -> $topic_id
function showListSearchAds($search, $affichage_titre, $ads_type, $topic_id, $affichage_prix, $affichage_option_prix, $affichage_localisation, $affichage_date, $criteria, $start='', $limit='')
{
//fin ajout    
	global $ads_handler, $xoopsDB, $xoopsUser, $myts, $xoopsModuleConfig;

        $criteria = new CriteriaCompo();

        if ( isset($_SESSION['pk_words']) && trim($_SESSION['pk_words']) != '' ) {
            $criteria4 = new CriteriaCompo();
            $words = $_SESSION['pk_words'];
//modif CPascalWeb - 4 novembre 2010 - mis a jour php 5+	
        //$words = split(' ', $myts->addSlashes($words));
		$words = preg_split('/ /', $myts->addSlashes($words));		
//fin				
            $nb_words = count($words);
                for ( $i = 0; $i < $nb_words; $i++ )
                {
                    $criteria4->add(new Criteria('ads_title', '%'.$words[$i].'%', 'LIKE'), 'OR');
                    $criteria4->add(new Criteria('ads_desc', '%'.$words[$i].'%','LIKE'), 'OR');
                    $criteria4->add(new Criteria('ads_tags', '%'.$words[$i].'%','LIKE'), 'OR');
//ajout CPascalWeb - 4 novembre 2010 - résultat des recherches par type 					
                    $criteria4->add(new Criteria('ads_type', '%'.$words[$i].'%','LIKE'), 'OR');	
//fin					
                }
				$criteria->add($criteria4);
        }

            //$ads_hnd =& xoops_getmodulehandler('ads', 'catads');
            $ads_hnd = xoops_getmodulehandler('ads', 'catads');			
            $permHandler = catadsPermHandler::getHandler();
            // $topic_id = !isset($_SESSION['pk_topic_id'])? NULL : $_SESSION['pk_topic_id'];
            $topic = $permHandler->listAds($xoopsUser, 'catads_access');

			include_once(XOOPS_ROOT_PATH."/class/xoopstree.php");
            $mytree = new XoopsTree($xoopsDB->prefix("catads_cat"),"topic_id","topic_pid");
            $criteria5 = new CriteriaCompo();
            $allcat = $mytree->getAllChildId($topic_id);
            $i = 0;

        foreach($topic as $valeur)
        {
            foreach($allcat as $valeur1)
            {
                if ($valeur == $valeur1)
                {
                    $show_topic_id[$i] = $valeur1;
                    $i++;
                }
            }
        }

        for($j=0; $j<$i; $j++)
        {
        $criteria5->add(new Criteria('cat_id',$show_topic_id[$j]), 'OR');
        }

		$criteria->add($criteria5);
        // pk obtenir topic_id spécifiques prime sur la fonction permanentes
        // $topic_id = !isset($_SESSION['pk_topic_id'])? NULL : $_SESSION['pk_topic_id'];
        if ( isset($_SESSION['pk_topic_id']) && trim($_SESSION['pk_topic_id']) != '' ) {
        $topic_id = $_SESSION["pk_topic_id"];
        $criteria->add(new Criteria('cat_id', $topic_id,'='));
        }

        if ( isset($_SESSION['pk_town']) && trim($_SESSION['pk_town']) != '' ) {
        $town = $_SESSION["pk_town"];
        $criteria->add(new Criteria('town', '%'.$town.'%','LIKE'), 'AND');
        }

        if ( isset($_SESSION['pk_zipcod']) && trim($_SESSION['pk_zipcod']) != '' ) {
        $zipcod = $_SESSION["pk_zipcod"];
        $criteria->add(new Criteria('codpost', '%'.$zipcod.'%','LIKE'), 'AND');
        }

        if ( isset($_SESSION['pk_price_start']) && trim($_SESSION['pk_price_start']) != '' ) {
        $price_start = $_SESSION["pk_price_start"];
        $criteria->add(new Criteria('price', $price_start,'>='), 'AND');
        }

        if ( isset($_SESSION['pk_price_end']) && trim($_SESSION['pk_price_end']) != '' ) {
        $price_end = $_SESSION["pk_price_end"];
        $criteria->add(new Criteria('price', $price_end,'<='), 'AND');
        }

        if ( isset($_SESSION['pk_region']) && trim($_SESSION['pk_region']) != '' ) {
        $region = $_SESSION["pk_region"];
        $criteria->add(new Criteria('region', $region,'='), 'AND');
        }

        if ( isset($_SESSION['pk_departement']) && trim($_SESSION['pk_departement']) != '' ) {
        $departement = $_SESSION["pk_departement"];
        $criteria->add(new Criteria('departement', $departement,'='), 'AND');
        }
//ajout CPascalWeb - 4 novembre 2010 - résultat des recherches par type 		
        if ( isset($_SESSION['ads_type']) && trim($_SESSION['ads_type']) != '' ) {
        $ads_type = $_SESSION["ads_type"];
        $criteria->add(new Criteria('ads_type', $ads_type,'='), 'AND');
        }		
//fin	
        $criteria->add(new Criteria('waiting','0'), 'AND');
        $criteria->add(new Criteria('suspend','0'), 'AND');
//ajout fonction CPascalWeb - 17 septembre posibilité de suspendre ou de réactivé une annonce			
        $criteria->add(new Criteria('suspendadmin','0'), 'AND');		
//ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse
        if($xoopsModuleConfig['active_suspect'] < '1'){
            $criteria->add(new Criteria('signalementannonce','0'), 'AND');
        } 
//fin		
        $criteria->add(new Criteria('published', time(),'<'), 'AND');
        $criteria->add(new Criteria('expired', time(),'>'), 'AND');


//Ajout
        //On regarde si les variables ne sont egal a rien
        if( $affichage_titre != '' || $affichage_prix != '' || $affichage_option_prix != '' || $affichage_localisation != '' || $affichage_date != '')
        {
        //Verif titre
        if ($affichage_titre != '' && $affichage_titre == 'ASC')  {
            $criteria->setSort('ads_title');
            $criteria->setOrder('ASC');
        }
        else if ($affichage_titre != '' && $affichage_titre == 'DESC'){
            $criteria->setSort('ads_title');
            $criteria->setOrder('DESC');
        }
        //Verif prix
        if ($affichage_prix != '' && $affichage_prix == 'ASC')  {
            $criteria->setSort('price');
            $criteria->setOrder('ASC');
        }
        else if ($affichage_prix != '' && $affichage_prix == 'DESC'){
            $criteria->setSort('price');
            $criteria->setOrder('DESC');
        }
        //Verif option prix
        if ($affichage_option_prix != '' && $affichage_option_prix == 'ASC')  {
            $criteria->setSort('price_option');
            $criteria->setOrder('ASC');
        }
        else if ($affichage_option_prix != '' && $affichage_option_prix == 'DESC'){
            $criteria->setSort('price_option');
            $criteria->setOrder('DESC');
        }
        //Verif localisation
        if ($affichage_localisation != '' && $affichage_localisation == 'ASC')  {
            $criteria->setSort('codpost');
            $criteria->setOrder('ASC');
        }
        else if ($affichage_localisation != '' && $affichage_localisation == 'DESC'){
                $criteria->setSort('codpost');
                $criteria->setOrder('DESC');
            }
        //Verif date
        if ($affichage_date != '' && $affichage_date == 'ASC')  {
            $criteria->setSort('published');
            $criteria->setOrder('ASC');
            }
        else if ($affichage_date != '' && $affichage_date == 'DESC'){
            $criteria->setSort('published');
            $criteria->setOrder('DESC');
            }
        }
        else
        {
        //Autrement on affiche les annonces par date, la plus recente
            $criteria->setSort('published');
            $criteria->setOrder('DESC');
        }
        //Ajout
            $criteria->setStart($start);
            $criteria->setLimit($limit);
            $ads = $ads_handler->getObjects($criteria);
            $listads = getAdsItem($ads);
        return $listads;
}


function showListAdsByUser($topic_id = 0, $uid = 0, $affichage_titre, $affichage_prix, $affichage_option_prix, $affichage_localisation, $affichage_date, $start = '', $limit = '') {
    global $ads_handler, $xoopsDB, $xoopsUser, $xoopsModuleConfig;
        //$ads_hnd =& xoops_getmodulehandler('ads', 'catads');
        $ads_hnd = xoops_getmodulehandler('ads', 'catads');		
        $permHandler = catadsPermHandler::getHandler();
        $criteria = new CriteriaCompo();
        $uid = !isset($_REQUEST['uid'])? NULL : $_REQUEST['uid'];
        $topic_id = !isset($_REQUEST['topic_id'])? NULL : $_REQUEST['topic_id'];
        $topic = $permHandler->listAds($xoopsUser, 'catads_access', $topic_id);
        $mytree = new XoopsTree($xoopsDB->prefix("catads_cat"),"topic_id","topic_pid");
        $criteria5 = new CriteriaCompo();
        $allcat = $mytree->getAllChildId($topic_id);
        $i = 0;

        foreach($topic as $valeur)
		{
            foreach($allcat as $valeur1)
            {
                if ($valeur == $valeur1)
                {
					$show_topic_id[$i] = $valeur1;
                    $i++;
                }
            }
        }

        for($j=0; $j<$i; $j++)
        {
            $criteria5->add(new Criteria('cat_id',$show_topic_id[$j]), 'OR');
        }

        $criteria->add($criteria5);
        // critères supplémentaire (criteria)
        $criteria->add(new Criteria('uid', $uid));
        $criteria->add(new Criteria('waiting','0'), 'AND');
        $criteria->add(new Criteria('suspend','0'), 'AND');
//ajout fonction CPascalWeb - 17 septembre posibilité de suspendre ou de réactivé une annonce			
        $criteria->add(new Criteria('suspendadmin','0'), 'AND');
//ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse
        if($xoopsModuleConfig['active_suspect'] < '1'){
            $criteria->add(new Criteria('signalementannonce','0'), 'AND');
        } 
//fin	
        $criteria->add(new Criteria('published', time(),'<'), 'AND');
        $criteria->add(new Criteria('expired', time(),'>'), 'AND');
//Ajout
        //On regarde si les variables ne sont egal a rien
        if( $affichage_titre != '' || $affichage_prix != '' || $affichage_option_prix != '' || $affichage_localisation != '' || $affichage_date != '')
        {
        //Verif titre
                if ($affichage_titre != '' && $affichage_titre == 'ASC')  {
                    $criteria->setSort('ads_title');
                    $criteria->setOrder('ASC');
                }
                else if ($affichage_titre != '' && $affichage_titre == 'DESC'){
                    $criteria->setSort('ads_title');
                    $criteria->setOrder('DESC');
                }
        //Verif prix
                if ($affichage_prix != '' && $affichage_prix == 'ASC')  {
                    $criteria->setSort('price');
                    $criteria->setOrder('ASC');
                }
                else if ($affichage_prix != '' && $affichage_prix == 'DESC'){
                    $criteria->setSort('price');
                    $criteria->setOrder('DESC');
                }
        //Verif option prix
                if ($affichage_option_prix != '' && $affichage_option_prix == 'ASC')  {
                    $criteria->setSort('price_option');
                    $criteria->setOrder('ASC');
                }
                else if ($affichage_option_prix != '' && $affichage_option_prix == 'DESC'){
                    $criteria->setSort('price_option');
                    $criteria->setOrder('DESC');
                }
        //Verif localisation
                if ($affichage_localisation != '' && $affichage_localisation == 'ASC')  {
                    $criteria->setSort('codpost');
                    $criteria->setOrder('ASC');
                }
                else if ($affichage_localisation != '' && $affichage_localisation == 'DESC'){
                    $criteria->setSort('codpost');
                    $criteria->setOrder('DESC');
                }
        //Verif date
                if ($affichage_date != '' && $affichage_date == 'ASC')  {
                    $criteria->setSort('published');
                    $criteria->setOrder('ASC');
                }
                else if ($affichage_date != '' && $affichage_date == 'DESC'){
                    $criteria->setSort('published');
                    $criteria->setOrder('DESC');
                }
        }
        else
        {
        //Autrement on affiche les annonces par date, la plus recente
            $criteria->setSort('published');
            $criteria->setOrder('DESC');
        }
        //Ajout
            $criteria->setStart($start);
            $criteria->setLimit($limit);
            $ads = $ads_handler->getObjects($criteria);
            $listads = getAdsItem($ads);
        return $listads;
}


function showMyAds($topic_id = 0, $uid = 0, $affichage_titre, $affichage_prix, $affichage_option_prix, $affichage_localisation, $affichage_date, $start = '', $limit = '') {
    global $ads_handler, $xoopsDB, $xoopsUser, $xoopsModuleConfig, $isAdmin;

    $uid = !isset($_REQUEST['uid'])? NULL : $_REQUEST['uid'];
    $criteria = new Criteria('uid', $uid);

    //On regarde si les variables ne sont egal a rien
        if( $affichage_titre != '' || $affichage_prix != '' || $affichage_option_prix != '' || $affichage_localisation != '' || $affichage_date != '')
        {
        //Verif titre
            if ($affichage_titre != '' && $affichage_titre == 'ASC')  {
                $criteria->setSort('ads_title');
                $criteria->setOrder('ASC');
            }
            else if ($affichage_titre != '' && $affichage_titre == 'DESC'){
                $criteria->setSort('ads_title');
                $criteria->setOrder('DESC');
            }
        //Verif prix
            if ($affichage_prix != '' && $affichage_prix == 'ASC')  {
                $criteria->setSort('price');
                $criteria->setOrder('ASC');
            }
            else if ($affichage_prix != '' && $affichage_prix == 'DESC'){
                $criteria->setSort('price');
                $criteria->setOrder('DESC');
            }
        //Verif option prix
            if ($affichage_option_prix != '' && $affichage_option_prix == 'ASC')  {
                $criteria->setSort('price_option');
                $criteria->setOrder('ASC');
            }
            else if ($affichage_option_prix != '' && $affichage_option_prix == 'DESC'){
                $criteria->setSort('price_option');
                $criteria->setOrder('DESC');
            }
        //Verif localisation
            if ($affichage_localisation != '' && $affichage_localisation == 'ASC')  {
                $criteria->setSort('codpost');
                $criteria->setOrder('ASC');
            }
            else if ($affichage_localisation != '' && $affichage_localisation == 'DESC'){
                $criteria->setSort('codpost');
                $criteria->setOrder('DESC');
            }
        //Verif date
            if ($affichage_date != '' && $affichage_date == 'ASC')  {
                $criteria->setSort('published');
                $criteria->setOrder('ASC');
            }
            else if ($affichage_date != '' && $affichage_date == 'DESC'){
                $criteria->setSort('published');
                $criteria->setOrder('DESC');
            }
        }
        else
        {
        //Autrement on affiche les annonces par date, la plus recente
            $criteria->setSort('published');
            $criteria->setOrder('DESC');
        }
//Ajout CPascalWeb 26 novembre 2010
			$limit = $xoopsModuleConfig['nb_perpage'];
//fin			
            $criteria->setStart($start);
            $criteria->setLimit($limit);
            $ads = $ads_handler->getObjects($criteria);
            $listads = getAdsItem($ads);
        return $listads;
}


// Effacement fichiers temporaires
function catads_clear_tmp_files( $dir_path , $prefix = 'tmp_' ) {
    if( ! ( $dir = @opendir( $dir_path ) ) )
        return 0 ;
        $ret = 0 ;
        $prefix_len = strlen( $prefix ) ;
        while( ( $file = readdir( $dir ) ) !== false ) {
                if( strncmp( $file , $prefix , $prefix_len ) === 0 ) {
                    if( @unlink( "$dir_path/$file" ) ) $ret ++ ;
                }
        }
        closedir( $dir ) ;
    return $ret ;
}

//redimentionner les images
function resize_image($src_file, $dest_file, $new_size, $method)
{
    global $xoopsModuleConfig, $ERROR;
		$imginfo = getimagesize($src_file);
    if ($imginfo == null)
    return false;
/*
$imginfo[0] //Width
$imginfo[1] //Height
$imginfo[2]; //Type image (1 = GIF  , 2 = JPG  , 3 = PNG  , 4 = SWF  , 5 = PSD  , 6 = BMP  , 7 = TIFF )
*/
        // GD ne peut traiter que JPG & PNG images
        if ($imginfo[2] != 1 && $imginfo[2] != 2 && $imginfo[2] != 3 && ($method == 'gd1' || $method == 'gd2'))
        {
        $ERROR = _MD_GD_FILE_TYPE_ERR;
        return false;
        }
        // height/width
        //echo "Width = ".$imginfo[0]."<br />";

        $srcWidth = $imginfo[0];
        $srcHeight = $imginfo[1];

        $ratio = max($srcWidth, $srcHeight) / $new_size;
        $ratio = max($ratio, 1.0);
        $destWidth = (int)($srcWidth / $ratio);
        $destHeight = (int)($srcHeight / $ratio);

        // Methode pour créer les thumbs
    switch ($method) {
        case "im":
                if (preg_match("#[A-Z]:|\\\\#Ai",__FILE__)){
                        // obtenir le basedir, retirez '/include'
                        $cur_dir = substr(dirname(__FILE__),0, -8);
                        $src_file = '"'.$cur_dir.'\\'.strtr($src_file, '/', '\\').'"';
                        $im_dest_file = str_replace('%', '%%', ('"'.$cur_dir.'\\'.strtr($dest_file, '/', '\\').'"'));
                } else {
                        $src_file = escapeshellarg($src_file);
                        $im_dest_file = str_replace('%', '%%', escapeshellarg($dest_file));
                }

                $output = array();
                $cmd = "{$xoopsModuleConfig['impath']}convert -quality {$xoopsModuleConfig['jpeg_qual']} {$xoopsModuleConfig['im_options']} -geometry {$destWidth}x{$destHeight} $src_file $im_dest_file";
                exec ($cmd, $output, $retval);

                if ($retval) {
                    $ERROR = _MD_IM_ERROR." $retval";
                        if ($xoopsModuleConfig['debug_mode']) {
                            // Re-exécutez la commande avec l'opérateur backtit afin d'obtenir toutes les sorties
                            // ne fonctionne pas est safe mode est activé
                            $output = `$cmd 2>&1`;
                            $ERROR .= "<br /><br /><div align=\"left\">"._MD_IM_ERROR_CMD."<br /><font size=\"2\">".nl2br(htmlspecialchars($cmd))."</font></div>";
                            $ERROR .= "<br /><br /><div align=\"left\">"._MD_IM_ERROR_CONV."<br /><font size=\"2\">";
                            $ERROR .= nl2br(htmlspecialchars($output));
                            $ERROR .= "</font></div>";
                        }
                        @unlink($dest_file);
                    return false;
                }
        break;
		case "net":
            if (preg_match("#[A-Z]:|\\\\#Ai",__FILE__)){
                // obtenir le basedir, retirez '/include'
                $cur_dir = substr(dirname(__FILE__),0, -8);
                $src_file = '"'.$cur_dir.'\\'.strtr($src_file, '/', '\\').'"';
                $im_dest_file = str_replace('%', '%%', ('"'.$cur_dir.'\\'.strtr($dest_file, '/', '\\').'"'));
            } else {
                $src_file =   escapeshellarg($src_file);
                $im_dest_file = str_replace('%', '%%', escapeshellarg($dest_file));
            }
        switch ($imginfo[2]){
        case GIS_GIF:
            $op_in  = 'giftopnm';
            $op_out = 'ppmtogif';
            $op_out2 = 'pnmtogif';
            $cmd = "{$xoopsModuleConfig['impath']}{$op_in} $src_file | pnmscale -xsize={$destWidth} -ysize={$destHeight} | ppmquant 255 | {$op_out} > $im_dest_file";
        break;

        case GIS_JPG:
            $op_in  = 'jpegtopnm';
            $op_out = 'pnmtojpeg';
            $op_out2 = 'ppmtojpeg';
            $cmd = "{$xoopsModuleConfig['impath']}{$op_in} $src_file | pnmscale -xsize={$destWidth} -ysize={$destHeight} | {$op_out} -quality={$xoopsModuleConfig['jpeg_qual']} > $im_dest_file";
            $cmd2 = "{$xoopsModuleConfig['impath']}{$op_in} $src_file | pnmscale -xsize={$destWidth} -ysize={$destHeight} | {$op_out2} -quality={$xoopsModuleConfig['jpeg_qual']} > $im_dest_file";
		break;

        case GIS_PNG:
            $op_in  = 'pngtopnm';
            $op_out = 'pnmtopng';
            $cmd = "{$xoopsModuleConfig['impath']}{$op_in} $src_file | pnmscale -xsize={$destWidth} -ysize={$destHeight} | {$op_out} > $im_dest_file";
        break;
        }
            $output = array();
        echo $cmd;
        if(!(@exec ($cmd)) && isset($cmd2)) @exec ($cmd2);
        break;//ferme ->case 'net'

        case "gd1":

                if (!function_exists('imagecreatefromjpeg')) {
					redirect_header(XOOPS_URL."/modules/catads/index.php",2,_MD_NO_GD_FOUND);
                }
                if ($imginfo[2] == GIS_JPG)
                        $src_img = imagecreatefromjpeg($src_file);
                elseif ($imginfo[2] == GIS_GIF)
                        $src_img = imagecreatefromgif($src_file);
                else
                        $src_img = imagecreatefrompng($src_file);
                if (!$src_img){
                        $ERROR = _MD_INVALID_IMG;
                    return false;
                }
                $dst_img = imagecreate($destWidth, $destHeight);
                imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $destWidth, (int)$destHeight, $srcWidth, $srcHeight);
                imagejpeg($dst_img, $dest_file, 80);
                imagedestroy($src_img);
                imagedestroy($dst_img);
        break;

        case "gd2":
                //echo "gd2<br>";
                if (!function_exists('imagecreatefromjpeg')) {
                    redirect_header('index.php',2,_AM_CATADS_NO_GD_FOUND);
					redirect_header(XOOPS_URL."/modules/catads/index.php",2,_AM_CATADS_NO_GD_FOUND);
                }
                if (!function_exists('imagecreatetruecolor')) {
					redirect_header(XOOPS_URL."/modules/catads/index.php",2,_MD_GD_VERSION_ERR);
                }
                if ($imginfo[2] == 2 )
                        $src_img = imagecreatefromjpeg($src_file);
                elseif ($imginfo[2] == 1 )
                        $src_img = imagecreatefromgif($src_file);
                else
                        $src_img = imagecreatefrompng($src_file);
                if (!$src_img){
                        $ERROR = _MD_INVALID_IMG;
                    return false;
                }
                $dst_img = imagecreatetruecolor($destWidth, $destHeight);
                imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $destWidth, (int)$destHeight, $srcWidth, $srcHeight);
                imagejpeg($dst_img, $dest_file, 80);
                imagedestroy($src_img);
                imagedestroy($dst_img);
        break;
	}

        // Réglez le mode de l'image téléchargée
        chmod($dest_file, 0644);
        //echo "fichier destination = ".$dest_file;
        // On vérifie que l'image est valide
        $imginfo = getimagesize($dest_file);
        if ($imginfo == null){
            $ERROR = _MD_RESIZE_FAILED;
            @unlink($dest_file);
            return false;
        } else {
            return true;
        }
	}

	
//function &deleteCode(&$text) {
function deleteCode($text) {
        $patterns = array();
        $replacements = array();
        $patterns[] = "/\[siteurl=(['\"]?)([^\"'<>]*)\\1](.*)\[\/siteurl\]/sU";
        $replacements[] = '\\3';
        $patterns[] = "/\[url=(['\"]?)(http[s]?:\/\/[^\"'<>]*)\\1](.*)\[\/url\]/sU";
        $replacements[] = '\\3';
        $patterns[] = "/\[url=(['\"]?)(ftp?:\/\/[^\"'<>]*)\\1](.*)\[\/url\]/sU";
        $replacements[] = '\\3';
        $patterns[] = "/\[url=(['\"]?)([^\"'<>]*)\\1](.*)\[\/url\]/sU";
        $replacements[] = '\\3';
        $patterns[] = "/\[color=(['\"]?)([a-zA-Z0-9]*)\\1](.*)\[\/color\]/sU";
        $replacements[] = '\\3';
        $patterns[] = "/\[size=(['\"]?)([a-z0-9-]*)\\1](.*)\[\/size\]/sU";
        $replacements[] = '\\3';
        $patterns[] = "/\[font=(['\"]?)([^;<>\*\(\)\"']*)\\1](.*)\[\/font\]/sU";
        $replacements[] = '\\3';
        $patterns[] = "/\[email]([^;<>\*\(\)\"']*)\[\/email\]/sU";
        $replacements[] = '\\1';
        $patterns[] = "/\[b](.*)\[\/b\]/sU";
        $replacements[] = '\\1';
        $patterns[] = "/\[i](.*)\[\/i\]/sU";
        $replacements[] = '\\1';
        $patterns[] = "/\[u](.*)\[\/u\]/sU";
        $replacements[] = '\\1';
        $patterns[] = "/\[d](.*)\[\/d\]/sU";
        $replacements[] = '\\1';
    return preg_replace($patterns, $replacements, $text);
	}

//rss (a revoir)
function getTitleById($topic_id = 0){
global $xoopsDB;
        //$db =& Database::getInstance();
        $db = $xoopsDB; //Database::getInstance();		
        $sql = "SELECT topic_title FROM ".$db->prefix("catads_cat")." WHERE topic_id =".$topic_id;
        $result = $db->query($sql);
    list($title) = $db->fetchRow($result);
    return $title;
}

//ajout CPascalWeb - 14 mai 2011 - fonction envoi email lorsque l'annonce arrive a expiration et lorsqu'elle a expirée
//!!!Bug envoi plusieurs fois les mails 
function catads_expired_ads()
{
	global $xoopsDB, $xoopsModuleConfig, $xoopsConfig, $xoopsUser;

	$hModule = xoops_gethandler('module');
	$hModConfig = xoops_gethandler('config');
	$catadsModule = $hModule->getByDirname('catads');	
	$module_id = $catadsModule -> getVar( 'mid' );
	$module_name = $catadsModule -> getVar( 'dirname' );
	$catadsConfig = $hModConfig->getConfigsByCat(0, $catadsModule->getVar('mid'));
	$daysSecondes = $catadsConfig['nb_days_expired'] * 86400;
	//$daysSecondes =  time() - ($catadsConfig['nb_days_expired'] * 86400);

	$sql = $xoopsDB->query("SELECT ads_id, expired, email FROM ".$xoopsDB->prefix("catads_ads")." WHERE waiting = '0'");
	while ($resultat = $xoopsDB->fetchArray($sql)) 	
	//while(list($ads_id, $expired, $email) = $xoopsDB->fetchRow($sql))
	{

		$dateLessNbDays = $resultat['expired'] - $daysSecondes;
		
		//Recherche des annonces qui vont bientot expirées
		//if ( time() >= $dateLessNbDays && time() <= $resultat['expired'] )
		if( $dateLessNbDays <= time() && time() <= $resultat['expired'])
		{
			
			//Selection des infos de l'annonce
			$sql1 = $xoopsDB->query("SELECT ads_id, ads_title, uid, email, created FROM ".$xoopsDB->prefix("catads_ads")." WHERE ads_id=".$resultat['ads_id']);
			list ($ads_id, $ads_title, $uid, $email, $created) = $xoopsDB -> fetchRow($sql1);
			$resultat1 = $xoopsDB->fetchArray($sql1);
			
			
				//Cherche le nom de l'annonceur
				$sql2 = $xoopsDB->query("SELECT uname FROM ".$xoopsDB->prefix("users")." WHERE uid = ".$uid);
				list($uname) = $xoopsDB->fetchRow($sql2);

						//Envoie par MP pour test en local
						/*$mp_url_ads = "[b][url=".XOOPS_URL."/modules/catads/adsitem.php?ads_id=".$ads_id."]\"".$ads_title."\"[/url][/b]";
						$mp_url_ads_renew = "[b][url=".XOOPS_URL."/modules/catads/renew.php?ads_id=".$ads_id."&uid=".$uid."&key=".$created."&expired=".$resultat['expired']."]\""._MD_CATADS_RENEW_ADS."\"[/url][/b]";
						
						$mp_title_ads = $resultat1['ads_title'];
		
						$mp_msg_text = str_replace("{X_UNAME}", $uname, _MD_CATADS_MAIL_TEXT);
						$mp_msg_text2 = str_replace("{X_ADS_TITLE}", $mp_title_ads, $mp_msg_text);
						$mp_msg_text3 = str_replace("{X_ADS}", $mp_url_ads, $mp_msg_text2);
						$mp_msg_text4 = str_replace("{X_DAY}", $catadsConfig['nb_days_expired'], $mp_msg_text3);
						$mp_msg_text5 = str_replace("{X_ADS_RENEW}", $mp_url_ads_renew, $mp_msg_text4);
						$mp_msg_text6 = str_replace("{X_SITEURL}", XOOPS_URL, $mp_msg_text5);
						$mp_msg_text7 = str_replace("{X_ADMINMAIL}", $xoopsConfig['adminmail'], $mp_msg_text6);
						$mp_msg_text8 = str_replace("{X_SITENAME}", $xoopsConfig['sitename'], $mp_msg_text7);
						
						$mp_msg = $mp_msg_text8;
						$mp_suject = _MD_CATADS_MAIL_TITLE;
						$mp_msg_time = time(); 
						
						//Insertion d'un message lors de l'expiration
						 $sql = "INSERT INTO ".$xoopsDB->prefix("priv_msgs")."(msg_id, msg_image, subject, from_userid, to_userid, msg_time, msg_text, read_msg) VALUES('','','".$mp_suject."','1','".$uid."','".$mp_msg_time."','".$mp_msg."','')";
						 $result = $xoopsDB->queryF($sql);
						 
						//pour eviter que le mail soit envoyer plusieurs fois //MANQUE PARAMETRE $dateLessNbDays
						$sql = "UPDATE ". $xoopsDB->prefix('catads_ads')." SET expired WHERE ads_id = ".$ads_id;
						$result = $xoopsDB->queryF($sql);*/

						//email automatique
						$mail_url_ads = "<a href='".XOOPS_URL."/modules/catads/adsitem.php?ads_id=".$ads_id."'>".$ads_title."</a>";
//rappel ! mettre la boite de sélection (sel_box 4) en guisse de lien $xoopsModuleConfig['renew_nb_days'] est réservé pour l'admin puis supp renew.php
//boite de sélection (sel_box 4) renouveler l'annonce
/* $jump = XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/adsitem.php?op=pubagain&amp;ads_id=".$ads_id."&amp;duration=";        
$opt = new catadsOption();
ob_start();
$opt->makeMySelBox('option_order','', 1, 4, "location=\"".$jump."\"+this.options[this.selectedIndex].value");
$xoopsTpl->assign('sel_box', ob_get_contents());
ob_end_clean();*/						
						$mail_url_ads_renew = "<a href='".XOOPS_URL."/modules/catads/renew.php?ads_id=".$ads_id."&uid=".$uid."&key=".$created."&expired=".$resultat['expired']."'>"._MD_CATADS_RENEW_ADS."</a>";
						$mail_title_ads = $resultat1['ads_title'];
						
						$mail_msg_text = str_replace("{X_UNAME}", $uname, _MD_CATADS_MAIL_TEXT);
						$mail_msg_text2 = str_replace("{X_ADS_TITLE}", $mail_title_ads, $mail_msg_text);
						$mail_msg_text3 = str_replace("{X_ADS}", $mail_url_ads, $mail_msg_text2);
						$mail_msg_text4 = str_replace("{X_DAY}", $catadsConfig['nb_days_expired'], $mail_msg_text3);
						$mail_msg_text5 = str_replace("{X_ADS_RENEW}", $mail_url_ads_renew, $mail_msg_text4);
						$mail_msg_text6 = str_replace("{X_SITEURL}", XOOPS_URL, $mail_msg_text5);
						$mail_msg_text7 = str_replace("{X_ADMINMAIL}", $xoopsConfig['adminmail'], $mail_msg_text6);
						$mail_msg_text8 = str_replace("{X_SITENAME}", $xoopsConfig['sitename'], $mail_msg_text7);
						
						$mail_msg = $mail_msg_text8;
						
						include_once XOOPS_ROOT_PATH."/class/xoopsmailer.php";

						$xoopsMailer = xoops_getMailer();
						$xoopsMailer->useMail();
						$xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
						$xoopsMailer->setFromName($xoopsConfig['sitename']);
						$xoopsMailer->setToEmails($email);
						$xoopsMailer->setSubject(_MD_CATADS_MAIL_TITLE);
						$xoopsMailer->setBody($mail_msg);
						$xoopsMailer->usePM();
						$xoopsMailer->multimailer->isHTML(true);
						$xoopsMailer->send();
						$xoopsMailer->getErrors();	
						 
						 //pour eviter que l'annonce soit a nouveau envoyer//MANQUE PARAMETRE $dateLessNbDays
						$sql = "UPDATE ". $xoopsDB->prefix('catads_ads')." SET expired WHERE ads_id = ".$ads_id;
						$result = $xoopsDB->queryF($sql);
		}
		//envoi mail automatique une fois l'annonce expirée		
		if ($resultat['expired'] < time())
		{
			//Selection des infos de l'annonce
			$sql1 = $xoopsDB->query("SELECT ads_id, ads_title, uid, email, created FROM ".$xoopsDB->prefix("catads_ads")." WHERE ads_id=".$resultat['ads_id']);
			list ($ads_id, $ads_title, $uid, $email, $created) = $xoopsDB -> fetchRow($sql1);
			$resultat1 = $xoopsDB->fetchArray($sql1);
			
				//Cherche le nom de l'annonceur
				$sql2 = $xoopsDB->query("SELECT uname FROM ".$xoopsDB->prefix("users")." WHERE uid = ".$uid);
				list($uname) = $xoopsDB->fetchRow($sql2);
				
						//Envoie par MP pour test en local
						/*$mp_url_ads = "[b][url=".XOOPS_URL."/modules/catads/adsitem.php?ads_id=".$ads_id."]\"".$ads_title."\"[/url][/b]";
						$mp_url_ads_renew = "[b][url=".XOOPS_URL."/modules/catads/renew.php?ads_id=".$ads_id."&uid=".$uid."&key=".$created."&expired=".$resultat['expired']."]\""._MD_CATADS_RENEW_ADS."\"[/url][/b]";
						
						$mp_title_ads = $resultat1['ads_title'];
		
						$mp_msg_text = str_replace("{X_UNAME}", $uname, _MD_CATADS_MAIL_EXPTEXT);
						$mp_msg_text2 = str_replace("{X_ADS_TITLE}", $mp_title_ads, $mp_msg_text);
						$mp_msg_text3 = str_replace("{X_ADS}", $mp_url_ads, $mp_msg_text2);
						$mp_msg_text4 = str_replace("{X_DAY}", formatTimestamp($resultat['expired']), $mp_msg_text3);
						$mp_msg_text5 = str_replace("{X_ADS_RENEW}", $mp_url_ads_renew, $mp_msg_text4);
						$mp_msg_text6 = str_replace("{X_SITEURL}", XOOPS_URL, $mp_msg_text5);
						$mp_msg_text7 = str_replace("{X_ADMINMAIL}", $xoopsConfig['adminmail'], $mp_msg_text6);
						$mp_msg_text8 = str_replace("{X_SITENAME}", $xoopsConfig['sitename'], $mp_msg_text7);
						
						$mp_msg = $mp_msg_text8;
						$mp_suject = _MD_CATADS_MAIL_EXPTITLE;
						$mp_msg_time = time(); */
						
						//email automatique
						$mail_url_ads = "<a href='".XOOPS_URL."/modules/catads/adsitem.php?ads_id=".$ads_id."'>".$ads_title."</a>";
//rappel ! mettre la boite de sélection (sel_box 4) en guisse de lien $xoopsModuleConfig['renew_nb_days'] est réservé pour l'admin puis supp renew.php
//boite de sélection (sel_box 4) renouveler l'annonce
/* $jump = XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/adsitem.php?op=pubagain&amp;ads_id=".$ads_id."&amp;duration=";        
$opt = new catadsOption();
ob_start();
$opt->makeMySelBox('option_order','', 1, 4, "location=\"".$jump."\"+this.options[this.selectedIndex].value");
$xoopsTpl->assign('sel_box', ob_get_contents());
ob_end_clean();*/						
						$mail_url_ads_renew = "<a href='".XOOPS_URL."/modules/catads/renew.php?ads_id=".$ads_id."&uid=".$uid."&key=".$created."&expired=".$resultat['expired']."'>"._MD_CATADS_RENEW_ADS."</a>";
						$mail_title_ads = $resultat1['ads_title'];
						
						$mail_msg_text = str_replace("{X_UNAME}", $uname, _MD_CATADS_MAIL_EXPTEXT);
						$mail_msg_text2 = str_replace("{X_ADS_TITLE}", $mail_title_ads, $mail_msg_text);
						$mail_msg_text3 = str_replace("{X_ADS}", $mail_url_ads, $mail_msg_text2);
						$mail_msg_text4 = str_replace("{X_DAY}", formatTimestamp($resultat['expired']), $mail_msg_text3);
						$mail_msg_text5 = str_replace("{X_ADS_RENEW}", $mail_url_ads_renew, $mail_msg_text4);
						$mail_msg_text6 = str_replace("{X_SITEURL}", XOOPS_URL, $mail_msg_text5);
						$mail_msg_text7 = str_replace("{X_ADMINMAIL}", $xoopsConfig['adminmail'], $mail_msg_text6);
						$mail_msg_text8 = str_replace("{X_SITENAME}", $xoopsConfig['sitename'], $mail_msg_text7);
						
						$mail_msg = $mail_msg_text8;
						
						include_once XOOPS_ROOT_PATH."/class/xoopsmailer.php";

						$xoopsMailer = xoops_getMailer();
						$xoopsMailer->useMail();
						$xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
						$xoopsMailer->setFromName($xoopsConfig['sitename']);
						$xoopsMailer->setToEmails($email);
						$xoopsMailer->setSubject(_MD_CATADS_MAIL_EXPTITLE);
						$xoopsMailer->setBody($mail_msg);
						$xoopsMailer->usePM();
						$xoopsMailer->multimailer->isHTML(true);
						$xoopsMailer->send();
						$xoopsMailer->getErrors();							

						//pour eviter que le mail soit a nouveau envoyer
						//$sql = "UPDATE ". $xoopsDB->prefix('catads_ads')." SET expired='0' WHERE ads_id = ".$ads_id;
						//$result = $xoopsDB->queryF($sql);
		}
	}	
	//return '';
}

?>