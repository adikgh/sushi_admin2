<? include "../config/core.php";

   if (!$user_id) header('location: /');


   	$type = @$_GET['type'];

	// $start_cdate = date('Y-m-d 06:00:00', strtotime("20.01.2025"));
	// $end_cdate = date('Y-m-d 06:00:00', strtotime("$start_cdate +1 day"));

    if (@$_GET['time']) {
		$time_sort = $_GET['time'];
		$start_cdate = date('Y-m-d 06:00:00', strtotime("$time_sort"));
		$end_cdate = date('Y-m-d 06:00:00', strtotime("$start_cdate +1 day"));
	}
    // if (@$_GET['catalog']) {
	// 	$sort_catalog = $_GET['catalog'];
	// }


    // if (@$_GET['company']) {
	// 	$sort_company = $_GET['company'];
    //     $_SESSION['company'] = $_GET['company'];
	// }
    
    // 
    $number = 0;
    $cashboxp = db::query("select price, product_id, COUNT(*) AS quantity from retail_orders_products where ins_dt BETWEEN '$start_cdate' and '$end_cdate' GROUP BY product_id order by quantity desc");



    // 
	// $oprs = db::query("select user_id, COUNT(*) AS paid from retail_orders where ins_dt BETWEEN '$start_cdate' and '$end_cdate' GROUP BY user_id order by paid desc");
	// $oprs = db::query("select price, product_id, COUNT(*) AS quantity from retail_orders_products where ins_dt BETWEEN '$start_cdate' and '$end_cdate' GROUP BY product_id order by quantity desc");
    // $number_p1 = 0;


    // elseif (@$_GET['status']) {
	// 	$status = $_GET['status'];
	// 	$orders = db::query("select * from retail_orders where ins_dt BETWEEN '$start_cdate' and '$end_cdate' and order_status = '$status'  and company_id = '$company' order by number desc");
	// } elseif (@$_GET['staff']) {
	// 	$staff = $_GET['staff'];
	// 	if ($staff == 'off') $orders = db::query("select * from retail_orders where ins_dt BETWEEN '$start_cdate' and '$end_cdate' and order_type = 1 and сourier_id is null and company_id = '$company' order by number desc");
	// 	elseif ($staff == 'soboi') $orders = db::query("select * from retail_orders where ins_dt BETWEEN '$start_cdate' and '$end_cdate' and order_type = 2 and company_id = '$company' order by number desc");
	// 	else $orders = db::query("select * from retail_orders where ins_dt BETWEEN '$start_cdate' and '$end_cdate' and сourier_id  = '$staff'  and company_id = '$company' order by number desc");
	// } 



    //  $cashbox = db::query("select * from report_1 where paid = 0 and branch_id = '$branch' order by id desc limit 1");
    // 	if (mysqli_num_rows($cashbox)) {
    // 		$cashbox_d = mysqli_fetch_assoc($cashbox);
    // 		$cashbox_id = $cashbox_d['id'];
    // 	} else {
    // 		$cashbox_id = (mysqli_fetch_assoc(db::query("SELECT * FROM `report_1` order by id desc")))['id'] + 1;
    // 		$ins = db::query("INSERT INTO `report_1`(`id`, `user_id`, `branch_id`) VALUES ('$cashbox_id', '$user_id', '$branch')");
    // 	}



	// site setting
	$menu_name = 'order_product';
	$css = ['order_product'];
	$js = ['order_product'];
?>
<? include "../block/header.php"; ?>

	<div class="bl_c">
        
		<? include "aheader.php"; ?>

        <br>

		<div class="">

            <div class="uc_ui uc_ui69">

                <? if ($user_right['positions_id'] == 1): ?>
                    <div class="uc_uin_other">
                        <select name="status" class="on_sort_company" >
                            <!-- <option data-id="" value="" <?=(!@$company?'selected':'')?>>Все</option> -->
                            <? $catl = db::query("select * from company "); ?>
                            <? while ($catl_d = mysqli_fetch_assoc($catl)): ?>
                                <option data-id="" value="<?=$catl_d['id']?>" <?=(@$company == $catl_d['id']?'selected':'')?>><?=$catl_d['name']?></option>
                            <? endwhile ?>
                        </select>
                    </div>
                <? endif ?>
            
                <div class="uc_uin_other">
                    <div class="form_im">
                        <input class="form_dt on_sort_time" type="date" name="" id="" value="<?=date('Y-m-d', strtotime("$start_cdate"))?>">
                    </div>
                </div>

				<!-- <div class="uc_uin_other">
					<select name="status" class="on_sort_catalog" >
                        <option data-id="" value="" <?=(!@$sort_catalog?'selected':'')?>>Все</option>
                        <? $catl = db::query("select * from product_catalog where company_id = '$company' and type = 'main'"); ?>
                        <? while ($catl_d = mysqli_fetch_assoc($catl)): ?>
                            <option data-id="" value="<?=$catl_d['id']?>" <?=(@$sort_catalog == $catl_d['id']?'selected':'')?>><?=$catl_d['name_kz']?></option>
                        <? endwhile ?>
					</select>
				</div> -->

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
                        <div class="uc_uh_name">Каталог атауы</div>
                        <div class="uc_uh_other">Жалпы саны</div>
                    </div>
                </div>
                <div class="uc_uc">
                    <? $catl = db::query("select * from product_catalog where company_id = '$company' and type = 'main'"); ?>
                    <? $number = 0; ?>
                    <? while ($catl_d = mysqli_fetch_assoc($catl)): ?>
                        <? $number++; ?>
                        <? $catalog_id = $catl_d['id']; ?>
                        <? 
                            $o_qn2 = 0;
                            $product = db::query("select * from product where `catalog_id` = '$catalog_id'");
                            while ($product_d = mysqli_fetch_assoc($product)) {
                                $product_id = $product_d['id'];
                                $p_qn = mysqli_fetch_assoc(db::query("select COUNT(*) AS quantity from retail_orders_products where ins_dt BETWEEN '$start_cdate' and '$end_cdate' and product_id = '$product_id'"))['quantity'];
                                $o_qn2 = $o_qn2 + $p_qn;
                            }
                        ?>
                        
                        <div class="uc_ui">
                            <div class="uc_uil">
                                <div class="uc_ui_number"><?=$number?></div>
                                <div class="uc_uiln" href="/user/admin/users/item/?id=<?=$user_d['id']?>">
                                    <div class="uc_uinu">
                                        <div class="uc_ui_name"><?=$catl_d['name_kz']?></div>
                                    </div>
                                </div>
                                <div class="uc_uin_other "><?=$o_qn2?> шт</div>
                            </div>
                        </div>
                        
                    <? endwhile ?>

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
                        <? $product_d = product::product($cashboxp_d['product_id']) ?>
                        <? $catalog_d = product::pr_catalog($product_d['catalog_id']) ?>
                        <? if ($catalog_d['company_id'] == $company): ?>
                            <? $number++; ?>
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