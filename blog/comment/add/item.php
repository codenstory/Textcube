<?php
define('ROOT', '../../..');
require ROOT . '/lib/include.php';
$entryId = $suri['id'];
$IV = array(
	'GET' => array(
		'__T__' => array('any', 13, 13)
	),
	'POST' => array(
		'key' => array('string', 32, 32),
		"name_$entryId" => array('string', 'default' => ''),
		"password_$entryId" => array('string', 'default' => ''),
		"secret_$entryId" => array(array('1'), 'mandatory' => false),
		"homepage_$entryId" => array('string', 'default' => 'http://'),
		"email_$entryId" => array('string', 'default' => ''),
		"comment_$entryId" => array('string', 'default' => '')
	)
);
if(!Validator::validate($IV))
	printRespond(array('error' => 1, 'description' => 'Illigal parameters'));
requireStrictRoute();
header('Content-Type: text/xml; charset=utf-8');
if (!isset($_GET['__T__']) || !isset($_POST['key']) || $_POST['key'] != md5(filemtime(ROOT . '/config.php'))) {
	print ("<?xml version=\"1.0\" encoding=\"utf-8\"?><response><error>0</error><commentBlock></commentBlock><recentCommentBlock></recentCommentBlock></response>");
	exit;
}
$userName = isset($_POST["name_$entryId"]) ? $_POST["name_$entryId"] : '';
$userPassword = isset($_POST["password_$entryId"]) ? $_POST["password_$entryId"] : '';
$userEmail = isset($_POST["email_$entryId"]) ? $_POST["email_$entryId"] : '';
$userSecret = isset($_POST["secret_$entryId"]) ? 1 : 0;
$userHomepage = isset($_POST["homepage_$entryId"]) ? $_POST["homepage_$entryId"] : '';
$userComment = isset($_POST["comment_$entryId"]) ? $_POST["comment_$entryId"] : '';
if (!doesHaveMembership() && !doesHaveOwnership() && $userName == '') {
	echo '<?xml version="1.0" encoding="utf-8"?><response><error>2</error><description><![CDATA[', _text('이름을 입력해 주십시오.'), ']]></description></response>';
} else if ($userComment == '') {
	echo '<?xml version="1.0" encoding="utf-8"?><response><error>2</error><description><![CDATA[', _text('본문을 입력해 주십시오.'), ']]></description></response>';
} else {
	if (!empty($userName))
		setcookie('guestName', $userName, time() + 2592000, "$blogURL/");
	if (!empty($userEmail)) {
		setcookie('guestEmail', $userEmail, time() + 2592000, "$blogURL/");
	} else {
		setcookie('guestEmail');
	}
	if (!empty($userHomepage) && ($userHomepage != 'http://')) {
		if (strpos($userHomepage, 'http://') === 0)
			setcookie('guestHomepage', $userHomepage, time() + 2592000, "$blogURL/");
		else
			setcookie('guestHomepage', "http://$userHomepage", time() + 2592000, "$blogURL/");
	}
	$comment = array();
	$comment['entry'] = $entryId;
	$comment['parent'] = null;
	$comment['name'] = $userName;
	$comment['email'] = $userEmail;
	$comment['password'] = $userPassword;
	$comment['homepage'] = ($userHomepage == '' || $userHomepage == 'http://') ? '' : $userHomepage;
	$comment['secret'] = $userSecret;
	$comment['comment'] = $userComment;
	$comment['ip'] = $_SERVER['REMOTE_ADDR'];
	$result = addComment($owner, $comment);
	if ($result === 'blocked') {
		echo '<?xml version="1.0" encoding="utf-8"?><response><error>1</error><description><![CDATA[', _text('귀하는 차단되었으므로 사용하실 수 없습니다.'), ']]></description></response>';
	} else if ($result === false) {
		echo '<?xml version="1.0" encoding="utf-8"?><response><error>2</error><description><![CDATA[', _text('댓글을 달 수 없습니다.'), ']]></description></response>';
	} else {
		$skin = new Skin($skinSetting['skin']);
		if ($entryId > 0) {
			$commentBlock = escapeCData(removeAllTags(getCommentView($entryId, $skin)));
			$recentCommentBlock = escapeCData(getRecentCommentsView(getRecentComments($owner), $skin->recentComments));
			$commentCount = getCommentCount($owner, $entryId);
			$commentCount = ($commentCount > 0) ? $commentCount : 0;
			list($tempTag, $commentView) = getCommentCountPart($commentCount, $skin);
		} else {
			$commentView = '';
			$commentBlock = escapeCData(removeAllTags(getCommentView($entryId, $skin)));
			$recentCommentBlock = escapeCData(getRecentCommentsView(getRecentComments($owner), $skin->recentComments));
		}
		echo '<?xml version="1.0" encoding="utf-8"?><response><error>0</error><commentView>'.$commentView.'</commentView><commentCount>'.$commentCount.'</commentCount><commentBlock><![CDATA[', $commentBlock, ']]></commentBlock><recentCommentBlock><![CDATA[', $recentCommentBlock, ']]></recentCommentBlock></response>';
	}
}
?>
