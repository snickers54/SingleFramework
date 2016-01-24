<?php
/*
Copyright © <2011> <singler> <julien>

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 2.1 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public
License along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 US
*/
define("DEBUG", 1);
define("PATH_CONTROLLERS", "application/controllers/");
define("PATH_VIEWS", "application/views/");
define("PATH_MODELS", "application/models/");
define("PATH_LIB", "library/");
define("PATH_LANG", "application/language/");

// utilisation d'EASYJQUERY
define("EASYJQUERY", 1);
// Utilisation du bootstrap de twitter
define("BOOTSTRAP", 1);
define("PATH_BOOTSTRAP_CSS", "bootstrap/");
define("PATH_BOOTSTRAP_JS", "bootstrap/");

// Paths pour les ressources
define("IMAGES", "/public/images");
define("CSS", "/public/css");
define("JS", "/public/js");

// Include des define pour la bdd
include('define_base.php');

?>
