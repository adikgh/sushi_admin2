<? include "../../config/core.php";

	// 
	if (!$user_right) header('location: /');

	// product
	if (isset($_GET['id']) || $_GET['id'] != '') {
		$product_id = $_GET['id'];
		$product = db::query("select * from product where id = '$product_id'");
		if (mysqli_num_rows($product)) {
			$product_d = mysqli_fetch_assoc($product);

			// catalog
			$catalog_id = $product_d['catalog_id'];
			$catalog_d = product::pr_catalog($product_d['catalog_id']);
			
		} else header('location: /admin/products/');
	} else header('location: /admin/products/');


	// site setting
	$menu_name = 'products';
	$pod_menu_name = 'item';
	$site_set['header'] = true;
	$site_set['menu'] = true;
	$site_set['atops'] = true;
	$site_set['footer'] = false;
	$site_set['utop_bk'] = 'products';
	$site_set['utop_type'] = 'item';
	$site_set['utop_nm'] = $product_d['name_ru'];
	$css = ['products/main', 'products/item'];
	$js = ['products/main', 'products/item'];
?>
<? include "../../block/header.php"; ?>

	<div class="bl_c">

		<? include "../aheader.php"; ?>

		<br>

		<div class="pitem">
		
			<div class="item_cn"><?=$product_d['name_ru']?></div>

			<div class="item_sprb">
				<div class="btn btn_back3 pr_upd_pop" data-id="<?=$product_id?>">Редактировать</div>
				<div class="btn btn_back_red3 pr_delete" data-id="<?=$product_id?>">Удалить товар</div>
			</div>


			<? $pitem = db::query("select * from product_item where product_id = '$product_id' order by ins_dt desc"); ?>
			<div class="item_c">
				<div class="item_is">Состав товара:</div>
				<div class="uc_u">
					<div class="tscroll">
						<table class="uc_u2q  uc_uc">
							<thead class="">
								<tr class="thead">
									<td class="td_number">#</td>
									<? if (mysqli_num_rows($pitem) > 1): ?> <td class=""><div class="uc_uin_cn"></div></td> <? endif ?>
									<td class="td_other">Называние</td>
									<td class="td_other">Количество</td>
									<td class="uc_uh_cn"></td>
								</tr>
							</thead>
							<tbody class="tbody">
								<? $sum = 0; ?>
								<? while ($buy_d = mysqli_fetch_assoc($pitem)): ?>
									<? $sum++; $buy_id = $buy_d['id']; ?>
									<? $comp_d = product::comp($buy_d['comp_id']) ?>
			
									<tr class="uc_ui uc_ui2">
										<td class="td_number"><div class="uc_ui_number"><?=$sum?></div></td>
										<? if (mysqli_num_rows($pitem) > 1): ?>
											<td class="">
												<div class="uc_uin_cn uc_uib_del pitem_btn_delete" data-title2="Удалить товар" data-id="<?=$buy_d['id']?>">
													<div class="menu_cin"><i class="fal fa-trash-alt"></i></div>
												</div>
											</td>
										<? endif ?>
										<td class="td_other"><?=$comp_d['name_kz']?></td>
										<td class="td_other">
											<div class="uc_uin_other">
												<input type="tel" class="uc_uin_calc_q fr_number3 view_updq_qn" data-id="<?=$buy_d['id']?>" value="<?=$buy_d['quantity']?>" data-lenght="1" />
											</div>
										</td>
									</tr>
								<? endwhile ?>
							</tbody>
						</table>
					</div>
					<div class="uc_ub">
						<div class="btn btn_k pitem_add_pop">
							<i class="far fa-layer-plus"></i>
							<span>Добавить вид товара</span>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

<? include "../../block/footer.php"; ?>

   <!-- upd product -->
   <div class="pop_bl pop_bl2 pr_upd_block">
      <div class="pop_bl_a pr_upd_back"></div>
      <div class="pop_bl_c">
         <div class="head_c">
            <h4>Обновить вид товара</h4>
            <div class="btn btn_dd pr_upd_back"><i class="fal fa-times"></i></div>
         </div>
         <div class="pop_bl_cl lazy_c"></div>
      </div>
   </div>


   <!-- add item -->
   <div class="pop_bl pop_bl3 pitem_add_block">
      	<div class="pop_bl_a pitem_add_back"></div>
      	<div class="pop_bl_c">
			<div class="head_c txt_c">
				<h4>Добавить вид товара</h4>
			</div>
			<div class="ec_c">
				<? $pcomp = db::query("select * from product_comp where company_id = '$company' order by ins_dt desc"); ?>
				<? while ($pcomp_d = mysqli_fetch_assoc($pcomp)): ?>
					<div class="ec_ci comp_sel" data-id="<?=$pcomp_d['id']?>"><?=$pcomp_d['name_kz']?></div>
				<? endwhile ?>
			</div>
			<div class="form_c">
				<div class="form_im">
					<div class="form_span">Количество:</div>
					<i class="fal fa-hashtag form_icon"></i>
					<input type="tel" class="form_txt fr_number pitem_quantity" placeholder="0" data-lenght="1">
				</div>
				<div class="form_im">
					<div class="btn pitem_add" data-id="<?=$product_id?>" data-comp=""><span>Добавить</span></div>
				</div>
			</div>
      	</div>
   </div>


   <!-- upd item -->
	<div class="pop_bl pop_bl2 pitem_upd_block">
      <div class="pop_bl_a pitem_upd_back"></div>
      <div class="pop_bl_c">
         <div class="head_c">
            <h4>Обновить вид товара</h4>
            <div class="btn btn_dd pitem_upd_back"><i class="fal fa-times"></i></div>
         </div>
         <div class="pop_bl_cl lazy_c"></div>
      </div>
   </div>

	<!-- upd item quantity -->
	<div class="pop_bl pop_bl2 pitem_updq_block">
      <div class="pop_bl_a pitem_updq_back"></div>
      <div class="pop_bl_c">
         <div class="head_c">
            <h4>Корректировка количество</h4>
            <div class="btn btn_dd pitem_updq_back"><i class="fal fa-times"></i></div>
         </div>
         <div class="pop_bl_cl lazy_c"></div>
      </div>
   </div>

   <!-- view_add_pop -->
   <div class="pop_bl pop_bl2 view_add_block">
      <div class="pop_bl_a view_add_back"></div>
      <div class="pop_bl_c">
         <div class="head_c">
            <h4>Добавить вид товара</h4>
            <div class="btn btn_dd view_add_back"><i class="fal fa-times"></i></div>
         </div>
         <div class="pop_bl_cl">
            <div class="form_c">
               <div class="form_im form_sel">
                  <div class="form_span">Склады:</div>
                  <i class="fal fa-warehouse-alt form_icon"></i>
                  <div class="form_im_txt sel_clc views_warehouses" data-val="">Выберите склад</div>
                  <i class="fal fa-caret-down form_icon_sel"></i>
                  <div class="form_im_sel sel_clc_i">
                     <? $warehouses = db::query("select * from product_warehouses"); ?>
                     <? while ($warehouses_d = mysqli_fetch_assoc($warehouses)): ?>
                        <div class="form_im_seli" data-val="<?=$warehouses_d['id']?>"><?=$warehouses_d['name']?></div>
                     <? endwhile ?>
                  </div>
               </div>
               <div class="form_im">
                  <div class="form_span">Количество:</div>
                  <i class="fal fa-hashtag form_icon"></i>
                  <input type="tel" class="form_im_txt fr_number views_quantity" placeholder="0" data-lenght="1">
               </div>
               <div class="form_im">
                  <div class="form_span">Комментарий:</div>
                  <i class="fal fa-text form_icon"></i>
                  <input type="text" class="form_im_txt views_comment" placeholder="" data-lenght="1">
               </div>
            </div>
            <div class="form_c">
					<div class="form_im">
						<div class="btn view_add" data-product-id="<?=$product_id?>" data-item-id=""><span>Добавить</span></div>
					</div>
				</div>
         </div>
      </div>
   </div>


   <!-- imgs b -->
   <div class="pop_bl pop_bl2 imgs_add_block">
      <div class="pop_bl_a imgs_add_back"></div>
      <div class="pop_bl_c">
         <div class="head_c">
            <h4>Добавить фото товара</h4>
            <div class="btn btn_dd imgs_add_back"><i class="fal fa-times"></i></div>
         </div>
         <div class="pop_bl_cl lazy_c">
            <div class="form_c">
               <div class="form_head">Добавить изображение товара:</div>
               <div class="uacc_ic">
                  <div class="upl_logo upl_logo2">
                     <input type="file" class="item_file2 file" multiple accept=".png, .jpeg, .jpg" data-id="<?=$product_id?>" data-item-id="">
                     <div class="upl_logo_c item_ava_clc2">Добавить фото</div>
                  </div>
                  <div class="upl_lv lazy_c"></div>
               </div>
            </div>
         </div>
      </div>
   </div>