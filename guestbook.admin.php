<?php
//This is a module for pluck, an opensource content management system
//Website: http://www.pluck-cms.org

//MODULE NAME: Linklist
//LICENSE: MIT

//Make sure the file isn't accessed directly
defined('IN_PLUCK') or exit('Access denied!');

function guestbook_pages_admin() {
	global $lang;

	$module_page_admin[] = array(
		'func'  => 'Main',
		'title' => $lang['guestbook']['main']
	);
	$module_page_admin[] = array(
		'func'  => 'activate',
		'title' => $lang['guestbook']['adminpage']
	);
		
	return $module_page_admin;
}

function guestbook_page_admin_Main() {
	global $lang;

	showmenudiv($lang['guestbook']['adminpage'],$lang['guestbook']['adminpage'],'data/image/note.png','admin.php?module=guestbook&amp;page=activate',false);

    if (!file_exists('data/settings/modules/guestbook')) {
            mkdir('data/settings/modules/guestbook', 0775, true);
    }

    if (!file_exists('data/settings/modules/guestbook/new')) {
            mkdir('data/settings/modules/guestbook/new', 0775, true);
    }

    if (isset($_GET['delete'])) {
        unlink ('data/settings/modules/guestbook/'.$_GET['delete']);
        echo $file . $lang['guestbook']['deleted'];
        redirect ('?module=guestbook','0');
    }

    $dir = opendir('data/settings/modules/guestbook/');
    while (false !== ($file = readdir($dir))) {
        if(($file !== ".") and ($file !== "..") and ($file != "new")) {
        include ('data/settings/modules/guestbook/'.$file);
        echo '
        <div class="menudiv" style="margin: 10px;">
            <table width="100%">
                <tr>
                    <td width="20"><img src="data/image/website_small.png"></td>
                    <td>
                        <span>'.$entrytitle.'</a></span><br/>
                        <p>'.$email.'</p>
                        <p>'.$entry.'</p>
                    </td>
                    <td align="right">
                        <a href="?module=guestbook&delete='.$file.'"><img src="data/image/trash_small.png" border="0" title="'.$lang['guestbook']['delete'].'" alt="'.$lang['guestbook']['delete'].'"></a>
                    </td>
                </tr>
            </table>
        </div>';

        }
    }

}

function guestbook_page_admin_activate(){
	global $lang;
    	showmenudiv($lang['guestbook']['backlink'],false,'data/image/restore.png','?module=guestbook',false);

    $dir = opendir('data/settings/modules/guestbook/new/');
    while (false !== ($file = readdir($dir))) {
           if(($file !== ".") and ($file !== "..")) {
           include ('data/settings/modules/guestbook/new/'.$file);
            echo '
            <div class="menudiv" style="margin: 10px;">
                <table width="100%">
                    <tr>
                        <td width="20"><img src="data/image/website_small.png"></td>
                        <td>
                            <span>'.$entrytitle.'</a></span><br/>
                            <p>'.$email.'</p>
                            <p>'.$entry.'</p>
                        </td>
                        <td align="right">
                            <a href="?module=guestbook&page=activate&activate='.$file.'"><img src="data/image/add_small.png" border="0" title='.$lang['guestbook']['activate'].'" alt="'.$lang['linklist']['activate'].'"></a>
                            <a href="?module=guestbook&page=activate&delete='.$file.'"><img src="data/image/trash_small.png" border="0" title="'.$lang['guestbook']['delete'].'" alt="'.$lang['linklist']['delete'].'"></a>
                        </td>
                    </tr>
                </table>
            </div>';
           }
       }
    
    if (isset($_GET['delete'])) {
        unlink ('data/settings/modules/guestbook/new/' . $_GET['delete']);
        echo $file . $lang['guestbook']['deleted'];
        redirect('?module=guestbook','0');
    }
    
    if (isset($_GET['activate'])) {
        copy('data/settings/modules/guestbook/new/'.$_GET['activate'],'data/settings/modules/guestbook/'.$_GET['activate']);
        unlink ('data/settings/modules/guestbook/new/'.$_GET['activate']);
        redirect('?module=guestbook&amp;page=activate','0');
    }
    
}


?>
