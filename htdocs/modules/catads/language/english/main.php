<?php

define("_MD_CATADS_FROMSITE","The ads of");
define("_MD_CATADS_MAIN","small ads");
define("_MD_CATADS_PRICE","Price ");
define("_MD_CATADS_EDITADS","Modify this announces");
define("_MD_CATADS_CAT_NOEXIST","Sorry <br />This category does not exist !");
define("_MD_CATADS_PAS_ANNONCE","No announces yet visible");	
define("_MD_CATADS_NO_WAIT","No announces pending validation");
define("_MD_CATADS_NBWAIT","<span style='color:#FF0000; font-weight:bold'>%s</span> ads awaiting validation");
//add CPascalWeb - 7 octobre 2010 define function display according to the number	
define("_MD_CATADS_ACTUALLEMENT","currently there are:");	
define("_MD_CATADS_NBWAITUNE","<span style='color:#FF0000; font-weight:bold'>%s</span> announces pending validation");
define("_MD_CATADS_ACTUALYUNE","<span style='color:#FF0000; font-weight:bold'>%s</span> announces seen ".$GLOBALS['xoopsConfig']['sitename']."");	
define("_MD_CATADS_SEEWAITUNE","See the announces waiting");
//fin	
define("_MD_CATADS_ACTUALY","<span style='color:#FF0000; font-weight:bold'>%s</span> ads seen on ".$GLOBALS['xoopsConfig']['sitename']."");
define("_MD_CATADS_SEEWAIT","See the ads waiting");	
//add CPascalWeb - 7 octobre 2010 suspended and announces reporting function
//suspended by the site announces (administrator) 
define("_MD_CATADS_NO_SUSPADMIN","No ads suspended ".$GLOBALS['xoopsConfig']['sitename']."");
define("_MD_CATADS_SUSPADMIN","<span style='color:#FF0000; font-weight:bold'>%s</span> ads by suspended ".$GLOBALS['xoopsConfig']['sitename']."");	
define("_MD_CATADS_SUSPADMINUNE","<span style='color:#FF0000; font-weight:bold'>%s</span> announce suspended ".$GLOBALS['xoopsConfig']['sitename']."");
define("_MD_CATADS_VOIRSUSPADMIN","View ads suspended by ".$GLOBALS['xoopsConfig']['sitename']."");	
define("_MD_CATADS_VOIRSUSPADMINUNE","See the announce suspended ".$GLOBALS['xoopsConfig']['sitename']."");	
//announces suspended by the announcer	
define("_MD_CATADS_NO_SUSPUSER","No ads suspended by their proprietary");
define("_MD_CATADS_SUSPUSER","<span style='color:#FF0000; font-weight:bold'>%s</span> ads suspended by their proprietary");	
define("_MD_CATADS_SUSPUSERUNE","<span style='color:#FF0000; font-weight:bold'>%s</span> Ad suspended by its owner");
define("_MD_CATADS_VOIRSUSPUSER","View ads suspended by announcers");	
define("_MD_CATADS_VOIRSUSPUSERUNE","See the announcement suspended by the advertiser");
define("_MD_CATADS_SIGNALSUSPECT","<span style='color:#FF0000; font-weight:bold'>%s</span> reported suspicious ads");	
define("_MD_CATADS_VOIRSIGNALSUSPECT","View announcements reported suspicious");	
define("_MD_CATADS_SIGNALSUSPECTUNE","<span style='color:#FF0000; font-weight:bold'>%s</span> reported suspicious ad");
define("_MD_CATADS_VOIRSIGNALSUSPECTUNE","See the announcement reported suspicious");	
//fin		
define("_MD_CATADS_LASTADD","latest ads");
define("_MD_CATADS_INFO_ADS","announcements information");
define("_MD_CATADS_CAT","Categories");
define("_MD_CATADS_RSSFEED","RSS feed");

//search.php
define("_MD_CATADS_SEARCH","Advanced Search");
define("_MD_CATADS_SEARCH_CATEGORY","Category:");
define("_MD_CATADS_SEARCH_WORDS","Search words:");
define("_MD_CATADS_SEARCH_PRICE","Price:");
define("_MD_CATADS_SEARCH_PRICE_A","to ");
define("_MD_CATADS_SEARCH_REGIONS","country:");
define("_MD_CATADS_SEARCH_DEPARTEMENTS","Department:");
define("_MD_CATADS_SEARCH_CITY","Towns:");
define("_MD_CATADS_SEARCH_ZIPCOD","zip code:");	
define("_MD_CATADS_SEARCH_USER","Users:");

//adslist.php
define("_MD_CATADS_ADDANNONCE","submit an ad");
//ajout fonction CPascalWeb - 9 octobre 2010 affichage define si mode anonyme + mis en garde	
define("_MD_CATADS_ADDANNONCE_ANONYM","To submit an ad in this category to subscribe thank you:");	
define("_MD_CATADS_ADDANNONCE_ANONYMINSC","here");
define("_MD_CATADS_DEPOANNONCE_SITE","submit an ad");	
define("_MD_CATADS_NOM_REFERENCE","small ads");
define("_MD_CATADS_TAGS_REFERENCE","small ads");	
define("_MD_CATADS_DEPOANNONC_SELEC_ANONYM","To submit an ad in one of these categories to subscribe thank you:");		
define("_MD_CATADS_DEPOANNONC_SELEC","To submit an announcement thank you to select one of these categories");	
define("_MD_CATADS_RETOUR","Back to the small ads");	
define("_MD_CATADS_ATTENTION","Caution");
define("_MD_CATADS_ATTINFOS","This may be an error or abuse of the system by one of our users. As a precaution Team ".$GLOBALS['xoopsConfig']['sitename']." currently controls this property stay safe, thank you for your understanding");
//fin	
define("_MD_CATADS_NOADSINCAT","There are no ads in this category");
define("_MD_CATADS_ADSEXP","Your ad expired !");
define("_MD_CATADS_ADSWAIT","Your ad is awaiting approval...");
define("_MD_CATADS_ADSSUSPECT","This announcement has just been reported as suspicious !");	
//add function CPascalWeb - 7 octobre 2010 define the following number display	
define("_MD_CATADS_SEARCH_NB_1A","there is <span style='color:#FF0000; font-weight:bold'>%s</span> announcement found");
define("_MD_CATADS_SEARCH_NB","there is <span style='color:#FF0000; font-weight:bold'>%s</span> ads found");	
define("_MD_CATADS_SEARCH_NB_NOA","Sorry no ads found !");	
//fin
//add function CPascalWeb - 7 octobre 2010 Added checkbox in another category	
define("_MD_CATADS_SELECT_CAT","Change category:");	
define("_MD_CATADS_AFF_PAR_TYPE","Sort these announcements by:");	
//fin	
//adsuserlist.php
define("_MD_CATADS_MYADS","My announcements");
define("_MD_CATADS_ALLADS","All ads of:");

//catads_adssublist.tpl
define("_MD_CATADS_TITLE","Title");
define("_MD_CATADS_DATE","Dates");
define("_MD_CATADS_LOCAL2","Towns");
define("_MD_CATADS_OPTION_PRICE","Conditions");
//add CPascalWeb - 21 octobre 2010	
define("_MD_CATADS_ANNONCES","Announcements");
define("_MD_CATADS_ENLIGNE","Online !");	
define("_MD_CATADS_ENATTENTE","Waiting !");	
define("_MD_CATADS_SUSPARADMIN","Suspended ".$GLOBALS['xoopsConfig']['sitename']." !");	
define("_MD_CATADS_SUSPARANNOCEUR","Suspended by you !");	
define("_MD_CATADS_EXPIREE","Expired !");	
define("_MD_CATADS_VAEXPIREE","Will soon be expired !");	
define("_MD_CATADS_STATUS","Status");
define("_MD_CATADS_IMGANNONCE","Pictures");	
define("_MD_CATADS_SIGNALEMENT","Suspect !");	
define("_MD_CATADS_SELECT_SORT","or by order:");
define("_MD_CATADS_SORT_ASC","A => Z");
define("_MD_CATADS_SORT_DESC","Z => A");
//fin	

//adsitem.php
define("_MD_CATADS_NO_EXIST","This announcement does not exist");
define("_MD_CATADS_BYMAIL","Contact the author by email");
define("_MD_CATADS_BYPM","Contact the author via personal message");
define("_MD_CATADS_NBVIEW","%s times");
define("_MD_CATADS_PUBAGAIN_CONF","Want to republish this ad ?");
define("_MD_CATADS_PUBAGAIN_OK","Your ad has been extended %s days");
define("_MD_CATADS_UPDATE_ERROR","Error ! update not performed");
define("_MD_CATADS_SEE_OTHER_ADS","See the %s ads of %s visible on ".$GLOBALS['xoopsConfig']['sitename']."");
define("_MD_CATADS_NO_OTHER_ADS","No other announcement of %s visible on ".$GLOBALS['xoopsConfig']['sitename']."");
define("_MD_CATADS_PUBSTOP_CONF","Are you sure you want to suspend your ad ?");
define("_MD_CATADS_PUBGO_CONF","Are you sure you want to reactivate your ad ?");
define("_MD_CATADS_PUBSTOP_OK","Your ad has been suspended !");
define("_MD_CATADS_PUBGO_OK","Your ad is available again !");
//add function CPascalWeb - 17 septembre posibility to suspend or resume an ad
define("_MD_CATADS_PUBADMINSTOP_CONF","Are you sure you want to suspend this ad ?");
define("_MD_CATADS_PUBADMINGO_CONF","confirm you want to reactivate this ad ?");
define("_MD_CATADS_PUBADMINSTOP_OK","the ad has been suspended !");
define("_MD_CATADS_PUBADMINGO_OK","Ad is available again !");
define("_MD_CATADS_DESCANNONCE","announcement");
define("_MD_CATADS_NOM_REFERENCE_VIDEO","Video of the ad");//ne pas décoder (&#146;) javascript	
define("_MD_CATADS_NOM_REFERENCE_VIDEO_CAPTURE","video the ");		
//add function CPascalWeb - 5 novembre 2010 report of a suspicious ad
define("_MD_CATADS_DECLARFRAUDE_CONF","Warning !<br/ >You are about to report this ad as suspicious, to prevent abuse of this system your IP address will be provisionally registered<br />");
define("_MD_CATADS_DECLARNOFRAUDE_CONF","You confirm that this ad is no longer considered suspicious ?");
define("_MD_CATADS_DECLARFRAUDE_OK","".$GLOBALS['xoopsConfig']['sitename']." thank you for your help<br />announcement is reported suspicious !");
define("_MD_CATADS_DECLARNOFRAUDE_OK","the ad is no longer considered suspicious !");
define("_MD_CATADS_DECLARFRAUDE_FAITE","".$GLOBALS['xoopsConfig']['sitename']." thank you for your help, This ad has already had noted as suspicious. This may be an error or abuse of the system by one of our users but, This ad is a precautionary measure currently under audit by a new team ".$GLOBALS['xoopsConfig']['sitename']." thank you for your comprehension");
//fin
//add CPascalWeb - rentabiliweb
define("_MD_CATADS_VOIR_RENTABI_CONTACT","See coordinates");
//pageerreur.php
define("_MD_CATADS_CODE_RENTABI_INVALIDE","access code invalid !");
define("_MD_CATADS_MESS_RENTABI","Le code d'accés que vous avez saisis est invalide !<br /> thank you kindly again");
//contact.php tentative de fraude
define("_MD_CATADS_TITRE_RENTABI_FRAUDE","attempted fraud record !");
define("_MD_CATADS_MESS_FRAUDE","Not very cool !<br /> The price of the access code is not however raise");	

//Ajout CPascalWeb - affichage forcé dans rentabiliweb
//include/form_contact.inc.php
define("_MD_CATADS_CONTACT_TELEPH","Telephone:");
define("_MD_CATADS_CONTACT_TELEPHPORTABLE","Mobile Phone:");
//catads_adsitem.html
define("_MD_CATADS_DATE_EXP","expires on:");
define("_MD_CATADS_PRICE2","Price:");
define("_MD_CATADS_VIEW","This page has been viewed:");
define("_MD_CATADS_PHONEPORTABLE","Mobile Phone");	
define("_MD_CATADS_PHONE","Telephone");
define("_MD_CATADS_NOPHONE","unspecified");	
define("_MD_CATADS_VALIDADS","Validate this ad");
define("_MD_CATADS_DELETEADS","Remove this ad");
define("_MD_CATADS_NO_ADS","This ad is not available ...<br />");
define("_MD_CATADS_PUB_AGAIN","Renew your ad for:");
define("_MD_CATADS_PUB_STOP","Suspend this ad");
define("_MD_CATADS_PUB_GO","Reactivated this ad");
define("_MD_CATADS_PUB_SUSP","You've suspended your ad<br /><small>it is no longer visible on ".$GLOBALS['xoopsConfig']['sitename']."</small>");
//add function CPascalWeb - 17 septembre posibility to suspend or reactivate an ad
define("_MD_CATADS_PUB_SUSPADMIN","ad suspended by ".$GLOBALS['xoopsConfig']['sitename']." !<br /><small>it is no longer visible on ".$GLOBALS['xoopsConfig']['sitename']." the time of the Verification</small>");
define("_MD_CATADS_PUB_INTERDIT","Sorry !<br />this attempt at cheating is forbidden !");
//fin
//ajout CPascalWeb - defines divers	
define("_MD_CATADS_ADRESS_IP","IP Address of");	
define("_MD_CATADS_MODIFIER_ANNCEUR","Modify your ad");
define("_MD_CATADS_SUPPRIMER_ANNCEUR","Delete your ad");
define("_MD_CATADS_SUSP_ANNCEUR","Suspend your ad");
define("_MD_CATADS_NOSUSP_ANNCEUR","Reactivate your ad");
define("_MD_CATADS_VOIRTOUT_ANNCEUR","See all your ads");
define("_MD_CATADS_GESTIONAUTEUR","Manage your ad");
define("_MD_CATADS_GESTIONADM","Management announcement ".$GLOBALS['xoopsConfig']['sitename']."");
define("_MD_CATADS_BLOC_CONTACTINFOS","Contact the author of this ad");
define("_MD_CATADS_BLOC_PHOTOVIDEO","Pictures & Video of the ad");
define("_MD_CATADS_PAS_PHOTO","ad without photo");	
define("_MD_CATADS_BLOC_ADRESSE","Geographic location:");	
define("_MD_CATADS_BLOC_TAGS","Keywords link to the ad");
define("_MD_CATADS_BLOC_VILLE","Town:");
define("_MD_CATADS_BLOC_CPOSTAL","Zip code:");
define("_MD_CATADS_BLOC_COND","condition:");	
define("_MD_CATADS_ENVOIAMIE","send this ad to a person");	
define("_MD_CATADS_ENVOIAMIE_OBJET","Interesting ad %s");//%s = nom du site	
define("_MD_CATADS_ENVOIAMIE_INTRO1","hello, %s");//laisser carractére coder
define("_MD_CATADS_ENVOIAMIE_INTRO2","I find this ad ".$GLOBALS['xoopsConfig']['sitename']." for you");//laisser carractére coder
define("_MD_CATADS_ENVOIAMIE_INTRO3","you can see this ad by copying this link");
define("_MD_CATADS_BLOC_REGION","country:");
define("_MD_CATADS_BLOC_DEPARTEMENT","department:");	
define("_MD_CATADS_BLOC_CONTACT","Thank you contact me");
define("_MD_CATADS_BLOC_CONTACTTEL","My contact phone:");
define("_MD_CATADS_CONSEILSITE","Recommend this site to a person");
define("_MD_CATADS_SIGNALFRAUDE","Alert us to this ad");	
define("_MD_CATADS_SIGNALNOFRAUDE","remove warned suspect");
define("_MD_CATADS_SIGNALFRAUDEADM","enable ad suspicious");	
define("_MD_CATADS_VISIBLEIMPRIME","ad seen in:");
//fin
define("_MD_CATADS_PRINT","Print this announcement");
define("_MD_CATADS_PRINT_TITRE","Print announcement");	
define("_MD_CATADS_NO_ADS_E","This ad has expired !");
define("_MD_CATADS_NO_ADS_W","This ad is awaiting approval");
define("_MD_CATADS_NO_ADS_P","This ad will be published %s");
define("_MD_CATADS_DATE_PUB1","Ad was posted on:");
define("_MD_CATADS_PHOTO","Pictures of the ad");
define("_MD_CATADS_ADSFROM","submitted by:");
define("_MD_CATADS_DATE_ANNO","Published on:");
define("_MD_CATADS_PUB_SUSPIMPR","Announcement suspended by its owner or ".$GLOBALS['xoopsConfig']['sitename']."<br /><small>it is no longer visible on ".$GLOBALS['xoopsConfig']['sitename']."</small>");
//fichier formcontact.inc.php //
define("_MD_CATADS_MSGSEND","Your message has been sent");
define("_MD_CATADS_CONTACTAUTOR","Contact by mail the author of the ad");
define("_MD_CATADS_YOURNAME","Your name");
define("_MD_CATADS_YOUREMAIL","Your email");
define("_MD_CATADS_YOURPHONE","Your telephone");
define("_MD_CATADS_YOURPHONEPORTABLE","Your Cell Phone");	
define("_MD_CATADS_YOURMESSAGE","Your message");
//submit
define("_MD_CATADS_ONLY_MEMBERS","Sorry ! <br />Only registered members can submit an ad");
define("_MD_CATADS_FILEERROR","Error uploading your photo<br />Check that the number of bytes does not exceed %s");
define("_MD_CATADS_ERROR_INSERT","An error has failed to record your greeting");
define("_MD_CATADS_MODULE_NAME","catads");
define("_MD_CATADS_AFTER_MODERATE","The ad that you posted will be verified before publication");
define("_MD_CATADS_NO_MODERATE","Your ad has been recorded");
define("_MD_CATADS_INVALIDMAIL","Please enter a valid email address !");
define("_MD_CATADS_INVALIDPRICE","The price must be a number !");
define("_MD_CATADS_MAXLENGTH","The ad text must be less than %s characters !");
define("_MD_CATADS_PHONE_SPORTABLE","Mobile Phone:");
define("_MD_CATADS_PHONE_S","Fixed telephone:");
define("_MD_CATADS_MAIL_S","Email:");
define("_MD_CATADS_CITY_S","Town:");
define("_MD_CATADS_CODPOST_S","Zip code:");
define("_MD_CATADS_PRICE_S","Price: <span style='font-size:10px'>(ex: 45.52 &euro;)</span>");
define("_MD_CATADS_PRICE_MOD","Modify your price and conditions:");	
define("_MD_CATADS_PHONE_P","Telephone");
//add CPascalWeb - 27 novembre 2010 
define("_MD_CATADS_CONSEIL","Advice on how to writing your ad");	
define("_MD_CATADS_CONSEIL_1","It is strongly advised to put photos and video in your ad, an ad with photos and a video is viewed 7 times, it also gives a first idea of the condition of your item.");
define("_MD_CATADS_CONSEIL_2","Skip the language « SMS », it is imperative that the ad is legible. So avoid writing too much text, this must remain an ad, an announcement is more clear and precise, the greater the chance of reaching a settlement.");	
define("_MD_CATADS_CONSEIL_3","Write your ad in tiny, it is strongly discouraged capital letters, remember all the details and make sure that people can have all the information needed for your ad. Otherwise they will contact you for anything, waste of time for you and the user.");
define("_MD_CATADS_CONSEIL_4","Fill out the fields in your coordinates portion to be contact, and do not forget to remove your ad once the transaction, it only takes a few seconds and you will avoid more incidents after being banished from ".$GLOBALS['xoopsConfig']['sitename']."");	
define("_MD_CATADS_LECTURE","Play");
define("_MD_CATADS_PAUSE","Pause");	
//fin	
	
//add CPascalWeb - 17 septembre 	
define("_MD_CATADS_NOUVEAU","<span style='color: red;'>New !</span>");	
define("_MD_CATADS_MODIFADS","Modification your ad: ");	
//fin	
define("_MD_CATADS_MAILREQ","You chose to be contacted, preferably by email, in this case thank you enter your email address or to change your choice");
define("_MD_CATADS_PHONEREQ","You have chosen to contact preferably by phone, in this case thank you enter your phone number or change your choice");

//formulaire annonce
define("_MD_CATADS_MENUADD","Post your ads in category: ");
define("_MD_CATADS_MENUADD1","Modify your Photos: ");
//add CPascalWeb - 9 octobre 2010 		
define("_MD_CATADS_MSG_CONDSOUMISTITLE","Condition of publication:");	
define("_MD_CATADS_MSG_CONDSOUMIS","Your ad will be published after being checked by the team ".$GLOBALS['xoopsConfig']['sitename']."");
define("_MD_CATADS_MSG_CONDMODTITLE","Modified Condition:");	
define("_MD_CATADS_MSG_CONDMOD","Your ad will be changed after being checked by the team ".$GLOBALS['xoopsConfig']['sitename']."");	
//fin	
define("_MD_CATADS_TEXTE_S","Text of the ad:");
define("_MD_CATADS_ADDIMG","Add an image:");
define("_MD_CATADS_ADVERT","Be informed by mail of validation ?");
//ajout CPascalWeb - 16 octobre 2010
define("_MD_CATADS_ADVERTPUBLI","&nbsp;yes");
define("_MD_CATADS_SEPAR_TAGS","-");
define("_MD_CATADS_CONTACT_EMAIL","Send an Email");
define("_MD_CATADS_CONTACT_MESSPRIV","Private Messaging");
define("_MD_CATADS_CONTACT_MOI","CONTACT ME");	
//fin	
define("_MD_CATADS_CONTACT_MODE","To contact:");
define("_MD_CATADS_CONTACT_MODE1","Private Message");
define("_MD_CATADS_CONTACT_MODE2","email");
define("_MD_CATADS_CONTACT_MODE3","telephone");
define("_MD_CATADS_IMG_CONFIG","Maximum size %s ko, maximum width %s pixels, maximum height %s pixels");
define("_MD_CATADS_DATE_PUB","Publication Date:");
define("_MD_CATADS_TITLE1","Title:");
define("_MD_CATADS_RENEWALS_EXCEEDED","Number of renewals reached !<br /> thank you submit a new announcement");
define("_MD_CATADS_DURATION_PUB","Duration:");
define("_MD_CATADS_DAYS","days");
define("_MD_CATADS_CONTACTME","Your coordinates");
define("_MD_CATADS_CONTACT_PREF1","of preferably");
define("_MD_CATADS_CONTACT_PREF2","only");
define("_MD_CATADS_BY","par:");
//add CPascalWeb - 12 octobre 2010 - titre et alt dans les liens des titres et images des catégories	
define("_MD_CATADS_CAT_TITREALT","small ads");	
define("_MD_CATADS_CAT_TITREALTCAT","Free ads site");		
//fin	

//modifier annonce
define("_MD_CATADS_IMG","Picture");
define("_MD_CATADS_DELIMG","Delete this photo");
define("_MD_CATADS_REPLACEIMG","or replace it:");
define("_MD_CATADS_CONF_DEL","Are you sure you want to remove this ad ?");
define("_MD_CATADS_ERROR_UPDATE","Error update your ad ");
define("_MD_CATADS_NOERROR_UPDATE","Updated");
define("_MD_CATADS_ADSDELETED","Your ad has been deleted");
define("_MD_CATADS_ERRORDEL","Error !<br /> Your ad was not removed");
define("_MD_CATADS_PHOTO_MOD","Pictures of your ad");	
define("_MD_CATADS_PHOTO_CAUTION","<span style='color:#ff9900'>Warning</span> ! Do not delete the photo if the other one will no longer appear");
define("_MD_CATADS_CONTACTME_MOD","Modify your coordinates");
define("_MD_CATADS_CLOSEF","Close");
define("_MD_CATADS_ZOOMBOX_CLOSEF","Click on the cross to close this window");
define('_MD_CATADS_REGION','Regions:');
define('_MD_CATADS_DEPARTEMENT','Department:');
define('_MD_CATADS_TWON','Town:');
define('_MD_CATADS_ZIPCOD','Zip code:');
define("_MD_CATADS_VIDEO","Add a video");
define("_MD_CATADS_VIDEO_MOD","Modify your video");		
define("_MD_CATADS_VIDEO_HELP","<small>For example YouTube: http://www.youtube.com/watch?v=(code of the video) and nothing else after<br /> For example DailyMotion: http://www.dailymotion.com/video/xcqmb9_cdl-marseille-bordeaux-finale-2010_sport (and nothing else after)</small>");
define("_MD_CATADS_TAGS","Keywords of the ad");
define("_MD_CATADS_TAGS_MOD","Modify keywords in the ad");		
define("_MD_CATADS_TAGS_HELP","<small>enter keywords related to your ad, otherwise leave this blank it will automatically create</small><br /><br />");
define("_MD_CATADS_PREVIEW_TEXT","Overview");
define("_MD_CATADS_SUBMIT_AD","<strong>Submit an ad:</strong>");
	   
//add 21 avril 2011 - email message when a ad expires	   
define("_MD_CATADS_MAIL_TITLE","[{X_SITENAME}]: Warning ! Your ad to expire");
define("_MD_CATADS_MAIL_TEXT","Hello {X_UNAME},<br />
Your ad {X_ADS} on {X_SITENAME} will expire in {X_DAY} days. <br />
If you want to renew your ad thank you to click on this link: {X_ADS_RENEW}.<br /><br />
Cordially <br /><br />
{X_SITENAME} <br />
{X_SITEURL} <br /><br />
Our email address<br />
{X_ADMINMAIL}<br /><br />
");
define("_MD_CATADS_RENEW_ADS","Renew your ad");
  
//add CPascalWeb - 14 mai 2011 - function sending email when the ad has expired  
define("_MD_CATADS_MAIL_EXPTITLE","[{X_SITENAME}]: Warning ! Your ad has expired");
define("_MD_CATADS_MAIL_EXPTEXT","Hello {X_UNAME},<br />
Your ad {X_ADS} sur {X_SITENAME} it has expired since the: {X_DAY}. It is therefore more seen in {X_SITENAME}.<br />
To renew your ad simply click on this link: {X_ADS_RENEW}.<br /><br />
Cordially <br /><br />
{X_SITENAME} <br />
{X_SITEURL} <br /><br />
Our email address<br />
{X_ADMINMAIL}<br /><br />
");
	   
//add 29 avril 2011 - message send by mail when the advertiser's announcement suspends	   
define("_MD_CATADS_MAIL_SUSP_TITLE","[{X_SITENAME}]: Confirmation of the suspension of your ad !");
define("_MD_CATADS_MAIL_SUSP_TEXT","Hello {X_UNAME},<br />
You just suspend your ad {X_ADS} sur {X_SITENAME}, we confirm that it is suspended and thus more visible. <br />
If you want to cancel the suspension simply click on this link: {X_ADS} and to you connect.<br /><br />
Cordially <br />
{X_SITENAME} <br />
{X_SITEURL} <br /><br />
Our email address<br />
{X_ADMINMAIL}<br /><br />
");
//add 29 avril 2011 - message send by mail when the announcer ad its reactive	   
define("_MD_CATADS_MAIL_REACT_TITLE","[{X_SITENAME}]: Confirmation of the reactivation of your ad !");
define("_MD_CATADS_MAIL_REACT_TEXT","Hello {X_UNAME},<br />
You just reactivate your ad {X_ADS}, we confirm that it is again seen in {X_SITENAME}.<br /><br />
Cordially, {X_SITENAME} <br />
{X_SITEURL} <br />
Our email address<br />
{X_ADMINMAIL}<br /><br />
"); 
//add 29 avril 2011 - message send by mail when an administrator suspends a ad	   
define("_MD_CATADS_MAIL_SUSPADMIN_TITLE","[{X_SITENAME}]: Your ad has been suspended !");
define("_MD_CATADS_MAIL_SUSPADMIN_TEXT","Hello {X_UNAME},<br />
We are sorry to inform you that we have been forced to suspend your ad {X_ADS} on {X_SITENAME}. <br />
This suspension is hopefully temporary, For more information please contact us.<br /><br />
Thank you for your comprehension, cordially, {X_SITENAME} <br />
{X_SITEURL} <br />
Our email address<br />
{X_ADMINMAIL}<br /><br />
");
//add 29 avril 2011 - message send by mail when a director reactivates a ad   
define("_MD_CATADS_MAIL_REACTADMIN_TITLE","[{X_SITENAME}]: Your ad has been reactivate !");
define("_MD_CATADS_MAIL_REACTADMIN_TEXT","Hello {X_UNAME},<br />
We are pleased to inform you that we have reactivate your ad {X_ADS} on {X_SITENAME}. <br />
We accept our apology for the inconvenience.<br /><br />
Thank you for your comprehension, cordially, {X_SITENAME} <br />
{X_SITEURL} <br />
Our email address<br />
{X_ADMINMAIL}<br /><br />
");
//add 29 avril 2011 - message send by mail when an ad is reporting suspect		   
define("_MD_CATADS_MAIL_ADSSUSPECT_TITLE","[{X_SITENAME}]: Warning your ad has been reported suspicious !");
define("_MD_CATADS_MAIL_ADSSUSPECT_TEXT","Hello {X_UNAME},<br />
We are sorry to inform you that your ad {X_ADS} on {X_SITENAME} has been reported as suspicious.<br />
This may be an error or abuse of the system by one of our surfers.<br />As a precaution Team {X_SITENAME} will recheck your ad as soon as possible. For more information please contact us.<br /><br />
Thank you for your comprehension, cordially, {X_SITENAME} <br />
{X_SITEURL} <br />
Our email address<br />
{X_ADMINMAIL}<br /><br />
");
//add 29 avril 2011 - message send by mail when an ad is no longer reporting suspicious	   
define("_MD_CATADS_MAIL_ADSNOSUSPECT_TITLE","[{X_SITENAME}]: Your ad is no longer considered suspicious !");
define("_MD_CATADS_MAIL_ADSNOSUSPECT_TEXT","Hello {X_UNAME},<br />
We are pleased to inform you that your ad {X_ADS} on {X_SITENAME} was checked by our team, we have not noticed anything suspicious. <br />
Therefore, for our greatest pleasure to your new ad is visible on {X_SITENAME}. <br />
We accept our apology for the inconvenience.<br /><br />
Thank you for your comprehension, cordially, {X_SITENAME} <br />
{X_SITEURL} <br />
Our email address<br />
{X_ADMINMAIL}<br /><br />
");
//add 29 avril 2011 - message send by mail to the administrator / site when an ad is reporting suspect	   
define("_MD_CATADS_MAIL_ADNIM_ADSSUSPECT_TITLE","[{X_SITENAME}]: Warning an announcement was reported suspicious !");
define("_MD_CATADS_MAIL_ADNIM_ADSSUSPECT_TEXT","Hello {X_UNAME},<br />
The ad {X_ADS} on {X_SITENAME} has been reported by users as suspicious, it is advisable to check this ad as soon as possible.<br /><br />
Affected Ad: {X_ADS}.<br /><br />
Cordially, {X_SITENAME} <br />
{X_SITEURL} <br />
Our email address<br />
{X_ADMINMAIL}<br /><br />
");
//add 29 avril 2011 - message send by mail to the anonceur when he removes his ad	   
define("_MD_CATADS_MAIL_UID_ADSSUPP_TITLE","[{X_SITENAME}]: Confirm Delete your ad !");
define("_MD_CATADS_MAIL_UID_ADSSUPP_TEXT","Hello {X_UNAME},<br />
You just deleted your ad {X_ADS} our website {X_SITENAME}, we will confirm the total removal of this ad.<br />
We hope you have been satisfactory and it is with pleasure that we will broadcast your future announcements.<br /><br />
Cordially, {X_SITENAME} <br />
{X_SITEURL} <br />
Our email address<br />
{X_ADMINMAIL}<br /><br />
");
//send email reply to a ad
define("_MD_CATADS_HELLOFROMUSER","Hello,");
define("_MD_CATADS_FROMUSER","You have a message");
define("_MD_CATADS_YOURADS","Following your ad:");
define("_MD_CATADS_SUR","on");	
define("_MD_CATADS_MESSDE","Here is the message");
define("_MD_CATADS_FINMESS","end of message");
define("_MD_CATADS_CANJOINT","You can reach me by mail: ");
define("_MD_CATADS_ORAT","or by phone at: ");
define("_MD_CATADS_ORATPORTABLE","or at: ");	
define("_MD_CATADS_CONTACTAFTERADS","Contact in response to your ad");
define("_MD_CATADS_CONTACT_SITE","Cordially, {X_SITENAME} <br />{X_SITEURL} <br /><br />");

//has supp after verif
//define("_MD_CATADS_VISITECAT","Voir toutes les annonces");
//define("_MD_CATADS_ADSPHOTOANNONCE","Photos de l'annonce");
//define("_MD_CATADS_ADSPHOTOANNONCECLIC","cliquez sur les photos pour les agrandir");
//define("_MD_CATADS_AUTRESINFOS","autres informations sur cette annonce:");
//define("_MD_CATADS_CONTACTBLOC","Contact");
//define("_MD_CATADS_CONTACTBLOCSTITRE","Contactez l'annonceur");	
//define("_MD_CATADS_GESTIONADMIN","Gestion et informations sur cette annonce");
//define("_MD_CATADS_VIEWADMIN","cette annonce a &eacute;t&eacute; vue:");
//define("_MD_CATADS_EURO","&euro;");
//define("_MD_CATADS_ALLADSDESC","Toute les annonces de % % ");//% = code ne pas supprimer
//define("_MD_CATADS_ADSPLAN","A paraitre");
//define("_MD_CATADS_ADSPUB","Publiée");
//define("_MD_CATADS_ADSSUSP","Suspendu");	
//define("_MD_CATADS_TITLE_ASC","Titre par ordre croissant");
//define("_MD_CATADS_TITLE_DESC","Titre par ordre decroissant");
//define("_MD_CATADS_PRICE_ASC","Prix par ordre croissant");
//define("_MD_CATADS_PRICE_DESC","Prix par ordre decroissant");
//define("_MD_CATADS_OPTION_PRICE_ASC","Option de prix par ordre croissant");
//define("_MD_CATADS_OPTION_PRICE_DESC","Option de prix par ordre decroissant");
//define("_MD_CATADS_LOCAL_ASC","Ville par ordre croissant");
//define("_MD_CATADS_LOCAL_DESC","Ville par ordre decroissant");
//define("_MD_CATADS_DATE_ASC","Date par ordre croissant");
//define("_MD_CATADS_DATE_DESC","Date par ordre decroissant");
//define("_MD_CATADS_IMGDISP","Photo disponible");
//define("_MD_CATADS_FOR","pour");
//define("_MD_CATADS_GO_CAT","Aller à la rubrique");
//define("_MD_CATADS_CONTACTERMOI","Merci de me contacter");
//define("_MD_CATADS_CONTACT","Contact:");
//define("_MD_CATADS_LOCATION","Lieu ou se trouve l'objet: ");
//define("_MD_CATADS_DESC","Description:");	
//define("_MD_CATADS_SELCAT1","Pour ajouter une annonce ");
//define("_MD_CATADS_IN"," dans: ");
//define("_MD_CATADS_SELCAT2","ou sélectionner l'une de ces catégories");
//define("_MD_CATADS_MSG_UPLOAD","Voulez-vous ajouter une image à votre annonce ?");
//define("_MD_CATADS_IMG_FIELD","Vous devez selectionner un fichier");
//define("_MD_CATADS_IMG_NOPERM","Opération non autorisée");
//define("_MD_CATADS_IMG_TIME","Dépassement du temps autorisé");
//define("_MD_CATADS_ADS_NOEXIST","Cette annonce n'existe pas'");
//define("_MD_CATADS_NEW_SUBMIT","Nouvelle soumission d'annonce'");	
//define("_MD_CATADS_TITLE_S","Titre de l'annonce");
//define("_MD_CATADS_OTHER","- - - - - - - - - - -");
//define("_MD_CATADS_CONTACT_S","Vous contactez");
//define("_MD_CATADS_PRICE_DESC","Prix (ex: 45.52)");
//define("_MD_CATADS_CHOICE_MAIL_EXP","Être informer de l'expiration de l'annonce ?");
//define("_MD_CATADS_ZOOMBOX_CLOSEFMP","ou cliquer sur la croix pour fermer cette fenêtre");	
//define('_MD_CATADS_REGION_DEPARTEMENT','Localisation en france: ');
//define('_MD_CATADS_TWON_ZIPCODE','Localisation dans le departement: ');

?>