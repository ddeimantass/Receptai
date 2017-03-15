<?php
  $pagination = "<div class=\"pagination\">";
  $pagination .= "Puslapiai: ";
  for ($i = 1;$i <= $total_pages;$i++) {
      if ($i == $current_page) {
          $pagination .= " <span>$i</span>";
      } else {
          $pagination .= " <a href='".base_url()."index.php/site/pagrindinis?";
          if (!empty($search)) {
              $pagination .= "s=".urlencode(htmlspecialchars($search))."&";
          }
          $pagination .= "pg=$i'>$i</a>";
      }
  }
  $pagination .= "</div>";
?>

<article class="container" id="list">
    <div class="panel panel-default">
        <div class="panel-body row">
            <div class="page-header col-xs-12">
                <h1>Receptų sarašas</h1>
            </div>
            <div class="search col-xs-6 pull-right">
              <form class="pull-right" method="get" action="">
                  <div id="topForm" >
                      <input type="text" placeholder="Paieška" value="<?php echo htmlspecialchars($search); ?>" name="s" id="s" />
                      <input id="search_btn" type="submit" value="Ieškoti" />
                  </div>
                  <div id="bottomForm" >
                      <select name="sort" >
                          <option value="new" <?php echo $sort == "new" ? 'selected="selected"': ''; ?> >Naujausi</option>
                          <option value="a_z" <?php echo $sort == "a_z" ? 'selected="selected"': ''; ?> >pavadinimas A-Ž</option>
                          <option value="z_a" <?php echo $sort == "z_a" ? 'selected="selected"': ''; ?> >pavadinimas Ž-A</option>
                      </select>
                      <input id="search_btn" type="submit" value="Rikiuoti" />
                  </div>
                
              </form>
                
            </div>
            <div class="col-xs-6" >
                <?php
                    if ($search != null){
                        echo "<h3>Paieškos rezultatai atitinkantys: \"".htmlspecialchars($search)."\"</h3>";
                    }
                
                ?>
                <?php
                  if ($total_items < 1) {
                    echo "<p>Pagal paieškos užklausą nebuvo rasta jokių atitikmenų.</p>";
                    echo "<p>Ieškokite dar kartą arba "
                        ."<a href=".base_url()."\"index.php/site/pagrindinis\">Naršykite visas knygas</a></p>";
                    }
                  else
                    echo $pagination;
                ?>
                <ul>
                  <?php

                  foreach ($recipes as $recipe) {
                      $recipe = json_decode(json_encode($recipe), True);
                  ?>
                  <li><a href="<?php echo base_url();?>index.php/site/detaliai?id=<?php echo $recipe['id']; ?>"> <?php echo $recipe['title']; ?></a></li>
                  <?php
                  }
                  ?>
                </ul>
            </div>
        </div>
    </div>
</article>