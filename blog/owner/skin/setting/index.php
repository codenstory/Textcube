<?
define('ROOT', '../../../..');
require ROOT . '/lib/includeForOwner.php';
require ROOT . '/lib/piece/owner/header3.php';
require ROOT . '/lib/piece/owner/contentMenu32.php';
$categories = getCategories($owner);
$selected = 0;
?>
						<script type="text/javascript">
							//<![CDATA[
								function getValueById(id) {
									return document.getElementById(id).value;
								}
								
								function setSkin() {
									if(document.getElementById('showListOnCategoryTitles').checked) 
										showListOnCategory =1;
									else 
										showListOnCategory = 0;
									
									if(document.getElementById('showListOnArchiveTitles').checked) 
										showListOnArchive =1;
									else 
										showListOnArchive =0;
									
									if(document.getElementById('expandComment').checked) 
										expandComment =1;
									else 
										expandComment = 0;
									
									if(document.getElementById('expandTrackback').checked) 
										expandTrackback =1;
									else 
										expandTrackback =0;
									
									var tagboxAlign = 1;
									if (document.getElementById('tagboxAlignUsed')	.checked) {
										tagboxAlign = 1;
									} else if(document.getElementById('tagboxAlignName').checked) {
										tagboxAlign = 2;
									} else {
										tagboxAlign = 3;
									}
									
									param  = '';
									param += 'entriesOnPage='+getValueById('entriesOnPage') +'&';
									param += 'entriesOnRecent='+getValueById('entriesOnRecent') +'&';
									param += 'commentsOnRecent='+getValueById('commentsOnRecent') +'&';
									param += 'commentsOnGuestbook='+getValueById('commentsOnGuestbook') +'&';
									param += 'archivesOnPage='+getValueById('archivesOnPage') +'&';
									param += 'tagboxAlign='+tagboxAlign +'&';
									param += 'tagsOnTagbox='+getValueById('tagsOnTagbox') +'&';
									param += 'trackbacksOnRecent='+getValueById('trackbacksOnRecent') +'&';
									param += 'showListOnCategory='+showListOnCategory +'&';
									param += 'showListOnArchive='+showListOnArchive +'&';
									param += 'expandComment='+expandComment +'&';				
									param += 'expandTrackback='+expandTrackback +'&';
									param += 'recentNoticeLength='+getValueById('recentNoticeLength') +'&';
									param += 'recentEntryLength='+getValueById('recentEntryLength') +'&';
									param += 'recentCommentLength='+getValueById('recentCommentLength') +'&';
									param += 'recentTrackbackLength='+getValueById('recentTrackbackLength') +'&';				
									param += 'linkLength='+getValueById('linkLength') +'&';
									var request = new HTTPRequest("POST", '<?=$blogURL?>/owner/skin/setting/skin/');
									request.onSuccess = function() {
										PM.showMessage("<?=_t('저장되었습니다.')?>", "center", "bottom");
									}
									request.send(param);
								}
										
								function changeTreeStyle() {	
									var param = '';
									param += 'name='+document.getElementById('tree').value+'&';
									param += 'url=<?=$service['path']?>/image/tree/'+document.getElementById('tree').value+'&';
									param += 'showValue='+(document.getElementById('showValue').checked ? 1:0)+'&';
									param += 'itemColor='+document.getElementById('colorOnTree').value+'&';
									param += 'itemBgColor='+document.getElementById('bgColorOnTree').value+'&';
									param += 'activeItemColor='+document.getElementById('activeColorOnTree').value+'&';
									param += 'activeItemBgColor='+document.getElementById('activeBgColorOnTree').value+'&';
									param += 'labelLength='+document.getElementById('labelLengthOnTree').value+'&';
									
									document.getElementById('treePreview').src="<?=$blogURL?>/owner/skin/setting/tree/preview/?"+param;
								}
							//]]>
						</script>
						
						<div id="part-skin-setting" class="part">
							<h2 class="caption"><span class="main-text"><?=_t('스킨에 맞춘 내용 출력을 설정합니다')?></span></h2>
							
							<form id="skinSetting" name="skinSetting" method="post" action="<?=$blogURL?>/owner/skin/setting/skin" enctype="application/x-www-form-urlencoded">
								<div class="data-inbox">
									<div id="per-page-section" class="section">
<?
ob_start();
?>

												<select id="entriesOnPage" name="entriesOnPage">
<?
for ($i = 1; $i < 30; $i++) {
	if ($i == $blog['entriesOnPage'])
		$checked = ' selected="selected"';
	else
		$checked = '';
?>
													<option value="<?=$i?>" <?=$checked?>><?=$i?></option>
<?
}
?>
												</select>
<?
$arg = ob_get_contents();
ob_end_clean();
?>
										<dl id="post-per-count-line" class="line">
											<dt><label for="entriesOnPage"><?php echo _t('페이지 당 포스트 수')?></label></dt>
											<dd><?=_f('블로그 글을 한 페이지 당 %1개 보여줍니다.', $arg)?></dd>
										</dl>
<?
ob_start();
?>

												<select id="entriesOnRecent" name="entriesOnRecent">
<?
for ($i = 1; $i < 30; $i++) {
	if ($i == $skinSetting['entriesOnRecent'])
		$checked = ' selected="selected"';
	else
		$checked = '';
?>
													<option value="<?=$i?>" <?=$checked?>><?=$i?></option>
<?
}
?>
												</select>
<?
$arg = ob_get_contents();
ob_end_clean();
?>
										<dl id="recent-post-line" class="line">
											<dt><label for="entriesOnRecent"><?php echo _t('출력될 최신 글 수')?></label></dt>
											<dd><?=_f('최신 글을 %1개 보여줍니다.', $arg)?></dd>
										</dl>
<?
ob_start();
?>

												<select id="commentsOnRecent" name="commentsOnRecent">
<?
for ($i = 1; $i < 30; $i++) {
	if ($i == $skinSetting['commentsOnRecent'])
		$checked = ' selected="selected"';
	else
		$checked = '';
?>
													<option value="<?=$i?>" <?=$checked?>><?=$i?></option>
<?
}
?>
												</select>
<?
$arg = ob_get_contents();
ob_end_clean();
?>
										<dl id="recent-comment-line" class="line">
											<dt><label for="commentsOnRecent"><?php echo _t('출력될 최신 댓글 수')?></label></dt>
											<dd><?=_f('최신 댓글을 %1개 보여줍니다.', $arg)?></dd>
										</dl>
<?
ob_start();
?>

												<select id="trackbacksOnRecent" name="trackbacksOnRecent">
<?
for ($i = 1; $i < 30; $i++) {
	if ($i == $skinSetting['trackbacksOnRecent'])
		$checked = ' selected="selected"';
	else
		$checked = '';
?>
													<option value="<?=$i?>" <?=$checked?>><?=$i?></option>
<?
}
?>
												</select>
<?
$arg = ob_get_contents();
ob_end_clean();
?>
										<dl id="recent-trackback-line" class="line">
											<dt><label for="trackbacksOnRecent"><?php echo _t('출력될 최신 트랙백 수')?></label></dt>
											<dd><?=_f('최신 트랙백을 %1개 보여줍니다.', $arg)?></dd>
										</dl>
<?
ob_start();
?>

												<select id="archivesOnPage" name="archivesOnPage">
<?
for ($i = 1; $i < 30; $i++) {
	if ($i == $skinSetting['archivesOnPage'])
		$checked = ' selected="selected"';
	else
		$checked = '';
?>
													<option value="<?=$i?>" <?=$checked?>><?=$i?></option>
<?
}
?>
												</select>
<?
$arg = ob_get_contents();
ob_end_clean();
?>
										<dl id="recent-archive-line" class="line">
											<dt><label for="archivesOnPage"><?php echo _t('출력될 저장소 수')?></label></dt>
											<dd><?=_f('저장소를 %1달 보여줍니다.', $arg)?></dd>
										</dl>
									</div>
									
									<div id="click-section" class="section">
										<dl id="category-click-line" class="line">
											<dt><span class="label"><?=_t('분류 클릭 시')?></span></dt>
											<dd>
												<input type="radio" id="showListOnCategoryTitles" class="radio" name="showListOnCategory" value="titles"<?=$skinSetting['showListOnCategory'] ? ' checked="checked"' : ''?> /> <label for="showListOnCategoryTitles"><?=_t('글 목록을 표시합니다.')?></label><br />
												<input type="radio" id="showListOnCategoryContents" class="radio" name="showListOnCategory" value="contents"<?=$skinSetting['showListOnCategory'] ? '' : ' checked="checked"'?> /> <label for="showListOnCategoryContents"><?=_t('글 내용을 표시합니다.')?></label>
											</dd>
										</dl>
										<dl id="archive-click-line" class="line">
											<dt><span class="label"><?=_t('저장소 클릭 시')?></span></dt>
											<dd>
												<input type="radio" id="showListOnArchiveTitles" class="radio" name="showListOnArchive" value="titles"<?=$skinSetting['showListOnArchive'] ? ' checked="checked"' : ''?> /> <label for="showListOnArchiveTitles"><?=_t('글 목록을 표시합니다.')?></label><br />
												<input type="radio" id="showListOnArchiveContents" class="radio" name="showListOnArchive" value="contents"<?=$skinSetting['showListOnArchive'] ? '' : ' checked="checked"'?> /> <label for="showListOnArchiveContents"><?=_t('글 내용을 표시합니다.')?></label>
											</dd>
										</dl>
										<dl id="post-click-line" class="line">
											<dt><span class="label"><?=_t('글을 표시할 때')?></span></dt>
											<dd>
												<input type="checkbox" id="expandComment" class="checkbox" name="expandComment"<?=$skinSetting['expandComment'] ? ' checked="checked"' : ''?> /> <label for="expandComment"><?=_t('댓글을 기본으로 펼칩니다.')?></label><br />
												<input type="checkbox" id="expandTrackback" class="checkbox" name="expandTrackback"<?=$skinSetting['expandTrackback'] ? ' checked="checked"' : ''?> /> <label for="expandTrackback"><?=_t('트랙백을 기본으로 펼칩니다.')?></label>
											</dd>
										</dl>
									</div>
									
									<div id="length-section" class="section">
<?
ob_start();
?>

												<select id="recentNoticeLength" name="recentNoticeLength">
<?
for ($i = 3; $i <= 40; $i++) {
	if ($i == $skinSetting['recentNoticeLength'])
		$checked = ' selected="selected"';
	else
		$checked = '';
?>
													<option value="<?=$i?>" <?=$checked?>><?=$i?></option>
<?
}
?>
												</select>
<?
$arg = ob_get_contents();
ob_end_clean();
?>
										<dl id="recent-notice-length-line" class="line">
											<dt><label for="recentNoticeLength"><?php echo _t('최신 공지 길이')?></label></dt>
											<dd><?=_f('최신 공지를 %1 글자로 표시합니다.', $arg)?></dd>
										</dl>
<?
ob_start();
?>

												<select id="recentEntryLength" name="recentEntryLength">
<?
for ($i = 3; $i <= 40; $i++) {
	if ($i == $skinSetting['recentEntryLength'])
		$checked = ' selected="selected"';
	else
		$checked = '';
?>
													<option value="<?=$i?>" <?=$checked?>><?=$i?></option>
<?
}
?>
												</select>
<?
$arg = ob_get_contents();
ob_end_clean();
?>
										<dl id="recent-post-length-line" class="line">
											<dt><label for="recentEntryLength"><?php echo _t('최신 글 길이')?></label></dt>
											<dd><?=_f('최신 글을 %1 글자로 표시합니다.', $arg)?></dd>
										</dl>
<?
ob_start();
?>

												<select id="recentCommentLength" name="recentCommentLength">
<?
for ($i = 3; $i <= 40; $i++) {
	if ($i == $skinSetting['recentCommentLength'])
		$checked = ' selected="selected"';
	else
		$checked = '';
?>
													<option value="<?=$i?>" <?=$checked?>><?=$i?></option>
<?
}
?>
												</select>
<?
$arg = ob_get_contents();
ob_end_clean();
?>
										<dl id="recent-comment-length-line" class="line">
											<dt><label for="recentCommentLength"><?php echo _t('최신 댓글 길이')?></label></dt>
											<dd><?=_f('최신 댓글을 %1 글자로 표시합니다.', $arg)?></dd>
										</dl>
<?
ob_start();
?>

												<select id="recentTrackbackLength" name="recentTrackbackLength">
<?
for ($i = 3; $i <= 40; $i++) {
	if ($i == $skinSetting['recentTrackbackLength'])
		$checked = ' selected="selected"';
	else
		$checked = '';
?>
														<option value="<?=$i?>" <?=$checked?>><?=$i?></option>
<?
}
?>
												</select>
<?
$arg = ob_get_contents();
ob_end_clean();
?>
										<dl id="recent-trackback-length-line" class="line">
											<dt><label for="recentTrackbackLength"><?php echo _t('최신 트랙백 길이')?></label></dt>
											<dd><?=_f('최신 트랙백을 %1 글자로 표시합니다.', $arg)?></dd>
										</dl>
<?
ob_start();
?>

												<select id="linkLength" name="linkLength">
<?
for ($i = 3; $i <= 40; $i++) {
	if ($i == $skinSetting['linkLength'])
		$checked = ' selected="selected"';
	else
		$checked = '';
?>
													<option value="<?=$i?>" <?=$checked?>><?=$i?></option>
<?
}
?>
												</select>
<?
$arg = ob_get_contents();
ob_end_clean();
?>
										<dl id="recent-link-length-line" class="line">
											<dt><label for="linkLength"><?php echo _t('링크 길이')?></label></dt>
											<dd><?=_f('링크를 %1 글자로 표시합니다.', $arg)?></dd>
										</dl>
									</div>
									
									<div id="tag-setting-section" class="section">
										<dl id="tag-align-line" class="line">
											<dt><span class="label"><?=_t('태그의 정렬방법을')?></span></dt>
											<dd>
												<input type="radio" id="tagboxAlignUsed" class="radio" name="tagboxAlign" value="1" <?=($skinSetting['tagboxAlign'] == 1 ? 'checked = "checked"' : '')?> /> <label for="tagboxAlignUsed"><?=_t('인기도순으로 표시합니다.')?></label><br />
												<input type="radio" id="tagboxAlignName" class="radio" name="tagboxAlign" value="2" <?=($skinSetting['tagboxAlign'] == 2 ? 'checked = "checked"' : '')?> /> <label for="tagboxAlignName"><?=_t('이름순으로 표시합니다.')?></label><br />
												<input type="radio" id="tagboxAlignRadom" class="radio" name="tagboxAlign" value="3" <?=($skinSetting['tagboxAlign'] == 3 ? 'checked = "checked"' : '')?> /> <label for="tagboxAlignRadom"><?=_t('임의로 표시합니다.')?></label>
											</dd>
										</dl>
<?
ob_start();
?>

												<select id="tagsOnTagbox" name="tagsOnTagbox">
<?
for ($i = 10; $i <= 200; $i += 10) {
	if ($i == $skinSetting['tagsOnTagbox'])
		$checked = ' selected="selected"';
	else
		$checked = '';
?>
													<option value="<?=$i?>" <?=$checked?>><?=$i?></option>
<?
}
?>
													<option value="-1" <?=$skinSetting['tagsOnTagbox'] == - 1 ? 'selected = "selected"' : ''?>><?=_t('전체')?></option>
												</select>
<?
$arg = ob_get_contents();
ob_end_clean();
?>
										<dl id="tag-count-line" class="line">
											<dt><label for="tagsOnTagbox"><?php echo _t('태그상자의 태그 수')?></label></dt>
											<dd><?=_f('태그상자의 태그를 %1개 표시합니다.', $arg)?></dd>
										</dl>
									</div>

									<div id="guestbook-setting-section" class="section">
<?
ob_start();
?>

												<select id="commentsOnGuestbook" name="commentsOnGuestbook">
<?
for ($i = 1; $i < 30; $i++) {
	if ($i == $skinSetting['commentsOnGuestbook'])
		$checked = ' selected="selected"';
	else
		$checked = '';
?>						
													<option value="<?=$i?>" <?=$checked?>><?=$i?></option>
<?
}
?>
												</select>
<?
$arg = ob_get_contents();
ob_end_clean();
?>
										<dl class="line">
											<dt><label for="commentsOnGuestbook"><?php echo _t('페이지 당 방명록 수')?></label></dt>
											<dd><?=_f('방명록 한 페이지 당 %1개 글을 표시합니다.', $arg)?></dd>
										</dl>
									</div>
									
									<div class="button-box">
										<a class="save-button button" href="#void" onclick="setSkin(); return false;"><span class="text"><?=_t('저장하기')?></span></a>
									</div>
								</div>
							</form>
						</div>
						
						<hr class="hidden" />
						
						<div id="part-skin-tree" class="part">
							<h2 class="caption"><span class="main-text"><?=_t('스킨에 맞춘 분류의 출력을 설정합니다')?></span></h2>
							
							<form id="setSkinForm" method="post" action="<?=$blogURL?>/owner/skin/setting/tree" enctype="application/x-www-form-urlencoded">
								<div class="data-inbox">
									<iframe id="treePreview" src="<?=$blogURL?>/owner/skin/setting/tree/preview" width="300" height="300" frameborder="0" style="overflow: visible;"></iframe>
									
									<div id="property-box">
										<dl id="tree-skin-line" class="line">
											<dt><label for="tree"><?=_t('트리선택')?></label></dt>
											<dd>
												<select id="tree" name="tree" onchange="changeTreeStyle()">
<?
$skinPath = ROOT . '/image/tree';
if ($dh = opendir($skinPath)) {
	while (($file = readdir($dh)) !== false) {
		if ($file == '.' || $file == '..')
			continue;
		if ((!file_exists($skinPath . '/' . $file . '/tab_top.gif')))
			continue;
		if ($skinSetting['tree'] == $file)
			echo "<option value=\"$file\" selected=\"selected\">$file</option>";
		else
			echo "<option value=\"$file\">$file</option>";
	}
	closedir($dh);
}
?>
												</select>
											</dd>
										</dl>
										<dl id="selected-color-line" class="line">
											<dt><label for="activeColorOnTree"><?=_t('선택된 글자색')?></label></dt>
											<dd><input type="text" id="activeColorOnTree" class="text-input" name="activeColorOnTree" value="<?=$skinSetting['activeColorOnTree']?>" size="7" maxlength="6" onchange="changeTreeStyle()" /></dd>
										</dl>
										<dl id="selected-bgcolor-line" class="line">
											<dt><label for="activeBgColorOnTree"><?=_t('선택된 배경색')?></label></dt>
											<dd><input type="text" id="activeBgColorOnTree" class="text-input" name="activeBgColorOnTree" value="<?=$skinSetting['activeBgColorOnTree']?>" size="7" maxlength="6" onchange="changeTreeStyle()" /></dd>
										</dl>
										<dl id="unselected-color-line" class="line">
											<dt><label for="colorOnTree"><?=_t('선택되지 않은 글자색')?></label></dt>
											<dd><input type="text" id="colorOnTree" class="text-input" name="colorOnTree" value="<?=$skinSetting['colorOnTree']?>" size="7" maxlength="6" onchange="changeTreeStyle()" /></dd>
										</dl>
										<dl id="unselected-bgcolor-line" class="line">
											<dt><label for="bgColorOnTree"><?=_t('선택되지 않은 배경색')?></label></dt>
											<dd><input type="text" id="bgColorOnTree" class="text-input" name="bgColorOnTree" value="<?=$skinSetting['bgColorOnTree']?>" size="7" maxlength="6" onchange="changeTreeStyle()" /></dd>
										</dl>
										<dl id="label-langth-line" class="line">
											<dt><label for="labelLengthOnTree"><?php echo _t('레이블 길이')?></label></dt>
											<dd><?=_f('레이블을 %1 글자로 표시합니다.', '<input type="text" id="labelLengthOnTree" class="text-input" name="labelLengthOnTree" value="' . $skinSetting['labelLengthOnTree'] . '" size="3" maxlength="6" onchange="changeTreeStyle()" />')?></dd>
										</dl>
										<dl id="count-display-line" class="line">
											<dt><label for="showValue"><?php echo _t('포스트 갯수 출력')?></label></dt>
											<dd><input type="checkbox" class="checkbox" id="showValue" name="showValueOnTree" onclick="changeTreeStyle()" <?=$skinSetting['showValueOnTree'] ? 'checked' : ''?> /> <label for="showValue"><?=_t('카테고리의 글 수를 표시합니다.')?></label></dd>
										</dl>
									</div>
								
									<div class="button-box">
										<a class="save-button button" href="#void" onclick="setSkin(); return false;"><span class="text"><?=_t('저장하기')?></span></a>
									</div>
								</div>
							</form>
						</div>
<?
require ROOT . '/lib/piece/owner/footer1.php';
?>