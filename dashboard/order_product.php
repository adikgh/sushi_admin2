<? include "../config/core.php";

   if (!$user_id) header('location: /');


   	$type = @$_GET['type'];

	// $start_cdate = date('Y-m-d 06:00:00', strtotime("20.01.2025"));
	// $end_cdate = date('Y-m-d 06:00:00', strtotime("$start_cdate +1 day"));

   	if (@$_GET['time']) {
	   $time_sort = $_GET['time'];
	   $start_cdate = date('Y-m-d 06:00:00', strtotime("$date $time_sort day"));
	   $end_cdate = date('Y-m-d 06:00:00', strtotime("$start_cdate +1 day"));
   	}






//  $cashbox = db::query("select * from report_1 where paid = 0 and branch_id = '$branch' order by id desc limit 1");
// 	if (mysqli_num_rows($cashbox)) {
// 		$cashbox_d = mysqli_fetch_assoc($cashbox);
// 		$cashbox_id = $cashbox_d['id'];
// 	} else {
// 		$cashbox_id = (mysqli_fetch_assoc(db::query("SELECT * FROM `report_1` order by id desc")))['id'] + 1;
// 		$ins = db::query("INSERT INTO `report_1`(`id`, `user_id`, `branch_id`) VALUES ('$cashbox_id', '$user_id', '$branch')");
// 	}


    // 
	$oprs = db::query("select user_id, COUNT(*) AS paid from retail_orders where ins_dt BETWEEN '$start_cdate' and '$end_cdate' GROUP BY user_id order by paid desc");
    $number_p1 = 0;

    // 
	$cashboxp = db::query("select price, product_id, COUNT(*) AS quantity from retail_orders_products where ins_dt BETWEEN '$start_cdate' and '$end_cdate' GROUP BY product_id order by quantity desc");
    $number = 0;


	// site setting
	$menu_name = 'order_product';
	$css = ['order_product'];
	$js = ['order_product'];
?>
<? include "../block/header.php"; ?>

	<div class="bl_c">
        
		<? include "aheader.php"; ?>

		<div class="">
			<div class="uc_ui uc_ui69">
				<div class="uc_uin_other">
					<select name="status" class="on_sort_time" data-order-id="<?=$buy_d['id']?>" >
						<option data-id="" value="" data-val="0" <?=(@$time_sort == 0?'selected':'')?>>Бүгін (<?=date('d', strtotime("$date"))?>)</option>
						<option data-id="" value="" data-val="-1" <?=(@$time_sort == -1?'selected':'')?>>Кеше (<?=date('d', strtotime("$date -1 day"))?>)</option>
						<option data-id="" value="" data-val="-2" <?=(@$time_sort == -2?'selected':'')?>>Алдыңғы күні (<?=date('d', strtotime("$date -2 day"))?>)</option>
						<option data-id="" value="" data-val="-3" <?=(@$time_sort == -3?'selected':'')?>>Алдыңғы күні (<?=date('d', strtotime("$date -3 day"))?>)</option>
						<option data-id="" value="" data-val="-4" <?=(@$time_sort == -4?'selected':'')?>>Алдыңғы күні (<?=date('d', strtotime("$date -4 day"))?>)</option>
						<option data-id="" value="" data-val="-5" <?=(@$time_sort == -5?'selected':'')?>>Алдыңғы күні (<?=date('d', strtotime("$date -5 day"))?>)</option>
					</select>
				</div>
			</div>
		</div>

	</div>

    <br><br>
    
	<div class="">
        <div class="bl_c">
            <div class="uc_u">
        
                <div class="uc_uh">
                    <div class="uc_uhn">
                        <div class="uc_uh_number">#</div>
                        <div class="uc_uh_name">Тауар атауы</div>
                        <div class="uc_uh_other">Точка продаж</div>
                        <div class="uc_uh_other">Тауар бағасы</div>
                        <div class="uc_uh_other">Сатылым саны</div>
                        <div class="uc_uh_other">Жалпы суммасы</div>
                    </div>
                </div>
                <div class="uc_uc">
                    <? while ($cashboxp_d = mysqli_fetch_assoc($cashboxp)): ?>
                        <? $number++; ?>
                        <? $product_d = product::product($cashboxp_d['product_id']) ?>
                        <? $catalog_d = product::pr_catalog($product_d['catalog_id']) ?>
                        <? if ($catalog_d['company_id'] == $company): ?>
                            <div class="uc_ui">
                                <div class="uc_uil">
                                    <div class="uc_ui_number"><?=$number?></div>
                                    <a class="uc_uiln" href="/products/item/?id=<?=$product_d['id']?>">
                                        <div class="uc_uinu">
                                            <div class="uc_ui_name"><?=$product_d['name_kz']?></div>
                                        </div>
                                    </a>
                                    <div class="uc_uin_other"><?=$catalog_d['name_kz']?></div>
                                    <div class="uc_uin_other fr_price"><?=$cashboxp_d['price']?></div>
                                    <div class="uc_uin_other "><?=$cashboxp_d['quantity']?> шт</div>
                                    <div class="uc_uin_other fr_price"><?=$cashboxp_d['price'] * $cashboxp_d['quantity']?></div>
                                </div>
                            </div>
                        <? endif ?>
                    <? endwhile ?>

                </div>
            </div>
        </div>
    </div>

<? include "../block/footer.php"; ?>