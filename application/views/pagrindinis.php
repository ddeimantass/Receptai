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
<div class="search">
  <form method="get" action="index.php">
    <label for="s">Paieška:</label>
    <input type="text" name="s" id="s" />
    <input type="submit" value="ieškoti" />
  </form>
</div>
<h3>
  <?php
    if ($search != null)
      echo "Paieškos rezultatai atitinkantys: \"".htmlspecialchars($search)."\"";
  ?>
</h3>
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