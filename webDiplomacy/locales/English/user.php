<?php
/*
    Copyright (C) 2004-2010 Kestas J. Kuliukas

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

defined('IN_CODE') or die('This script can not be run by itself.');

/**
 * @package Base
 * @subpackage Forms
 */

?>
	<p><strong>E-mail address:</strong></br>
	<input type="text" class = "settings" name="userForm[email]" size="40" value="<?php
		if ( isset($_REQUEST['userForm']['email'] ) )
		{
			print $_REQUEST['userForm']['email'];
		}
		elseif( isset($User->email) )
		{
			print $User->email;
		}
		?>" <?php if ( isset($_REQUEST['emailToken']) ) print 'readonly '; ?> >
	</p>

	<p><strong>Hide e-mail address?</strong></br>
		<input type="radio" name="userForm[hideEmail]" value="Yes" <?php if($User->hideEmail=='Yes') print "checked"; ?>>Yes
		<input type="radio" name="userForm[hideEmail]" value="No" <?php if($User->hideEmail=='No') print "checked"; ?>>No
	</p>

	<p><strong>Password:</strong></br>
		<input type="password" name="userForm[password]" maxlength=30 autocomplete="new-password" class = "settings">
	</p>

	<p><strong>Confirm Password:</strong></br>
		<input type="password" name="userForm[passwordcheck]" maxlength=30 autocomplete="new-password" class = "settings">
	</p>

	<p><strong>Home page:</strong></br>
		<input type="text" class = "settings" size=50 name="userForm[homepage]" value="<?php print $User->homepage; ?>" maxlength=150>
		</br><?php if ( !$User->type['User'] ) print '<strong>(Optional)</strong>: '; ?>
			Your blog or personal/favorite website.
	</p>

	<p><strong>Comment:</strong></br>
		<TEXTAREA NAME="userForm[comment]" ROWS="3" COLS="50" class = "settings"><?php
			print str_replace('<br />', "\n", $User->comment);
		?></textarea>
	</br>
		<?php if ( !$User->type['User'] ) print '<strong>(Optional)</strong>: '; ?>
		Profile quote visible to others. Consider favorite quotes or links to games.
	</p>

<?php 
	if (isset(Config::$customForumURL))
	{
		list($newForumId) = $DB->sql_row("SELECT user_id FROM `phpbb_users` WHERE webdip_user_id = ".$User->id);
		if ($newForumId > 0)
		{
			print '<p class="profileCommentURL"><strong><a href="/contrib/phpBB3/ucp.php?i=179">Forum User Settings</a></strong></p>';
		}
	}

	foreach ($User->options->value as $name=>$val) 
	{
		print '<div><li class="settings"><strong>'.UserOptions::$titles[$name].':</strong></li>';
		foreach (UserOptions::$possibleValues[$name] as $possible) 
		{
			print ' <input type="radio" name="userForm['.$name.']" value="'.$possible.'" '. ($val == $possible ? 'checked' :'') . ' > '. $possible;
		}
		print '</div></br>';
	}
 	                               
if( $User->type['User'] ) {
	// If the user is registered show the list of muted users/countries:

	$MutedUsers = array();
	foreach($User->getMuteUsers() as $muteUserID) {
		$MutedUsers[] = new User($muteUserID);
	}
	if( count($MutedUsers) > 0 ) {
		print '<li class="formlisttitle">Muted users:</li>';
		print '<li class="formlistdesc">The users which you muted, and are unable to send you messages.</li>';
		print '<li class="formlistfield"><ul>';
		foreach ($MutedUsers as $MutedUser) {
			print '<li>'.$MutedUser->username.' '.libHTML::muted("profile.php?userID=".$MutedUser->id.'&toggleMute=on&rand='.rand(0,99999).'#mute').'</li>';
		}
		print '</ul></li>';
	}

	/*
	$MutedGames = array();
	foreach($User->getMuteCountries() as $muteGamePair) {
		list($gameID, $muteCountryID) = $muteGamePair;
		if( !isset($MutedGames[$gameID])) $MutedGames[$gameID] = array();
		$MutedGames[$gameID][] = $muteCountryID;
	}
	
	if( count($MutedGames) > 0 ) {
		print '<li class="formlisttitle">Muted countries:</li>'; 
		print '<li class="formlistdesc">The countries which you muted, and are unable to send you messages.</li>';
		print '<li class="formlistfield"><ul>';
		$LoadedVariants = array();
		foreach ($MutedGames as $gameID=>$mutedCountries) {
			list($variantID) = $DB->sql_row("SELECT variantID FROM wD_Games WHERE id=".$gameID);
			if( !isset($LoadedVariants[$variantID]))
				$LoadedVariants[$variantID] = libVariant::loadFromVariantID($variantID);
			$Game = $LoadedVariants[$variantID]->Game($gameID);
			print '<li>'.$Game->name.'<ul>';
			
			foreach($mutedCountries as $mutedCountryID) {
				print '<li>'.$Game->Members->ByCountryID[$mutedCountryID]->country.' '.
				libHTML::muted("board.php?gameID=".$Game->id."&msgCountryID=".$mutedCountryID."&toggleMute=".$mutedCountryID."&rand=".rand(0,99999).'#chatboxanchor').'</li>';
			} 
			print '</ul></li>'; 
		} 
		print '</ul></li>';
	} */
	
	if (!isset(Config::$customForumURL))
	{
		$tablMutedThreads = $DB->sql_tabl(
			"SELECT mt.muteThreadID, f.subject, f.replies, fu.username ".
			"FROM wD_MuteThread mt ".
			"INNER JOIN wD_ForumMessages f ON f.id = mt.muteThreadID ".
			"INNER JOIN wD_Users fu ON fu.id = f.fromUserID ".
			"WHERE mt.userID = ".$User->id);
		$mutedThreads = array();
		while( $mutedThread = $DB->tabl_hash($tablMutedThreads))
			$mutedThreads[] = $mutedThread;
		unset($tablMutedThreads);
		
		if( count($mutedThreads) > 0 ) {
			print '<li class="formlisttitle"><a name="threadmutes"></a>Muted threads:</li>';
			print '<li class="formlistdesc">The threads which you muted.</li>';
			
			$unmuteThreadID=0;
			if( isset($_GET['unmuteThreadID']) ) {
				
				$unmuteThreadID = (int)$_GET['unmuteThreadID'];
				$User->toggleThreadMute($unmuteThreadID);
				
				print '<li class="formlistfield"><strong>Thread <a class="light" href="forum.php?threadID='.$unmuteThreadID.'#'.$unmuteThreadID.
					'">#'.$unmuteThreadID.'</a> unmuted.</strong></li>';
			}
			
			print '<li class="formlistfield"><ul>';
			
			foreach ($mutedThreads as $mutedThread) {
				if( $unmuteThreadID == $mutedThread['muteThreadID']) continue;
				print '<li>'.
					'<a class="light" href="forum.php?threadID='.$mutedThread['muteThreadID'].'#'.$mutedThread['muteThreadID'].'">'.
					$mutedThread['subject'].'</a> '.
					libHTML::muted('usercp.php?unmuteThreadID='.$mutedThread['muteThreadID'].'#threadmutes').'<br />'.
					$mutedThread['username'].' ('.$mutedThread['replies'].' replies)<br />'.
					'</li>';
			}
			print '</ul></li>';
		}
	}
}
/*
 * This is done in PHP because Eclipse complains about HTML syntax errors otherwise
 * because the starting <form><ul> is elsewhere
 */
print '</ul>

<p><input type="submit" class="form-submit" value="Update"></p>
</form>
</div>';

?>
