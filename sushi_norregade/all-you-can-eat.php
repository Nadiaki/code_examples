<?php
require_once("header.php");
$categories = getCategories();
// this is hardcoded, but can be changed to be obtained through a login
$table_id = 16;
?>

<!--start all you can eat menu-->
<div id="div-allyoucaneat" class="rice-light">
    <div class="row align-center">
        <div class="small-12 medium-8 columns text-center">
            <h2>All you can eat<br>
                <span class="salmon-text">MENU</span></h2>

            <p>Aliquam erat volutpat. Nulla sapien libero, tempor vel nisi eget, interdum accumsan sapien. Vivamus
                tincidunt bibendum mattis. Etiam semper eleifend tincidunt. Aenean sed elit nunc.</p>
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
                            <span class="category-title"><?php echo $category["name_dk"] ?></span><br/>
                            <span class="category-title salmon-text">
                                <?php echo !empty($category["name_en"]) ? $category["name_en"] : "&nbsp;" ; ?>
                            </span>
                        </h3>
                    </div>
                </div>

                <?php
                    $menuItems = getMenuItems($category["id"]);
                    foreach ($menuItems as $menuItem) {
                ?>
                        <div class="row">
                            <div class="small-12 large-4 columns">
                                <img src="img/menu/<?php echo $menuItem["image"]; ?>" alt="<?php echo $menuItem["name_dk"]; ?>"/>
                            </div>
                            <div class="small-12 large-8 columns">
                                <div class="row">
                                    <div class="small-12 columns">
                                        <h5>
                                            <span class="dk-name nori-text"><?php echo $menuItem["name_dk"]; ?></span><br/>
                                            <span class="en-name">
                                                <?php echo !empty($menuItem["name_en"]) ? $menuItem["name_en"] : "&nbsp;" ; ?>
                                            </span>
                                        </h5>

                                        <p>
                                            <span class="dk-ingredients"><?php echo $menuItem["ingredients_dk"]; ?></span><br/>
                                            <span class="en-ingredients"><?php echo $menuItem["ingredients_en"]; ?></span><br/>
                                            <?php 
                                                echo !empty($menuItem["sensitivity_name"]) ? "<span>Contains: "
                                                    .$menuItem["sensitivity_name"]."</span> <br/>" : "";
                                            ?>
                                            <!--TODO: This should only show if there is set portion size!!, otherwise print non breaking space-->
                                            <span>
                                            <?php 
                                                echo !empty($menuItem["quantity"]) ? "Portion size: " . $menuItem["quantity"] : "&nbsp;"; 
                                            ?>
                                            </span><br/>
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-group">
                                        <span class="input-group-label">QTY.</span>
                                        <input class="input-group-field menu-food-item-quantity" 
                                            data-nameen="<?php echo $menuItem["name_en"]; ?>" 
                                            data-namedk="<?php echo $menuItem["name_dk"]; ?>" 
                                            data-foodid="<?php echo $menuItem["id"]; ?>"
                                            data-tableid="<?php echo $table_id; ?>"
                                        type="number" min="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                ?>
            </div>
        </div>
    <?php        
        }
    ?>

    <div class="row align-center food-category">
        <div class="small-12 medium-10 columns food-category-wrapper">
            <div class="row">
                <div class="columns">
                    <textarea name="comments" id="comments" placeholder="Any special requests? Let us know!"></textarea>
                </div>
            </div>
        </div>
    </div>
    
    <input type="hidden" value="<?php echo $table_id; ?>" id="table_id">

    <div class="row align-center text-center">
        <div class="small-6 medium-4 columns">
            <span><a type="submit" class="button expanded order-btn-all-you-can-eat">Place order</a></span>
            <span><a class="button expanded order-btn" id="call-waiter" data-tableid="<?php echo $table_id; ?>">Call Waiter</a></span>
        </div>
    </div>
</div>



<?php
    require_once("footer.php");
?>



