<?php

$modversion['name'] = _MI_CATADS_NAME;
$modversion['version'] = '1.7';
$modversion['module_status']    = 'RC 1';
$modversion['release_date']     = '2021/02/21';
$modversion['description'] = _MI_CATADS_DESC;
$modversion['credits'] = _MI_CATADS_CREDIT;
$modversion['author'] = 'CPascalWeb - JJdai(jjdelalandre@orange.fr)';
$modversion["license"] 	= "GNU General Public License";
$modversion["license_url"]	= "http://www.gnu.org/licenses/gpl.html";
$modversion['official'] = 0;
$modversion['image'] = "images/annonces.png";
$modversion['dirname'] = "catads";
$modversion['module_website_url']  = 'www.xoops.org/';
$modversion['module_website_name'] = 'XOOPS';
$modversion['min_php']             = '5.5';
$modversion['min_xoops']           = '2.5.9';

//status
$modversion['status'] = "1.6 Release Candidate 1";
$modversion['support_site_url'] = "http://www.frxoops.org/modules/newbb/viewforum.php?forum=12";
$modversion['support_site_name'] = "Xoops France";
$modversion['support_email'] = "";
$modversion['submit_bug'] = "http://www.frxoops.org/modules/newbb/viewforum.php?forum=12";
$modversion['submit_feature'] = "http://www.frxoops.org/modules/liaise/index.php?form_id=3";
$modversion['author_word'] = _MI_CATADS_HISTORY;

//Administration
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu']  = "admin/menu.php";
$modversion['system_menu'] = 1;

//insertion des valeurs installe ou mise a jour
$modversion['onUpdate'] = 'include/update_function.php';
$modversion['onInstall'] = 'include/install_function.php';

//             les templates
$i=0;
$modversion['templates'][$i++]=['file' => 'catads_index.tpl',
                                'description' => 'Page d\'accueil du module'];

$modversion['templates'][$i++]=['file' => 'catads_adslist.tpl',
                                'description' => 'affiche la liste des annonces dans la recherche'];

$modversion['templates'][$i++]=['file' => 'catads_item.tpl',
                                'description' => ''];

$modversion['templates'][$i++]=['file' => 'catads_addsubcat.tpl',//ne sert pas visiblement faire un bloc avec !
                                'description' => 'affiche la liste des sous catégories'];

$modversion['templates'][$i++]=['file' => 'catads_adssublist.tpl',
                                'description' => 'les dernières petites annonces'];

$modversion['templates'][$i++]=['file' => 'catads_subcat.tpl',
                                'description' => 'affiche la liste des sous catégories en page d\'acceuil'];

$modversion['templates'][$i++]=['file' => 'catads_adsform.tpl',
                                'description' => 'formulaire pour soumettre une annonce'];

$modversion['templates'][$i++]=['file' => 'catads_adsform2.tpl',
                                'description' => 'formulaire pour modifier une annonce'];

$modversion['templates'][$i++]=['file' => 'catads_cat.tpl',
                                'description' => 'affiche la liste des catégories en page d\'acceuil'];


//ajout CPascalWeb - 25 novembre 2010 page html spécifique pour soumettre une annonce
$modversion['templates'][$i++]=['file' => 'catads_soumettre.tpl',
                                'description' => 'Page pour soumettre une annonce'];



//                     fin des templates

//les blocs
//bloc dernières annonces
$modversion['blocks'][1]['file'] = "catads_new.php";//ok
$modversion['blocks'][1]['name'] = _MI_CATADS_BNAME1;
$modversion['blocks'][1]['description'] = "";
$modversion['blocks'][1]['show_func'] = "b_catads_show";
$modversion['blocks'][1]['edit_func'] = "b_catads_edit";
$modversion['blocks'][1]['options'] = "5|0|1|120|25";
$modversion['blocks'][1]['template'] = 'catads_block_new.tpl';//ok

//bloc déposer une annonce
$modversion['blocks'][2]['file'] = "catads_add.php";//ok
$modversion['blocks'][2]['name'] = _MI_CATADS_BNAME2;
$modversion['blocks'][2]['description'] = "";
$modversion['blocks'][2]['show_func'] = "b_catads_add";
$modversion['blocks'][2]['template'] = 'catads_block_add.tpl';//ok

//bloc mes annonces
$modversion['blocks'][3]['file'] = "catads_myads.php";//ok
$modversion['blocks'][3]['name'] = _MI_CATADS_BNAME3;
$modversion['blocks'][3]['description'] = "";
$modversion['blocks'][3]['show_func'] = "b_catads_myads";
$modversion['blocks'][3]['edit_func'] = "b_catads_myads_edit";
$modversion['blocks'][3]['options'] = "5|0|25";
$modversion['blocks'][3]['template'] = 'catads_block_myads.tpl';//ok

//bloc recherche avancée
$modversion['blocks'][4]['file'] = "catads_search.php";//ok
$modversion['blocks'][4]['name'] = _MI_CATADS_BNAME5;
$modversion['blocks'][4]['description'] = "";
$modversion['blocks'][4]['show_func'] = "b_catads_search";
$modversion['blocks'][4]['options'] = '';
$modversion['blocks'][4]['template'] = 'catads_block_search.tpl';//ok

//liens menu principal
$modversion['hasMain'] = 1;
global $xoopsUser;
    $uid = (is_object($xoopsUser))? $xoopsUser->getVar('uid'): 0;
			//soumetre une annonce
            $modversion['sub'][1]['name'] = _MI_CATADS_SMENU2;
            $modversion['sub'][1]['url'] = "submit.php";
			//recherche une annonce				
            $modversion['sub'][3]['name'] = _MI_CATADS_SMENU3;
            $modversion['sub'][3]['url'] = "search.php";
    //$ads_handler =& xoops_getmodulehandler('ads', 'catads');
    $ads_handler = xoops_getmodulehandler('ads', 'catads');	
	//mes annonces
    if ($uid > 0)
    {
        $criteria = new Criteria('uid', $uid);
        $nbads = $ads_handler->getCount($criteria);
            if ($nbads > 0)
            {
            $modversion['sub'][2]['name'] = _MI_CATADS_SMENU1;
            $modversion['sub'][2]['url'] = "adsuserlist.php?uid=".$uid;
            }
    }

//sql
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

//tables base de données
$modversion['tables'][0] = "catads_ads";
$modversion['tables'][1] = "catads_cat";
$modversion['tables'][2] = "catads_options";
$modversion['tables'][3] = "catads_regions";
$modversion['tables'][4] = "catads_departements";

//recherche
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "catads_search";

//--------------------------------- début Configuration
//Contrôle des annonces avant leurs parutions  ?
$i=1;
$modversion['config'][$i]['name'] = 'moderated';
$modversion['config'][$i]['title'] = '_MI_CATADS_MODERATE';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '0';
$modversion['config'][$i]['options'] = array();
$i++;

//Autoriser l'effacement des annonces ?
$modversion['config'][$i]['name'] = 'usercandelete';
$modversion['config'][$i]['title'] = '_MI_CATADS_CANDELETE';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '0';
$modversion['config'][$i]['options'] = array();
$i++;

//Autoriser la modification des annonces ?
$modversion['config'][$i]['name'] = 'usercanedit';
$modversion['config'][$i]['title'] = '_MI_CATADS_CANEDIT';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '1';
$modversion['config'][$i]['options'] = array();
$i++;

//ajout option CPascalWeb - 4 mai 2011 - autoriser l'annonceur de modifier son adresse Email ?
$modversion['config'][$i]['name'] = 'modifmail';
$modversion['config'][$i]['title'] = '_MI_CATADS_MODIFEMAIL';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '1';
$modversion['config'][$i]['options'] = array();
$i++; 
//fin

//ajout cpascalweb - 7 novembre 2010 - option choix afficher ou non les annonces signalées comme étant suspectes
$modversion['config'][$i]['name'] = 'active_suspect';
$modversion['config'][$i]['title'] = '_MI_ACTIV_SUSPECT';
$modversion['config'][$i]['description'] = '_MI_ACTIV_SUSPECT_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '0';
$modversion['config'][$i]['options'] = array();
$i++;

//Autoriser les mots clés personnalisées (tags)
$modversion['config'][$i]['name'] = 'allow_custom_tags';
$modversion['config'][$i]['title'] = '_MI_CATADS_ALLOW_CUSTOM_TAGS';
$modversion['config'][$i]['description'] = '_MI_CATADS_ALLOW_CUSTOM_TAGS_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '1';
$modversion['config'][$i]['options'] = array();
$i++;

//autorisé les annonceurs à mettre un lien vidéo dans leurs annonces
$modversion['config'][$i]['name'] = 'show_video_field';
$modversion['config'][$i]['title'] = '_MI_CATADS_SHOW_VIDEO_FIELD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '1';
$modversion['config'][$i]['options'] = array();
$i++;

//Autorisé l'annonceur à choisir une date de publication
$modversion['config'][$i]['name'] = 'allow_publish_date';
$modversion['config'][$i]['title'] = '_MI_CATADS_ALLOW_PUBLISH_DATE';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '1';
$modversion['config'][$i]['options'] = array();
$i++;

//Délai maximum avant la parution de l'annonce
$modversion['config'][$i]['name'] = 'nb_days_before';
$modversion['config'][$i]['title'] = '_MI_CATADS_NBDAYS_BEFORE';
$modversion['config'][$i]['description'] = '_MI_CATADS_NBDAYS_BEFORE_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '15';
$modversion['config'][$i]['options'] = array();
$i++;

//Annonces considéré comme nouveau (jours)
$modversion['config'][$i]['name'] = 'nb_days_new';
$modversion['config'][$i]['title'] = '_MI_CATADS_NBDAY_NEW';
$modversion['config'][$i]['description'] = '_MI_CATADS_NBDAY_NEW_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '3';
$modversion['config'][$i]['options'] = array();
$i++;

//ajout cpascalweb - 31 octobre 2010 - option choix javascript pop up contact zoombox ou non
$modversion['config'][$i]['name'] = 'pop_up_zoombox';
$modversion['config'][$i]['title'] = '_MI_CONTAC_ZOOMBOX';
$modversion['config'][$i]['description'] = '_MI_CONTAC_ZOOMBOX_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '0';
$modversion['config'][$i]['options'] = array();
$i++;

//nombre de jours avant l'envoie d'un message indiquant l'expiration de l'annonce
$modversion['config'][$i]['name'] = 'nb_days_expired';
$modversion['config'][$i]['title'] = '_MI_CATADS_NBDAYSEXPIRED';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '2';
$modversion['config'][$i]['options'] = array();
$i++;

//nombre de renouvellements autorisés
$modversion['config'][$i]['name'] = 'nb_pub_again';
$modversion['config'][$i]['title'] = '_MI_CATADS_NBPUB_AGAIN';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '1';
$modversion['config'][$i]['options'] = array();
$i++;

//ajout CPascalWeb - 21 avril 2011 - sécurité anti spam	
$modversion['config'][$i]['name'] = 'captcha';
$modversion['config'][$i]['title'] = '_MI_CATADS_ACTIVE_CAPTCHA';
$modversion['config'][$i]['description'] = '_MI_CATADS_ACTIVE_CAPTCHA_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '1';
$modversion['config'][$i]['options'] = array();
$i++;
//fin

//activer le SEO
$modversion['config'][$i]['name'] = 'show_seo';
$modversion['config'][$i]['title'] = '_MI_CATADS_SHOW_SEO';
$modversion['config'][$i]['description'] = '_MI_CATADS_SHOW_SEO_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '0';
$modversion['config'][$i]['options'] = array();
$i++;

//ajout cpascalweb - le 3 mai 2011 - Choix de l'éditeur de texte
include_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
$modversion['config'][$i]['name']           = 'form_options';
$modversion['config'][$i]['title']          = '_MI_CATADS_FORM_OPTIONS';
$modversion['config'][$i]['description']    = '_MI_CATADS_FORM_OPTIONS_DESC';
$modversion['config'][$i]['formtype']       = 'select';
$modversion['config'][$i]['valuetype']      = 'text';
$modversion['config'][$i]['default']        = 'dhtmltextarea';
$modversion['config'][$i]['options']        = XoopsLists::getDirListAsArray(XOOPS_ROOT_PATH . '/class/xoopseditor');
$modversion['config'][$i]['category']       = 'global';
$i++;
//fin

//ajout CPascalWeb - 23 mai 2011 - séparation administration
$modversion["config"][$i]["name"]        = "break";
$modversion["config"][$i]["title"]       = "_MI_CATADS_ADMIN_SEPAR";
$modversion["config"][$i]["description"] = "";
$modversion["config"][$i]["formtype"]    = "line_break";
$modversion["config"][$i]["valuetype"]   = "textbox";
$modversion["config"][$i]["default"]     = "head";
$i++;

//Nombre d'annonces par page (administration)
$modversion['config'][$i]['name'] = 'nb_perpage_admin';
$modversion['config'][$i]['title'] = '_MI_CATADS_NBPERPAGE_ADMIN';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '20';
$modversion['config'][$i]['options'] = array();
$i++;

//Nombre de jours lorsque l'administrateur renouvelle une annonce depuis l'administration du module
$modversion['config'][$i]['name'] = 'renew_nb_days';
$modversion['config'][$i]['title'] = '_MI_CATADS_RENEW_NBDAYS';
$modversion['config'][$i]['description'] = '_MI_CATADS_RENEW_NBDAYS_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '7';
$modversion['config'][$i]['options'] = array();
$i++;

//ajout cpascalweb - le 23 mai 2011 - Choix de l'éditeur de texte pour l'administrateur
//JJDai suppression de cette option et utilisation du même editeur dans le BO et le FO
/*
include_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
$modversion['config'][$i]['name']           = 'form_admin_options';
$modversion['config'][$i]['title']          = '_MI_CATADS_FORMADMIN_OPTIONS';
$modversion['config'][$i]['description']    = '';
$modversion['config'][$i]['formtype']       = 'select';
$modversion['config'][$i]['valuetype']      = 'text';
$modversion['config'][$i]['default']        = 'dhtmltextarea';
$modversion['config'][$i]['options']        = XoopsLists::getDirListAsArray(XOOPS_ROOT_PATH . '/class/xoopseditor');
$modversion['config'][$i]['category']       = 'global';
$i++;
*/
//fin

//ajout CPascalWeb - 22 mai 2011 - séparation Formulaire de proposition d'annonce
$modversion["config"][$i]["name"]        = "break";
$modversion["config"][$i]["title"]       = "_MI_CATADS_FORMUL_SEPAR";
$modversion["config"][$i]["description"] = "";
$modversion["config"][$i]["formtype"]    = "line_break";
$modversion["config"][$i]["valuetype"]   = "textbox";
$modversion["config"][$i]["default"]     = "head";
$i++;

//email obigatoire ?
$modversion['config'][$i]['name'] = 'email_req';
$modversion['config'][$i]['title'] = '_MI_CATADS_EMAIL_REQUIRED';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '0';
//ajout option CPascalWeb - 23 avril 2011 email facultatif
//$modversion['config'][$i]['options'] = array(_MI_CATADS_NOASK=>0, _MI_CATADS_OPTIONAL=>1,_MI_CATADS_REQUIRED=>2);
$modversion['config'][$i]['options'] = array(_MI_CATADS_REQUIRED=>0, _MI_CATADS_OPTIONAL=>1);
$i++;

//Téléphone fixe obigatoire ?
$modversion['config'][$i]['name'] = 'phonefixe_req';
$modversion['config'][$i]['title'] = '_MI_CATADS_TELFIXE_REQUIRED';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '0';
$modversion['config'][$i]['options'] = array(_MI_CATADS_NOASK=>0, _MI_CATADS_OPTIONAL=>1,_MI_CATADS_REQUIRED=>2);
$i++;

//ajout option CPascalWeb - 12 novembre 2010 téléphone portable facultatif, obligatoire ou non demandé 
$modversion['config'][$i]['name'] = 'phoneportable_req';
$modversion['config'][$i]['title'] = '_MI_CATADS_TELPORTABLE_REQUIRED';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '0';
$modversion['config'][$i]['options'] = array(_MI_CATADS_NOASK=>0, _MI_CATADS_OPTIONAL=>1,_MI_CATADS_REQUIRED=>2);
$i++;
//fin de l'ajout du 23 avril 2011

//région obigatoire ?
$modversion['config'][$i]['name'] = 'region_req';
$modversion['config'][$i]['title'] = '_MI_CATADS_REGION_REQUIRED';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '2';
//ajout option CPascalWeb - 23 avril 2011 région facultatif
//$modversion['config'][$i]['options'] = array(_MI_CATADS_NOASK=>0,_MI_CATADS_REQUIRED=>1);
$modversion['config'][$i]['options'] = array(_MI_CATADS_NOASK=>0, _MI_CATADS_OPTIONAL=>1,_MI_CATADS_REQUIRED=>2);
$i++;

//département obigatoire ?
$modversion['config'][$i]['name'] = 'departement_req';
$modversion['config'][$i]['title'] = '_MI_CATADS_DEPARTEMENT_REQUIRED';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '2';
//ajout option CPascalWeb - 23 avril 2011 département facultatif
//$modversion['config'][$i]['options'] = array(_MI_CATADS_NOASK=>0,_MI_CATADS_REQUIRED=>1);
$modversion['config'][$i]['options'] = array(_MI_CATADS_NOASK=>0, _MI_CATADS_OPTIONAL=>1,_MI_CATADS_REQUIRED=>2);
$i++;

//ajout option CPascalWeb - 23 avril 2011 ville facultatif, obligatoire ou non demandé 
$modversion['config'][$i]['name'] = 'town_req';
$modversion['config'][$i]['title'] = '_MI_CATADS_VILLE_REQUIRED';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '2';
$modversion['config'][$i]['options'] = array(_MI_CATADS_NOASK=>0, _MI_CATADS_OPTIONAL=>1,_MI_CATADS_REQUIRED=>2);
$i++;
//fin

//code postal obligatoire ?
$modversion['config'][$i]['name'] = 'zipcode_req';
$modversion['config'][$i]['title'] = '_MI_CATADS_ZIPCODE_REQUIRED';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '2';
//ajout option CPascalWeb - 23 avril 2011 code postal facultatif
//$modversion['config'][$i]['options'] = array(_MI_CATADS_NOASK=>0,_MI_CATADS_REQUIRED=>1);
$modversion['config'][$i]['options'] = array(_MI_CATADS_NOASK=>0, _MI_CATADS_OPTIONAL=>1,_MI_CATADS_REQUIRED=>2);
$i++;

//ajout CPascalWeb - 22 mai 2011 - séparation paramètres d'affichages
$modversion["config"][$i]["name"]        = "break";
$modversion["config"][$i]["title"]       = "_MI_CATADS_OPTIONAFF_SEPAR";
$modversion["config"][$i]["description"] = "";
$modversion["config"][$i]["formtype"]    = "line_break";
$modversion["config"][$i]["valuetype"]   = "textbox";
$modversion["config"][$i]["default"]     = "head";
$i++;

//page index: lignes/colonnes
$modversion['config'][$i]['name'] = 'tpltype';
$modversion['config'][$i]['title'] = '_MI_CATADS_TPLTYPE';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '2';
$modversion['config'][$i]['options'] = array(_MI_CATADS_LIN=>1, _MI_CATADS_COL=>2);
$i++;

//nombre colonnes index
$modversion['config'][$i]['name'] = 'nbcol';
$modversion['config'][$i]['title'] = '_MI_CATADS_NBCOL';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '3';
$modversion['config'][$i]['options'] = array(2=>2, 3=>3, 4=>4, 5=>5);
$i++;

//ajout option CPascalWeb - 24 mai 2011 - afficher ou non le bloc les dernières annonces
$modversion['config'][$i]['name'] = 'bloc_dernieres_annonces';
$modversion['config'][$i]['title'] = '_MI_CATADS_BLOCAFF_LASTADS';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '1';
$modversion['config'][$i]['options'] = array();
$i++;

//ajout CPascalWeb - 30 octobre 2010 - Nombre de dernières annonces à afficher
$modversion['config'][$i]['name'] = 'nb_dernieres_annonces';
$modversion['config'][$i]['title'] = '_MI_CATADS_NBAFF_LASTADS';
$modversion['config'][$i]['description'] = '_MI_CATADS_NBAFF_LASTADS_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '4';
$modversion['config'][$i]['options'] = array();
$i++;
//fin

//Nombre d'annonces par page (site)
$modversion['config'][$i]['name'] = 'nb_perpage';
$modversion['config'][$i]['title'] = '_MI_CATADS_NBPERPAGE';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '10';
$modversion['config'][$i]['options'] = array();
$i++;

//Nombre de nouvelles annonces
$modversion['config'][$i]['name'] = 'nb_news';//!!! RAPPEL POUR RC2 VOIR SON UTILITE
$modversion['config'][$i]['title'] = '_MI_CATADS_DISPLAYNEW';
$modversion['config'][$i]['description'] = '_MI_CATADS_DISPLAYNEW_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '10';
$modversion['config'][$i]['options'] = array();
$i++;

//nombre de caractères maxi du texte de l'annonce
$modversion['config'][$i]['name'] = 'txt_maxlength';
$modversion['config'][$i]['title'] = '_MI_CATADS_MAXLENTXT';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '500';
$modversion['config'][$i]['options'] = array();
$i++;

//nombre de caractères maximum dans le titre (liste d'annonces)
$modversion['config'][$i]['name'] = 'title_length';
$modversion['config'][$i]['title'] = '_MI_CATADS_TITLE_LENGTH';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '25';
$modversion['config'][$i]['options'] = array();
$i++;

//nombre de caractères maximum dans la description des annonces
$modversion['config'][$i]['name'] = 'desc_length';
$modversion['config'][$i]['title'] = '_MI_CATADS_DESC_LENGTH';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '80';
$modversion['config'][$i]['options'] = array();
$i++;

//ajout CPascalWeb - 22 mai 2011 - séparation paramètres des cartes
$modversion["config"][$i]["name"]        = "break";
$modversion["config"][$i]["title"]       = "_MI_CATADS_CARTE_SEPAR";
$modversion["config"][$i]["description"] = "";
$modversion["config"][$i]["formtype"]    = "line_break";
$modversion["config"][$i]["valuetype"]   = "textbox";
$modversion["config"][$i]["default"]     = "head";
$i++;

//afficher la carte France map en page d'accueil
$modversion['config'][$i]['name'] = 'show_card';
$modversion['config'][$i]['title'] = '_MI_CATADS_SHOW_CARD';
$modversion['config'][$i]['description'] = '_MI_CATADS_SHOW_CARD_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '0';
$modversion['config'][$i]['options'] = array();
$i++;

//ajout CPascalWeb - 22 mai 2011 - séparation choix des indications à afficher
$modversion["config"][$i]["name"]        = "break";
$modversion["config"][$i]["title"]       = "_MI_CATADS_OPTIONINDIC_SEPAR";
$modversion["config"][$i]["description"] = "";
$modversion["config"][$i]["formtype"]    = "line_break";
$modversion["config"][$i]["valuetype"]   = "textbox";
$modversion["config"][$i]["default"]     = "head";
$i++;

//ajout cpascalweb - le 23 mai 2011 - Choix d'afficher ou non le bloc actuellement
$modversion['config'][$i]['name'] = 'affiche_bloc_indic';
$modversion['config'][$i]['title'] = '_MI_CATADS_AFFI_BLOC_ACTU';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '1';
$modversion['config'][$i]['options'] = array();
$i++;
//fin

//ajout cpascalweb - le 23 mai 2011 - Choix d'afficher ou non le total des annonces visibles
$modversion['config'][$i]['name'] = 'affiche_ads_visible';
$modversion['config'][$i]['title'] = '_MI_CATADS_AFFI_ADS_VISIBLE';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '1';
$modversion['config'][$i]['options'] = array();
$i++;
//fin

//ajout cpascalweb - le 14 mai 2011 - Choix d'afficher ou non le nombre de fois que l'annonce a été vue
$modversion['config'][$i]['name'] = 'affiche_vue';
$modversion['config'][$i]['title'] = '_MI_CATADS_AFFI_ADS_VUE';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '1';
$modversion['config'][$i]['options'] = array();
$i++;
//fin

//ajout cpascalweb - le 10 octobre 2010 - afficher ou non les annonces suspendu par le site dans le blocs information annonces
$modversion['config'][$i]['name'] = 'aff_suspendadmin';
$modversion['config'][$i]['title'] = '_MI_CATADS_AFF_ADSSUSPSITE';
$modversion['config'][$i]['description'] = '_MI_CATADS_AFF_ADSSUSPSITE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '0';
$modversion['config'][$i]['options'] = array();
$i++;

//ajout cpascalweb - le 10 octobre 2010 - afficher ou non les annonces suspendu par l'annonceur dans le blocs information annonces
$modversion['config'][$i]['name'] = 'aff_suspend';
$modversion['config'][$i]['title'] = '_MI_CATADS_AFF_ADSSUSPPROPRIO';
$modversion['config'][$i]['description'] = '_MI_CATADS_AFF_ADSSUSPPROPRIO_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '0';
$modversion['config'][$i]['options'] = array();
$i++;

//Affichage des descriptions dans les categories
$modversion['config'][$i]['name'] = 'show_cat_desc';
$modversion['config'][$i]['title'] = '_MI_CATADS_SHOW_CAT_AFFDESC';
$modversion['config'][$i]['description'] = '_MI_CATADS_SHOW_CAT_AFFDESC_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '1';
$modversion['config'][$i]['options'] = array();
$i++;

//Afficher le Type d'annonce (loue,vend,)
$modversion['config'][$i]['name'] = 'show_ad_type';
$modversion['config'][$i]['title'] = '_MI_CATADS_SHOW_AD_TYPE';
$modversion['config'][$i]['description'] = '_MI_CATADS_SHOW_AD_TYPE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '1';
$modversion['config'][$i]['options'] = array();
$i++;

//afficher le pseudo
$modversion['config'][$i]['name'] = 'display_pseudo';
$modversion['config'][$i]['title'] = '_MI_CATADS_DISP_PSEUDO';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '1';
$modversion['config'][$i]['options'] = array();
$i++;

//ajout CPascalWeb - 22 mai 2011 - séparation paramètres des images & photos
$modversion["config"][$i]["name"]        = "break";
$modversion["config"][$i]["title"]       = "_MI_CATADS_IMAGE_SEPAR";
$modversion["config"][$i]["description"] = "";
$modversion["config"][$i]["formtype"]    = "line_break";
$modversion["config"][$i]["valuetype"]   = "textbox";
$modversion["config"][$i]["default"]     = "head";
$i++;

//ajout CPascalWeb - 30 octobre 2010 - largeur des images des catégories
//largeur des images des catégories
$modversion['config'][$i]['name'] = 'cat_width';
$modversion['config'][$i]['title'] = '_MI_CAT_IMAGE_WIDTH';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 30;
$modversion['config'][$i]['options'] = array();
$i++;
//fin de l'ajout

//ajout CPascalWeb - 30 octobre 2010 
//largeur des images des sous catégories
$modversion['config'][$i]['name'] = 'scat_width';
$modversion['config'][$i]['title'] = '_MI_SCAT_IMAGE_WIDTH';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 30;
$modversion['config'][$i]['options'] = array();
$i++;
//fin de l'ajout

//photo max taille
$modversion['config'][$i]['name'] = 'photo_maxsize';
$modversion['config'][$i]['title'] = '_MI_CATADS_MAXSIZEIMG';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '153600';
$modversion['config'][$i]['options'] = array();
$i++;

//photo max hauteur
$modversion['config'][$i]['name'] = 'photo_maxheight';
$modversion['config'][$i]['title'] = '_MI_CATADS_MAXHEIGHTIMG';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '600';
$modversion['config'][$i]['options'] = array();
$i++;

//photo max largeur
$modversion['config'][$i]['name'] = 'photo_maxwidth';
$modversion['config'][$i]['title'] = '_MI_CATADS_MAXWIDTHIMG';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '600';
$modversion['config'][$i]['options'] = array();
$i++;

//largeur max des thumbs
$modversion['config'][$i]['name'] = 'thumb_width';
$modversion['config'][$i]['title'] = '_MI_THUMB_WIDTH';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 70;
$modversion['config'][$i]['options'] = array();
$i++;

//largeur de l'image principal dans la page de l'annonce
$modversion['config'][$i]['name'] = 'click_image_width';
$modversion['config'][$i]['title'] = '_MI_CLICK_IMAGE_WIDTH';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 220;
$modversion['config'][$i]['options'] = array();
$i++;

//librairie & utiliser pour redimensionner les images
$modversion['config'][$i]['name'] = 'thumb_method';
$modversion['config'][$i]['title'] = '_MI_THUMB_METHOD';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'gd2';
$modversion['config'][$i]['options'] = array( 'GD version 1.x' => 'gd1', 'GD version 2.x' => 'gd2', 'Image Magick' => 'im', 'Netpbm' => 'net' );
$i++;

//ajout CPascalWeb - 22 mai 2011 - séparation micropaiement	
$modversion["config"][$i]["name"]        = "break";
$modversion["config"][$i]["title"]       = "_MI_CATADS_MIC_PAIE_SEPAR";
$modversion["config"][$i]["description"] = "";
$modversion["config"][$i]["formtype"]    = "line_break";
$modversion["config"][$i]["valuetype"]   = "textbox";
$modversion["config"][$i]["default"]     = "head";
$i++;

//ajout cpascalweb option système micropaiement1 le 18 août 2009
//activer ou non la fonction micropaiement1 pour accéder aux coordonnées
$modversion['config'][$i]['name'] = 'micropaiement1';
$modversion['config'][$i]['title'] = '_MI_CATADS_MIC_PAIE';
$modversion['config'][$i]['description'] = '_MI_CATADS_MIC_PAIE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;

//identification du site protéger par rentabiliweb = site_id ($idsite)
$modversion['config'][$i]['name'] = 'idsite';
$modversion['config'][$i]['title'] = '_MI_CATADS_RENTAB_IDSITE';
$modversion['config'][$i]['description'] = '_MI_CATADS_RENTAB_IDSITE_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';
$i++;

//id de la page protéger par rentabiliweb = doc_id ($idprotect)
$modversion['config'][$i]['name'] = 'idprotect';
$modversion['config'][$i]['title'] = '_MI_CATADS_RENTAB_IDPROTECT';
$modversion['config'][$i]['description'] = '_MI_CATADS_RENTAB_IDPROTECT_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';
$i++;

//texte intro dans pop up micropaiement
$modversion['config'][$i]['name'] = 'introtexte';
$modversion['config'][$i]['title'] = '_MI_CATADS_RENTAB_INTROTEXT';
$modversion['config'][$i]['description'] = '_MI_CATADS_RENTAB_INTROTEXT_DESC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_CATADS_RENTAB_INTROTEXT_DEFAULT;
$i++;

//texte info dans pop up micropaiement
$modversion['config'][$i]['name'] = 'infotexte';
$modversion['config'][$i]['title'] = '_MI_CATADS_RENTAB_INFOTEXT';
$modversion['config'][$i]['description'] = '_MI_CATADS_RENTAB_INFOTEXT_DESC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_CATADS_RENTAB_INFOTEXT_DEFAULT;
$i++;
//fin de l'ajout CPascalWeb - micropaiement

//ajout CPascalWeb - 22 mai 2011 - séparation 1	
$modversion["config"][$i]["name"]        = "break";
$modversion["config"][$i]["title"]       = "_MI_CATADS_PUB_ANNONCE_SEPAR";
$modversion["config"][$i]["description"] = "";
$modversion["config"][$i]["formtype"]    = "line_break";
$modversion["config"][$i]["valuetype"]   = "textbox";
$modversion["config"][$i]["default"]     = "head";
$i++;

//ajout CPascalWeb - 24 novembre 2010 - régie publicitaire du module
//afficher une bannière pub sur la page de l'annonce ? (1/3)
$modversion['config'][$i]['name'] = 'aff_pub_annonce';
$modversion['config'][$i]['title'] = '_MI_CATADS_PUB_ANNONCE';
$modversion['config'][$i]['description'] = '_MI_CATADS_PUB_ANNONCE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '0';
$modversion['config'][$i]['options'] = array();
$i++;

//ajout option CPascalWeb - 24 novembre 2010 - utiliser les bannières pub du site (2/3)
$modversion['config'][$i]['name'] = 'aff_pub_annonce_site';
$modversion['config'][$i]['title'] = '_MI_CATADS_PUB_ANNONCE_SITE';
$modversion['config'][$i]['description'] = '_MI_CATADS_PUB_ANNONCE_SITE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '0';
$modversion['config'][$i]['options'] = array();
$i++;

//sinon insérer un script pub dans ce bloc (3/3)
$modversion['config'][$i]['name'] = 'aff_pub_annonce_code';
$modversion['config'][$i]['title'] = '_MI_CATADS_PUB_ANNONCE_SCRIPT';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';
$modversion['config'][$i]['options'] = array();
$i++;

//ajout option CPascalWeb - 24 novembre 2010 - afficher une bannière pub dans le bloc Photos & vidéo de l'annonce (1/3)
$modversion['config'][$i]['name'] = 'aff_pub_annonce_bloc';
$modversion['config'][$i]['title'] = '_MI_CATADS_PUB_ANNONCE_BLOC';
$modversion['config'][$i]['description'] = '_MI_CATADS_PUB_ANNONCE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '0';
$modversion['config'][$i]['options'] = array();
$i++;

//ajout option CPascalWeb - 24 novembre 2010 - utiliser les bannières pub du site (2/3)
$modversion['config'][$i]['name'] = 'aff_pub_annonce_bloc_site';
$modversion['config'][$i]['title'] = '_MI_CATADS_PUB_ANNONCE_SITE';
$modversion['config'][$i]['description'] = '_MI_CATADS_PUB_ANNONCE_SITE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '0';
$modversion['config'][$i]['options'] = array();
$i++;

//sinon insérer un script pub dans ce bloc (3/3)
$modversion['config'][$i]['name'] = 'aff_pub_annonce_bloc_code';
$modversion['config'][$i]['title'] = '_MI_CATADS_PUB_ANNONCE_SCRIPT';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';
$modversion['config'][$i]['options'] = array();
$i++;
//fin

//ajout option CPascalWeb - 24 novembre 2010 - afficher une bannières pub sur les pages général du module (1/3)
$modversion['config'][$i]['name'] = 'aff_pub_general';
$modversion['config'][$i]['title'] = '_MI_CATADS_PUB_GENERAL';
$modversion['config'][$i]['description'] = '_MI_CATADS_PUB_GENERAL_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '0';
$modversion['config'][$i]['options'] = array();
$i++;

//ajout option CPascalWeb - 24 novembre 2010 - utiliser les bannières pub du site (2/3)
$modversion['config'][$i]['name'] = 'aff_pub_general_site';
$modversion['config'][$i]['title'] = '_MI_CATADS_PUB_ANNONCE_SITE';
$modversion['config'][$i]['description'] = '_MI_CATADS_PUB_ANNONCE_SITE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '0';
$modversion['config'][$i]['options'] = array();
$i++;

//sinon insérer un script pub dans ce bloc (3/3)
$modversion['config'][$i]['name'] = 'aff_pub_general_code';
$modversion['config'][$i]['title'] = '_MI_CATADS_PUB_ANNONCE_SCRIPT';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';
$modversion['config'][$i]['options'] = array();
$i++;
//fin

//ajout cpascalweb - le 12 octobre 2010 afficher une pub dans le bloc informations annonces ? (1/2)
$modversion['config'][$i]['name'] = 'pub_bloc_info';
$modversion['config'][$i]['title'] = '_MI_CATADS_PUB_BLOCINFO';
$modversion['config'][$i]['description'] = '_MI_CATADS_PUB_BLOCINFO_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '0';
$modversion['config'][$i]['options'] = array();
$i++;

//script a insérer dans le bloc informations annonces: (2/2)
$modversion['config'][$i]['name'] = 'pub_bloc_info_script';
$modversion['config'][$i]['title'] = '_MI_CATADS_PUB_BLOCINFO_SCRIPT';
$modversion['config'][$i]['description'] = '_MI_CATADS_PUB_BLOCINFO_SCRIPT_DESC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';
$modversion['config'][$i]['options'] = array();
$i++;
//fin pub bloc infos annonoces

///////////////A VOIR ET A AJOUTER POUR LA VERSION RC2
//Extensions autorisees a ajouter plus tard !
/*$modversion['config'][$i]['name'] = 'allowed_file_extensions';
$modversion['config'][$i]['title'] = '_MI_FILE_EXT';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'GIF/PNG/JPG/JPEG/TIF/TIFF/AVI/MP3';
$i++;*/

// image cols (ne fonctionne pas voir prochaine version)
//$modversion['config'][$i]['name'] = 'nb_cols_img';
//$modversion['config'][$i]['title'] = '_MI_CATADS_NBCOLS_IMG';
//$modversion['config'][$i]['description'] = '';
//$modversion['config'][$i]['formtype'] = 'select';
//$modversion['config'][$i]['valuetype'] = 'int';
//$modversion['config'][$i]['default'] = '3';
//$modversion['config'][$i]['options'] = array(1=>1, 2=>2, 3=>3, 4=>4);
//$i++;

//Formulaire: avec bbcodes //a voir si vraiment utile
/*
$modversion['config'][$i]['name'] = 'bbcode';
$modversion['config'][$i]['title'] = '_MI_CATADS_BBCODE';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '1';
$modversion['config'][$i]['options'] = array();
$i++;
*/

//Les anonymes peuvent poster ? //sert a rien puisque aprés les anonymes ne peuvent pas modifié leurs annonce
/*
$modversion['config'][$i]['name'] = 'anoncanpost';
$modversion['config'][$i]['title'] = '_MI_CATADS_ANONCANPOST';
$modversion['config'][$i]['description'] = '_MI_CATADS_ANONCANPOST_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '0';
$modversion['config'][$i]['options'] = array();
$i++;
*/
/////////////////////////////////////////////////////////////////////////////

//ajout CPascalWeb - 22 mai 2011 - séparation	
$modversion["config"][$i]["name"]        = "break";
$modversion["config"][$i]["title"]       = "_MI_CATADS_NOTIFY_SEPAR";
$modversion["config"][$i]["description"] = "";
$modversion["config"][$i]["formtype"]    = "line_break";
$modversion["config"][$i]["valuetype"]   = "textbox";
$modversion["config"][$i]["default"]     = "head";
$i++;
/////////////////////////////////////////////////////////////////////////////

//ajout JJDai - 21 février 2021
$modversion['config'][] = [
    'name'        => 'displayTemplateName',
    'title'       => '_MI_CATADS_SHOW_TPL_NAME',
    'description' => '_MI_CATADS_SHOW_TPL_NAME_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];

////////////////////////////////////////////////////////////////////////////////	

//commentaires
$modversion['hasComments'] = 1;
$modversion['comments']['pageName'] = 'adsitem.php';
$modversion['comments']['itemName'] = 'ads_id';

//information automatique
$modversion['hasNotification'] = 1;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'catads_notify_iteminfo';

$modversion['notification']['category'][1]['name'] = 'global';
$modversion['notification']['category'][1]['title'] = _MI_CATADS_GLOBAL_NOTIFY;
$modversion['notification']['category'][1]['description'] = _MI_CATADS_GLOBAL_NOTIFYDSC;
$modversion['notification']['category'][1]['subscribe_from'] = array('index.php','adslist.php','adsitem.php');

$modversion['notification']['category'][2]['name'] = 'category';
$modversion['notification']['category'][2]['title'] = _MI_CATADS_CATEGORY_NOTIFY;
$modversion['notification']['category'][2]['description'] = _MI_CATADS_CATEGORY_NOTIFYDSC;
$modversion['notification']['category'][2]['subscribe_from'] = array('adslist.php','adsitem.php');
$modversion['notification']['category'][2]['item_name'] = 'cat_id';
$modversion['notification']['category'][2]['allow_bookmark'] = 1;

$modversion['notification']['category'][3]['name'] = 'ads';
$modversion['notification']['category'][3]['title'] = _MI_CATADS_ADS_NOTIFY;
$modversion['notification']['category'][3]['description'] = _MI_CATADS_ADS_NOTIFYDSC;
$modversion['notification']['category'][3]['subscribe_from'] = 'adsitem.php';
$modversion['notification']['category'][3]['item_name'] = 'ads_id';
$modversion['notification']['category'][3]['allow_bookmark'] = 1;

$modversion['notification']['event'][1]['name'] = 'ads_submit';
$modversion['notification']['event'][1]['category'] = 'global';
$modversion['notification']['event'][1]['admin_only'] = 1;
$modversion['notification']['event'][1]['title'] = _MI_CATADS_GLOBAL_ADSSUBMIT_NOTIFY;
$modversion['notification']['event'][1]['caption'] = _MI_CATADS_GLOBAL_ADSSUBMIT_NOTIFYCAP;
$modversion['notification']['event'][1]['description'] = _MI_CATADS_GLOBAL_ADSSUBMIT_NOTIFYDSC;
$modversion['notification']['event'][1]['mail_template'] = 'global_adssubmit_notify';
$modversion['notification']['event'][1]['mail_subject'] = _MI_CATADS_GLOBAL_ADSSUBMIT_NOTIFYSBJ;

$modversion['notification']['event'][2]['name'] = 'new_ads';
$modversion['notification']['event'][2]['category'] = 'global';
$modversion['notification']['event'][2]['title'] = _MI_CATADS_GLOBAL_NEWADS_NOTIFY;
$modversion['notification']['event'][2]['caption'] = _MI_CATADS_GLOBAL_NEWADS_NOTIFYCAP;
$modversion['notification']['event'][2]['description'] = _MI_CATADS_GLOBAL_NEWADS_NOTIFYDSC;
$modversion['notification']['event'][2]['mail_template'] = 'global_newads_notify';
$modversion['notification']['event'][2]['mail_subject'] = _MI_CATADS_GLOBAL_NEWADS_NOTIFYSBJ;

$modversion['notification']['event'][3]['name'] = 'ads_edit';
$modversion['notification']['event'][3]['category'] = 'global';
$modversion['notification']['event'][3]['admin_only'] = 1;
$modversion['notification']['event'][3]['title'] = _MI_CATADS_GLOBAL_EDIT_NOTIFY;
$modversion['notification']['event'][3]['caption'] = _MI_CATADS_GLOBAL_EDIT_NOTIFYCAP;
$modversion['notification']['event'][3]['description'] = _MI_CATADS_GLOBAL_EDIT_NOTIFYDSC;
$modversion['notification']['event'][3]['mail_template'] = 'global_adsedit_notify';
$modversion['notification']['event'][3]['mail_subject'] = _MI_CATADS_GLOBAL_EDIT_NOTIFYSBJ;

$modversion['notification']['event'][4]['name'] = 'ads_submit';
$modversion['notification']['event'][4]['category'] = 'category';
$modversion['notification']['event'][4]['admin_only'] = 1;
$modversion['notification']['event'][4]['title'] = _MI_CATADS_CATEGORY_SUBMIT_NOTIFY;
$modversion['notification']['event'][4]['caption'] = _MI_CATADS_CATEGORY_SUBMIT_NOTIFYCAP;
$modversion['notification']['event'][4]['description'] = _MI_CATADS_CATEGORY_SUBMIT_NOTIFYDSC;
$modversion['notification']['event'][4]['mail_template'] = 'category_adssubmit_notify';
$modversion['notification']['event'][4]['mail_subject'] = _MI_CATADS_CATEGORY_SUBMIT_NOTIFYSBJ;

$modversion['notification']['event'][5]['name'] = 'new_ads';
$modversion['notification']['event'][5]['category'] = 'category';
$modversion['notification']['event'][5]['title'] = _MI_CATADS_CATEGORY_NEWADS_NOTIFY;
$modversion['notification']['event'][5]['caption'] = _MI_CATADS_CATEGORY_NEWADS_NOTIFYCAP;
$modversion['notification']['event'][5]['description'] = _MI_CATADS_CATEGORY_NEWADS_NOTIFYDSC;
$modversion['notification']['event'][5]['mail_template'] = 'category_newads_notify';
$modversion['notification']['event'][5]['mail_subject'] = _MI_CATADS_CATEGORY_NEWADS_NOTIFYSBJ;

$modversion['notification']['event'][6]['name'] = 'approve';
$modversion['notification']['event'][6]['category'] = 'ads';
$modversion['notification']['event'][6]['invisible'] = 1;
$modversion['notification']['event'][6]['title'] = _MI_CATADS_ADS_APPROVE_NOTIFY;
$modversion['notification']['event'][6]['caption'] = _MI_CATADS_ADS_APPROVE_NOTIFYCAP;
$modversion['notification']['event'][6]['description'] = _MI_CATADS_ADS_APPROVE_NOTIFYDSC;
$modversion['notification']['event'][6]['mail_template'] = 'ads_approve_notify';
$modversion['notification']['event'][6]['mail_subject'] = _MI_CATADS_ADS_APPROVE_NOTIFYSBJ;

$modversion['notification']['event'][7]['name'] = 'ads_edit';
$modversion['notification']['event'][7]['category'] = 'ads';
$modversion['notification']['event'][7]['invisible'] = 1;
$modversion['notification']['event'][7]['title'] = _MI_CATADS_ADS_EDIT_NOTIFY ;
$modversion['notification']['event'][7]['caption'] = _MI_CATADS_ADS_EDIT_NOTIFYCAP;
$modversion['notification']['event'][7]['description'] = _MI_CATADS_ADS_EDIT_NOTIFYDSC;
$modversion['notification']['event'][7]['mail_template'] = 'ads_edit_notify';
$modversion['notification']['event'][7]['mail_subject'] = _MI_CATADS_ADS_EDIT_NOTIFYSBJ;

?>