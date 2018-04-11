<?php
//This is a module for pluck, an opensource content management system
//Website: http://www.pluck-cms.org

//Make sure the file isn't accessed directly.
defined('IN_PLUCK') or exit('Access denied!');

//Include language-items

function guestbook_pages_site() {
	global $lang;

	$module_page_admin[] = array(
		'func'  => 'Main',
		'title' => $lang['guestbook']['main']
	);
	$module_page_admin[] = array(
		'func'  => 'newentry',
		'title' => $lang['guestbook']['newentry']
	);
		
	return $module_page_admin;
}

function guestbook_theme_Main() {
	global $lang;

    if (!file_exists('data/settings/modules/guestbook')) {
        mkdir('data/settings/modules/guestbook', 0775, true);
    }

    if (!file_exists('data/settings/modules/guestbook/new')) {
            mkdir('data/settings/modules/guestbook/new', 0775, true);
    }
    echo "<br/><br/>";
    $dir = opendir('data/settings/modules/guestbook');
    while (false !== ($file = readdir($dir))) {
        if(($file !== ".") and ($file !== "..") and ($file !== "new")) {
                include ('data/settings/modules/guestbook/'.$file);
                echo '<h2>'.$entrytitle.'</h2><div>'.$entry.'<br/></div>';
        }
    }

    echo '<br/><a href="'.SITE_URL.'/'.PAGE_URL_PREFIX.CURRENT_PAGE_SEONAME.'&amp;module=guestbook&amp;page=newentry">' . $lang['guestbook']['newentry'] . '</a>';

}

function guestbook_page_site_newentry(){
global $lang;
    ?>
    <div>
        <form method="post" action="" style="margin-top: 5px; margin-bottom: 15px;">
            <?php echo $lang['guestbook']['title']; ?> <br /><input name="title" type="text" value="" /><br />
            <?php echo $lang['guestbook']['email']; ?> <br /><input name="email" type="text" value="" /><br />
            <?php echo $lang['guestbook']['descr']; ?> <br /><textarea name="description" rows="7" cols="45" class="mceNoEditor"></textarea><br />
            <input type="submit" name="Submit" value="<?php echo $lang['guestbook']['send']; ?>" />
        </form>
    </div>
    
    <?php

    if(isset($_POST['Submit'])) {

        //Check if everything has been filled in
        if((!isset($_POST['title'])) || (!isset($_POST['email'])) || (!isset($_POST['description']))) { ?>
            <span style="color: red;"><?php echo $lang['guestbook']['fillall']; ?></span>
        <?php
            // exit;
        }
        else {
            //Then fetch our posted variables
            $title = $_POST['title'];
            $email = $_POST['email'];
            $description = $_POST['description'];

            //Check for HTML, and eventually block it
            if ((ereg('<', $title)) || (ereg('>', $title)) || (ereg('<', $email)) || (ereg('>', $email)) || (ereg('<', $description)) || (ereg('>', $description))) { ?>
                <span style="color: red;"><?php echo $lang['guestbook']['nohtml']; ?></span>
            <?php }
        else {

            $description=str_replace("\n", '<br \>', $description);

            $file=str_replace(" ", "_", $title);
            $file=date ("dmY"). '-' . $file;
            
            $fp = fopen ('data/settings/modules/guestbook/new/' . $file . '.php',"w");
            fputs ($fp, '<?php'."\n"
                .'$entrytitle = "'.$title.'";'."\n"
                .'$email = "'.$email.'";'."\n"
                .'$entry = "'.$description.'";'."\n"
                .'');
            fclose ($fp);
            
            $message = $lang['guestbook']['mail']."<br><br>".
            $lang['guestbook']['mail_tit'].'<br><b>'.$title."</b><br>".
            $lang['guestbook']['mail_dis'].'<br>'.$description."<br>".
            $lang['guestbook']['mail_email'].'<br>'.$email.'<br>';
            
            mail ($site_email,$lang['guestbook']['msubject'],$message,"From: ".$email." \n" . "Content-type: text/html; charset=utf-8");
            
            echo $lang['guestbook']['wsend'];

            }
        }
    }

}


?>
