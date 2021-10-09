<?php

namespace utils;

use utils\AbstractClassLoader as UtilsAbstractClassLoader;

class ClassLoader extends UtilsAbstractClassLoader
{
	public function __construct($file_root)
	{
		parent::__construct($file_root);
	}

	public function loadClass(string $classname)
	{
		/**
		 * Méthode loadClass: charge le fichier de définition d'une classe.
		 *
		 * Paramètres:
		 *
		 *  - $classname (string): le nom complet d'une classe
		 *  
		 *  
		 * Algorithme:
		 *
		 * - transforme le nom de la classe en un chemin vers le fichier 
		 *   de définition avec la methode $this->getFilename
		 *
		 * - ajoute le prefix pour avoir le chemin complet depuis la racine du
		 *   de l'application avec la méthode $this->makePath
		 *
		 * - si le fichier existe :
		 *   
		 *   - le charger avec l'instruction require_once
		 * 
		 * - sinon : rien (surtout ne pas générer d'exception ou d'erreur)
		 *        
		 */
		$path = $this->getFilename($classname);
		$full_path = $this->makePath($path);
		// echo ('<div>' . $classname . '</div>');
		// echo ('<div>' . $path . '</div>');
		// echo ('<div>' . $full_path . '</div>');
		if (file_exists($full_path)) {
			require_once($full_path);
		}
	}

	protected function getFilename(string $classname): string
	{
		/**
		 * Méthode getFilename: transfomre le nom d'une classe espace de noms 
		 * compris en un chemin vers la définition de la classe.
		 * 
		 * Exemple: 
		 *
		 *   peopleapp\personne\Etudiant -> peopleapp/personne/Etudiant.php
		 *
		 * Paramètres:
		 *
		 * - $classname (string): le nom complet d'une classe
		 *
		 * Retourne:
		 *  
		 * - string : le chemin ver le fichier depuis la racine des espaces de nom 
		 *
		 * Algorithme:
		 *
		 * 
		 * - remplacer toute les autres occurrences du caractère "\"
		 *   par la constante DIRECTORY_SEPARATOR
		 *
		 * - ajouter ".php" a la fin de la chaine 
		 *
		 * - retourner la chaine finale.
		 */

		$filename = str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.php';
		// echo ('<div>getFilename : ' . $filename . '<div>');
		return $filename;
	}

	protected function makePath(string $filename): string
	{
		/**
		 * Méthode makePath: ajoute le préfix au chemin
		 * vers le fichier de définition d'une classe.
		 *
		 * Paramètres:
		 *
		 * - $filename (string): le chemin ver le fichier d'une classe
		 *
		 * Retourne:
		 *  
		 * - string : le même chemin avec le préfixe au début 
		 *
		 * Algorithme:
		 *
		 * - ajoute $this->prefix et DIRECTORY_SEPARATOR au début de $filename
		 *  
		 * - retourne la nouvelle chaine 
		 *
		 */
		// echo $this->prefix;
		// echo '<div>' . $filename . '<div>';
		return $this->prefix . DIRECTORY_SEPARATOR . $filename;
	}
}
