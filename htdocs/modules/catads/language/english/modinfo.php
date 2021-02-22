<?php

//name and description of the module
define("_MI_CATADS_NAME","small ads");
define("_MI_CATADS_DESC","Management module of free and paid small ads<br />version: 1.6 RC1");

//mainmenu submenu navigation
define("_MI_CATADS_SMENU1","My ads");
define("_MI_CATADS_SMENU2","Submit");
define("_MI_CATADS_SMENU3","Advanced Search");

//Menu 
define("_MI_CATADS_ADMENU1", "Home");
define("_MI_CATADS_ADMENU2", "Ads Management");
define("_MI_CATADS_ADMENU3", "Category Management");
define("_MI_CATADS_ADMENU4", "Additional fields");
define("_MI_CATADS_ADMENU5", "Purge ads");
define("_MI_CATADS_ADMENU6", "Permissions");

//block names
define("_MI_CATADS_BNAME1","Latest Ads");
define("_MI_CATADS_BNAME2","Deposit one ads");
define("_MI_CATADS_BNAME3","My ads");
define("_MI_CATADS_BNAME5","Advanced Search");

//configuration
define("_MI_CATADS_MODERATE","Check the ads before publication ?");
define("_MI_CATADS_CANDELETE","Allow the advertiser to remove their ads ?");
define("_MI_CATADS_CANEDIT","Allow the advertiser to modify their ads ?");
define("_MI_CATADS_ALLOW_CUSTOM_TAGS","Allow advertisers to put themselves their keywords (tags) ?");
define("_MI_CATADS_ALLOW_CUSTOM_TAGS_DESC","allowed advertisers to put themselves their keywords (tags) or they will create automatically from the title");
define("_MI_CATADS_SHOW_VIDEO_FIELD","Allow advertisers to put a video link in their ads ?");
define("_MI_CATADS_ALLOW_PUBLISH_DATE","Allow the advertiser to scheduled publication date ?");
define("_MI_CATADS_NBDAYS_BEFORE","How many days maximum may have scheduled a release date ?");
define("_MI_CATADS_NBDAYS_BEFORE_DESC","Maximum delay before publication of the advertisement");
//add option CPascalWeb - 4 mai 2011
define("_MI_CATADS_MODIFEMAIL","Allow the advertiser to change his email address ?");
//fin
define("_MI_CATADS_NBDAY_NEW","How many days is it considered an ad like new ?");
define("_MI_CATADS_NBDAY_NEW_DESC","how to update a new announcement is seen as an indication 'new !' remain near this period");
define("_MI_CATADS_NBPUB_AGAIN","How many times the advertiser is permitted to renew his ads ?");
define("_MI_CATADS_NBDAYSEXPIRED","Number of days before sending a message indicating the expiration of the ads ?");
define("_MI_CATADS_MAXSIZEIMG","Maximum size photos of ads allowed to be downloaded:");
define("_MI_CATADS_MAXSIZEIMG_DESC","0 to prohibit download");
define("_MI_CATADS_MAXHEIGHTIMG","Maximum height allowed pictures of ads to be downloaded:");
define("_MI_CATADS_MAXWIDTHIMG","Maximum width of pictures of ads allowed to be downloaded:");
//add CPascalWeb - 24 novembre 2010 - Optional display an ad site or a script on the pages of ads
define("_MI_CATADS_PUB_ANNONCE_SEPAR","Management of the advertising module");
define("_MI_CATADS_PUB_ANNONCE","Display a banner ad on the pages of ads ?");
//add CPascalWeb - 24 novembre 2010 - Optional display an ad site or a script
define("_MI_CATADS_PUB_ANNONCE_BLOC","Display a pub in the block Photos & Video of the ad ?");
//add option CPascalWeb - 24 novembre 2010 - display one banner ad on the main page of the module
define("_MI_CATADS_PUB_GENERAL","Display a pub on the main page of the module ?");
define("_MI_CATADS_PUB_GENERAL_DESC","display or not one banner ad on pages categories, subcategories, my Ads, advanced search, submit etc... choose if yes to display a banner pub on the site or an advertising insert in the field below");
//define des pubs commun
define("_MI_CATADS_PUB_ANNONCE_SITE","Use one banner pub site ?");
define("_MI_CATADS_PUB_ANNONCE_SITE_DESC","if yes one banner pub the site will display<br />if not the code will display the next field");
define("_MI_CATADS_PUB_ANNONCE_DESC","choose if yes to display a banner pub on the site or an advertising insert in the field below");
define("_MI_CATADS_PUB_ANNONCE_SCRIPT","Or the advertising code of this field");
//add cpascalweb - le 12 octobre 2010 Display a pub in the information block ads ?
define("_MI_CATADS_PUB_BLOCINFO","Display a pub in the information block ads ?");
define("_MI_CATADS_PUB_BLOCINFO_DESC","display or not a pub in the information block ads if yes complete the following field");
define("_MI_CATADS_PUB_BLOCINFO_SCRIPT","script to insert information in the block ads:");
define("_MI_CATADS_PUB_BLOCINFO_SCRIPT_DESC","the script or insert advertising links in the desired information block ads advisor maximum width is 336");
//fin pub bloc info
define("_MI_CATADS_MAXLENTXT","Maximum number of characters in the ads text ?");
define("_MI_CATADS_TITLE_LENGTH","Maximum number of characters in the title ?");
define("_MI_CATADS_DESC_LENGTH","Maximum number of characters in the message description ?");
define("_MI_CATADS_ADMIN_SEPAR","Preferences administration");
define("_MI_CATADS_RENEW_NBDAYS","Number of days when the administrator shall renew an ads:");
define("_MI_CATADS_RENEW_NBDAYS_DESC","Number of days when the administrator renew an ad from the administration module");
define("_MI_CATADS_NBPERPAGE_ADMIN","How many ads to display per page in the administration ?");
//add cpascalweb - le 23 mai 2011 - choice of text processing
define("_MI_CATADS_FORMADMIN_OPTIONS","Text processing used in the administration:");
//fin
define("_MI_CATADS_FORMUL_SEPAR","Submission form announcement");
define("_MI_CATADS_EMAIL_REQUIRED","The email field is:");
define("_MI_CATADS_REGION_REQUIRED","The field country is:");
define("_MI_CATADS_DEPARTEMENT_REQUIRED","The department field is:");
define("_MI_CATADS_ZIPCODE_REQUIRED","The zip code field is:");
define("_MI_CATADS_REQUIRED","obligatory");
define("_MI_CATADS_OPTIONAL","Optional");
define("_MI_CATADS_NOASK","not required");
//add cpascalweb - le 23 avril 2011 - Obligatory fixed telephone ?
define("_MI_CATADS_TELFIXE_REQUIRED","The home Phone field is fixed:");
define("_MI_CATADS_TELPORTABLE_REQUIRED","The mobile phone field is:");
define("_MI_CATADS_VILLE_REQUIRED","The city field is:");
//fin
define("_MI_CATADS_OPTIONAFF_SEPAR","Display Settings");
define("_MI_CATADS_NBPERPAGE","How many ads does it displayed per page on the site ?");
define("_MI_CATADS_DISPLAYNEW","How many new listings have it displayed ?");
define("_MI_CATADS_DISPLAYNEW_DESC","Number of new ads to display up on the site");
define("_MI_CATADS_TPLTYPE","Presentation of the categories on the home page:");
define("_MI_CATADS_COL","Columns");
define("_MI_CATADS_LIN","Lines");
define("_MI_CATADS_NBCOL","Dispose the sub categories on the home page:");
//add CPascalWeb - 30 octobre 2010 - Number of new ads to display
define("_MI_CATADS_NBAFF_LASTADS","How many ads should I last displayed ?");
define("_MI_CATADS_NBAFF_LASTADS_DESC","How does it latest ads displayed in the block 'latest small ads'");
//fin
//add option CPascalWeb - 24 mai 2011 - display or not block new ads
define("_MI_CATADS_BLOCAFF_LASTADS","Display the latest block small ads ?");
//fin
define("_MI_CATADS_CARTE_SEPAR","Card parameters");
define("_MI_CATADS_SHOW_CARD","Display map France map to homepage ?");
define("_MI_CATADS_SHOW_CARD_DESC","Important ! To show this card, fill the fields in the file setting.php");
define("_MI_CATADS_OPTIONINDIC_SEPAR","Choice of indications to display");
//add cpascalweb - le 10 octobre 2010 - display ads or not suspended by the announcer in the information block ads
define("_MI_CATADS_AFF_ADSSUSPPROPRIO","Display the number of ads suspended by the announcer ?");
define("_MI_CATADS_AFF_ADSSUSPPROPRIO_DESC","display ads or not suspended by the owner in the information block ads next to the map of France to homepage<br /><br /><small>infos:<br />only for visitors ".$GLOBALS['xoopsConfig']['sitename']." online mode will have access to this information for easy management</small>");
//add cpascalweb - le 10 octobre 2010 - display ads or not suspended by the site the information block ads
define("_MI_CATADS_AFF_ADSSUSPSITE","Display the number of ads suspended by ".$GLOBALS['xoopsConfig']['sitename']." ?");
define("_MI_CATADS_AFF_ADSSUSPSITE_DESC","display ads or not suspended by ".$GLOBALS['xoopsConfig']['sitename']." information in the block ads to homepage<br /><br /><small>infos:<br />only for visitors, ".$GLOBALS['xoopsConfig']['sitename']." online mode will have access to this information for easy management</small>");
define("_MI_CATADS_SHOW_AD_TYPE","Display the of the ad type ?");
define("_MI_CATADS_SHOW_AD_TYPE_DESC","display or not the type of ad example: search, rented, for sale...)");
//add cpascalweb - le 14 mai 2011 - Choosing whether to display the number of times the ad has been seen
define("_MI_CATADS_AFFI_ADS_VUE","Display the number of times the ad has been seen ?");
define("_MI_CATADS_DISP_PSEUDO","Display the Nickname ?");
//fin
//add cpascalweb - le 23 mai 2011 - Choosing whether to display the current block
define("_MI_CATADS_AFFI_BLOC_ACTU","Display the information block ads ?");
//add cpascalweb - le 23 mai 2011 - Choosing whether to display the total visible ads
define("_MI_CATADS_AFFI_ADS_VISIBLE","Display the all ads visible ?");
//fin
//add cpascalweb - le 10 mai 2011 - choice of text processing
define("_MI_CATADS_FORM_OPTIONS","Text processing used by the announcer:");
define("_MI_CATADS_FORM_OPTIONS_DESC","choose the default text processing to use for writing ads");
//fin
define("_MI_CATADS_SHOW_CAT_AFFDESC","Display the description of subcategories ?");
define("_MI_CATADS_SHOW_CAT_AFFDESC_DESC","Display or not the description of the subcategories on the page of sub categories ?");
define("_MI_CATADS_SHOW_SEO","Enable SEO ?");
define("_MI_CATADS_SHOW_SEO_DESC","Warning ! do not forget to put the htaccess file in the root module xoops or copy/paste its contents into yours if you already have one");
//define("_MI_CATADS_NBCOLS_IMG","Ads: number of images per line");
define("_MI_THUMB_WIDTH","Width of the thumbnails on the site");
define("_MI_THUMB_METHOD","Method to resize images");
define("_MI_CLICK_IMAGE_WIDTH","Width of the main photo in Page of the ads:");
//add cpascalweb - le 12 mai 2011 - Security antispam captcha
define("_MI_CATADS_ACTIVE_CAPTCHA","Enable security antispam captcha ?");
define("_MI_CATADS_ACTIVE_CAPTCHA_DESC","enable or disable the security code anti-spam captcha when submitting an ad");
//fin
//add cpascalweb Optional choice of the width of images in categories and subcategories
define("_MI_CATADS_IMAGE_SEPAR","Of imaging parameters categories & Photos Ads");
define("_MI_CAT_IMAGE_WIDTH","Width of category images:");
define("_MI_SCAT_IMAGE_WIDTH","Width images of sub-categories:");
//add cpascalweb - javascript popup option choice or not contact Zoombox
define("_MI_CONTAC_ZOOMBOX","Use Zoombox on page of the ad in the contact ?");
define("_MI_CONTAC_ZOOMBOX_DESC","use or not use the javascript Zoombox on page of the ad in the contact");
//add cpascalweb - 7 novembre 2010 - option choice whether to display ads flagged as suspicious
define("_MI_ACTIV_SUSPECT","Allow to the ads flagged as suspicious visible ?");
define("_MI_ACTIV_SUSPECT_DESC","leave or not the ads flagged as suspicious visible on the site the time of the audit");
//fin 
define("_MI_CATADS_MIC_PAIE_SEPAR","Option Micropayment");
//add cpascalweb micropaiement1 rentabiliweb option for viewing the details of a announcement le 18 août 2009
define("_MI_CATADS_MIC_PAIE", "Enable an option Micropayment 1 ?<br />&nbsp;&nbsp;&nbsp;&nbsp;<b><small><a href='http://www.rentabiliweb.com/en/?trackADV=351138' target=_blank />Register here</a> | <a href='#' onclick='javascript:openWithSelfMain(\"".XOOPS_URL."/modules/catads/docs/aidemicropaiement1.png\",\"rentabiliweb\",760,485);'>help parameters</a><small></b>");       
define("_MI_CATADS_MIC_PAIE_DESC", "Micropayment System to see the coordinates of ads");
//identification of the site protected rentabiliweb = doc_id
define("_MI_CATADS_RENTAB_IDSITE", "Identification code pages Micropayment");  
define("_MI_CATADS_RENTAB_IDSITE_DESC", "identification of pages provided by rentabiliweb for protected pages = doc_id click installation form and meet <b>only</b> numbers in your doc_id <a href='#' onclick='javascript:openWithSelfMain(\"".XOOPS_URL."/modules/catads/docs/doc_id.png\",\"rentabiliweb\",760,220);'>example</a>");
//id page protected by rentabiliweb = site_id 
define("_MI_CATADS_RENTAB_IDPROTECT", "Micropayment site identification code");  
define("_MI_CATADS_RENTAB_IDPROTECT_DESC", "id of the site provided by rentabiliweb credited to your account = site_id click installation form and meet <b>only</b> numbers in your site_id <a href='#' onclick='javascript:openWithSelfMain(\"".XOOPS_URL."/modules/catads/docs/site_id.png\",\"rentabiliweb\",760,220);'>example</a>");
// Micropayment rentabiliweb intro text in pop up
define("_MI_CATADS_RENTAB_INTROTEXT", "intro text popup Micropayment");       
define("_MI_CATADS_RENTAB_INTROTEXT_DESC", "your introductory text or condition in the pop up micropayment");
define("_MI_CATADS_RENTAB_INTROTEXT_DEFAULT", "To access this section please use the form below micropayment");
// Micropayment rentabiliweb text information in pop up
define("_MI_CATADS_RENTAB_INFOTEXT", "text info popup Micropayment");       
define("_MI_CATADS_RENTAB_INFOTEXT_DESC", "information your text in the pop up micropayment");
define("_MI_CATADS_RENTAB_INFOTEXT_DEFAULT", "To access this premium service and get your code, please click on the flag of your country and then choose your payment method:");
//fin
//about.php
define("_MI_CATADS_AUTEURS", "Authors & developers"); 
define("_MI_CATADS_MESS_AUTEUR", "Note of CPascalWeb:"); 
define("_MI_CATADS_MESS_AUTEUR_TXT", "Modifications to made ??to the version RC2
<br />- A minor but annoying bug fixed: in function catads_expired_ads .../include/functions.php sending emails several times (each time you connect or update the home page)
<br />- A minor bug corrected: Class 'XoopsTree' is deprecated, check 'XoopsObjectTree' in tree.php
<br />- Review and update the notification system
<br />- Changed the card system added the option of displaying a map according to his country 
<br />- Review the categories & sub categories pre-installed translation (setup SQL) by country
<br />- Review the system RSS
<br />- Review the system tags
<br />- Review the module css (it is based on one of my themes)
<br />- Review the seo module (not clean url) & add a few sample pages: adsuserlist.php, submit.php etc... 
<br />- Modified sytem format pictures & photos(to resize images)
<br />- Review my micropayment system especially the presentation button not terrible & update it dates from 2009
<br />- Add the possibility of activating the micropayment system in: 'modify your ad' and 'Submit News'
<br />- Add the possibility of activating the micropayment system of their choice: allopass and other
<br />- Improve the SEO says 'natural'
<br />- highslide.js remove or replace zombox better
<br />- Review how 'preview' in Submission
<br />- Add automatic deletion of pictures when deleting Ad
<br />- Add a selection box in the admin category for best ad management
<br />- Cleaning and optimizing php code & defines
<br />- And various small things changed/corrected and added
<br /><br />
<p align='center' style='font-size: 1em;font-weight: bold;font-style: italic;'>All contributions, assistance and councils are welcome</p>"); 

define("_MI_CATADS_CREDIT", "- CPascalWeb for version of catads 1.6 <br /> - Peekay for version of catads 1.53.5 <br /> - Kraven30 for version of catads 1.52"); 
define("_MI_CATADS_HISTORY", "<p style='font-size: 1.1em;font-weight: bold;font-style: italic;'>Version 1.6 RC1 du 25/05/2011 by CPascal/CPascalWeb</p><br />
<p style='font-size: 1em;font-weight: bold;font-style: italic;'>Modifications made</p>
<br />- Home Administration statistics add ad categories and added attention icon
<br />- Page ad management add status icons + links + modif presentation
<br />- Put in utf8 format
<br />- Modify all the sections of the admin
<br />- Modify all pages side site
<br />- Modify email and pm buttons
<br />- Modify photos javascript ads
<br />- Modify video adding javascript + link photo
<br />- Fixed bug selection box at the renewal of the announcement by the advertiser 
<br />- Updating PHP 5 +
<br />- System changes included calendar calendar xoops and bug fix scheduled listings
<br />- Correction of system security code does not work capcha
<br />- Correction system to make the fields email, phone, city, county, region etc.. obligatory or not that does not work in the tender forms and vary + Added option falcultative
<br />- Revision and cleaning of 95% of defines
<br />- Modify page historical presentation of the module (about.php)

<br /><br />
<p style='font-size: 1em;font-weight: bold;font-style: italic;'>Added made</p>
<br />- Adding the ability to suspend or resume an ad by the administrator from the site or from the admin (in cases of suspected ad ad suspended nom_du_site)
<br />- Adding micro payment option to access contact advertisers
<br />- Added a link for inclusion in anonymous mode
<br />- Added optional display of ads in the status information block ads
<br />- Added optional display advertising on the main page of the module using a code or banner ads Site
<br />- Added optional display advertising on the pages of ads using a code or banner ads Site
<br />- Added optional display advertising in the information block ads using a code or banner ads Site
<br />- Added optional display advertising in the block Pictures & video of the ad using a code or banner ads Site
<br />- Adding images of subcategories on the page of subcategories
<br />- Adding to the category page selection box change category + information in connected mode or mode annonyme
<br />- Adding to the category page selection box sort properties according to the type
<br />- Adding to the list of sub categories images and descriptions of each sub-category
<br />- Add choice of the width of the image category and sub-categories
<br />- Adding javascript photo ads
<br />- Added option choice in popup window with contact by mail and posting pictures
<br />- Added option to choose popup contact mp
<br />- Added option to send this ad to a friend (with optional popup window)
<br />- Added option to alert us on this ad (with optional popup window)
<br />- Add mobile phone
<br />- Added 12 basic categories with 96 images containing sub categories  
<br />- Added councils on writing your ad (inspired by AdsLight de Iluc) in the pages submission an ad with javascript
<br />- Add captures thumbnails of youtube videos and dailymotion
<br />- Added option to activate or not the security code capcha
<br />- Adding automatic confirmation email sent when the announcer's announcement removes
<br />- Adding automatic confirmation email sent when the announcer pauses or resumes its announcement
<br />- Adding automatic confirmation email sent to the advertiser when the site administrator suspends or reactivates its announcement
<br />- Adding automatic sending mail to the advertiser when the announcement was noted as suspicious and when his ad is no longer considered suspicious
<br />- Adding automatic sending mail the site administrator when an ad has been reported as suspicious
<br />- Adding automatic sending mail to the advertiser when an ad is approved after amendment	
<br />- Added option to choose the editor side of the module site preferences
<br />- Added option choice whether to allow advertisers to change their email addresses
<br />- Added option to choose to display the number of times the ad has been seen
<br />- Added option to choose the editor side site administration module's preferences
<br />- Added option to choose display or not the information block ads
<br />- Added option to choose display or not the total number of ad in the block information
<br />- Added option to choose display or not the block since the latest ads preference module


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
define("_MI_CATADS_NOTIFY_SEPAR","Managing notifications and comments");
define("_MI_CATADS_GLOBAL_NOTIFY", "Global");
define("_MI_CATADS_GLOBAL_NOTIFYDSC", "Notification options global announcements");
define("_MI_CATADS_CATEGORY_NOTIFY", "Category");
define("_MI_CATADS_CATEGORY_NOTIFYDSC", "Notification options apply to the category");
define("_MI_CATADS_ADS_NOTIFY", "Classifieds");
define("_MI_CATADS_ADS_NOTIFYDSC", "Notification options apply to the current announcement");
//Evénement 1
define("_MI_CATADS_GLOBAL_ADSSUBMIT_NOTIFY", "Proposed advertisement");
define("_MI_CATADS_GLOBAL_ADSSUBMIT_NOTIFYCAP", "Notification of the proposed new announcement (pending)");
define("_MI_CATADS_GLOBAL_ADSSUBMIT_NOTIFYDSC", "Receive notification when one new announcement is proposed");
define("_MI_CATADS_GLOBAL_ADSSUBMIT_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} automatic notification: New announcement");
//Evénement 2
define("_MI_CATADS_GLOBAL_NEWADS_NOTIFY", "New announcement");       
define("_MI_CATADS_GLOBAL_NEWADS_NOTIFYCAP", "Notification of the availability of a new ad");                           
define("_MI_CATADS_GLOBAL_NEWADS_NOTIFYDSC", "Receive notification when one new announcement is posted");                
define("_MI_CATADS_GLOBAL_NEWADS_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} automatic notification: New announcement");
//Evénement 2
define("_MI_CATADS_GLOBAL_EDIT_NOTIFY", "Edit announcement");       
define("_MI_CATADS_GLOBAL_EDIT_NOTIFYCAP", "Notification of the publication of an advertisement");                           
define("_MI_CATADS_GLOBAL_EDIT_NOTIFYDSC", "Receive notification when an announcement is edited with moderation.");                
define("_MI_CATADS_GLOBAL_EDIT_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} automatic notification: Edit announcement"); 
//Evénement 3
define("_MI_CATADS_CATEGORY_SUBMIT_NOTIFY", "Proposed new announcement");    
define("_MI_CATADS_CATEGORY_SUBMIT_NOTIFYCAP", "Notification of the proposal for a new ad that is awaiting publication");
define("_MI_CATADS_CATEGORY_SUBMIT_NOTIFYDSC", "Receive notification when one new announcement is given");
define("_MI_CATADS_CATEGORY_SUBMIT_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} automatic notification: Proposal for one new announcement");
//Evénement 4
define("_MI_CATADS_CATEGORY_NEWADS_NOTIFY", "Proposed new announcement");       
define("_MI_CATADS_CATEGORY_NEWADS_NOTIFYCAP", "Notification of one new ad in this category");
define("_MI_CATADS_CATEGORY_NEWADS_NOTIFYDSC", "Receive notification when one new announcement appears in this section");
define("_MI_CATADS_CATEGORY_NEWADS_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} Automatic Notification: Publication of a new ads");
//Evénement 5
define("_MI_CATADS_ADS_APPROVE_NOTIFY", "Ads was posted");
define("_MI_CATADS_ADS_APPROVE_NOTIFYCAP", "Notification of the publication of my announcement");
define("_MI_CATADS_ADS_APPROVE_NOTIFYDSC", "Receive one notification when my announcement will be published");
define("_MI_CATADS_ADS_APPROVE_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} automatic notification: Announcement published");
//Evénement 6
define("_MI_CATADS_ADS_EDIT_NOTIFY", "Ads was posted");
define("_MI_CATADS_ADS_EDIT_NOTIFYCAP", "Amended notification when my announcement");
define("_MI_CATADS_ADS_EDIT_NOTIFYDSC", "To be notified when my announcement is published");
define("_MI_CATADS_ADS_EDIT_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} automatic notification: Announcement published");

// JJdai
define('_MI_CATADS_ABOUT',"About");
define('_MI_CATADS_SHOW_TPL_NAME', 'dispplay template name');
define('_MI_CATADS_SHOW_TPL_NAME_DESC', 'Option to use during developpement, deactivate in production');


?>