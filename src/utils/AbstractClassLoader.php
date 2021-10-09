<?php

namespace utils;

abstract class AbstractClassLoader
{

	protected $prefix = '';

	/**
	 * Constructeur: enregistre le chemin vers la racine des espaces de noms
	 * dans l'attribut $prefix 
	 *
	 */

	public function __construct($file_root)
	{
		$this->prefix = $file_root;
	}

	abstract public function loadClass(string $classname);

	abstract protected function makePath(string $filename): string;

	abstract protected function getFilename(string $classname): string;

	/**
	 * Méthode register : enregistre le chargeur de classe au près de
	 * l'interprète PHP 
	 * 
	 * Note : 
	 * 
	 * Comme le chargeur de classe est une méthode, on doit donner une
	 * une instance sur laquelle sera appelée cette méthode.
	 * 
	 */

	public function register()
	{
		spl_autoload_register(array($this, 'loadClass'));
	}
}
