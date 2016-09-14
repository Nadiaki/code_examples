<?php
require_once("header.php");

if(!empty($_POST["submit_stock_change"])){
    updateFoodStockStatus($_POST["id_food_item"], empty($_POST["current_stock_status"]));
}

$categories = getCategories();
?>

<div id="div-stock" class="rice-light">
    <div class="row align-center">
        <div class="small-12 medium-8 columns text-center">
            <h2>Manage Stocks<br>
        </div>
    </div>

    <?php
        foreach ($categories as $category) {
    ?>
        <div class="row align-center food-category">
            <div class="small-12 medium-10 columns food-category-wrapper">
                <div class="row">
                    <div class="columns">
                        <h3>
                            <span class="category-title salmon-text "><?php echo $category["name_dk"] ?></span><br/>
                        </h3>
                    </div>
                </div>

                <?php
                    $menuItems = getAllMenuItems($category["id"]);
                    foreach ($menuItems as $menuItem) {
                ?>
                        <form action="manage_stocks.php" method="POST">
                            <div class="row">
                                <div class="small-12 large-12 columns">
                                    <div class="row">
                                        <div class="small-6 columns">
                                            <h5><span class="dk-name nori-text"><?php echo $menuItem["name_dk"]; ?></span></h5>
                                        </div>
                                        <div class="small-6 columns">
                                            <input type="hidden" name="id_food_item" value="<?php echo $menuItem["id"]; ?>">
                                            <input type="hidden" name="current_stock_status" value="<?php echo $menuItem["in_stock"]; ?>">
                                            <p><input type="submit" class="button expanded <?php echo !empty($menuItem["in_stock"]) ? "" : "alert"; ?>"
                                                      name="submit_stock_change" value="<?php echo !empty($menuItem["in_stock"]) ? "Set Out of Stock" : "Set in Stock"; ?>" ></p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                <?php
                    }
                ?>
            </div>
        </div>
    <?php        
        }
    ?>
</div>

<?php
    require_once("footer.php");