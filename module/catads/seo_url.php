<?php
if (!defined("XOOPS_ROOT_PATH") || !defined("XOOPS_URL") ) {
    exit();
}
//modif CPascalWeb - 24 février 2011 - correction seo
define('REAL_MODULE_NAME', 'catads');
define('SEO_MODULE_NAME', 'petites_annonces');
// define('SEO_MODULE_NAME', 'catads');

//modif CPascalWeb - 24 février 2011 - correction seo
ob_start('seo_urls');

function seo_urls($s)
{
    $XPS_URL = str_replace('/','\/', quotemeta(XOOPS_URL) );
    $s = catads_absolutize($s); // URLs et HTML.
    $module_name = REAL_MODULE_NAME;
    $search = array(
        // recherche URLs du module
        '/<(a|meta)([^>]*)(href|url)=([\'\"]{0,1})'.$XPS_URL.'\/modules\/'.$module_name.'\/(adslist.php)([^>\'\"]*)([\'\"]{1})([^>]*)>/i',
        '/<(a|meta)([^>]*)(href|url)=([\'\"]{0,1})'.$XPS_URL.'\/modules\/'.$module_name.'\/(adsitem.php)([^>\'\"]*)([\'\"]{1})([^>]*)>/i',
    );
    $s = preg_replace_callback($search, 'replace_links', $s);
    return $s;
}

function replace_links($matches)
{
    switch ($matches[5]) {
        case 'adslist.php':
            $add_to_url = '';
            $req_string = $matches[6];
				if (!empty($matches[6]))
                {
					//remplacement topic_id= n°id
                    if(preg_match('/topic_id=([0-9]+)/', $matches[6], $mvars))
                    {
//modif CPascalWeb - 24 février 2011 - correction seo					
                  //$add_to_url = 'categorie'.$mvars[1].'-'.catads_seo_cat($mvars[1]).'/';
                    $add_to_url = 'categorie'.$mvars[1].'/'.catads_seo_cat($mvars[1]).'.html';
					$req_string = preg_replace('/topic_id=([0-9]+)/','', $matches[6]);
                    }
                    else
                    {
                        return $matches['0'];
                    }
                }
        break;
		
        case 'adsitem.php':
            $add_to_url = '';
            $req_string = $matches[6];
                if (!empty($matches[6]))
                {
				//remplacement ads_id= n°ads_id
                    if(preg_match('/ads_id=([0-9]+)/', $matches[6], $mvars))
                    {
//modif CPascalWeb - 24 février 2011 - correction seo					
                    //$add_to_url = 'annonce'.$mvars[1].':'.catads_seo_titre($mvars[1]).'/';
					$add_to_url = 'annonce'.$mvars[1].'/'.catads_seo_titre($mvars[1]).'.html';
					$req_string = preg_replace('/ads_id=[0-9]+/','', $matches[6]);	
                    }
                    else
                    {
                        return $matches['0'];
                    }
                }
        break;

        default:
//modif CPascalWeb - 24 février 2011 - correction seo		
		$add_to_url = '';
        $req_string = $matches[6];
//fin	
        break;
        }
        if ($req_string == '?')
        {
            $req_string = '';
        }
        $ret = '<'.$matches[1].$matches[2].$matches[3].'='.$matches[4].XOOPS_URL.'/'.SEO_MODULE_NAME.'/'.$add_to_url.$req_string.$matches[7].$matches[8].'>';
        return $ret;
	}

function catads_seo_cat($topic_id)
{
        global $xoopsDB;
        //$db =& Database::getInstance();
        $db = $xoopsDB; //Database::getInstance();		
        $query = "
            SELECT
            topic_title
            FROM
            ". $db->prefix("catads_cat")."
            WHERE
            topic_id = ".$topic_id."";
        $result = $db->query($query);
        $res = $db->fetchArray($result);
        $ret = catads_seo_title($res['topic_title']);
        return $ret;
}

function catads_seo_titre($ads_id)
{
        global $xoopsDB;
        //$db =& Database::getInstance();
        $db = $xoopsDB; //Database::getInstance();		
        $query = "
            SELECT
            ads_title
            FROM
            ".$xoopsDB->prefix("catads_ads")."
            WHERE
            ads_id = ".$ads_id."";
        $result = $db->query($query);
        $res = $db->fetchArray($result);
        $ret = catads_seo_title($res['ads_title']);
        return $ret;
}

function catads_seo_title($title='', $withExt=false)
{
// assainir le titre avec le langage courant
     $myts = MyTextSanitizer::getInstance();
     if (method_exists($myts, 'formatForML')) {
        $title = $myts->formatForML($title);
     }

    // Transformation de la chaine en minuscule
    // Codage de la chaine afin d'éviter les erreurs 500 en cas de caractères imprévus
    $title   = rawurlencode(strtolower($title));

    // Transformation des ponctuations
    //                 Tab     Space      !        "        #        %        &        '        (        )        ,        /        :        ;        <        =        >        ?        @        [        \        ]        ^        {        |        }        ~       .
    $pattern = array("/%09/", "/%20/", "/%21/", "/%22/", "/%23/", "/%25/", "/%26/", "/%27/", "/%28/", "/%29/", "/%2C/", "/%2F/", "/%3A/", "/%3B/", "/%3C/", "/%3D/", "/%3E/", "/%3F/", "/%40/", "/%5B/", "/%5C/", "/%5D/", "/%5E/", "/%7B/", "/%7C/", "/%7D/", "/%7E/", "/\./", "/%2A/");
    $rep_pat = array(  "-"  ,   "-"  ,   ""   ,   ""   ,   ""   , "-100" ,   ""   ,   "-"  ,   ""   ,   ""   ,   ""   ,   "-"  ,   ""   ,   ""   ,   ""   ,   "-"  ,   ""   ,   ""   , "-at-" ,   ""   ,   "-"   ,  ""   ,   "-"  ,   ""   ,   "-"  ,   ""   ,   "-"  ,  ""  ,  ""  );
    $title   = preg_replace($pattern, $rep_pat, $title);

    // Transformation des caractères accentués
    //                  è        é        ê        ë        ç        à        â        ä        î        ï        ù        ü        û        ô        ö                 è           é           à           ê           â          "             "            ç
    $pattern = array("/%B0/", "/%E8/", "/%E9/", "/%EA/", "/%EB/", "/%E7/", "/%E0/", "/%E2/", "/%E4/", "/%EE/", "/%EF/", "/%F9/", "/%FC/", "/%FB/", "/%F4/", "/%F6/", "/%E3%A8/", "/%E3%A9/", "/%E3%A0/", "/%E3%AA/", "/%E3%A2/", "/a%80%9C/", "/a%80%9D/", "/%E3%A7/");
    $rep_pat = array(  "-", "e"  ,   "e"  ,   "e"  ,   "e"  ,   "c"  ,   "a"  ,   "a"  ,   "a"  ,   "i"  ,   "i"  ,   "u"  ,   "u"  ,   "u"  ,   "o"  ,   "o",   "e",   "e",   "a",   "e",   "a",   "-",   "-",   "c" );
    $title = preg_replace($pattern, $rep_pat, $title);

    if (sizeof($title) > 0)
    {
        if ($withExt) {
            $title = '.html';
        }
        return $title;
    }
    else
        return '';
}

function catads_absolutize($s){
        if(preg_match('/\/$/',$_SERVER['REQUEST_URI'])){
            $req_dir=preg_replace('/\/$/','',$_SERVER['REQUEST_URI']);
            $req_php="";
        }else{
            $req_dir=dirname($_SERVER['REQUEST_URI']);
            $req_php=preg_replace('/.*(\/[a-zA-Z0-9_\-]+)\.php.*/','\\1.php',$_SERVER['REQUEST_URI']);
        }
        $req_dir = ($req_dir == "\\" || $req_dir == "/" ) ? "" : $req_dir ;
        $dir_arr=explode('/', $req_dir);
        $m = count($dir_arr)-1;
        $d1 = @str_replace('/'.$dir_arr[$m],   '', $req_dir);
        $d2 = @str_replace('/'.$dir_arr[$m-1], '', $d1);
        $d3 = @str_replace('/'.$dir_arr[$m-2], '', $d2);
        $d4 = @str_replace('/'.$dir_arr[$m-3], '', $d3);
        $d5 = @str_replace('/'.$dir_arr[$m-4], '', $d4);
        $host = 'http://'.$_SERVER['HTTP_HOST'];
		//ajou CPascalWeb - 9 mai 2011 - essai redirect_header et xoops_confirm  !!!
        $in = array(
                 '/<([^>\?\&]*)(href|src|action|background|redirect_header|xoops_confirm|window\.location)=([^\"\' >]+)([^>]*)>/i'
                ,'/<([^>\?\&]*)(href|src|action|background|redirect_header|xoops_confirm|window\.location)=([\"\']{1})\.\.\/\.\.\/\.\.\/([^\"\']*)([\"\']{1})([^>]*)>/i'
                ,'/<([^>\?\&]*)(href|src|action|background|redirect_header|xoops_confirm|window\.location)=([\"\']{1})\.\.\/\.\.\/([^\"\']*)([\"\']{1})([^>]*)>/i'
                ,'/<([^>\?\&]*)(href|src|action|background|redirect_header|xoops_confirm|window\.location)=([\"\']{1})\.\.\/([^\"\']*)([\"\']{1})([^>]*)>/i'
                ,'/<([^>\?\&]*)(href|src|action|background|redirect_header|xoops_confirm|window\.location)=([\"\']{1})\/([^\"\']*)([\"\']{1})([^>]*)>/i'
                ,'/<([^>\?\&]*)(href|src|action|background|redirect_header|xoops_confirm|window\.location)=([\"\']{1})\?([^\"\']*)([\"\']{1})([^>]*)>/i'
                //c'est la dir
                ,'/<([^>\?\&]*)(href|src|action|background|redirect_header|xoops_confirm|window\.location)=([\"\']{1})([^#]{1}[^\/\"\'>]*)([\"\']{1})([^>]*)>/i'
                ,'/<([^>\?\&]*)(href|src|action|background|redirect_header|xoops_confirm|window\.location)=([\"\']{1})(?:\.\/)?([^\"\'\/:]*\/*)?([^\"\'\/:]*\/*)?([^\"\'\/:]*\/*)?([a-zA-Z0-9_\-]+)\.([^\"\'>]*)([\"\']{1})([^>]*)>/i'
                ,'/[^"\'a-zA-Z_0-9](window\.open|url)\(([\"\']{0,1})(?:\.\/)?([^\"\'\/]*)\.([^\"\'\/]+)([\"\']*)([^\)]*)/i'
                ,'/<meta([^>]*)url=([a-zA-Z0-9_\-]+)\.([^\"\'>]*)([\"\']{1})([^>]*)>/i'
        );
        $out = array(
                 '<\\1\\2="\\3"\\4>'
                ,'<\\1\\2=\\3'.$host.$d3.'/\\4\\5\\6>'
                ,'<\\1\\2=\\3'.$host.$d2.'/\\4\\5\\6>'
                ,'<\\1\\2=\\3'.$host.$d1.'/\\4\\5\\6>'
                ,'<\\1\\2=\\3'.$host.'/\\4\\5\\6>'
                ,'<\\1\\2=\\3'.$host.$_SERVER['PHP_SELF'].'?\\4\\5\\6>'
                //c'est la dir
                ,'<\\1\\2=\\3'.$host.$req_dir.'/\\4\\5\\6\\7>'
                ,'<\\1\\2=\\3'.$host.$req_dir.'/\\4\\5\\6\\7.\\8\\9\\10>'
                ,'$1($2'.$host.$req_dir.'/$3.$4$5$6'
                ,'<meta$1url='.$host.$req_dir.'/$2.$3$4$5>'
        );
        $s = preg_replace($in, $out, $s);

        return $s;
}

?>