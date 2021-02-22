<?php

function catads_create_files_uploads()
{
    global $xoopsDB, $xoopsUser, $xoopsConfig, $xoopsModule, $xoopsModuleConfig;
    //Création du dossier catads dans uploads
    $dir = XOOPS_ROOT_PATH."/uploads/catads";
	if(!is_dir($dir))
		mkdir($dir, 0777);
		chmod($dir, 0777);

    //Création des sous-dossiers de catads
        $dir = XOOPS_ROOT_PATH."/uploads/catads/images";
	if(!is_dir($dir))
		mkdir($dir, 0777);
		chmod($dir, 0777);
        $dir = XOOPS_ROOT_PATH."/uploads/catads/images/annonces";
	if(!is_dir($dir))
		mkdir($dir, 0777);
		chmod($dir, 0777);
        $dir = XOOPS_ROOT_PATH."/uploads/catads/images/annonces/thumb";
	if(!is_dir($dir))
		mkdir($dir, 0777);
		chmod($dir, 0777);
        $dir = XOOPS_ROOT_PATH."/uploads/catads/images/annonces/original";
	if(!is_dir($dir))
		mkdir($dir, 0777);
		chmod($dir, 0777);
        $dir = XOOPS_ROOT_PATH."/uploads/catads/images/categories";
	if(!is_dir($dir))
		mkdir($dir, 0777);
		chmod($dir, 0777);


    //Copie des fichiers index.html dans le dossier uploads
        $indexFile = XOOPS_ROOT_PATH."/modules/catads/include/index.html";
        copy($indexFile, XOOPS_ROOT_PATH."/uploads/catads/index.html");
        copy($indexFile, XOOPS_ROOT_PATH."/uploads/catads/images/index.html");
        copy($indexFile, XOOPS_ROOT_PATH."/uploads/catads/images/annonces/index.html");
        copy($indexFile, XOOPS_ROOT_PATH."/uploads/catads/images/annonces/thumb/index.html");
        copy($indexFile, XOOPS_ROOT_PATH."/uploads/catads/images/annonces/original/index.html");
        copy($indexFile, XOOPS_ROOT_PATH."/uploads/catads/images/categories/index.html");
	
		
	//Copie des images dans le dossier uploads
		//Copie des images pour les catégories		
        $imgFile = XOOPS_ROOT_PATH."/modules/catads/images/uploads/catads/images/categories/blank.gif";
        copy($imgFile, XOOPS_ROOT_PATH."/uploads/catads/images/categories/blank.gif");
//ajout CPascalWeb - images type pour les catégories			
        $imgFile = XOOPS_ROOT_PATH."/modules/catads/images/uploads/catads/images/categories/vehicules.png";
        copy($imgFile, XOOPS_ROOT_PATH."/uploads/catads/images/categories/vehicules.png");		
        $imgFile = XOOPS_ROOT_PATH."/modules/catads/images/uploads/catads/images/categories/jeux.png";
        copy($imgFile, XOOPS_ROOT_PATH."/uploads/catads/images/categories/jeux.png");		
        $imgFile = XOOPS_ROOT_PATH."/modules/catads/images/uploads/catads/images/categories/informatiques.png";
        copy($imgFile, XOOPS_ROOT_PATH."/uploads/catads/images/categories/informatiques.png");		
        $imgFile = XOOPS_ROOT_PATH."/modules/catads/images/uploads/catads/images/categories/telephonie.png";
        copy($imgFile, XOOPS_ROOT_PATH."/uploads/catads/images/categories/telephonie.png");
        $imgFile = XOOPS_ROOT_PATH."/modules/catads/images/uploads/catads/images/categories/bricolages.png";
        copy($imgFile, XOOPS_ROOT_PATH."/uploads/catads/images/categories/bricolages.png");	
        $imgFile = XOOPS_ROOT_PATH."/modules/catads/images/uploads/catads/images/categories/interieurs.png";
        copy($imgFile, XOOPS_ROOT_PATH."/uploads/catads/images/categories/interieurs.png");		
        $imgFile = XOOPS_ROOT_PATH."/modules/catads/images/uploads/catads/images/categories/numeriques.png";
        copy($imgFile, XOOPS_ROOT_PATH."/uploads/catads/images/categories/numeriques.png");			
        $imgFile = XOOPS_ROOT_PATH."/modules/catads/images/uploads/catads/images/categories/electromenagers.png";
        copy($imgFile, XOOPS_ROOT_PATH."/uploads/catads/images/categories/electromenagers.png");			
        $imgFile = XOOPS_ROOT_PATH."/modules/catads/images/uploads/catads/images/categories/animaux.png";
        copy($imgFile, XOOPS_ROOT_PATH."/uploads/catads/images/categories/animaux.png");		
	    $imgFile = XOOPS_ROOT_PATH."/modules/catads/images/uploads/catads/images/categories/sports.png";
        copy($imgFile, XOOPS_ROOT_PATH."/uploads/catads/images/categories/sports.png");	
	    $imgFile = XOOPS_ROOT_PATH."/modules/catads/images/uploads/catads/images/categories/vetements.png";
        copy($imgFile, XOOPS_ROOT_PATH."/uploads/catads/images/categories/vetements.png");	
	    $imgFile = XOOPS_ROOT_PATH."/modules/catads/images/uploads/catads/images/categories/immobiliers.png";
        copy($imgFile, XOOPS_ROOT_PATH."/uploads/catads/images/categories/immobiliers.png");	
//ajout CPascalWeb - option 	
		//Copie des images type pour les annonces en cas d'absence de photos
        $imgFile = XOOPS_ROOT_PATH."/modules/catads/images/uploads/catads/images/annonces/original/pasphotos.png";		
        copy($imgFile, XOOPS_ROOT_PATH."/uploads/catads/images/annonces/original/pasphotos.png");
        $imgFile = XOOPS_ROOT_PATH."/modules/catads/images/uploads/catads/images/annonces/thumb/pasphotos.png";		
        copy($imgFile, XOOPS_ROOT_PATH."/uploads/catads/images/annonces/thumb/pasphotos.png");		
//fin de l'ajout		
		
    return true;
}

catads_create_files_uploads();


?>