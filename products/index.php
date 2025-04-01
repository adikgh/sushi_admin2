<? include "../config/core.php";

	// 
	if (!$user_id) header('location: /');


	// filter
	// if (@$_GET['on'] == 1) $product_all = db::query("select * from product where arh = 0");
	// elseif (@$_GET['off'] == 1) $product_all = db::query("select * from product where arh = 0");
	// elseif (@$_GET['catalog']) {
	// 	$catalog_id = $_GET['catalog'];
	// 	$product_all = db::query("select * from product where catalog_id = '$catalog_id' and arh = 0");
	// } elseif (@$_GET['brand']) {
	// 	$brand_id = $_GET['brand'];
	// 	$product_all = db::query("select * from product where brand_id = '$brand_id' and arh = 0");
	// } else 
	$product_all = db::query("select * from product where company_id = '$company'");
	$page_result = mysqli_num_rows($product_all);

	// page number
	$page = 1; if (@$_GET['page'] && is_int(intval($_GET['page']))) $page = $_GET['page'];
	$page_age = 100;
	$page_all = ceil($page_result / $page_age);
	if ($page > $page_all) $page = $page_all;
	$page_start = ($page - 1) * $page_age;
	$number = $page_start;

	// filter
	// if (@$_GET['on'] == 1) $product = db::query("select * from product where arh = 0 order by ins_dt desc limit $page_start, $page_age");
	// elseif (@$_GET['off'] == 1) $product = db::query("select * from product where arh = 0 order by ins_dt desc limit $page_start, $page_age");
	// elseif (@$_GET['catalog']) $product = db::query("select * from product where catalog_id = '$catalog_id' and arh = 0 order by ins_dt desc limit $page_start, $page_age");
	// elseif (@$_GET['brand']) $product = db::query("select * from product where brand_id = '$brand_id' and arh = 0 order by ins_dt desc limit $page_start, $page_age");
	// else 
	
	$product = db::query("select * from product where company_id = '$company' order by name_ru asc limit $page_start, $page_age");


	// site setting
	$menu_name = 'products';
	$pod_menu_name = 'main';
	// $site_set['footer'] = false;
	$css = ['products/main'];
	$js = ['products/main'];
?>
<? include "../block/header.php"; ?>

	<div class="bl_c">

      <!-- a header -->
		<? include "aheader.php"; ?>

			<br>

		   	<!--  -->
		   	<div class="ucours_t">
				<div class="ucours_tl">
					<div class="ucours_tm">
						<div class="btn btn_cl product_add_pop">
						<i class="fal fa-plus"></i>
						<span>Добавить товар</span>
						</div>
					</div>
      			</div>
   			</div>
		
		<? if ($page_result): ?>
			
			<div class="uc_u">
				<div class="uc_us">
					<div class="form_im uc_usn">
						<input type="text" placeholder="Поиск" class="product_search">
						<i class="fal fa-search form_icon"></i>
					</div>
				</div>

				<div class="tscroll">
					<div class="uc_u2q uc_uc">
						<div class="uc_uh">
							<div class="uc_uhn">
								<div class="uc_uh_number">#</div>
								<div class="uc_uh_other">Наименование</div>
								<div class="uc_uh_other">Категория</div>
								<div class="uc_uh_other">Цена продажи</div>
							</div>
							<div class="uc_uh_cn"></div>
						</div>
						<div class="uc_uc">
							<? while ($pr_d = mysqli_fetch_assoc($product)): ?>
								<? $number++; ?>
								
								<div class="uc_ui uc_ui2">
									<div class="uc_uil">
										<div class="uc_ui_number"><?=$number?></div>
										<a class="uc_uin_other" href="item/?id=<?=$pr_d['id']?>"><?=$pr_d['name_ru']?></a>
										<div class="uc_uin_other"><? if ($pr_d['catalog_id']): ?> <div><?=product::pr_catalog_name($pr_d['catalog_id'], $lang)?></div> <? endif ?></div>
										<div class="uc_uin_other"><?=($pr_d['price']==0?'<m>Цена не указана</m>':$pr_d['price'].' тг')?></div>
									</div>
									<div class="uc_uib">
										<div class="uc_uibo"><i class="fal fa-ellipsis-v"></i></div>
										<div class="menu_c uc_uibs">
											<a class="menu_ci" target="_blank" href="/products/item/?id=<?=$pr_d['id']?>">
												<div class="menu_cin"><i class="fal fa-external-link"></i></div>
												<div class="menu_cih">Открыть товар</div>
											</a>
											<div class="menu_ci product2_add_pop" data-id="<?=$pr_d['id']?>">
												<div class="menu_cin"><i class="fal fa-clone"></i></div>
												<div class="menu_cih">Дублировать товар</div>
											</div>
											<div class="menu_ci uc_uib_del pr_btn_delete" data-title2="Удалить товар" data-id="<?=$pr_d['id']?>">
												<div class="menu_cin"><i class="fal fa-trash-alt"></i></div>
												<div class="menu_cih">Удалить товар</div>
											</div>
										</div>
									</div>
								</div>
							<? endwhile ?>
						</div>
					</div>
				</div>
				<div class="uc_u2qm  uc_uc dsp_n"></div>
			</div>

			<? if ($page_all > 1): ?>
				<div class="uc_p">
					<? if ($page > 1): ?> <a class="uc_pi" href="<?=$url_page?>?&page=<?=$page-1?>"><i class="fal fa-angle-left"></i></a> <? endif ?>
					<a class="uc_pi <?=($page==1?'uc_pi_act':'')?>" href="<?=$url_page?>?&page=1">1</a>
					<? for ($pg = 2; $pg < $page_all; $pg++): ?>
						<? if ($pg == $page - 1): ?>
							<? if ($page - 1 != 2): ?> <div class="uc_pi uc_pi_disp">...</div> <? endif ?>
							<a class="uc_pi <?=($page==$pg?'uc_pi_act':'')?>" href="<?=$url_page?>?&page=<?=$pg?>"><?=$pg?></a>
						<? endif ?>
						<? if ($pg == $page): ?> <a class="uc_pi <?=($page==$pg?'uc_pi_act':'')?>" href="<?=$url_page?>?&page=<?=$pg?>"><?=$pg?></a> <? endif ?>
						<? if ($pg == $page + 1): ?>
							<a class="uc_pi <?=($page==$pg?'uc_pi_act':'')?>" href="<?=$url_page?>?&page=<?=$pg?>"><?=$pg?></a>
							<? if ($page + 1 != $page_all - 1): ?> <div class="uc_pi uc_pi_disp">...</div> <? endif ?>
						<? endif ?>
					<? endfor ?>
					<a class="uc_pi <?=($page==$page_all?'uc_pi_act':'')?>" href="<?=$url_page?>?&page=<?=$page_all?>"><?=$page_all?></a>
					<? if ($page < $page_all): ?> <a class="uc_pi" href="<?=$url_page?>?&page=<?=$page+1?>"><i class="fal fa-angle-right"></i></a> <? endif ?>
				</div>
			<? endif ?>

		<? else: ?> <div class="ds_nr"><i class="fal fa-ghost"></i><p>НЕТ</p></div> <? endif ?>

	</div>

<? include "../block/footer.php"; ?>

	<? include "pop_add.php"; ?>