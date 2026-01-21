<?php
/**
 * Module Logout - Déconnexion
 */

session_destroy();
flash('success', 'Vous avez été déconnecté.');
redirect('/login');
