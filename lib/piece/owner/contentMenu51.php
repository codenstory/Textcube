			<div id="layout-body">
				<h2><?php echo _t('서브메뉴 : 환경설정');?></h2>
				
				<div id="sub-menu-box">
					<ul id="sub-menu">
						<li id="sub-menu-blog"><a href="<?php echo $blogURL;?>/owner/setting/blog"><span class="text"><?php echo _t('기본');?></span></a></li>
						<li id="sub-menu-entry"><a href="<?php echo $blogURL;?>/owner/setting/entry"><span class="text"><?php echo _t('글 작성');?></span></a></li>
						<li id="sub-menu-account" class="selected"><a href="<?php echo $blogURL;?>/owner/setting/account"><span class="text"><?php echo _t('계정 정보');?></span></a></li>
						<li id="sub-menu-filter"><a href="<?php echo $blogURL;?>/owner/setting/filter"><span class="text"><?php echo _t('필터');?></span></a></li>
						<li id="sub-menu-data"><a href="<?php echo $blogURL;?>/owner/data"><span class="text"><?php echo _t('데이터 관리');?></span></a></li>
						<li id="sub-menu-helper"><a href="<?php echo getHelpURL('setting/account');?>" onclick="window.open(this.href); return false;"><span class="text"><?php echo _t('도우미');?></span></a></li>
					</ul>
				</div>
				
				<hr class="hidden" />
				
				<div id="pseudo-box">
					<div id="data-outbox">
