<?php

/**
 * Classe abstraite qui représente un manager. Elle récupère automatiquement le gestionnaire de base de données.
 */

namespace App\Manager;
abstract class AbstractEntityManager {

    protected $db;

    /**
     * Constructeur de la classe.
     * Il récupère automatiquement l'instance de DBManager.
     */
    public function __construct()
    {
        $this->db = DBManager::getInstance();
    }
}