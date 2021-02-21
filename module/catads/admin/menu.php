<?php

$moduleDirName      = basename(dirname(__DIR__));
//echo "===>dirname = {$moduleDirName}<br>";
$module_handler  = xoops_gethandler('module');
$module          = $module_handler->getByDirname($moduleDirName);
$moduleId      = $module->mid();

//$pathIcon32 = XOOPS_URL . '/modules/catads/' . 'images/icon/32/';
$pathIcon32 = 'images/icon/32/';


$i=0;
$adminmenu = array();

$adminmenu[] = ['title' => _MI_CATADS_ADMENU1, 
                'link'  => 'admin/index.php',
                'icon'  => $pathIcon32 . 'accueil.png',
                'menu'  => 'index',
                'desc'  => '' ];

$adminmenu[] = ['title' => _MI_CATADS_ADMENU3, 
                'link'  => 'admin/category.php',
                'icon'  => $pathIcon32 . 'categories.png',
                'menu'  => 'category',
                'desc'  => '' ];
                      
$adminmenu[] = ['title' => _MI_CATADS_ADMENU2, 
                'link' => 'admin/ads.php',
                'icon' => $pathIcon32 . 'annonces.png',
                'menu' => 'ads',
                'desc' => '' ];

$adminmenu[] = ['title' => _MI_CATADS_ADMENU4, 
                'link'  => 'admin/options.php',
                'icon'  => $pathIcon32 . 'options.png',
                'menu'  => 'options',
                'desc'  => '' ];

$adminmenu[] = ['title' => _MI_CATADS_ADMENU5, 
                'link'  => 'admin/purge.php',
                'icon'  => $pathIcon32 . 'purge.png',
                'menu'  => 'purge',
                'desc'  => '' ];
                      
$adminmenu[] = ['title' => _MI_CATADS_ADMENU6, 
                'link'  => 'admin/permissions.php',
                'icon'  => $pathIcon32 . 'permissions.png',
                'menu'  => 'permissions',
                'desc'  => '' ];
/*
$adminmenu[] = ['title' => _MI_CATADS_IMPORT_IMG, 
                'link'  => 'admin/import.php',
                'icon'  => $pathIcon32 . 'import.png',
                'menu'  => 'import',
                'desc'  => '' ];
*/                      

$adminmenu[] = ['title' => _MI_CATADS_ABOUT,
                'link'  => 'admin/about.php',
                'icon'  => $pathIcon32 . 'about.png',
                'menu'  => 'about',
                'desc'  => ''];


//echo "==>menu : <pre>" . print_r($adminmenu, true) . "</pre>";
                      

?>