<?php

//Calcul la taille du fichier
    function Size($size)
    {
                $mb = 1024*1024;
                if ($size > $mb)
                {
                    $mysize = sprintf ("%01.2f", $size/$mb) . " MB";
                }elseif ($size >= 1024)
                {
                    $mysize = sprintf ("%01.2f", $size/1024) . " KB";
                }
                else
                {
                    $mysize = sprintf(_AM_CATADS_NUMBYTES, $size);
                }
                return $mysize;
    }

//afficher les annonces
    function show_ads()
    {
        global $xoopsModule, $xoopsDB, $xoopsModuleConfig,$adsCatHandler;
            $pick = isset($_GET['pick']) ? intval($_GET['pick']) : 0;
            $start = isset($_GET['start']) ? intval($_GET['start']) : 0;
            $sel_status = isset($_GET['sel_status']) ? $_GET['sel_status'] : 0;
            $sel_order = isset($_GET['sel_order']) ? $_GET['sel_order'] : 'DESC';
			
            $limit = $xoopsModuleConfig['nb_perpage_admin'];
            $status_option0 = '';
            $status_option1 = '';
            $status_option2 = '';
            $status_option3 = '';
//ajout CPascalWeb - affiche uniquement des annonces suspendu par l'annonceur					
            $status_option4 = '';
//ajout CPascalWeb - affiche uniquement des annonces suspendu par le site					
            $status_option5 = '';
//ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse		
            $status_option6 = '';
//fin			
            $order_option_asc = '';
            $order_option_desc = '';
            $jourSecondes = $xoopsModuleConfig['nb_days_expired'] * 86400;
            //$ads_handler =& xoops_getmodulehandler('ads');
			$ads_handler = xoops_getmodulehandler('ads');
            //boite de selection d'affichage: toutes les annonces - les annonces en attente - les annonces en ligne - les annonces expirées
                switch ($sel_status)
                {
				//affichage: toutes les annonces				
                case 0 :
                    $status_option0 = "selected='selected'";
                    $title = _AM_CATADS_ALL;
                    $criteria = new Criteria('ads_id', '0', '>');
                    $criteria->setSort('published');
                break;
				//affichage: les annonces en attente
                case 1 :
                    $status_option2 = "selected='selected'";
                    $title = _AM_CATADS_WAIT;
                    $criteria = new Criteria('waiting', '1');
                    $criteria->setSort('created');
                break;
				//affichage: les annonces en ligne 
                case 2 :
                    $status_option1 = "selected='selected'";
                    $title = _AM_CATADS_PUB;
                    $criteria = new CriteriaCompo(new Criteria('waiting', '0'));
                    $criteria->add(new Criteria('published', time(),'<'));
                    $criteria->add(new Criteria('expired', time(),'>'));
                    $criteria->setSort('published');
                break;
				//affichage: les annonces expirées
                case 3 :
                    $status_option3 = "selected='selected'";
                    $title = _AM_CATADS_EXP;
                    $criteria = new CriteriaCompo(new Criteria('expired', time(), '<'));
                    $criteria->add(new Criteria('waiting', '0'));
                    $criteria->setSort('expired');
                break;
						
//ajout CPascalWeb - affiche uniquement des annonces suspendu par l'annonceur						
                case 4 :
                    $status_option4 = "selected='selected'";
                    $title = _AM_CATADS_SUSPENDUSELEC;
                    $criteria = new CriteriaCompo(new Criteria('suspend', '1'));
                    $criteria->setSort('suspend');
                break;						
//ajout CPascalWeb - affiche uniquement des annonces suspendu par l'annonceur						
                case 5 :
                    $status_option5 = "selected='selected'";
                    $title = _AM_CATADS_SUSPENDUADMINSELEC;
                    $criteria = new CriteriaCompo(new Criteria('suspendadmin', '1'));
                    $criteria->setSort('suspendadmin');
                break;
//ajout fonction CPascalWeb - 5 novembre 2010 annonce signaler frauduleuse	
                case 6 :
                    $status_option6 = "selected='selected'";
                    $title = _AM_CATADS_SIGNALEMENTSELEC;
                    $criteria = new CriteriaCompo(new Criteria('signalementannonce', '1'));
                    $criteria->setSort('signalementannonce');
                break;
//fin					
                }
               //boite de selection d'affichage: des annonces de a-z ou de z-a 	
                switch ($sel_order)
                {
				//affichage: des annonces de a-z
                    case 'ASC':
                    $order_option_asc = "selected='selected'";
                    $criteria->setOrder('ASC');
                    break;
				//affichage: des annonces de z-a
                    case 'DESC':
                    $order_option_desc = "selected='selected'";
                    $criteria->setOrder('DESC');
                    break;
                }

                $totalcount = $ads_handler->getCount($criteria);
                $criteria->setLimit($limit);
                $criteria->setStart($start);
                //$msg =& $ads_handler->getObjects($criteria);
				 $msg = $ads_handler->getObjects($criteria);
                $ads = $ads_handler->getAllAds($criteria);
                //$mytree = new XoopsTree($xoopsDB->prefix("catads_cat"),"topic_id","topic_pid");
                $arr_cat = $adsCatHandler->getAllLastChild();

                echo "<form name='pick' id='pick' action='" . $_SERVER['PHP_SELF'] . "' method='GET' style='margin: 0;'>";
               //boite de selection d'affichage: toutes les annonces - les annonces en attente - les annonces en ligne - les annonces expirées
			   //Ajout CPascalWeb - suspendu par l'annonceur et suspendu par le site et annonces signaler frauduleuses
               //boite de selection d'affichage: des annonces de a-z ou de z-a 			   
			    echo "<table width='100%' cellspacing='1' cellpadding='2' class='head'>
                                <tr>
                                        <td><input name='allbox' id='allbox' onclick='xoopsCheckAll(\"adslist\", \"allbox\");' type='checkbox' value='Check All' /><span style='font-weight: bold; font-size: 12px; font-variant: small-caps; position: relative; top: -.2em;'>". _AM_CATADS_SELECT ."&nbsp;" .$title."&nbsp;(".$totalcount.")</span></td>
                                        <td align='right' style='font-weight: bold; font-size: 12px; font-variant: small-caps; position: relative; top: -.2em;'>
                                        " . _AM_CATADS_DISPLAY . ":
                                                <select name='sel_status' onchange='submit()'>
                                                        <option value='0' $status_option0>" . _AM_CATADS_ALL . " </option>
                                                        <option value='1' $status_option2>" . _AM_CATADS_WAIT . " </option>
                                                        <option value='2' $status_option1>" . _AM_CATADS_PUB . " </option>
                                                        <option value='3' $status_option3>" . _AM_CATADS_EXP . " </option>
														 <option value='4' $status_option4>" . _AM_CATADS_SUSPENDUSELEC . " </option>
														 <option value='5' $status_option5>" . _AM_CATADS_SUSPENDUADMINSELEC . " </option>
														 <option value='6' $status_option6>" . _AM_CATADS_SIGNALEMENTSELEC . " </option>														 
                                                </select>&nbsp;&nbsp;
                                      
                                        " . _AM_CATADS_SELECT_SORT . ":
                                                <select name='sel_order' onchange='submit()'>
                                                <option value='ASC' $order_option_asc>" . _AM_CATADS_SORT_ASC . "</option>
                                                <option value='DESC' $order_option_desc>" . _AM_CATADS_SORT_DESC . "</option>
                                                </select>&nbsp;&nbsp;										
										
										</td>
                                </tr>
                        </table>
                        </form>";
						//modif CPascalWeb
                               /* echo "<table  width='100%' cellspacing='1' class='outer'>";
                                echo "<tr class='bg3'>";
                                echo "<td align='center'><input name='allbox' id='allbox' onclick='xoopsCheckAll(\"adslist\", \"allbox\");' type='checkbox' value='Check All' /></td>";
                                echo "<td align='center'><b>"._AM_CATADS_IMAGE."</td>";
                                echo "<td align='center'><b>"._AM_CATADS_STATUS."</td>";
                                echo "<td align='center'><b>"._AM_CATADS_TITLE_ADS."</td>";
                                echo "<td align='center'><b>"._AM_CATADS_AUTHOR."</td>";
                                echo "<td align='center'><b>"._AM_CATADS_PRICE."</td>";
                                echo "<td align='center'><b>"._AM_CATADS_DATE."</td>";
                                echo "<td align='center'><b>"._AM_CATADS_IP."</td>";
                                echo "<td align='center'><b>"._AM_CATADS_ACTION."</td>";
                                echo "</tr>";*/
						//modif CPascalWeb	

						//annonces
						echo "<table  width='100%' cellspacing='1' class='outer'>";
                        echo "<tr class='bg3'>";
						//modif CPascalWeb ajout textes icônes d'indication et autres liens utiles
                        if ($totalcount != '0')
                        {
                            echo "<form name='adslist' id='adslist' action='" . $_SERVER['PHP_SELF'] . "' method='POST' style='margin: 0;'>";

                            foreach( $msg as $onemsg )
                            {
                                $dateLessNbDays = $onemsg->getVar('expired') - $jourSecondes;
                                if ($onemsg->getVar('waiting') > 0)
                                {
                                    $approve = "<a href='adsmod.php?op=approve&ads_id=".$onemsg->getVar('ads_id')."' class='tooltip' title="._AM_CATADS_APPROVE.">"._AM_CATADS_APPROVE."</a><br />";
                                if ($onemsg->getVar('published') > time())
								//annonce programée en attente de validation	
                                    //$img_status = "<img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/ic16_clockblue.gif' alt='' / >";
                                   	$img_status = "<a href=\"ads.php?sel_status=1&amp;sel_order=ASC\" class='tooltip' title='"._AM_CATADS_ANN_PROGRAMER_ATTENTE."' class='tooltip'><strong><font color='#FFA500'>"._AM_CATADS_ANN_PROGRAMER_ATTENTE."</font></strong>&nbsp;<img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/attention_pf.gif' style='vertical-align: middle;' title='"._AM_CATADS_ANN_PROGRAMER_ATTENTE."' alt='"._AM_CATADS_ANN_PROGRAMER_ATTENTE."' /></a>";								
								else
                                    //$img_status = "<img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/en_attente.gif' alt='"._AM_CATADS_WAIT."' title='"._AM_CATADS_WAIT."' />";
                                   	$img_status = "<a href=\"ads.php?sel_status=1&amp;sel_order=ASC\" class='tooltip' title='"._AM_CATADS_ATTENTE."' class='tooltip'><strong>"._AM_CATADS_ATTENTE."</strong>&nbsp;<img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/attention_pf.gif' style='vertical-align: middle;' title='"._AM_CATADS_ATTENTE."' alt='"._AM_CATADS_ATTENTE."' /></a>";
                                } elseif ( $dateLessNbDays <= time() && time() <= $onemsg->getVar('expired'))
                                {
								//arrive à expiration annonceur prévenu
//modif CPascalWeb - 18 mai 2011 plus besoin envoi mail automatique									
                               // if ( $onemsg->getVar('expired_mail_send') == 0 ){
                                    //$img_status = "<img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/letter.png' alt='"._AM_CATADS_SEND_MAIL."' title='"._AM_CATADS_SEND_MAIL."' />";
                                   	$img_status = "<font color='#FFA52B'>"._AM_CATADS_SEND_MAIL_EXP."</font>&nbsp;<img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/attention_pf.png' class='tooltip' style='vertical-align: middle;' alt='' />";                                        
								//arrive à expiration
								//} else {
                                    //$img_status = "<img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/expiree_bientot.gif' alt='"._AM_CATADS_EXP_SOON."' title='"._AM_CATADS_EXP_SOON."' />";
                                   //	$img_status = "<font color='#FFA52B'>"._AM_CATADS_SEND_MAIL_EXP2."</font>&nbsp;<img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/attention_pf.png' class='tooltip' style='vertical-align: middle;' alt='' />";                                            
								//}
								//annonce expirée	
                                } elseif ($onemsg->getVar('expired') < time())
                                {
                                    //$img_status = "<img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/expiree.gif' alt='"._AM_CATADS_EXP."' title='"._AM_CATADS_EXP."' />";
                                  	$img_status = "<a href=\"ads.php?sel_status=3&amp;sel_order=ASC\" class='tooltip' title="._AM_CATADS_EXPUNE."><strong><font color='red'>"._AM_CATADS_EXPUNE."</font></strong>&nbsp;<img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/avertissement.png' style='vertical-align: middle;'alt='' /></a>";
								//annonce programée
								} elseif ($onemsg->getVar('published') > time())
                                {
                                    $img_status = "<font color='#84A62B'>"._AM_CATADS_ANN_PROGRAMER."</font>&nbsp;<img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/programmer.png' style='vertical-align: middle;' title='"._AM_CATADS_ANN_PROGRAMER."' alt='"._AM_CATADS_ANN_PROGRAMER."' class='tooltip' />";
								} 
								else
                                {
								//annonce en ligne	
                                    //$img_status = "<img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/en_ligne.gif' alt='"._AM_CATADS_PUB."' title='"._AM_CATADS_PUB."' />";
                                   	$img_status = "<strong><font color='#84A62B'>"._AM_CATADS_PUB."</font></strong><a href=\"ads.php?sel_status=2&amp;sel_order=DESC\">&nbsp;<img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/enligne.png' style='vertical-align: middle;' alt='' class='tooltip' /></a>";                                        
								}
								//annonce suspendu par l'annonceur
                                if ($onemsg->getVar('suspend') == '1'){
                                        //$img_status = "<img src='".XOOPS_URL."/modules/".$xoopsModule->getVar('dirname')."/images/icon/stop.gif' alt='Suspended' title='Suspended' />";
                                   	$img_status = "<strong><font color='#949494'>"._AM_CATADS_SUSPENDU."</font></strong>";                                          
								}
//ajout fonction CPascalWeb - 17 septembre 2010 posibilité de suspendre ou de réactivé une annonce										
								//annonce suspendu par l'admin
                                if ($onemsg->getVar('suspendadmin') == '1'){
                                   	$img_status = "<strong><font color='#949494'>"._AM_CATADS_SUSPENDUADMIN."</font></strong>";                                          
								}
//ajout fonction CPascalWeb - 5 novembre 2010 annonce signaler frauduleuse										
								//annonce signaler frauduleuse
                                if ($onemsg->getVar('signalementannonce') == '1'){
                                   	$img_status = "<strong><font color='#949494'>"._AM_CATADS_SIGNALEMENT."</font></strong>";                                          
								}									
//fin de l'ajout 										
								//annonce sans catégorie
                                if(!in_array($onemsg->getVar('cat_id'),$arr_cat))
                                    //$img_status ="<img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/attention.gif' alt='"._AM_CATADS_WARNING."' title='"._AM_CATADS_WARNING."' />";
                                   	$img_status = "<font color='red'>"._AM_CATADS_WARNING."</font>&nbsp;<img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/avertissement.gif' style='vertical-align: middle;' class='tooltip' alt='' />";   
                                    $sentby = XoopsUser::getUnameFromId($onemsg->getVar('uid'));

                                        //$cat_path = $mytree->getpathFromId( $onemsg->getVar('topic_id'), 'topic_title');
                                        //$cat_path = substr($cat_path, 1);
                                        //$cat_path = str_replace("/","<br />",$cat_path);

                                if ( $onemsg->getVar('thumb') != '' ){
                                    $image = "<img src=\"".XOOPS_URL."/uploads/catads/images/annonces/thumb/".$onemsg->getVar('thumb')."\" alt=\"\" />";
                                } else {
//modif CPascalWeb image pasphotos.png + chemin										
                                    //$image = "<img src=\"".XOOPS_URL."/modules/catads/images/no_dispo_mini.gif\" alt=\"\" />";
									$image = "<img src=\"".XOOPS_URL."/uploads/catads/images/annonces/thumb/pasphotos.png\" alt=\"\" />";
                                }
//Ajout CPascalWeb - 18 septembre 2010 active ou désactive une annonce + affiche icône suivant le status										
								if ($onemsg->getVar('suspendadmin') == '0'){
									$icone_status = "<a href='#' class='tooltip' title="._AM_CATADS_WAIT_ACTION."><img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/ok.png' width='18px' alt="._AM_CATADS_WAIT_ACTION." title="._AM_CATADS_WAIT_ACTION." /></a>";
		
								if ($onemsg->getVar('suspend') == '0'){
									$icone_status = "<a href='adsmod.php?op=suspendrereactiver&ads_id=".$onemsg->getVar('ads_id')."' class='tooltip' title="._AM_CATADS_WAIT_ACTION."><img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/ok.png' width='18px' alt="._AM_CATADS_WAIT_ACTION." title="._AM_CATADS_WAIT_ACTION." /></a>";
                                } 
								else {
									$icone_status = "<a href='#' class='tooltip' title="._AM_CATADS_SUSPENDU."><img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/suspenduannonceur.png' width='18px' alt="._AM_CATADS_SUSPENDU." title="._AM_CATADS_SUSPENDU." /></a>";
                                }
								} else {
									$icone_status = "<a href='adsmod.php?op=suspendrereactiver&ads_id=".$onemsg->getVar('ads_id')."' class='tooltip' title="._AM_CATADS_WAIT_ACTION_REACTIVE."><img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/suspendu.png' width='18px' alt="._AM_CATADS_WAIT_ACTION_REACTIVE." title="._AM_CATADS_WAIT_ACTION_REACTIVE." /></a>";
                                }		
//ajout fonction CPascalWeb - 5 novembre 2010 annonce signaler frauduleuse + affiche icône suivant le status										
								/*if ($onemsg->getVar('signalementannonce') == '0'){
									$icone_status = "<a href='adsmod.php?op=signalementannonce&ads_id=".$onemsg->getVar('ads_id')."' class='tooltip' title="._AM_CATADS_SUSPECT_ACTION."><img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/ok.png' width='18px' alt="._AM_CATADS_SUSPECT_ACTION." title="._AM_CATADS_SUSPECT_ACTION." /></a>";
                                } else {
									$icone_status = "<a href='adsmod.php?op=signalementannonce&ads_id=".$onemsg->getVar('ads_id')."' class='tooltip' title="._AM_CATADS_DECLARFRAUDE_OK."><img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/suspect.png' width='18px' alt="._AM_CATADS_DECLARFRAUDE_OK." title="._AM_CATADS_DECLARFRAUDE_OK." /></a>";
                                }*/
//fin									
							//modif CPascalWeb
                                       /* echo "<tr class='odd'>";
                                        echo "<td width='5%' align='center' class='odd';><input type='checkbox' name='ads_id[]' id='ads_id[]' value='".$onemsg->getVar('ads_id')."'/></td>";
                                        echo "<td width='5%' align='center' style='border:1px solid #666666;'><b>".$image."</b></td>";
                                        echo "<td width='5%' align='center' class='odd'>".$img_status."</td>";
                                        echo "<td align='center' class = 'odd'><a href='../adsitem.php?ads_id=".$onemsg->getVar('ads_id')."'>".$onemsg->getVar('ads_title')."</a></td>";
                                        echo "<td align='center' class = 'odd'>".$sentby."</td>";
                                        echo "<td align='center' class = 'odd'>".$onemsg->getVar('price')."&nbsp;".$onemsg->getVar('monnaie')."</td>"; 
                                        echo "<td align='center' class = 'odd'>".formatTimestamp($onemsg->getVar('published'))."</td>";
                                        echo "<td align='center' class = 'odd'>".$onemsg->getVar('poster_ip')."</td>";
                                        echo "<td align='center' class = 'odd'><a href='adsmod.php?op=edit&ads_id=".$onemsg->getVar('ads_id')."'><img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/edit.gif' alt="._AM_CATADS_EDIT." title="._AM_CATADS_EDIT." /></a></td>";
                                        echo "</tr>";*/

								//Ajout CPascalWeb - fonction $icone_status + define + autres fonctions affichage 				
                                echo "<tr>";
                                echo "<th align='left'>"._AM_CATADS_ANNONCES."</th>";
                                echo "<th align='left'>"._AM_CATADS_INFOS."</th>";
                                echo "<th align='left'>"._AM_CATADS_DESCR."</th>";
							    echo "<th align='center' width='10%'><b>"._AM_CATADS_ACTION."</b></th>";
								echo "</tr>";	
								echo "<tr>";
                                echo "<td width='5%' align='center'><a href='../adsitem.php?ads_id=".$onemsg->getVar('ads_id')."' target='_blank'>".$image."</a></td>";
								echo "<td align='left' width='20%' class='even'>
								<b>"._AM_CATADS_TITLE_ADS."</b>:<a href='../adsitem.php?ads_id=".$onemsg->getVar('ads_id')."' target='_blank'>&nbsp;".$onemsg->getVar('ads_title')."</a>
								<br /><br />
                                <b>"._AM_CATADS_SOUMISPAR."</b>:<a href='../../../userinfo.php?uid=".$onemsg->getVar('uid')."' target='_blank'>&nbsp;".$sentby."</a>
								<br />
								<b>"._AM_CATADS_IP."</b>:&nbsp;".$onemsg->getVar('poster_ip')."
								<br />
								<b>"._AM_CATADS_ANNONCE.":&nbsp;ID</b>&nbsp;".$onemsg->getVar('ads_id')."
								<br />
                                <b>"._AM_CATADS_DATE."</b>:&nbsp;".formatTimestamp($onemsg->getVar('published'))."
								<br />
                                <b>"._AM_CATADS_DATEFIN."</b>:&nbsp;".formatTimestamp($onemsg->getVar('expired'))."
								<br />
								<b>"._AM_CATADS_TOUTESANNDE."</b>:<a href='../adslist.php?uid=".$onemsg->getVar('uid')."' target='_blank'>&nbsp;".$sentby."</a>								
								<br />									
								<b>"._AM_CATADS_ANNVUE."</b>:&nbsp;".$onemsg->getVar('view')."
								</td>";
//modif CPascalWeb 16 avril 2011									
                               $myts = MyTextSanitizer::getInstance();
							    echo "<td align='left' valign='top' class='even'>
								".$onemsg->getVar('ads_type').":&nbsp;".$onemsg->getVar('price')."&nbsp;".$onemsg->getVar('monnaie')."&nbsp;".$onemsg->getVar('price_option')."
								<br/><br/>
								".$myts->undoHtmlSpecialChars($onemsg->getVar('ads_desc'))."
								</td>";
//fin								
								echo "<td align='center' class='even'>
                                <a href='../adsitem.php?ads_id=".$onemsg->getVar('ads_id')."' class='tooltip' target='_blank' title="._AM_CATADS_WAIT_VOIR."><img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/viewmag.png' width='18px' alt="._AM_CATADS_WAIT_VOIR." title="._AM_CATADS_WAIT_VOIR." /></a>
								<a href='adsmod.php?op=edit&ads_id=".$onemsg->getVar('ads_id')."' class='tooltip' title="._AM_CATADS_EDIT."><img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/edit.gif' width='18px' alt="._AM_CATADS_EDIT." title="._AM_CATADS_EDIT." /></a>
								". $icone_status ."
								<a href='adsmod.php?op=delete&ads_id=".$onemsg->getVar('ads_id')."' class='tooltip' title="._AM_CATADS_DELETE."><img src='".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/icon/delete.png' width='18px' alt="._AM_CATADS_DELETE." title="._AM_CATADS_DELETE." /></a>	
								</td>";
                                echo "</tr>";
//rappel mettre $sel_status ici plus pratique								
								echo "<th align='left' style='background-color: #FFFFFF;'><input type='checkbox' name='ads_id[]' id='ads_id[]' value='".$onemsg->getVar('ads_id')."'/></th>";
								echo "<th align='left' style='background-color: #FFFFFF;'>".$img_status."</th>";
								echo "<th align='left' style='background-color: #FFFFFF;'>&nbsp;</th>";
								echo "<th align='left' style='background-color: #FFFFFF;'>&nbsp;</th>";
//fin		
                            }

                            switch ($sel_status)
                            {
                            case 1 :
                                echo "<tr class='foot'><td><select name='op'>";
                                echo "<option value='approve_ads'>"._AM_CATADS_APPROUVE."</option>";
                                echo "<option value='delete_ads'>"._AM_CATADS_DELETE."</option>";
                                echo "</select></td>";
                                echo "<td colspan='8'>".$GLOBALS['xoopsSecurity']->getTokenHTML()."<input type='submit' class='xo-buttons' value='"._GO."' />";
                                echo "</td></tr>";
                                echo "</form>";
                            break;

                            case 2 :
                                echo "<tr class='foot'><td><select name='op'>";
                                echo "<option value='wait_ads'>"._AM_CATADS_WAIT1."</option>";
                                echo "<option value='delete_ads'>"._AM_CATADS_DELETE."</option>";
                                echo "</select></td>";
                                echo "<td colspan='8'>".$GLOBALS['xoopsSecurity']->getTokenHTML()."<input type='submit' value='"._GO."' />";
                                echo "</td></tr>";
                                echo "</form>";
                            break;

                            case 3 :
                                echo "<tr class='foot'><td><select name='op'>";
                                echo "<option value='wait_ads'>"._AM_CATADS_WAIT1."</option>";
                                echo "<option value='renew_ads'>"._AM_CATADS_RENEW."</option>";
                                echo "<option value='delete_ads'>"._AM_CATADS_DELETE."</option>";
                                echo "</select></td>";
                                echo "<td colspan='8'>".$GLOBALS['xoopsSecurity']->getTokenHTML()."<input type='submit' value='"._GO."' />";
                                echo "</td></tr>";
                                echo "</form>";
                            break;
//ajout fonction CPascalWeb - 17 septembre posibilité de suspendre ou de réactivé une annonce
							case 4 :
                                echo "<tr class='foot'><td><select name='op'>";
                                echo "<option value='delete_ads'>"._AM_CATADS_DELETE."</option>";
                                echo "</select></td>";
                                echo "<td colspan='8'>".$GLOBALS['xoopsSecurity']->getTokenHTML()."<input type='submit' value='"._GO."' />";
                                echo "</td></tr>";
                                echo "</form>";
                            break;

							case 5 :
                                echo "<tr class='foot'><td><select name='op'>";
                                echo "<option value='delete_ads'>"._AM_CATADS_DELETE."</option>";
                                echo "</select></td>";
                                echo "<td colspan='8'>".$GLOBALS['xoopsSecurity']->getTokenHTML()."<input type='submit' value='"._GO."' />";
                                echo "</td></tr>";
                                echo "</form>";
                            break;												
//fin de l'ajout
//ajout fonction CPascalWeb - 5 novembre 2010 signalement d'une annonce frauduleuse uniquement possibilité de supprimer
							case 6 :
                                echo "<tr class='foot'><td><select name='op'>";
                                echo "<option value='delete_ads'>"._AM_CATADS_DELETE."</option>";
                                echo "</select></td>";
                                echo "<td colspan='8'>".$GLOBALS['xoopsSecurity']->getTokenHTML()."<input type='submit' value='"._GO."' />";
                                echo "</td></tr>";
                                echo "</form>";
                            break;	
//fin de l'ajout
                            default:
                                echo "<tr class='foot'><td><select name='op'>";
                                echo "<option value='approve_ads'>"._AM_CATADS_APPROUVE."</option>";
                                echo "<option value='wait_ads'>"._AM_CATADS_WAIT1."</option>";
                                echo "<option value='renew_ads'>"._AM_CATADS_RENEW."</option>";
                                echo "<option value='delete_ads'>"._AM_CATADS_DELETE."</option>";
 							    echo "</select></td>";
                                echo "<td colspan='8'>".$GLOBALS['xoopsSecurity']->getTokenHTML()."<input type='submit' value='"._GO."' />";
                                echo "</td></tr>";
                                echo "</form>";
                            break;
                            }
                        } else {
                            echo "<tr><td align='center' colspan='10' class='head'><b>"._AM_CATADS_PASANNONCES."</b></td></tr>";
                        }
                            echo "</table>";

                        if ( $totalcount > $limit )
                        {
                            include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
                            $pagenav = new XoopsPageNav($totalcount, $limit, $start, 'start', 'sel_status='.$sel_status.'&sel_order='.$sel_order);
                            echo "<div style='text-align: center;' class='even'>".$pagenav->renderNav()."</div><br />";
                        } else
                        {
                            echo '';
                        }
    }
		
//approuver les annonces
    function approve_ads()
    {
            global $xoopsModule;
            //$ads_handler =& xoops_getmodulehandler('ads');
            $ads_handler = xoops_getmodulehandler('ads');			
            $ads_count = (!empty($_POST['ads_id']) && is_array($_POST['ads_id'])) ? count($_POST['ads_id']) : 0;
            $ads_id = isset($_POST['ads_id']) ? intval($_POST['ads_id']) : 0;

			if ($ads_count > 0)
                {
                        $messagesent = _AM_CATADS_VALIDATE;
                        for ( $i = 0; $i < $ads_count; $i++ )
                        {
                                //$ads = & $ads_handler->get($_POST['ads_id'][$i]);
                                $ads = $ads_handler->get($_POST['ads_id'][$i]);								
                                $ads_id = $ads->getVar('ads_id');
                                $topic_id = $ads->getVar('cat_id');
                                include_once XOOPS_ROOT_PATH."/class/xoopsblock.php";
                                include_once XOOPS_ROOT_PATH.'/class/template.php';
                                xoops_template_clear_module_cache($xoopsModule->getVar('mid'));
                                
								//Notification
                                //$notification_handler =& xoops_gethandler('notification');
                                $notification_handler = xoops_gethandler('notification');								
                                $tags = array();
                                $tags['ADS_TITLE'] = $ads->getVar('ads_type').' '.$ads->getVar('ads_title');
                                $tags['ADS_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/adsitem.php?ads_id=' . $ads_id;

                                if( $ads->getVar('notify_pub') == 1 )
                                {
                                        $notification_handler->triggerEvent('global', 0, 'new_ads', $tags);
                                        $notification_handler->triggerEvent('category', $topic_id, 'new_ads', $tags);
                                        $notification_handler->triggerEvent('ads', $ads_id, 'approve', $tags);
                                }

                                $ads->setVar('waiting', 0);
                                $ads->setVar('notify_pub', 0);
                                if (!$ads_handler->insert($ads))
                                {
                                    $messagesent = _AM_CATADS_ERRORVALID;//Le statut des annonces n'ont pas pu etre modifiées
                                }
                        }
//ajout CPascalWeb - 2 mai 2011 - envoi mail quand une annonce est approuvé	aprés modification					
			global $xoopsDB, $xoopsConfig, $xoopsUser;
	
				$ads_title = $ads->getVar('ads_title');
				$waiting = $ads->getVar('waiting');
				$uid = $ads->getVar('uid');
				
					//récupéré le nom de l'annonceur
					$sql2 = $xoopsDB->query("SELECT uname FROM ".$xoopsDB->prefix("users")." WHERE uid = ".$uid);
					list($uname) = $xoopsDB->fetchRow($sql2);
					
					//Envoie par email
						$mail_url_ads = "<a href='".XOOPS_URL."/modules/catads/adsitem.php?ads_id=".$ads_id."'>".$ads_title."</a>";
						
						$mail_msg_text =  str_replace("{X_UNAME}", $uname, _AM_CATADS_MAIL_VALID_MODIFADS_TEXT);
						$mail_msg_text2 = str_replace("{X_ADS_TITLE}", $ads_title, $mail_msg_text);
						$mail_msg_text3 = str_replace("{X_ADS}", $mail_url_ads, $mail_msg_text2);
						$mail_msg_text4 = str_replace("{X_SITEURL}", XOOPS_URL, $mail_msg_text3);
						$mail_msg_text5 = str_replace("{X_ADMINMAIL}", $xoopsConfig['adminmail'], $mail_msg_text4);
						$mail_msg_text6 = str_replace("{X_SITENAME}", $xoopsConfig['sitename'], $mail_msg_text5);
						$mail_msg = $mail_msg_text6;
						
						include_once XOOPS_ROOT_PATH."/class/xoopsmailer.php";
						$email= $ads->getVar('email');

						$xoopsMailer = getMailer();
						$xoopsMailer->useMail();
						$xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
						$xoopsMailer->setFromName($xoopsConfig['sitename']);
						$xoopsMailer->setToEmails($email);
						$xoopsMailer->setSubject(_AM_CATADS_MAIL_VALID_MODIFADS_TITLE);
						$xoopsMailer->setBody($mail_msg);
						$xoopsMailer->usePM();
						$xoopsMailer->multimailer->isHTML(true);//encodage html
						$xoopsMailer->send();
						$xoopsMailer->getErrors();	
				
						//pour eviter que l'annonce soit a nouveau envoyer
						$sql = "UPDATE ". $xoopsDB->prefix('catads_ads')." SET waiting = '0' WHERE ads_id = ".$ads_id;
						$result = $xoopsDB->queryF($sql);				
//fin					
                }
                else {
                    $messagesent = _AM_CATADS_NOMSG;
                }
                redirect_header($_SERVER['PHP_SELF'],2,$messagesent);
                exit();
    }
	
//Approuver l'annonce apres l'avoir modifiée
    function approve($ads_id) {
        global $xoopsModuleConfig, $xoopsModule;

            //$ads_handler =& xoops_getmodulehandler('ads');
            //$ads = & $ads_handler->get($ads_id);
            $ads_handler = xoops_getmodulehandler('ads');
            $ads = $ads_handler->get($ads_id);			

                if ($ads->getVar('published') < time()){
                    $duration = $ads->getVar('expired') - $ads->getVar('published');
                    $ads->setVar('published', time());
                    $expired = time() + $duration*86400;
//ajout CPascalWeb - 2 mai 2011 - envoi mail quand une annonce est approuvé	aprés modification			
			global $xoopsDB, $xoopsConfig, $xoopsUser;
				$ads_title = $ads->getVar('ads_title');
				$waiting = $ads->getVar('waiting');
				$uid = $ads->getVar('uid');
				
					//récupéré le nom de l'annonceur
					$sql2 = $xoopsDB->query("SELECT uname FROM ".$xoopsDB->prefix("users")." WHERE uid = ".$uid);
					list($uname) = $xoopsDB->fetchRow($sql2);
					
					//Envoie par email
						$mail_url_ads = "<a href='".XOOPS_URL."/modules/catads/adsitem.php?ads_id=".$ads_id."'>".$ads_title."</a>";
						
						$mail_msg_text =  str_replace("{X_UNAME}", $uname, _AM_CATADS_MAIL_VALID_MODIFADS_TEXT);
						$mail_msg_text2 = str_replace("{X_ADS_TITLE}", $ads_title, $mail_msg_text);
						$mail_msg_text3 = str_replace("{X_ADS}", $mail_url_ads, $mail_msg_text2);
						$mail_msg_text4 = str_replace("{X_SITEURL}", XOOPS_URL, $mail_msg_text3);
						$mail_msg_text5 = str_replace("{X_ADMINMAIL}", $xoopsConfig['adminmail'], $mail_msg_text4);
						$mail_msg_text6 = str_replace("{X_SITENAME}", $xoopsConfig['sitename'], $mail_msg_text5);
						$mail_msg = $mail_msg_text6;
						
						include_once XOOPS_ROOT_PATH."/class/xoopsmailer.php";
						$email= $ads->getVar('email');

						$xoopsMailer = getMailer();
						$xoopsMailer->useMail();
						$xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
						$xoopsMailer->setFromName($xoopsConfig['sitename']);
						$xoopsMailer->setToEmails($email);
						$xoopsMailer->setSubject(_AM_CATADS_MAIL_VALID_MODIFADS_TITLE);
						$xoopsMailer->setBody($mail_msg);
						$xoopsMailer->usePM();
						$xoopsMailer->multimailer->isHTML(true);//encodage html
						$xoopsMailer->send();
						$xoopsMailer->getErrors();	
				
						//pour eviter que l'annonce soit a nouveau envoyer
						$sql = "UPDATE ". $xoopsDB->prefix('catads_ads')." SET waiting = '0' WHERE ads_id = ".$ads_id;
						$result = $xoopsDB->queryF($sql);				
//fin					
                } else {
                    $ads->setVar('published', $published);
                    $ads->setVar('expired', $expired);
                }
                $ads->setVar('waiting', 0);
                $cat_id = $ads->getVar('cat_id');
                $approve_ads_ok = $ads_handler->insert($ads);
                if ($approve_ads_ok){
                        $messagesent = _AM_CATADS_ADSAPPROVED;//L'annonce a été publiée
                        // cache
                        include_once XOOPS_ROOT_PATH."/class/xoopsblock.php";
                        include_once XOOPS_ROOT_PATH.'/class/template.php';
                        xoops_template_clear_module_cache($xoopsModule->getVar('mid'));
						
						// Notification
                        //$notification_handler =& xoops_gethandler('notification');
                        $notification_handler = xoops_gethandler('notification');						
                        $tags = array();
                        $tags['ADS_TITLE'] = $ads->getVar('ads_type').' '.$ads->getVar('ads_title');
                        $tags['ADS_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/adsitem.php?ads_id='.$ads_id;

                        $notification_handler->triggerEvent('global', 0, 'new_ads', $tags);
                        $notification_handler->triggerEvent('category', $cat_id, 'new_ads', $tags);
                        $notification_handler->triggerEvent('ads', $ads_id, 'approve', $tags);
                } else {
                        $messagesent = _AM_CATADS_ERROR_UPDATE;//Erreur ! lors de la mise à jour
                }
                redirect_header("index.php?op=show&sel_status=0", 1, $messagesent);
                exit();
    }
	
//mettre une annonce en attente AJOUTER ENVOIE MAIL
    function wait_ads()
    {
            //$ads_handler =& xoops_getmodulehandler('ads');
            $ads_handler = xoops_getmodulehandler('ads');			
            $ads_count = (!empty($_POST['ads_id']) && is_array($_POST['ads_id'])) ? count($_POST['ads_id']) : 0;
                if ($ads_count > 0) {
                    $messagesent = _AM_CATADS_VALIDATE;//Le statut des annonces ont ete modifiées
				
					
                        for ( $i = 0; $i < $ads_count; $i++ )
                        {
                            //$ads = & $ads_handler->get($_POST['ads_id'][$i]);
                            $ads = $ads_handler->get($_POST['ads_id'][$i]);							
                            $ads->setVar('waiting', 1);
                                if (!$ads_handler->insert($ads)) {
                                    $messagesent = _AM_CATADS_ERRORVALID;//Le statut des annonces n'ont pas pu etre modifiées
                                }
                        }
                } else {
                    $messagesent = _AM_CATADS_NOMSG;//Erreur ! aucune annonce sélectionner
                }
                redirect_header($_SERVER['PHP_SELF'],2,$messagesent);
                exit();
    }

		
//renouveler les annonces
    function renew_ads()
    {
                global $xoopsModuleConfig;

                //$ads_handler =& xoops_getmodulehandler('ads');
                $ads_handler = xoops_getmodulehandler('ads');				
                $ads_count = (!empty($_POST['ads_id']) && is_array($_POST['ads_id'])) ? count($_POST['ads_id']) : 0;
                $expired = time() + ($xoopsModuleConfig['renew_nb_days'] * 86400);

                if ($ads_count > 0) {
                        $messagesent = _AM_CATADS_VALIDATE;
                        for ( $i = 0; $i < $ads_count; $i++ )
                        {
                            //$ads = & $ads_handler->get($_POST['ads_id'][$i]);
                            $ads = $ads_handler->get($_POST['ads_id'][$i]);							
                            $ads->setVar('published', time());
                            $ads->setVar('expired', $expired);
                                if (!$ads_handler->insert($ads)) {
                                    $messagesent = _AM_CATADS_ERRORVALID;//Le statut des annonces n'ont pas pu etre modifiées
                                }
                        }
                } else {
                    $messagesent = _AM_CATADS_NOMSG;
                }
                redirect_header($_SERVER['PHP_SELF'],2,$messagesent);
                exit();
    }

		
//supprimer les annonces !!!RAPPEL AJOUTER LA SUPPRESSION DES IMAGES DE L'ANNONCE
    function delete_ads()
    {
               // $ads_handler =& xoops_getmodulehandler('ads');
                $ads_handler = xoops_getmodulehandler('ads');			   
                $ads_count = (!empty($_POST['ads_id']) && is_array($_POST['ads_id'])) ? count($_POST['ads_id']) : 0;
                if ($ads_count > 0) {
                    $messagesent = _AM_CATADS_MSGDELETED;
                        for ( $i = 0; $i < $ads_count; $i++ )
                        {
                           // $ads = & $ads_handler->get($_POST['ads_id'][$i]);
                            $ads = $ads_handler->get($_POST['ads_id'][$i]);						   
                            $filename = $ads->getVar('title');
                            $filename = $ads->getVar('photo');
						
                                if (!$ads_handler->delete($ads))
                                {
                                    $messagesent = _AM_CATADS_ERRORDEL;
                                }
                                /*if($filename != '') {
                                        $filename = XOOPS_ROOT_PATH.'/modules/catads/images/ads/'.$filename;
                                        unlink($filename);
                                }*/
                        }
                }
                else {
                    $messagesent = _AM_CATADS_NOMSG;
                }
                redirect_header($_SERVER['PHP_SELF'],2,$messagesent);
                exit();
    }

		
//supprimer une annonce !!!RAPPEL AJOUTER LA SUPPRESSION DES IMAGES DE L'ANNONCE
	function delete($ads_id) {
            global $xoopsModule;

            $ads_id =  isset($_POST['ads_id']) ? intval($_POST['ads_id']) : intval($_GET['ads_id']);
            $ok =  isset($_POST['ok']) ? intval($_POST['ok']) : 0;

                if ( $ok == 1 ) {
                   // $ads_handler =& xoops_getmodulehandler('ads');
                    //$ads = & $ads_handler->get($ads_id);
                    $ads_handler = xoops_getmodulehandler('ads');
                    $ads = $ads_handler->get($ads_id);					
                    //cache
                    include_once XOOPS_ROOT_PATH."/class/xoopsblock.php";
                    include_once XOOPS_ROOT_PATH.'/class/template.php';
                    xoops_template_clear_module_cache($xoopsModule->getVar('mid'));
                    $i = 0;
                        while ($i < 6){
                                if ($ads->getVar('photo'.$i)) {
//modif CPascalWeb - 17 novembre 2010								
                                    //$filename = XOOPS_ROOT_PATH.'/uploads/catads/images/annonces/original/'.$ads->getVar('photo'.$i);
                                    $filename = XOOPS_ROOT_PATH.'/uploads/'.$xoopsModule->dirname().'/images/annonces/original/'.$ads->getVar('photo'.$i);
//fin									
                                    unlink($filename);
                                }
                                $i++;
                        }
					
                        $del_ads_ok = $ads_handler->delete($ads);
                        if ($del_ads_ok){
                            //supprimer les commentaires
                            xoops_comment_delete($xoopsModule->getVar('mid'), $ads_id);
                            //supprimer les informations automatique
                            xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'ads', $ads_id);
                            $messagesent = _AM_CATADS_ADSDELETED;
                        } else {
                            $messagesent = _AM_CATADS_ERRORDEL;
                        }
//modif CPascalWeb - redirection sur page d'annonce ads.php						
                        //redirect_header("index.php?op=show", 2, $messagesent);
						redirect_header("ads.php?op=show_ads", 2, $messagesent);
//fin
                } else {
                    xoops_cp_header();
                    xoops_confirm(array('op' => 'delete', 'ads_id' => $ads_id, 'ok' => 1), 'adsmod.php', _AM_CATADS_CONF_DEL);
                    xoops_cp_footer();
                }
    }
		
//Formulaire ajouter une categorie
	function categoryForm($topic_id=0, $add)
    {
        global $xoopsDB, $xoopsModule;
        include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';

            $cat = new catadsCategory($topic_id);
                if ($topic_id) {
                    $sform = new XoopsThemeForm(_AM_CATADS_MODIFYCATEGORY, "op", xoops_getenv('PHP_SELF'));
                } else {
                    $sform = new XoopsThemeForm(_AM_CATADS_ADDCATEGORY, "op", xoops_getenv('PHP_SELF'));
                }

                if ($add == 1) {
                    $cat->weight = '1';
                    $cat->img = '----------';
                    $cat->display_cat = 1;
                    $cat->display_price = 1;
                    $cat->nb_photo = 6;
                }
                    $sform->addElement(new XoopsFormText(_AM_CATADS_CATEGORYWEIGHT, 'weight', 10, 5, $cat->weight), false);
                    $sform->addElement(new XoopsFormText(_AM_CATADS_CATEGORYNAME, 'title', 30, 30, $cat->topic_title('E')), true);
                    $sform->addElement(new XoopsFormTextArea(_AM_CATADS_CATEDESC, 'desc', $cat->topic_desc('E')), false);

                    $xt = new XoopsTree($xoopsDB->prefix("catads_cat"),'topic_id','topic_pid');
                    ob_start();
                if ($add == 1) {
                    $xt->makeMySelBox('topic_title','topic_title', 0, 1,'topic_pid');
                    $sform->addElement(new XoopsFormLabel(_AM_CATADS_IN, ob_get_contents()));
                }else{
                    $xt->makeMySelBox('topic_title','topic_title',$cat->topic_pid, 1, 'topic_pid');
                    $sform->addElement(new XoopsFormLabel(_AM_CATADS_MOVETO, ob_get_contents()));
                }
                    ob_end_clean();
					echo "<br />";

                    //$graph_array =& XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH."/uploads/".$xoopsModule->dirname()."/images/categories");
                    $graph_array = XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH."/uploads/".$xoopsModule->dirname()."/images/categories");					
                    $indeximage_select = new XoopsFormSelect('', 'indeximage', $cat->img);
                    $indeximage_select->addOption ('', '----------');
                    $indeximage_select->addOptionArray($graph_array);
                    $indeximage_select->setExtra("onchange='showImgSelected(\"image\", \"indeximage\", \"uploads/".$xoopsModule->dirname()."/images/categories\", \"\", \"".XOOPS_URL."\")'");
                    $indeximage_tray = new XoopsFormElementTray(_AM_CATADS_CATEGORYIMG, '&nbsp;');
                    $indeximage_tray->addElement($indeximage_select);
                    $indeximage_tray->addElement(new XoopsFormLabel('', "<br /><br /><img src='".XOOPS_URL."/uploads/".$xoopsModule->dirname()."/images/categories/".$cat->img."' name='image' id='image' alt='' />" ));
                    $sform->addElement($indeximage_tray);

                    $display_cat = new XoopsFormRadioYN(_AM_CATADS_CAT_DISP, 'display_cat',$cat->display_cat);
                    $sform->addElement($display_cat);

					$check_price = new XoopsFormRadioYN(_AM_CATADS_PRICE_DISP, 'display_price',$cat->display_price);
                    $sform->addElement($check_price);

                    $select_photo = new XoopsFormSelect(_AM_CATADS_NBMAX_PHOTO, 'nb_photo',$cat->nb_photo);
                    $select_photo->addOptionArray(array('0'=>0, '1'=>1, '2'=>2, '3'=>3, '4'=>4, '5'=>5, '6'=>6));
                    $sform->addElement($select_photo);

                    $button_tray = new XoopsFormElementTray('','');
                if ($topic_id) {
                    $button_tray->addElement(new XoopsFormHidden('topic_id', $topic_id));
                    $button_tray->addElement(new XoopsFormButton('', 'save', _SEND, 'submit'));
                    $button_tray->addElement(new XoopsFormButton('', 'delete', _DELETE, 'submit'));
                } else {
                    $button_tray->addElement(new XoopsFormButton('', 'save', _SEND, 'submit'));
                }
                    $button_tray->addElement(new XoopsFormHidden('add', $add));
                    $sform->addElement($button_tray);
                    $sform->display();
    }

		
//Traitement Purge annonces de tout le monde
	function purge_ads_all_user()
    {
        global $xoopsDB;
            $supp_ads_all_user = isset($_POST['supp_ads_all_user']) ? intval($_POST['supp_ads_all_user']) : intval($_GET['supp_ads_all_user']);
            $ok =  isset($_POST['ok']) ? intval($_POST['ok']) : 0;

            if ( $supp_ads_all_user == 0) redirect_header("purge.php", 2);;
                if ( $ok == 1 )
                {
                    if ( $supp_ads_all_user == 1 )
                    {
                        $query = "DELETE FROM ".$xoopsDB->prefix("catads_ads")."";
                        $result = $xoopsDB->queryF($query);
                    }
                        $messagesent = sprintf(_AM_CATADS_DELETE_ADS_ALL_USER);
                        redirect_header("purge.php", 2, $messagesent);
                    }
                    else
                    {
                        xoops_confirm(array('op' => 'purge_ads_all_user', 'supp_ads_all_user' => $supp_ads_all_user, 'ok' => 1), 'purge.php', _AM_CATADS_CONF_DEL_ALL);
                    }
    }


//Traitement Purge annonces expirées
	function purge_ads_expired()
    {
        $nbdays =  isset($_POST['nbdays']) ? intval($_POST['nbdays']) : intval($_GET['nbdays']);
        $ok =  isset($_POST['ok']) ? intval($_POST['ok']) : 0;

            if ( $ok == 1 ) {
                $date_del = time() - $nbdays*86400;
                $criteria = new CriteriaCompo(new Criteria('published', '0', '>'));
                $criteria->add(new Criteria('expired', $date_del,'<'));
                //$ads_handler =& xoops_getmodulehandler('ads');
                $ads_handler = xoops_getmodulehandler('ads');				
                $ads = $ads_handler->getObjects($criteria);
                $nbok = $nbfailed =0;
					foreach($ads as $oneads){
						$i = 0;
							while ($i < 6){
								if ($oneads->getVar('photo'.$i)) {
//modif CPascalWeb - 17 novembre 2010								
                                    //$filename = XOOPS_ROOT_PATH.'/uploads/catads/images/annonces/original/'.$oneads->getVar('photo'.$i);
                                    $filename = XOOPS_ROOT_PATH.'/uploads/'.$xoopsModule->dirname().'/images/annonces/original/'.$oneads->getVar('photo'.$i);
//fin										
									unlink($filename);
                            }
                                $i++;
                            }
                                if($del_ads_ok = $ads_handler->delete($oneads))
                                    $nbok ++;
                                else
                                    $nbfailed ++;
                        }
                        $messagesent = sprintf(_AM_CATADS_ADSEXPDELETED,$nbok);
                        redirect_header("index.php?sel_status=0", 2, $messagesent);
                } else {
                    xoops_confirm(array('op' => 'purge_ads_expired', 'nbdays' => $nbdays, 'ok' => 1), 'purge.php',_AM_CATADS_CONF_DELEXP);
                }
    }


//Traitement Purge annonces annonceurs
	function purge_ads_user()
    {
        global $xoopsDB;
            $user = isset($_POST['user']) ? intval($_POST['user']) : 0;
            $supp_ads_exp = isset($_POST['supp_ads_exp']) ? intval($_POST['supp_ads_exp']) : intval($_GET['supp_ads_exp']);
            $ok =  isset($_POST['ok']) ? intval($_POST['ok']) : 0;

        if ( $user == 0) redirect_header("purge.php", 2, _AM_CATADS_DELETE_ADS_NOUSER);;
            if ( $ok == 1 ) {
                $query = "SELECT uname FROM ".$xoopsDB->prefix("users")." WHERE uid=".$user;
                $result = $xoopsDB->queryF($query);
                $data = $xoopsDB->fetchArray($result);
                $uname = $data['uname'];

            if ( $supp_ads_exp == 1 ) {
            //if ($onemsg->getVar('expired') < time()) {//ne pas oublier a vérifier !
                $query = "DELETE FROM ".$xoopsDB->prefix("catads_ads")." WHERE uid=".$user;
                $result = $xoopsDB->queryF($query);
            }
            else
            {
                $query = "DELETE FROM ".$xoopsDB->prefix("catads_ads")." WHERE uid=".$user." AND expired < ".time()."";
                $result = $xoopsDB->queryF($query);
            }
                $messagesent = sprintf(_AM_CATADS_DELETE_ADS_USER,$uname);
                redirect_header("purge.php", 2, $messagesent);
            }
            else
            {
                xoops_confirm(array('op' => 'purge_ads_user', 'user' => $user, 'supp_ads_exp' => $supp_ads_exp, 'ok' => 1), 'purge.php', _AM_CATADS_CONF_DELEXP);
            }
    }


//Affichage des formulaire de purge
    function show_purge()
    {
        global $xoopsDB;
            //Formulaire de Purge pour tout le monde
            $form = new XoopsThemeForm(_AM_CATADS_ADS_PURGE_ALL_USER, "form", "purge.php");
            $form->addElement(new XoopsFormRadioYN(_AM_CATADS_DELEXP3, 'supp_ads_all_user', 0), true);
            $form->addElement(new XoopsFormHidden("op", "purge_ads_all_user"), true);
            $form->addElement(new XoopsFormButton("", "submit", _AM_CATADS_PURGER, "submit"), true);
            $form->display();
            echo "<br />";

            //Formulaire de Purge par annonceur
            $query = "SELECT uid FROM ".$xoopsDB->prefix("catads_ads")." GROUP BY uid";
            $result = $xoopsDB->query($query);
            $form = new XoopsThemeForm(_AM_CATADS_ADS_USER,"form", "purge.php");
            $select = new XoopsFormSelect(_AM_CATADS_DELEXP1, "user", null, 5, false);
                while($user = $xoopsDB->fetchArray($result))
                {
                    $select->addOption($user["uid"], XoopsUser::getUnameFromId($user["uid"]));
                }

            $form->addElement($select, true);
            $form->addElement(new XoopsFormRadioYN(_AM_CATADS_ADS_DELEXP, 'supp_ads_exp', 0), true);
            $form->addElement(new XoopsFormHidden("op", "purge_ads_user"), true);
            $form->addElement(new XoopsFormButton("", "submit", _AM_CATADS_PURGER, "submit"), true);
            $form->display();
            echo "<br />";

            //Formulaire de Purge par nb jours
            $delform = new XoopsThemeForm(_AM_CATADS_ADS_PURGE, "form", "purge.php");
            $elt_tray = new XoopsFormElementTray(_AM_CATADS_DELEXP2,'');
			$elt_tray->addElement(new XoopsFormText('', 'nbdays', 10, 5, 30), true);
            $elt_tray->addElement(new XoopsFormLabel('', _AM_CATADS_DAYS ));
            $delform->addElement($elt_tray);
            $delform->addElement(new XoopsFormHidden("op", "purge_ads_expired"), true);
            $delform->addElement(new XoopsFormButton('', 'submit', _AM_CATADS_PURGER, 'submit'));
            $delform->display();
    }

?>