<?php

//nom et description du module
define("_MI_CATADS_NAME","petites annonces");
define("_MI_CATADS_DESC","Module de gestion de petites annonces gratuites ou payantes<br />version: 1.6 RC1");

//navigation mainmenu sous menu
define("_MI_CATADS_SMENU1","Mes annonces");
define("_MI_CATADS_SMENU2","Soumettre");
define("_MI_CATADS_SMENU3","Recherche avancée");

//Menu 
define("_MI_CATADS_ADMENU1", "Accueil");
define("_MI_CATADS_ADMENU2", "Gestion des annonces");
define("_MI_CATADS_ADMENU3", "Gestion des catégories");
define("_MI_CATADS_ADMENU4", "Champs supplémentaires");
define("_MI_CATADS_ADMENU5", "Purger les annonces");
define("_MI_CATADS_ADMENU6", "Permissions");

//noms des blocs
define("_MI_CATADS_BNAME1","Dernières annonces");
define("_MI_CATADS_BNAME2","Déposer une annonce");
define("_MI_CATADS_BNAME3","Mes annonces");
define("_MI_CATADS_BNAME5","Recherche avancée");

//configuration
define("_MI_CATADS_MODERATE","Contrôler les annonces avant la publication ?");
define("_MI_CATADS_CANDELETE","Autoriser l'annonceur à effacer ses annonces ?");
define("_MI_CATADS_CANEDIT","Autoriser l'annonceur de modifier ses annonces ?");
define("_MI_CATADS_ALLOW_CUSTOM_TAGS","Autoriser les annonceurs à mettre eux mêmes leurs mots clés (tags) ?");
define("_MI_CATADS_ALLOW_CUSTOM_TAGS_DESC","autorisé les annonceurs à mettre eux mêmes leurs mots clés (tags) sinon ils seront créer automatiquement à partir du titre");
define("_MI_CATADS_SHOW_VIDEO_FIELD","Autoriser les annonceurs à mettre un lien vidéo dans leurs annonces ?");
define("_MI_CATADS_ALLOW_PUBLISH_DATE","Autoriser l'annonceur à programmé une date de publication ?");
define("_MI_CATADS_NBDAYS_BEFORE","Combien de jours maximum peut ont programmé une date de publication ?");
define("_MI_CATADS_NBDAYS_BEFORE_DESC","Délai maximum avant la parution de l'annonce");
//ajout option CPascalWeb - 4 mai 2011
define("_MI_CATADS_MODIFEMAIL","Autoriser l'annonceur de modifier son adresse Email ?");
//fin
define("_MI_CATADS_NBDAY_NEW","Combien de jour une annonce est elle considéré comme nouvelle ?");
define("_MI_CATADS_NBDAY_NEW_DESC","combien de jour une annonce est considéré comme nouvelle l'indication 'nouveau !' restera à côté durant cette période");
define("_MI_CATADS_NBPUB_AGAIN","Combien de fois l'annonceur est-il autorisé à renouveler son annonce ?");
define("_MI_CATADS_NBDAYSEXPIRED","Nombre de jours avant l'envoie d'un message indiquant l'expiration de l'annonce ?");
define("_MI_CATADS_MAXSIZEIMG","Taille maximum des photos des annonces autorisés à être télécharger:");
define("_MI_CATADS_MAXSIZEIMG_DESC","0 pour interdire de télécharger");
define("_MI_CATADS_MAXHEIGHTIMG","Hauteur maximum des photos des annonces autorisés à être télécharger:");
define("_MI_CATADS_MAXWIDTHIMG","Largeur maximum des photos des annonces autorisés à être télécharger:");
//ajout CPascalWeb - 24 novembre 2010 - option afficher une pub du site ou un script sur les pages des annonces
define("_MI_CATADS_PUB_ANNONCE_SEPAR","Gestion de la régie publicitaire du module");
define("_MI_CATADS_PUB_ANNONCE","Afficher une bannière pub sur les pages des annonces ?");
//ajout CPascalWeb - 24 novembre 2010 - option afficher une pub du site ou un script
define("_MI_CATADS_PUB_ANNONCE_BLOC","Afficher une pub dans le bloc Photos & vidéo de l'annonce ?");
//ajout option CPascalWeb - 24 novembre 2010 - afficher une bannières pub sur les pages principal du module
define("_MI_CATADS_PUB_GENERAL","Afficher une pub sur les pages principal du module ?");
define("_MI_CATADS_PUB_GENERAL_DESC","afficher ou non une bannière pub sur les pages catégories, sous catégories, mes annonces, recherche avancée, soumettre etc.. si oui choisir d'afficher une bannière pub du site ou d'insérer un code publicitaire dans le champ suivant");
//define des pubs commun
define("_MI_CATADS_PUB_ANNONCE_SITE","Utiliser une bannière pub du site ?");
define("_MI_CATADS_PUB_ANNONCE_SITE_DESC","si oui une bannière pub du site sera afficher<br />si non le code du champ suivant sera afficher");
define("_MI_CATADS_PUB_ANNONCE_DESC","si oui choisir d'afficher une bannière pub du site ou d'insérer un code publicitaire dans le champ suivant");
define("_MI_CATADS_PUB_ANNONCE_SCRIPT","Ou le code publicitaire de ce champ");
//ajout cpascalweb - le 12 octobre 2010 afficher une pub dans le bloc informations annonces ?
define("_MI_CATADS_PUB_BLOCINFO","Afficher une pub dans le bloc informations annonces ?");
define("_MI_CATADS_PUB_BLOCINFO_DESC","afficher ou non une pub dans le bloc informations annonces si oui remplir le champ suivant");
define("_MI_CATADS_PUB_BLOCINFO_SCRIPT","script a insérer dans le bloc informations annonces:");
define("_MI_CATADS_PUB_BLOCINFO_SCRIPT_DESC","insérez le script ou liens de la publicité souhaité dans le bloc informations annonces largeur maximum conseiller est de 336");
//fin pub bloc info
define("_MI_CATADS_MAXLENTXT","Nombre de caractères maximum dans le texte de l'annonce ?");
define("_MI_CATADS_TITLE_LENGTH","Nombre de caractères maximum dans le titre ?");
define("_MI_CATADS_DESC_LENGTH","Nombre de caractères maximum dans la description des annonces ?");
define("_MI_CATADS_ADMIN_SEPAR","Préférences de l'administration");
define("_MI_CATADS_RENEW_NBDAYS","Nombre de jours lorsque l'administrateur renouvelle une annonce:");
define("_MI_CATADS_RENEW_NBDAYS_DESC","Nombre de jours lorsque l'administrateur renouvelle une annonce depuis l'administration du module");
define("_MI_CATADS_NBPERPAGE_ADMIN","Combien d'annonces à afficher par page dans l'administration ?");
//ajout cpascalweb - le 23 mai 2011 - choix du traitement de texte
define("_MI_CATADS_FORMADMIN_OPTIONS","Traitement de texte utiliser dans l'administration:");
//fin
define("_MI_CATADS_FORMUL_SEPAR","Formulaire de proposition d'annonce");
define("_MI_CATADS_EMAIL_REQUIRED","Le champ email est:");
define("_MI_CATADS_REGION_REQUIRED","Le champ région est:");
define("_MI_CATADS_DEPARTEMENT_REQUIRED","Le champ departement est:");
define("_MI_CATADS_ZIPCODE_REQUIRED","Le champ code postal est:");
define("_MI_CATADS_REQUIRED","obligatoire");
define("_MI_CATADS_OPTIONAL","facultatif");
define("_MI_CATADS_NOASK","non demandé");
//ajout cpascalweb - le 23 avril 2011 - Téléphone fixe obigatoire ?
define("_MI_CATADS_TELFIXE_REQUIRED","Le champ téléphone fixe est:");
define("_MI_CATADS_TELPORTABLE_REQUIRED","Le champ téléphone portable est:");
define("_MI_CATADS_VILLE_REQUIRED","Le champ ville est:");
//fin
define("_MI_CATADS_OPTIONAFF_SEPAR","Paramètres affichage");
define("_MI_CATADS_NBPERPAGE","Combien d'annonces faut-il affiché par page sur le site ?");
define("_MI_CATADS_DISPLAYNEW","Combien de nouvelles annonces faut-il affiché ?");
define("_MI_CATADS_DISPLAYNEW_DESC","Nombre de nouvelles annonces maximum à afficher sur le site");
define("_MI_CATADS_TPLTYPE","Présentation des catégories sur la page d'accueil:");
define("_MI_CATADS_COL","Colonnes");
define("_MI_CATADS_LIN","Lignes");
define("_MI_CATADS_NBCOL","Disposer les sous catégories sur la page d'accueil par:");
//ajout CPascalWeb - 30 octobre 2010 - Nombre des dernières annonces à afficher
define("_MI_CATADS_NBAFF_LASTADS","Combien de dernières annonces faut-il affiché ?");
define("_MI_CATADS_NBAFF_LASTADS_DESC","combien de dernières annonces faut-il affiché dans le bloc 'les dernières petites annonces'");
//fin
//ajout option CPascalWeb - 24 mai 2011 - afficher ou non le bloc les dernières annonces
define("_MI_CATADS_BLOCAFF_LASTADS","Afficher le bloc les dernières petites annonces ?");
//fin
define("_MI_CATADS_CARTE_SEPAR","Paramètres des cartes");
define("_MI_CATADS_SHOW_CARD","Afficher la carte France map en page d'accueil ?");
define("_MI_CATADS_SHOW_CARD_DESC","Important ! Pour faire apparaître cette carte, il faut remplir les champs du fichier setting.php");
define("_MI_CATADS_OPTIONINDIC_SEPAR","Choix des indications à afficher");
//ajout cpascalweb - le 10 octobre 2010 - afficher ou non les annonces suspendu par l'annonceur dans le blocs information annonces
define("_MI_CATADS_AFF_ADSSUSPPROPRIO","Afficher le nombre d'annonces suspendu par l'annonceur ?");
define("_MI_CATADS_AFF_ADSSUSPPROPRIO_DESC","afficher ou non les annonces suspendu par le propriétaire dans le bloc informations annonces a côté de la carte de france en page d'accueil<br /><br /><small>infos:<br />uniquement pour les visiteurs ".$GLOBALS['xoopsConfig']['sitename']." en mode connecté aura accès à ces informations pour une facilité de gestion</small>");
//ajout cpascalweb - le 10 octobre 2010 - afficher ou non les annonces suspendu par le site dans le blocs information annonces
define("_MI_CATADS_AFF_ADSSUSPSITE","Afficher le nombre d'annonces suspendu par ".$GLOBALS['xoopsConfig']['sitename']." ?");
define("_MI_CATADS_AFF_ADSSUSPSITE_DESC","afficher ou non les annonces suspendu par ".$GLOBALS['xoopsConfig']['sitename']." dans le bloc informations annonces en page d'accueil<br /><br /><small>infos:<br />uniquement pour les visiteurs, ".$GLOBALS['xoopsConfig']['sitename']." en mode connecté aura accès à ces informations pour une facilité de gestion</small>");
define("_MI_CATADS_SHOW_AD_TYPE","Afficher le type de l'annonce ?");
define("_MI_CATADS_SHOW_AD_TYPE_DESC","afficher ou non le type de l'annonce exemple: recherche, à loué, à vendre...)");
//ajout cpascalweb - le 14 mai 2011 - Choix d'afficher ou non le nombre de fois que l'annonce a été vue
define("_MI_CATADS_AFFI_ADS_VUE","Afficher le nombre de fois que l'annonce a été vue ?");
define("_MI_CATADS_DISP_PSEUDO","Afficher le pseudo ?");
//fin
//ajout cpascalweb - le 23 mai 2011 - Choix d'afficher ou non le bloc actuellement
define("_MI_CATADS_AFFI_BLOC_ACTU","Afficher le bloc informations annonces ?");
//ajout cpascalweb - le 23 mai 2011 - Choix d'afficher ou non le total des annonces visibles
define("_MI_CATADS_AFFI_ADS_VISIBLE","Afficher le total des annonces visibles ?");
//fin
//ajout cpascalweb - le 10 mai 2011 - choix du traitement de texte
define("_MI_CATADS_FORM_OPTIONS","Traitement de texte utiliser par l'annonceur:");
define("_MI_CATADS_FORM_OPTIONS_DESC","choisir le traitement de texte par défault à utiliser pour la rédaction des annonces");
//fin
define("_MI_CATADS_SHOW_CAT_AFFDESC","Afficher le descriptif des sous catégories ?");
define("_MI_CATADS_SHOW_CAT_AFFDESC_DESC","Afficher ou non le descriptif de la sous catégories dans la page de la sous catégories ?");
define("_MI_CATADS_SHOW_SEO","Activer le SEO ?");
define("_MI_CATADS_SHOW_SEO_DESC","Attention ! ne pas oublié de mettre le fichier htaccess du module à la racine de xoops ou de copier/coller son contenu dans le votre si vous en avez déjà un");
//define("_MI_CATADS_NBCOLS_IMG","Annonce: nombre de photos par ligne");
define("_MI_THUMB_WIDTH","Largeur des vignettes des annonces sur le site:");
define("_MI_THUMB_METHOD","Méthode pour redimensionner les images");
define("_MI_CLICK_IMAGE_WIDTH","Largeur de l'image principal dans la page de l'annonce:");
//ajout cpascalweb - le 12 mai 2011 - sécurité anti spam captcha
define("_MI_CATADS_ACTIVE_CAPTCHA","Activer la sécurité anti spam captcha ?");
define("_MI_CATADS_ACTIVE_CAPTCHA_DESC","activer ou non le code de sécurité anti spam captcha lors de la soumission d'une annonce");
//fin
//ajout cpascalweb option choix de la largeur des images des catégories et sous catégories
define("_MI_CATADS_IMAGE_SEPAR","Paramètres des images catégories & photos des annonces");
define("_MI_CAT_IMAGE_WIDTH","Largeur des images des catégories:");
define("_MI_SCAT_IMAGE_WIDTH","Largeur des images des sous catégories:");
//ajout cpascalweb - option choix javascript pop up contact zoombox ou non
define("_MI_CONTAC_ZOOMBOX","Utiliser zoombox sur la page de l'annonce dans la partie contact ?");
define("_MI_CONTAC_ZOOMBOX_DESC","utiliser ou non le javascript zoombox sur la page de l'annonce dans la partie contact");
//ajout cpascalweb - 7 novembre 2010 - option choix afficher ou non les annonces signalées comme étant suspectes
define("_MI_ACTIV_SUSPECT","Laisser les annonces signalées comme étant suspectes visible ?");
define("_MI_ACTIV_SUSPECT_DESC","laisser ou non les annonces signalées comme étant suspectes visible sur le site le temps de la vérification");
//fin 
define("_MI_CATADS_MIC_PAIE_SEPAR","Option Micropaiement");
//ajout cpascalweb option micropaiement1 rentabiliweb pour visualisé les coordonnées d'une annonce le 18 août 2009
define("_MI_CATADS_MIC_PAIE", "Activer l'option Micropaiement 1 ?<br />&nbsp;&nbsp;&nbsp;&nbsp;<b><small><a href='http://www.rentabiliweb.com/fr/?trackADV=351138' target=_blank />Inscription ici</a> | <a href='#' onclick='javascript:openWithSelfMain(\"".XOOPS_URL."/modules/catads/docs/aidemicropaiement1.png\",\"rentabiliweb\",760,485);'>aide param&egrave;tres</a></small></b>");       
define("_MI_CATADS_MIC_PAIE_DESC", "syst&egrave;me de Micropaiement pour voir les coordonn&eacute;es des annonces");
//identification du site protégées  par rentabiliweb = doc_id
define("_MI_CATADS_RENTAB_IDSITE", "Code d'identification pages Micropaiement");  
define("_MI_CATADS_RENTAB_IDSITE_DESC", "identification des pages fourni par rentabiliweb pour prot&eacute;g&eacute;es les pages = doc_id cliquez sur installation du formulaire et relever <b>uniquement</b> les num&eacute;ros de votre doc_id <a href='#' onclick='javascript:openWithSelfMain(\"".XOOPS_URL."/modules/catads/docs/doc_id.png\",\"rentabiliweb\",760,220);'>exemple</a>");
//id de la page protégées  par rentabiliweb = site_id 
define("_MI_CATADS_RENTAB_IDPROTECT", "Code d'identification site Micropaiement");  
define("_MI_CATADS_RENTAB_IDPROTECT_DESC", "id du site fourni par rentabiliweb pour cr&eacute;dit&eacute; votre compte = site_id cliquez sur installation du formulaire et relever <b>uniquement</b> les num&eacute;ros de votre site_id <a href='#' onclick='javascript:openWithSelfMain(\"".XOOPS_URL."/modules/catads/docs/site_id.png\",\"rentabiliweb\",760,220);'>exemple</a>");
// texte intro Micropaiement rentabiliweb dans fenêtre pop up
define("_MI_CATADS_RENTAB_INTROTEXT", "texte intro pop up Micropaiement");       
define("_MI_CATADS_RENTAB_INTROTEXT_DESC", "votre texte d'introduction ou condition dans la fen&ecirc;tre pop up micropaiement");
define("_MI_CATADS_RENTAB_INTROTEXT_DEFAULT", "Pour acc&eacute;der &agrave; cette rubrique veuillez utilisez le formulaire de micropaiement ci-dessous");
// texte information Micropaiement rentabiliweb dans fenêtre pop up
define("_MI_CATADS_RENTAB_INFOTEXT", "texte infos pop up Micropaiement");       
define("_MI_CATADS_RENTAB_INFOTEXT_DESC", "votre texte infos dans la fen&ecirc;tre pop up micropaiement");
define("_MI_CATADS_RENTAB_INFOTEXT_DEFAULT", "Pour acc&eacute;der &agrave; ce service payant et pour obtenir votre code, veuillez cliquer sur le drapeau de votre pays puis choisir votre mode de paiement:");
//fin

//about.php
define("_MI_CATADS_AUTEURS", "Auteurs & développeurs"); 
define("_MI_CATADS_MESS_AUTEUR", "Note de CPascalWeb:"); 
define("_MI_CATADS_MESS_AUTEUR_TXT", "Modifications a effectuées pour la version RC2
<br />- A corrigé bug mineur mais génant: la fonction catads_expired_ads dans .../include/functions.php envoi plusieurs fois les mails (à chaque connexion ou actualisation de la page d'accueil)
<br />- A corrigé bug mineur: Class 'XoopsTree' is deprecated, check 'XoopsObjectTree' in tree.php
<br />- Revoir et mettre à jour le système de notifications
<br />- Modifié le système de carte ajoutée le choix d'afficher une carte suivant son pays 
<br />- Revoir les catégories & sous catégories pré-installé traduction (installation SQL) suivant le pays
<br />- Revoir le système RSS
<br />- Revoir le système de tags
<br />- Revoir le css du module (il est basé sur un de mes thèmes)
<br />- Revoir le seo du module (url pas propre) & ajouter quelques pages exemple: adsuserlist.php, submit.php etc... 
<br />- Modifié le sytème format des images & photos (pour redimensionner les images)
<br />- Revoir mon système de micropaiement surtout la présentation bouton pas terrible & mettre a jour il date de 2009
<br />- Ajouter la possibilité d'activé le système de micropaiement dans: 'modifier votre annonce' et dans 'proposé une annonce'
<br />- Ajouter la possibilité d'activé le système de micropaiement de son choix: allopass et autres
<br />- Améllioré le référencement dit 'naturel'
<br />- supprimer highslide.js remplacer par zombox ou mieux
<br />- Revoir le mode 'prévisualiser' dans soumission
<br />- Ajouter l'effacement automatique des photos lors de l'effacement de l'annonce
<br />- Ajouter une boite de selection par catégorie dans l'admin pour une meilleur gestion des annonces
<br />- Nettoyage et optimisation du code php & defines
<br />- Et divers petites choses a modifié/corrigé et a ajouter
<br /><br />
<p align='center' style='font-size: 1em;font-weight: bold;font-style: italic;'>Toutes contributions, aides et conseils sont bienvenue</p>"); 

define("_MI_CATADS_CREDIT", "- CPascalWeb pour la version catads 1.6 <br /> - Peekay pour la version catads 1.53.5 <br /> - Kraven30 pour la version catads 1.52"); 
define("_MI_CATADS_HISTORY", "<p style='font-size: 1.1em;font-weight: bold;font-style: italic;'>Version 1.6 RC1 du 25/05/2011 par CPascal/CPascalWeb</p><br />
<p style='font-size: 1em;font-weight: bold;font-style: italic;'>Modifications effectuées</p>
<br />- Page d'accueil de l'administration ajout statistiques des annonces catégories et ajout icône d'attention
<br />- Page gestion des annonces ajout icônes status + liens + modif présentation 
<br />- Mis en format utf8
<br />- Modif toutes les rubriques de l'admin
<br />- Modif toutes les pages côté site
<br />- Modif les boutons email et pm
<br />- Modif javascript des photos des annonces
<br />- Modif vidéo ajout javascript + lien sur photo
<br />- Correction bug boite de sélection lors du renouvelement de l'annonce par l'annonceur  
<br />- Mise a jour PHP 5+
<br />- Modif systeme calendrier pris en compte du calendrier xoops et correction bug annonces programmées
<br />- Correction du systeme du code de sécurité capcha qui ne fonctionner pas
<br />- Correction du systeme de rendre les champs email, téléphones, villes, département, régions etc.. obligatoire ou pas qui ne fonctionner pas dans les formulaires de soumission et de modification + ajout option falcultative
<br />- Révision et nettoyage de 95% des defines
<br />- Modif présentation page historique du module (about.php)

<br /><br />
<p style='font-size: 1em;font-weight: bold;font-style: italic;'>Ajouts effectuées</p>
<br />- Ajout la possibilité de suspendre ou de réactivé une annonce par l'administrateur depuis le site ou depuis l'admin (en cas d'annonce suspecte annonce suspendu par nom_du_site)
<br />- Ajout option micropaiement pour accéder aux coordonnées des annonceurs
<br />- Ajout d'un lien pour inscription en mode anonyme
<br />- Ajout option affichage du status des annonces dans le bloc informations annonces
<br />- Ajout option affichage publicité sur les pages principal du module en utilisant un code ou une bannière pub du site
<br />- Ajout option affichage publicité sur les pages des annonces en utilisant un code ou une bannière pub du site
<br />- Ajout option affichage publicité dans le bloc informations annonces en utilisant un code ou une bannière pub du site
<br />- Ajout option affichage publicité dans le bloc Photos & vidéo de l'annonce en utilisant un code ou une bannière pub du site
<br />- Ajout images des sous catégories dans la page des sous catégories
<br />- Ajout dans la page catégorie boite de sélection changer de catégorie + indications en mode connecté ou en mode annonyme
<br />- Ajout dans la page catégorie boite de sélection trier les annonces suivant le type
<br />- Ajout dans la liste des sous catégories images et descriptions de chaque sous catégorie
<br />- Ajout choix de la largeur des images catégorie et des sous catégories
<br />- Ajout javascript pour les photos des annonces
<br />- Ajout option choix fenêtre popup dans contacter par mail avec annonce et photos
<br />- Ajout option choix fenêtre popup dans contacter par mp
<br />- Ajout option envoyer cette annonce à un ami (avec option fenêtre popup)
<br />- Ajout option nous alerter sur cette annonce (avec option fenêtre popup)
<br />- Ajout téléphone portable 
<br />- Ajout 12 catégories de base avec images contenant 96 sous catégories   
<br />- Ajout conseille pour bien rédiger votre annonce (inspiré par AdsLight de Iluc) dans la page de soumission avec un javascript
<br />- Ajout captures des miniatures des vidéos youtube et dailymotion 
<br />- Ajout option activer ou non le code de sécurité capcha
<br />- Ajout envoi mail de confirmation automatique quand l'annonceur supprime son annonce
<br />- Ajout envoi mail de confirmation automatique quand l'annonceur suspend ou réactive son annonce
<br />- Ajout envoi mail de confirmation automatique a l'annonceur quand l'administrateur du site suspend ou réactive son annonce
<br />- Ajout envoi mail automatique a l'annonceur quand son annonce a été signaler comme étant suspecte et quand son annonce n'est plus considérée comme étant suspecte
<br />- Ajout envoi mail automatique a l'administrateur du site quand une annonce a été signaler comme etant suspecte
<br />- Ajout envoi mail automatique a l'annonceur quand une annonce est approuvé aprés modification	
<br />- Ajout option choix de l'éditeur côté site dans préférences du module
<br />- Ajout option choix d'autoriser ou non aux annonceurs de modifiés leurs adresses emails
<br />- Ajout option choix d'afficher le nombre de fois que l'annonce à éte vue
<br />- Ajout option choix de l'éditeur côté site administration dans préférences du module
<br />- Ajout option choix d'afficher ou non le bloc informations annonces
<br />- Ajout option choix d'afficher ou non le nombre total d'annonce dans le bloc informations
<br />- Ajout option choix d'afficher ou non le bloc les dernières petites annonces depuis préférence du module


<br /><br /><br />
<p style='font-size: 1.1em;font-weight: bold;font-style: italic;'>Version 1.53.5 RC3 du 10/06/2010</u> par Peekay</p>
  <br />
  Changes:<br />
  <br />
  - Firefox Ad Blocker Plus warning added to release notes (thx madDan).<br />
  - Corrected description in prefs for default email and admin renewal period.<br />
  <br />
  Bugfixes:
  <br /><br />
  - Template cloning generated a Smarty error (French character issue).<br />
  - Email notification failed if notification options were hidden.<br />
  - Email renewal did not respect allowed renewal count.<br />
  - Allowed renewal count was not decremented after email renewal.<br />
  - Currency and price options were missing from admin edit form.<br />
  - Ad preview did not incorporate style CSS.<br />
  </p>
  <p><u>1.53.4 RC2 12/05/2010</u> - Peekay<br />
  <br />
  Changes:<br />
  <br />
  - Search form menus now group categories and sub-categories correctly.<br />
  - Admin ad-listing now shows user-selected currency.<br />
  - Listings now show ad-type if that preference is set.<br />
  - Title and description display length in listings can now be set as prefs.<br />
  - Ad template and category page templates and CSS updated.<br /><br />
    Bugfixes:<br />
  <br />
  - My-ads listing did not paginate.<br />
  </p>
  <p><u>1.53.3 RC1 10/05/2010</u> - Peekay<br />
  <br />
  Changes:<br />
  <br />
  - RSS now hides ads in categories which disallow anonymous viewing.<br />
  - Meta description tag and keywords are generated dynamically.<br />
  - Admin ad-listing now shows the latest ads first by default.<br /><br />
  Bugfixes:<br />
  <br />
  - Blocks did not respect category permissions.<br />
  - Xoops User-Profile listing of ads did not respect category permissions.<br />
  - Icon for suspended-ads was missing from admin ad-management screen.<br />
  - Import.php failed to check for Classifieds module installation resulting in potential data loss.<br />
  - Title character-length option in blocks did not work.<br />
  - Admin blocks displayed incorrectly in IE7.<br />
  - The Javascript intended to require keyword entry in the search form did not work.<br />
  <br /></p>
  <p><u>1.53.2 Beta 26/04/2010</u> - Peekay<br />
  <br />
  Changes:<br />
  <br />
  - Search results pagination function updated to be PHP 5 compatible.<br />
  - One language change (language/English/main.php) see notes.<br />
  <br />
  Bugfixes:<br />
  <br />
  - Anonymous comment posting failed using PHP 5.<br />
  - Notify on publication option didn't work.<br />
  <br />
  Notes:<br />
  <br />
  The words 'by email' were removed from the 'Notify me when published' language definition because the notification is only sent by email if the user chooses email as their method for Xoops
  notifications. Otherwise it is sent by PM.<br /></p>
  <p><u>1.53.1 Beta 20/04/2010</u> - Peekay<br />
  <br />
  Changes:<br />
  <br />
  - Search now checks for a number in the price-search field.<br />
  <br />
  Bugfixes:<br />
  <br />
  - Search results did not paginate.<br />
  <br />
  Language Packs (download from the project page):<br />
  <br />
  - Arabic translation by Mariane.<br />
  - Chinese translation by Hunnuh.<br />
  - French translation by Tatane.<br /></p>
  <p><u>1.53 Beta 01/04/2010</u> - Peekay - <i>Based on Catads 1.522 FINAL (Sourceforge)</i><br />
  <br />
  Changes:<br />
  <br />
  - Option added to allow custom tags.<br />
  - Option added to hide notification options (so renewal notice can be sent by email always).<br />
  - Option added to hide video field.<br />
  - Option added to restrict publication date to today's date.<br />
  - Option added to hide 'For Sale' etc. (so module can be used as a directory)<br />
  - Clicking a tag now includes tags in search.<br />
  - Keyword search now includes tags.<br />
  - Search allows partial match on post code.<br />
  - Users can search for a keyword in 'category', 'region', 'country' or 'town'.<br />
  - Sub-category 'no-image' option added.<br />
  - Default installation now uses 'regions' table for world regions menu (customisable).<br />
  - Default installation now uses 'departements' table for world countries menu (customisable).<br />
  - Click-to-enlarge image size can now be set in admin.<br />
  - English language files updated.<br />
  - Some field lengths changed.<br />
  - Template now uses theme CSS instead of custom CSS.<br />
  - Module is 99% W3C valid for anonymous users.<br />
  - Blocks are W3C valid, except scrolling ads block which uses the 'marquee' tag.<br />
  - French map is no longer operational by default and will require manual menu changes.<br />
  - (French map files and admin pref have been retained for legacy).<br />
  <br />
  Bugfixes:<br />
  <br />
  - RSS feed did not respect expired, waiting, unpublished or suspended ads.<br />
  - Keyword search did not respect expired, waiting, unpublished or suspended ads.<br />
  - Search failed to limit results to specified parameters (category, region, town etc.)<br />
  - Images did not preview.<br />
  - Email and PM icons did not preview.<br />
  - Region and department names did not preview.<br />
  - Tags did not preview.<br />
  - User notification choice was lost on preview.<br />
  - Notify on publication choice was lost on preview.<br />
  - Selecting 'email' set 'PM' as method.<br />
  - Incorrect moderation message was displayed if moderation disabled.<br />
  - Admin blocks displayed incorrectly in Firefox.<br />
  - Admin 'view category description' option duplicated.<br />
  - Invalid ID in pop-box script.<br />
  - Invalid Highslide CSS (loaded in body).<br />
  - Invalid Flash embed code.<br />
  - Invalid 'no-image' ID.<br />
  - Broken image icon in sub-categories if no image chosen.<br />
  <br />
  Known issues. Code patches or file replacements would be welcomed for the following:<br />
  <br />
  - Search results do not paginate - FIXED 1.53.1.<br />
  - Blocks do not respect category permissions - FIXED 1.53.3.<br />
  - Block template file 'catads_block_expired_ads.tpl' is missing? SOLVED (no template is required)<br />
  - Image filesize error on upload is not flagged in admin edit (this works in user edit).<br />
  - Notify on publication email is not sent - FIXED 1.53.2.<br />
  <br /></p>

  
  <p style='font-size: 1.1em;font-weight: bold;font-style: italic;'>Version 1.52 Final du 28/07/2009</u> par TDM Xoops</p>
  <p>http://www.tdmxoops.net | webmaster@tdmxoops.net<br /><br />Merci &agrave; Nikita et Tatane et merci a Mariane pour la traduction en anglais et en arabe</i><br />
  - Modification du script pour le zoom des vignettes<br />
  - Les annonces expirees ne sont plus affichees dans la carte<br />
  - Rajout du bloc \"Recherche\"<br />
  - Rajout d'une video dans les annonces<br />
  - Possibilite d'afficher les descriptions des categories<br />
  - Les sous-categories sont affichees dans la categorie principale<br />
  - Rajout des tags<br />
  - Possibilite d'activer le SEO<br /></p>
  <p><u>1.51 Beta 19/3/2009</u> <i>Merci &agrave; Tatane pour les tests</i><br />
  02/01/2009 :<br />
  - Bug avec les notifications ( Quand l'utilisateur demandait d'etre prevenu lors la parution de son email, aucun email etait envoye ).<br />
  - Modification de l'edition des annonces lorsqu'il y a la moderation ( Quand le membre voulait editer son annonce pour supprimer ou editer ses images, il ne pouvait pas ).<br />
  - Bug avec la creation de la vignette qui ne correspondait &amp; l'image de survol si il y avait plus de 2 images.<br />
  - Bug lors de la creation de la table regions et departements en fonction de certaines bases de donnees.<br />
  - Bug si l'utilisateur ne choisit pas de mettre les regions ou les departements en champs obligatoire, les annonces ne s'affichent pas sur la carte.<br />
  - Rajout dans l'edition d'annonce dans l'administration, les champs \"Departement\" et \"Region\".<br />
  - Captcha \"Formulaire contact\" par Eparcyl.<br />
  - UTF-8 pour les fichiers de langues par Kris.<br />
  - Affichage des menus deroulants au-dessus de la carte de France<br />
  - Petits bugs par si par l&amp;<br />
  19/01/2009 :<br />
  - La page \"notifications.php\" plante &amp; cause du module<br />
  - Quand l'utilisateur edite son annonce et la moderation est active. Un email est envoye &amp; l'administrateur pour le prevenir et l'annonce est mise en attente.<br />
  - Quand le membre edite son annonce, il peut choisir d'etre prevenu de la publication de son annonce.<br />
  - Dans la partie administrateur, rajout de champs dans l'edition d'une annonce (prix, telephone, regions, departement, titre)<br />
  - Rajout d'une icone \"membre prevenu de l'expiration de son annonce\" dans l'administration.<br />
  21/01/2009 :<br />
  - Ajout d'un champ dans les preferences pour inserer des pubs adsences ou des bannieres par exemple en bas de vos annonces.<br />
  - Dans la partie administrateur, rajout de champs dans l'edition d'une annonce (ajout de photo, suppression de photo)<br />
  - Possibilite de ne pas afficher certaines sous-categories dans la page d'accueil du module<br />
  26/01/2009 :<br />
  - Importation des annonces du module Classifields vers Catads<br />
  02/02/2009 :<br />
  - Rajout d'une option dans l'edition du bloc \" Dernieres annonces \" pour accelerer ou ralentir la vitesse de defilement.<br />
  24/02/2009 :<br />
  - Modification de la case \"ville\", on pouvait pas mettre plus de 22 caracteres.<br />
  - Les annonces qui ont ete editees ne recoivent plus de notifications d'annonce &amp; echeance.<br /></p>
  <p><u>V1.50 26/11/08</u> (Kraven30) <i>Merci &agrave; Eparcyl92 et Tatane pour les tests</i><br />
    Administration<br />
  - Modification par lot des statuts des annonces.<br />
  - Suppression des annonces par utilisateur.<br />
  - Rajout d'une fonction renouveler annonce.<br />
  - Rajout d'une fonction approche de l'expiration.<br />
  - Creation d'un bloc \"Envoi d'email lors de l'approche de l'expiration\".<br />
  - Ajout des permissions d'acces des cat&eacute;gories et de soumissions d'annonces dans les cat&eacute;gories.<br />
  - R&eacute;organisation de l'administration.<br />
  - D&eacute;placement des images dans le dossier uploads &agrave; la racine du site<br />
  - Cr&eacute;ation de vignettes</p>
  <p>//Utilisateur<br />
  - Trie par ordre croissant ou d&eacute;croissant des annonces.<br />
  - Modification du formulaire pour choisir de recevoir l'email d'expiration ou pas.<br />
  - Am&eacute;lioration de l'interface des listes des annonces.<br />
  - Am&eacute;lioration de l'interface de l'annonce.<br />
  - Syst&egrave;me d'agradissement des images des annonces ajax \"Popbox\"<br />
  - Survol des images - Bug d'affichage imprimante, rajout d'une photo.<br />
  - L'utilisateur peur renouveler son annonce quand il l'a recoit par email ou par mp.<br />
  - Bug: le nombre de lecture de l'annonce ne s'incremente plus apres le nombre 127.<br />
  - Bug: Probl&egrave;me d'affichage des categories.<br />
  - Affichage d'une carte de France<br />
  - Ajout d'un syst&egrave;me de recherche</p>
  <p><u>V1.41</u>(Philippe Montalbetti)<br />
  - Rajout du syst&egrave;me RSS.</p>
<p>Merci donc & tous...</p>"); 

//notifications
define("_MI_CATADS_NOTIFY_SEPAR","Gestion des notifications et des commentaires");
define("_MI_CATADS_GLOBAL_NOTIFY", "Globale");
define("_MI_CATADS_GLOBAL_NOTIFYDSC", "Options de notification globales des annonces");
define("_MI_CATADS_CATEGORY_NOTIFY", "Catégorie");
define("_MI_CATADS_CATEGORY_NOTIFYDSC", "Options de notification s'appliquant à la catégorie");
define("_MI_CATADS_ADS_NOTIFY", "Annonces");
define("_MI_CATADS_ADS_NOTIFYDSC", "Options de notification s'appliquant à l'annonce actuelle");
//Evénement 1
define("_MI_CATADS_GLOBAL_ADSSUBMIT_NOTIFY", "Annonce proposée");
define("_MI_CATADS_GLOBAL_ADSSUBMIT_NOTIFYCAP", "Notification de la proposition d'une nouvelle annonce (en attente)");
define("_MI_CATADS_GLOBAL_ADSSUBMIT_NOTIFYDSC", "Recevoir une notification quand une nouvelle annonce est proposée");
define("_MI_CATADS_GLOBAL_ADSSUBMIT_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} notification automatique: Nouvelle annonce");
//Evénement 2
define("_MI_CATADS_GLOBAL_NEWADS_NOTIFY", "Nouvelle annonce");       
define("_MI_CATADS_GLOBAL_NEWADS_NOTIFYCAP", "Notification de la parution d'une nouvelle annonce");                           
define("_MI_CATADS_GLOBAL_NEWADS_NOTIFYDSC", "Recevoir une notification quand une nouvelle annonce est publiée");                
define("_MI_CATADS_GLOBAL_NEWADS_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} notification automatique: Nouvelle annonce");
//Evénement 2
define("_MI_CATADS_GLOBAL_EDIT_NOTIFY", "Edition annonce");       
define("_MI_CATADS_GLOBAL_EDIT_NOTIFYCAP", "Notification de l'édition d'une annonce.");                           
define("_MI_CATADS_GLOBAL_EDIT_NOTIFYDSC", "Recevoir une notification quand une annonce est editée avec la modération");                
define("_MI_CATADS_GLOBAL_EDIT_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} notification automatique: Edition annonce"); 
//Evénement 3
define("_MI_CATADS_CATEGORY_SUBMIT_NOTIFY", "Nouvelle annonce proposée");    
define("_MI_CATADS_CATEGORY_SUBMIT_NOTIFYCAP", "Notification de la proposition d'une nouvelle annonce qui est en attente de publication");
define("_MI_CATADS_CATEGORY_SUBMIT_NOTIFYDSC", "Recevoir une notification quand une nouvelle annonce est proposée");
define("_MI_CATADS_CATEGORY_SUBMIT_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} notification automatique: Proposition d'une nouvelle annonce");
//Evénement 4
define("_MI_CATADS_CATEGORY_NEWADS_NOTIFY", "Nouvelle annonce proposée");       
define("_MI_CATADS_CATEGORY_NEWADS_NOTIFYCAP", "Notification d'une nouvelle annonce dans cette rubrique.");
define("_MI_CATADS_CATEGORY_NEWADS_NOTIFYDSC", "Recevoir une notification quand une nouvelle annonce parait dans cette rubrique.");
define("_MI_CATADS_CATEGORY_NEWADS_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} notification automatique: Parution d'une nouvelle annonce");
//Evénement 5
define("_MI_CATADS_ADS_APPROVE_NOTIFY", "Annonce publiée");
define("_MI_CATADS_ADS_APPROVE_NOTIFYCAP", "Notification de la publication de mon annonce");
define("_MI_CATADS_ADS_APPROVE_NOTIFYDSC", "Recevoir une notification quand mon annonce sera publiée.");
define("_MI_CATADS_ADS_APPROVE_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} notification automatique: Annonce publiée");
//Evénement 6
define("_MI_CATADS_ADS_EDIT_NOTIFY", "Annonce publiée");
define("_MI_CATADS_ADS_EDIT_NOTIFYCAP", "Notification quand mon annonce modifiée");
define("_MI_CATADS_ADS_EDIT_NOTIFYDSC", "Etre averti lorsque mon annonce est édité");
define("_MI_CATADS_ADS_EDIT_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} notification automatique: Annonce édité");

//a supp définitivement aprés test !
//define("_MI_CATADS_INFORM_EXP","Être informer de l'expiration de l'annonce par:");
//define("_MI_CATADS_INFORM_EXP_MAIL","Email");
//define("_MI_CATADS_INFORM_EXP_MP","message privé");
//define("_MI_CATADS_AUTO","Message auto lorsque une annonce arrive à expiration ?");
//define("_MI_CATADS_AUTO_DESC","Envoyer un message lorsque une annonce arrive à expiration");
//define("_MI_CATADS_ANONCANPOST","Autorisé les anonymes peuvent poster");//a revoir !
//define("_MI_CATADS_ANONCANPOST_DESC","Mettez sur oui  pour autoriser les anonymes a poster");
//define("_MI_CATADS_BBCODE","Formulaire: autorisé les bbcodes ?");
//define("_MI_CATADS_BNAME4","Envoie un email si l'annonce arrive à expiration");//bloc a revoir ou a supprimer

// JJdai
define('_MI_CATADS_ABOUT',"À propos");
define('_MI_CATADS_SHOW_TPL_NAME', 'Afficher le nom des templates');
define('_MI_CATADS_SHOW_TPL_NAME_DESC', 'Option à utiliser pour le développement, la désactiver en production');

?>