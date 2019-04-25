<?php
/*
    Copyright (C) 2004-2015 Kestas J. Kuliukas and Timothy Jones

	This file is part of webDiplomacy.

    webDiplomacy is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    webDiplomacy is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with webDiplomacy.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once('header.php');
global $User;
header('Content-Type: application/javascript');

if ($User->options != null) 
{
	print $User->options->asJS();	
}
else
{
	print UserOptions::defaultJS();	
}
